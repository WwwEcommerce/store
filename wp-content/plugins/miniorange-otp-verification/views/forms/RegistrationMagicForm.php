<?php

use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;

echo' 	<div class="mo_otp_form" id="'.get_mo_class($handler).'"><input type="checkbox" '.esc_attr($disabled).' id="crf_default" class="app_enable" data-toggle="crf_default_options" name="mo_customer_validation_crf_default_enable" value="1"
				'.esc_attr($crf_enabled).' /><strong>'. esc_attr($form_name) .'</strong>';

echo'			<div class="mo_registration_help_desc" '.esc_attr($crf_hidden).' id="crf_default_options">
					<b>'. mo_( "Choose between Phone or Email Verification").'</b>
					<p><input type="radio" '.esc_attr($disabled).' id="crf_phone" data-toggle="crf_phone_instructions" class="form_options app_enable" name="mo_customer_validation_crf_enable_type" value="'.esc_attr($crf_type_phone).'"
						'.( esc_attr($crf_enable_type) == esc_attr($crf_type_phone) ? "checked" : "" ).' />
							<strong>'. mo_( "Enable Phone Verification").'</strong>';

echo'					<div '.(esc_attr($crf_enable_type) != esc_attr($crf_type_phone) ? "hidden" :"").' id="crf_phone_instructions" class="mo_registration_help_desc">
							'. mo_( "Follow the following steps to enable Phone Verification").':
							<ol>
								<li><a href="'.esc_url($crf_form_list).'" target="_blank">'. mo_( "Click Here").'</a> '. mo_( " to see your list of forms").'</li>
								<li>'. mo_( "Click on <b>fields</b> link of your form to see list of fields.").'</li>
								<li>'. mo_( "Choose <b>Text</b> field from the list. Please do not select Phone/Mobile Number.").'</li>
								<li>'. mo_( "Enter the <b>Label</b> of your new field. Keep this handy as you will need it later.").'</li>
								<li>'. mo_( "Navigate to Advanced settings.").'</li>
								<li>'. mo_( "Under RULES section check the box which says <b>Is Required</b>.").'</li>
								<li>'. mo_( "Enable <b>Define New User Meta Key</b> under <b>Add Field to WordPress User Profile</b> section.").'</li>
								<li>'. mo_( "Enter the meta key as <b>rm_phone_number</b>.").'</li>
								<li>'. mo_( "Click on <b>Save</b> button to save your new field.").'<br/>
								<br/>'. mo_( "Add Form" ).' : <input type="button"  value="+" '. esc_attr($disabled) .' onclick="add_crf(\'phone\',2);" class="button button-primary" />&nbsp;
								<input type="button" value="-" '. esc_attr($disabled) .' onclick="remove_crf(2);" class="button button-primary" /><br/><br/>';

								$form_results = get_multiple_form_select($crf_form_otp_enabled,FALSE,TRUE,$disabled,2,'crf','Label');
								$crfcounter2 = !MoUtility::isBlank($form_results['counter']) ? max($form_results['counter']-1,0) : 0 ;
echo'											
								</li>								
								<li>'.mo_( "Click on the Save Button to save your settings and keep a track of your Form Ids." ).'</li>
							</ol>
						</div>
					</p>
					<p><input type="radio" '.esc_attr($disabled).' id="crf_email" data-toggle="crf_email_instructions" class="form_options app_enable" name="mo_customer_validation_crf_enable_type" value="'.esc_attr($crf_type_email).'"
						'.( esc_attr($crf_enable_type) == esc_attr($crf_type_email) ? "checked" : "").' />
						<strong>'. mo_( "Enable Email Verification").'</strong>
					</p>
					<div '.(esc_attr($crf_enable_type) != esc_attr($crf_type_email) ? "hidden" :"").' id="crf_email_instructions" class="crf_form mo_registration_help_desc">
						<ol>
							<li><a href="'.esc_url($crf_form_list).'" target="_blank">'. mo_( "Click Here").'</a> '. mo_( " to see your list of forms").'</li>
							<li>'. mo_( "Click on <b>fields</b> link of your form to see  list of fields.").'</li>
							<li>'. mo_( "Choose <b>email</b> field from the list.").'</li>
							<li>'. mo_( "Enter the <b>Label</b> of your new field. Keep this handy as you will need it later.").'</li>
							<li>'. mo_( "Under RULES section check the box which says <b>Is Required</b>.").'</li>
							<li>'. mo_( "Click on <b>Save</b> button to save your new field.").'<br/>
							<br/>'. mo_( "Add Form" ).' : <input type="button"  value="+" '. esc_attr($disabled) .' onclick="add_crf(\'email\',1);" class="button button-primary"/>&nbsp;
								<input type="button" value="-" '. esc_attr($disabled) .' onclick="remove_crf(1);" class="button button-primary" /><br/><br/>';

								$form_results = get_multiple_form_select($crf_form_otp_enabled,FALSE,TRUE,$disabled,1,'crf','Label');
								$crfcounter1 	  =  !MoUtility::isBlank($form_results['counter']) ? max($form_results['counter']-1,0) : 0 ;

echo                        '</li>
						
							
							<li>'.mo_( "Click on the Save Button to save your settings and keep a track of your Form Ids." ).'</li>
						</ol>
					</div>
					<p><input type="radio" '.esc_attr($disabled).' id="crf_both" data-toggle="crf_both_instructions"  class="form_options app_enable" name="mo_customer_validation_crf_enable_type" value="'.esc_attr($crf_type_both).'"
						'.( esc_attr($crf_enable_type) == esc_attr($crf_type_both)? "checked" : "" ).' />
						<strong>'. mo_( "Let the user choose").'</strong>';

						mo_draw_tooltip(
						    MoMessages::showMessage(MoMessages::INFO_HEADER),MoMessages::showMessage(MoMessages::ENABLE_BOTH_BODY)
                        );

echo'				<div '.(esc_attr($crf_enable_type) != esc_attr($crf_type_both) ? "hidden" :"").' id="crf_both_instructions" class="mo_registration_help_desc">
						'. mo_( "Follow the following steps to enable both Email and Phone Verification").':
						<ol>
							<li><a href="'.esc_url($crf_form_list).'" target="_blank">'. mo_( "Click Here").'</a> '. mo_( " to see your list of forms").'</li>
							<li>'. mo_( "Click on <b>fields</b> link of your form to see list of fields.").'</li>
							<li>'. mo_( "Choose <b>Text</b> field from the list. Please do not select Phone/Mobile Number.").'</li>
								<li>'. mo_( "Enter the <b>Label</b> of your new field. Keep this handy as you will need it later.").'</li>
								<li>'. mo_( "Navigate to Advanced settings.").'</li>
								<li>'. mo_( "Under RULES section check the box which says <b>Is Required</b>.").'</li>
								<li>'. mo_( "Enable <b>Associate with Existing User Meta Keys</b> under <b>Add Field to WordPress User Profile</b> section.").'</li>
								<li>'. mo_( "Select your user meta key as <b>pmpro_bphone</b>.").'</li>
							<li>'. mo_( "Click on <b>Save</b> button to save your new field.").'<br/>
							<br/>'. mo_( "Add Form" ).' : <input type="button"  value="+" '. esc_attr($disabled) .' onclick="add_crf(\'both\',3);" class="button button-primary"/>&nbsp;
								<input type="button" value="-" '. esc_attr($disabled) .' onclick="remove_crf(3);" class="button button-primary" /><br/><br/>';

								$form_results = get_multiple_form_select($crf_form_otp_enabled,FALSE,TRUE,$disabled,3,'crf','Label');
                                $crfcounter3	  =  !MoUtility::isBlank($form_results['counter']) ? max($form_results['counter']-1,0) : 0 ;

echo                        '</li>
						
							
							<li>'.mo_( "Click on the Save Button to save your settings and keep a track of your Form Ids." ).'</li>
						</ol>
					</div>
				</p>
			</div>
		</div>';

        multiple_from_select_script_generator(FALSE,TRUE,'crf','Label',[$crfcounter1,$crfcounter2,$crfcounter3]);