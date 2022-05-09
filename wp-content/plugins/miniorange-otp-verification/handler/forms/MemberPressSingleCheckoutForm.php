<?php

namespace OTP\Handler\Forms;

use OTP\Helper\FormSessionVars;
use OTP\Helper\MoOTPDocs;
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;
use OTP\Helper\SessionUtils;
use OTP\Objects\BaseMessages;
use OTP\Objects\FormHandler;
use OTP\Objects\IFormHandler;
use OTP\Objects\VerificationLogic;
use OTP\Objects\VerificationType;
use OTP\Traits\Instance;
use ReflectionException;
use WP_Error;


class MemberPressSingleCheckoutForm extends FormHandler implements IFormHandler
{
    use Instance;

    protected function __construct()
    {
        $this->_isLoginOrSocialForm = FALSE;
        $this->_isAjaxForm = TRUE;
        $this->_formSessionVar = FormSessionVars::MEMBERPRESS_SINGLE_REG;
        $this->_typePhoneTag = 'mo_mrp_single_phone_enable';
        $this->_typeEmailTag = 'mo_mrp_single_email_enable';
        $this->_typeBothTag = 'mo_mrp_single_both_enable';
        $this->_formName = mo_("MemberPress Single Checkout Registration Form");
        $this->_formKey = 'MEMBERPRESSSINGLECHECKOUT';
        $this->_isFormEnabled = get_mo_option('mrp_single_default_enable');
        $this->_formDocuments = MoOTPDocs::MRP_FORM_LINK;
        parent::__construct();
    }

    
    function handleForm()
    {
        $this->_byPassLogin = get_mo_option('mrp_single_anon_only');
        $this->_phoneKey = get_mo_option('mrp_single_phone_key');
        $this->_otpType = get_mo_option('mrp_single_enable_type');
        $this->_phoneFormId = 'input[name='.$this->_phoneKey.']';

        add_action("wp_ajax_momrp_single_send_otp", [$this,'_send_otp']);
        add_action("wp_ajax_nopriv_momrp_single_send_otp", [$this,'_send_otp']);

        // add_action("wp_ajax_momrp_single_final_submission", [$this,'validate_single_checkout_form']);
        // add_action("wp_ajax_momrp_single_final_submission", [$this,'validate_single_checkout_form']);

        if (isset($_POST['action']) && $_POST['action']=="momrp_single_final_submission") {
            $this->validate_single_checkout_form();
        }

        // add_filter('mepr-validate-signup', array($this,'miniorange_site_register_form'),99,1);
        add_action('wp_enqueue_scripts',array($this, 'miniorange_single_checkout_register_script'));
    }

    function validate_single_checkout_form()
    {
        $this->checkIfOTPSent();
        $this->checkIntegrityAndValidateOTP($_POST);
    }

    function checkIfOTPSent()
    {
        if(!SessionUtils::isOTPInitialized($this->_formSessionVar)) {
            wp_send_json(MoUtility::createJson(
                MoMessages::showMessage(MoMessages::ENTER_VERIFY_CODE), MoConstants::ERROR_JSON_TYPE
            ));
        }
    }

    private function checkIntegrityAndValidateOTP($data)
    {

        $this->checkIntegrity($data);
        
        $this->validateChallenge(sanitize_text_field($data['otpType']),NULL,sanitize_text_field($data['otp_token']));

        if(SessionUtils::isStatusMatch($this->_formSessionVar,self::VALIDATED,sanitize_text_field($data['otpType']))) {
            wp_send_json(MoUtility::createJson(
                    MoConstants::SUCCESS_JSON_TYPE, MoConstants::SUCCESS_JSON_TYPE
            ));
        }else{
            wp_send_json(MoUtility::createJson(
                MoMessages::showMessage(MoMessages::INVALID_OTP), MoConstants::ERROR_JSON_TYPE
            ));
        }
    }

    private function checkIntegrity($data)
    {
        if($data['otpType']==='phone' ) {
            if(!SessionUtils::isPhoneVerifiedMatch($this->_formSessionVar,sanitize_text_field($data['user_phone']))) {
                wp_send_json(MoUtility::createJson(
                    MoMessages::showMessage(MoMessages::PHONE_MISMATCH), MoConstants::ERROR_JSON_TYPE
                ));
            }
        } else if(!SessionUtils::isEmailVerifiedMatch($this->_formSessionVar,sanitize_email($data['user_email']))) {
            wp_send_json(MoUtility::createJson(
                    MoMessages::showMessage(MoMessages::EMAIL_MISMATCH), MoConstants::ERROR_JSON_TYPE
            ));
        }
    }

    function _send_otp()
    {
        $data = $_POST;

        $this->validateAjaxRequest();
        MoUtility::initialize_transaction($this->_formSessionVar);
        if($this->_otpType==$this->_typePhoneTag)
            $this->_processPhoneAndStartOTPVerificationProcess($data);
        else
            $this->_processEmailAndStartOTPVerificationProcess($data);
    }

    private function _processPhoneAndStartOTPVerificationProcess($data)
    {
        if(!MoUtility::sanitizeCheck('user_phone',$data))
            wp_send_json( MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_PHONE),MoConstants::ERROR_JSON_TYPE) );
        else
            $this->setSessionAndStartOTPVerification(trim($data['user_phone']),NULL,trim($data['user_phone']),VerificationType::PHONE);
    }

    private function _processEmailAndStartOTPVerificationProcess($data)
    {
        if(!MoUtility::sanitizeCheck('user_email',$data))
            wp_send_json( MoUtility::createJson(MoMessages::showMessage(MoMessages::ENTER_EMAIL),MoConstants::ERROR_JSON_TYPE) );
        else
            $this->setSessionAndStartOTPVerification($data['user_email'],$data['user_email'],NULL,VerificationType::EMAIL);
    }

    private function setSessionAndStartOTPVerification($sessionValue, $userEmail, $phoneNumber, $_otpType)
    {
        SessionUtils::addEmailOrPhoneVerified($this->_formSessionVar,$sessionValue,$_otpType);
        $this->sendChallenge('',$userEmail,NULL,$phoneNumber,$_otpType);
    }


    function miniorange_single_checkout_register_script()
    {
        wp_register_script( 'momrpsingle', MOV_URL . 'includes/js/momrpsingle.min.js',array('jquery') );
        wp_localize_script( 'momrpsingle', 'momrpsingle', array(
            'siteURL'       => wp_ajax_url(),
            'otpType'       => $this->_otpType,
            'formkey'       => strcasecmp($this->_otpType,$this->_typePhoneTag)==0 ? $this->_phoneKey : 'user_email',
            'nonce'         => wp_create_nonce($this->_nonce),
            'buttontext'    => mo_("Click Here to send OTP"),
            'imgURL'        => MOV_LOADER_URL,
        ));
        wp_enqueue_script( 'momrpsingle' );
    }
    
    function miniorange_site_register_form($errors)
    {
                if($this->_byPassLogin && is_user_logged_in()) return $errors;

        $usermeta = $_POST;

        $phone_number = '';
        if($this->isPhoneVerificationEnabled()) {
            $phone_number = sanitize_text_field($_POST[$this->_phoneKey]);
            $errors = $this->validatePhoneNumberField($errors);
        }

        if(is_array($errors) && !empty($errors)) return $errors;

        if($this->checkIfVerificationIsComplete()) return $errors;
        MoUtility::initialize_transaction($this->_formSessionVar);
        $errors = new WP_Error();

        foreach ($_POST as $key => $value)
        {
            if($key=="user_first_name")
                $username = $value;
            elseif ($key=="user_email")
                $email = $value;
            elseif ($key=="mepr_user_password")
                $password = $value;
            else
                $extra_data[$key]=$value;
        }

        $extra_data['usermeta'] = $usermeta;
        $this->startVerificationProcess($username,$email,$errors,$phone_number,$password,$extra_data);
        return $errors;
    }


    
    function validatePhoneNumberField($errors)
    {
        
	    global $phoneLogic;
    	if(!MoUtility::sanitizeCheck($this->_phoneKey,$_POST)) {
		    $errors[] = mo_( 'Phone number field can not be blank');
	    }
	    else if(!MoUtility::validatePhoneNumber(sanitize_text_field($_POST[$this->_phoneKey]))) {
		    $errors[] = $phoneLogic->_get_otp_invalid_format_message();
	    }
	    return $errors;
    }


    
    function startVerificationProcess($username,$email,$errors,$phone_number,$password,$extra_data)
    {
        if(strcasecmp($this->_otpType,$this->_typePhoneTag)==0)
            $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::PHONE,$password,$extra_data);
        elseif(strcasecmp($this->_otpType,$this->_typeBothTag)==0)
            $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::BOTH,$password,$extra_data);
        else
            $this->sendChallenge($username,$email,$errors,$phone_number,VerificationType::EMAIL,$password,$extra_data);
    }

    
    function checkIfVerificationIsComplete()
    {
        if(SessionUtils::isStatusMatch($this->_formSessionVar,self::VALIDATED,$this->getVerificationType()))
        {
            $this->unsetOTPSessionVariables();
            return TRUE;
        }
        return FALSE;
    }


    
    function moMRPgetphoneFieldId()
    {
        global $wpdb;
        return $wpdb->get_var("SELECT id FROM {$wpdb->prefix}bp_xprofile_fields where name ='".$this->_phoneKey."'");
    }

    
    function handle_post_verification($redirect_to,$user_login,$user_email,$password,$phone_number,$extra_data,$otpType)
    {
        SessionUtils::addStatus($this->_formSessionVar,self::VALIDATED,$otpType);
    }

    
    function handle_failed_verification($user_login,$user_email,$phone_number,$otpType)
    {
        SessionUtils::addStatus($this->_formSessionVar,self::VERIFICATION_FAILED,$otpType);
    }


    
    public function getPhoneNumberSelector($selector)
    {

        if(self::isFormEnabled() && $this->isPhoneVerificationEnabled()) {
            array_push($selector, $this->_phoneFormId);
        }
        return $selector;
    }

    
    function isPhoneVerificationEnabled()
    {
        $otpType = $this->getVerificationType();
        return $otpType===VerificationType::PHONE || $otpType===VerificationType::BOTH;
    }


    
    public function unsetOTPSessionVariables()
    {
        SessionUtils::unsetSession([$this->_txSessionId,$this->_formSessionVar]);
    }


    
    function handleFormOptions()
    {
        if(!MoUtility::areFormOptionsBeingSaved($this->getFormOption())) return;

        $this->_isFormEnabled = $this->sanitizeFormPOST('mrp_single_default_enable');
        $this->_otpType = $this->sanitizeFormPOST('mrp_single_enable_type');
        $this->_phoneKey = $this->sanitizeFormPOST('mrp_single_phone_field_key');
        $this->_byPassLogin = $this->sanitizeFormPOST('mpr_single_anon_only');

        if($this->basicValidationCheck(BaseMessages::MEMBERPRESS_CHOOSE)) {
                        update_mo_option('mrp_single_default_enable', $this->_isFormEnabled);
            update_mo_option('mrp_single_enable_type', $this->_otpType);
            update_mo_option('mrp_single_phone_key',$this->_phoneKey);
            update_mo_option('mrp_single_anon_only',$this->_byPassLogin);
        }
    }
}