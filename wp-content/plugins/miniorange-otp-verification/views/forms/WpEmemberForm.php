<?php

use OTP\Helper\MoMessages;

echo' 	<div class="mo_otp_form" id="'.esc_attr(get_mo_class($handler)).'"><input type="checkbox" '.esc_attr($disabled).' id="emember_reg" class="app_enable" data-toggle="emember_default_options" name="mo_customer_validation_emember_default_enable" value="1"
										'.esc_attr($emember_enabled).' /><strong>'.esc_attr($form_name).'</strong>';

echo'								<div class="mo_registration_help_desc" '.esc_attr($emember_hidden).' id="emember_default_options">
									<b>'. mo_( "Choose between Phone or Email Verification" ).'</b>
									<p><input type="radio" '.esc_attr($disabled).' id="emember_phone" class="app_enable" name="mo_customer_validation_emember_enable_type" 
											value="'.esc_attr($emember_type_phone).'" data-toggle="emember_phone_instructions"
										'.( esc_attr($emember_enable_type) == esc_attr($emember_type_phone) ? "checked" : "").' />
										<strong>'. mo_( "Enable Phone Verification" ).'</strong>
									</p>
									<div '.( esc_attr($emember_enable_type) != esc_attr($emember_type_phone) ? "hidden" :"").' class="mo_registration_help_desc" 
											id="emember_phone_instructions" >
											'. mo_( "Follow the following steps to enable Phone Verification for" ).'
											eMember Form: 
											<ol>
												<li><a href="'.esc_url($form_settings_link).'" target="_blank">'. mo_( "Click Here" ).'</a> '. mo_( "to see your form settings." ).'</li>
												<li>'. mo_( "Go to the <b>Registration Form Fields</b> section." ).'</li>
												<li>'. mo_( "Check the \"Show phone field on registration page\" option to show Phone field on your form." ).'</li>
												<li>'. mo_( "Click on the Save Button to save your settings" ).'</li>
											</ol>
									</div>
									<p><input type="radio" '.esc_attr($disabled).' id="emember_email" class="app_enable" name="mo_customer_validation_emember_enable_type" value="'.esc_attr($emember_type_email).'"
										'.( esc_attr($emember_enable_type) == esc_attr($emember_type_email) ? "checked" : "").' />
										<strong>'. mo_( "Enable Email Verification" ).'</strong>
									</p>
									<p><input type="radio" '.esc_attr($disabled).' id="emember_both" class="app_enable" name="mo_customer_validation_emember_enable_type" 
										value="'.esc_attr($emember_type_both).'" data-toggle="emember_both_instructions"
										'.( esc_attr($emember_enable_type) == esc_attr($emember_type_both) ? "checked" : "").' />
											<strong>'. mo_( "Let the user choose" ).'</strong>';

											mo_draw_tooltip(
											    MoMessages::showMessage(MoMessages::INFO_HEADER),
                                                MoMessages::showMessage(MoMessages::ENABLE_BOTH_BODY)
                                            );

echo'										
									</p>
									<div '.( esc_attr($emember_enable_type) != esc_attr($emember_type_both) ? "hidden" :"").' class="mo_registration_help_desc" 
											id="emember_both_instructions" >
											'. mo_( "Follow the following steps to enable Phone Verification for" ).'
											eMember Form: 
											<ol>
												<li><a href="'.esc_url($form_settings_link).'" target="_blank">'. mo_( "Click Here" ).'</a> '. mo_( "to see your form settings." ).'</li>
												<li>'. mo_( "Go to the <b>Registration Form Fields</b> section." ).'</li>
												<li>'. mo_( "Check the \"Show phone field on registration page\" option to show Phone field on your form." ).'</li>
												<li>'. mo_( "Click on the Save Button to save your settings" ).'</li>
											</ol>
									</div>
								</div>
							</div>';