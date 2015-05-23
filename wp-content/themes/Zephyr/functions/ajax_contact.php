<?php

if ( ! function_exists('us_sendContact'))
{
	function us_sendContact()
	{
		$captcha_salt = 'Zephyr'; // Do not change unless you changed it in functions/shortcodes.php file
		$errors = array();
		$errors_count = 0;

		$emailTo = get_option('admin_email');

		if ( ! empty($_POST['receiver'])){
			$emailTo = sanitize_email($_POST['receiver']);
		}


		if (isset($_POST['captcha']) AND isset($_POST['captcha_result'])){
			$captcha = $_POST['captcha'];
			$captcha_result = $_POST['captcha_result'];
			if (md5($captcha.$captcha_salt) != $captcha_result){
				$errors['captcha'] = __('Please, enter correct result', 'us');
				$errors_count++;
			}
		}

		if ($errors_count > 0){
			$response = array ('success' => 0, 'errors' => $errors);
			echo json_encode($response);
			die();
		}

		$body = '';

		$name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
		if ( ! empty($name)){
			$body .= __('Name', 'us').': '.$name."\n";
		}

		$email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
		if ( ! empty($email)){
			$body .= __('Email', 'us').": ".$email."\n";
		}

		$phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
		if ( ! empty($phone)){
			$body .= __('Phone', 'us').": ".$phone."\n";
		}

		$message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
		if ( ! empty($message)){
			$body .= __('Message', 'us').": ".$message."\n";
		}

		$headers = '';

		wp_mail($emailTo, __('Contact request from', 'us')." ".get_bloginfo('name'), $body, $headers);

		$response = array ('success' => 1);
		echo json_encode($response);

		die();

	}

	add_action( 'wp_ajax_nopriv_sendContact', 'us_sendContact' );
	add_action( 'wp_ajax_sendContact', 'us_sendContact' );
}
