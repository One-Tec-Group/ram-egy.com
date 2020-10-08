<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$CI =& get_instance();
$CI->load->database();
$CI->load->model('setting_m');
$setting = $CI->setting_m->get_setting(1);

    

// To use reCAPTCHA, you need to sign up for an API key pair for your site.
// link: http://www.google.com/recaptcha/admin
if($setting->captcha_status == 0) {
	$config['recaptcha_site_key'] = $setting->recaptcha_site_key;
	$config['recaptcha_secret_key'] = $setting->recaptcha_secret_key;

	// reCAPTCHA supported 40+ languages listed here:
	// https://developers.google.com/recaptcha/docs/language
	$config['recaptcha_lang'] = 'en';

}
