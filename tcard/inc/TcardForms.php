<?php
/**
 * @since           	1.0.0
 * @package         	Tcard
 * @subpackage  		Tcard/inc
 * @author     		Cloanta Alexandru <alexandrucloanta@yahoo.com>
 * @link            	https://www.addudev.com
 **/

if (!defined('ABSPATH')) die('No direct access allowed');

class TcardForms
{


	public static function contact() {

		check_ajax_referer( 'tcard_contact', 'security' );
		global $wpdb;

		$tcard_skin_table = $wpdb->prefix.'tcard_skins';

        $group_id = sanitize_text_field($_POST['group_id']);
        $skin_key = sanitize_text_field($_POST['skin_key']);
        $side = sanitize_text_field($_POST['side']);


        $admin_email = $wpdb->get_results("SELECT content FROM $tcard_skin_table WHERE group_id = $group_id");
        $admin_email = unserialize($admin_email[$skin_key]->content);
        $admin_email = $admin_email[$skin_key][$side]["contact_admin_email"][0];

		$fields = $_POST['fields'];
		foreach ($fields as $key => $field) {

			$field[0] = str_replace($key, "", $field[0]);
		
			if($field[0] == "email"){
				$email = sanitize_email($field[1]);
			}else{
				$field[1] = sanitize_text_field($field[1]);
			}

			if($field[0] == "full_name"){ 
				$full_name = $field[1];				
			}

			if($field[0] == "first_name"){ 
				$first_name = $field[1];				
			}

			if($field[0] == "last_name"){
				$last_name = $field[1];
			}

			if($field[0] == "phone"){
				if(!empty($field[1])){
					$phone = "<strong>".__('Phone:')."</strong> " . $field[1] . "<br>";
				}
			}

			if($field[0] == "company"){
				if(!empty($field[1])){
					$company = "<strong> ".__('Company:')." </strong> " . stripslashes($field[1]) . "<br>";
				}
			}

			if($field[0] == "website"){
				if(!empty($field[1])){
					$website = "<strong> ".__('Website:')." </strong> " . $field[1] . "<br>";
				}
			}

			if($field[0] == "subject"){
				$subject = $field[1];
			}


			if(!empty($full_name)){
				$name = $full_name;
			}elseif(!empty($first_name) && !empty($last_name)){
				$name = $first_name. " " .$last_name;
			}
		}
	
		$message = esc_textarea($_POST['message']);

		if(!empty($admin_email)){
			$to = $admin_email;
		}else{
			$to = get_option( 'admin_email' );
		}

		$headers = "From: $name <$email>" . "\r\n";
		$headers .= "Reply-To: ". $email . "\r\n";
		$headers .= "Content-Type: text/html;";

		$body = $company . $phone . $website . "<br>" . stripslashes($message) . "\r\n";

		if(wp_mail( $to, $subject, $body, $headers )){
			printf(
			    __( "Thank %s for your message. It has been sent.", 'tcard' ),
			    "<span>$name</span>"
			);
		}else{
			http_response_code(500);
			_e("There was an error trying to send your message. Please try again later.", 'tcard');
		}

		die();
	}

	/**
	 * @since 1.0.0
	 */

	public static function registration($group_id,$side,$skin) {

	    if ( isset( $_POST["tcard_register".$group_id.$side.$skin."_nonce"] ) && 
	    	wp_verify_nonce( $_POST["tcard_register".$group_id.$side.$skin."_nonce"], "tcard_register".$group_id.$side.$skin."_action" ) ){

			$username   			= sanitize_user( $_POST['tcard_username'.$group_id.$side.$skin] );
			$password   			= esc_attr( $_POST['tcard_password'.$group_id.$side.$skin] );
			$email      			= sanitize_email( $_POST['tcard_email'.$group_id.$side.$skin] );
			$website    			= esc_url( $_POST['tcard_website'.$group_id.$side.$skin] );
			$first_name 			= sanitize_text_field( $_POST['tcard_first_name'.$group_id.$side.$skin] );
			$last_name  			= sanitize_text_field( $_POST['tcard_last_name'.$group_id.$side.$skin] );
			$nickname   			= sanitize_text_field( $_POST['tcard_nickname'.$group_id.$side.$skin] );
			$description  			= esc_textarea( $_POST['tcard_description'.$group_id.$side.$skin] );
	 		
	 		$userdata = array(
		        'user_login'    =>   $username,
		        'user_email'    =>   $email,
		        'user_pass'     =>   $password,
		        'user_url'      =>   $website,
		        'first_name'    =>   $first_name,
		        'last_name'     =>   $last_name,
		        'nickname'      =>   $nickname,
		        'description'   =>   $description,
	        );
	        $user = wp_insert_user( $userdata );
	    }

	}

	/**
	 * @since    1.0.0
	 */
	public static function registration_validation($group_id,$side,$skin)  {
		
		if ( isset( $_POST["tcard_register".$group_id.$side.$skin."_nonce"] ) && 
	    	wp_verify_nonce( $_POST["tcard_register".$group_id.$side.$skin."_nonce"], "tcard_register".$group_id.$side.$skin."_action" ) ){
			global $reg_errors;
			$reg_errors = new WP_Error;

			$username   		= sanitize_user( $_POST['tcard_username'.$group_id.$side.$skin] );
        	$password   		= esc_attr( $_POST['tcard_password'.$group_id.$side.$skin] );
        	$rpassword 			= esc_attr( $_POST['tcard_repeat_password'.$group_id.$side.$skin] );
        	$email      		= sanitize_email( $_POST['tcard_email'.$group_id.$side.$skin] );
        	$website    		= esc_url( $_POST['tcard_website'.$group_id.$side.$skin] );
        	$first_name 		= sanitize_text_field( $_POST['tcard_first_name'.$group_id.$side.$skin] );
        	$last_name  		= sanitize_text_field( $_POST['tcard_last_name'.$group_id.$side.$skin] );
        	$nickname   		= sanitize_text_field( $_POST['tcard_nickname'.$group_id.$side.$skin] );
        	$description  		= esc_textarea( $_POST['tcard_description'.$group_id.$side.$skin] );

			if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
				$msg = __( 'Required form field is missing', 'tcard' );
			    $reg_errors->add('field', $msg);
			}

			if ( 4 > strlen( $username ) ) {
				$msg = __( 'Username too short. At least 4 characters is required', 'tcard' );
			    $reg_errors->add( 'username_length', $msg );
			}

			if ( username_exists( $username ) ){
				$msg = __( 'Sorry, that username already exists!', 'tcard' );
				$reg_errors->add('user_name', $msg);	
			}
				    
			if ( !validate_username( $username ) ) {
				$msg = __( 'Sorry, the username you entered is not valid', 'tcard' );
			    $reg_errors->add( 'username_invalid', $msg );
			}

			if ( 5 > strlen( $password ) ) {
					$msg = __( 'Password length must be greater than 5', 'tcard' );
			        $reg_errors->add( 'password', $msg );
			}
			
			if(isset($rpassword)){
				if ( $password !== $rpassword ) {
					$msg = __( 'Passwords do not match', 'tcard' );
				    $reg_errors->add( 'repeat_password', $msg );
				}
			}

			if ( !is_email( $email ) ) {
				$msg = __( 'Email is not valid', 'tcard' );
			    $reg_errors->add( 'email_invalid', $msg );
			}

			if ( email_exists( $email ) ) {
				$msg = __( 'Email Already in use', 'tcard' );
			    $reg_errors->add( 'email', $msg );
			}

			if ( ! empty( $website ) ) {
			    if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
			    	$msg = __( 'Website URL is not valid', 'tcard' );
			        $reg_errors->add( 'website', $msg );
			    }
			}

			$all_errors = array();
			if ( is_wp_error( $reg_errors ) ) {
			 
			    foreach ( $reg_errors->get_error_messages() as $error ) {
			     
			       $all_errors[] = $error;
			      
			    }
				return $all_errors; 
			}
		}

	}

	/**
	 * @since    1.0.0
	 */
	public static function login_redirect( $user, $username, $password ) {

		if (isset( $_POST['tcard_login_nonce'] ) && wp_verify_nonce( $_POST['tcard_login_nonce'], 'tcard_login_action' )){
		
	        if ( is_wp_error( $user ) ) {
	            $error_codes = join( ',', $user->get_error_codes() );
	            $login_url = sanitize_text_field( $_POST['redirect_to'] );
	            $login_url = add_query_arg( array(
					    'login' => $error_codes,
					    'username' => $username,
					), $login_url );
	            wp_redirect( $login_url );
	            exit;
	        }
		}

	    return $user;
	}

	/**
	 * @since    1.0.0
	 */
	public static function get_error_message_login($error,$username){
		switch ( $error ) {
	        case 'empty_username':
	            return __('The username field is empty.', 'tcard' );
	 
	        case 'empty_password':
	            return __('The password field is empty.', 'tcard' );
	 
	        case 'invalid_username':
	            $err = __("There is no account created with this username %s",'tcard');
	            return sprintf( $err, "<span>$username</span>" );
	            
	 		case 'invalid_email':
		 		$err = __("There is no user registered with this email address %s",'tcard');
		 		return sprintf( $err, "<span>$username</span>" );

		 	case 'empty_email':
		 		return __("The email field is empty.",'tcard');

	        case 'incorrect_password':
	            $err = __("The password you entered for the username %s is incorrect. %s Did you forget your password ? %s",
	                'tcard');
	            return sprintf( $err, "<span>$username</span>" ,"<a href=".wp_lostpassword_url().">" , '</a>');
	 
	        default:
	            break;
	    }
	}
}