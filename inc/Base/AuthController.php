<?php
/**
 * @package  sandip-plugin
 */
namespace Inc\Base;

use \Inc\Base\BaseController;

class AuthController extends BaseController{

    public $isActivated;

    public function register(){
        $this->isActivated = get_option( "front_login" );

        if($this->isActivated == 1){
            /* Enqueue Styles and Scripts for the Front End Login Form */
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
            /* This hook will add this code at the end of the head tag OR at the start of the Page */
            add_action( 'wp_head', array( $this, 'add_auth_template' ) );
            /* action to handle the ajax request */
            add_action( "wp_ajax_nopriv_sandip_auth_ajax", array($this, "login") );

        }
    
    }

    public function enqueue(){
        wp_enqueue_style( "auth-sandip-login-style", $this->pluginURL.'src/adminstyles.css');
        wp_enqueue_script( "auth-sandip-login-script", $this->pluginURL.'src/auth.js', $deps= array(), $ver = 1.0, $in_footer = true );
    }

    public function add_auth_template(){
        /* If the user is not logged In Show the Login Form */
        if (is_user_logged_in()){
            return;
        }else{
            $templatefile = $this->pluginPATH."/templates/authTemplate.php";

            if(file_exists($templatefile)){
                load_template( $templatefile, true );
            }
        }
    }

    public function login(){
        check_ajax_referer( 'ajax-login-nonce', 'sandip_auth'  );

        $info = array();
        $info["user_login"] = $_POST["username"];
        $info["user_password"] = $_POST["password"];
        $info["remember"] = true;

        /*
        This is return a boolean according to username and password passed 
        second arg true means save a cookie and remember this username
        */
        $user_sign_in = wp_signon( $info, true );

        if ( is_wp_error( $user_sign_in) ) {
			echo json_encode(
				array(
					'status' => false,
					'message' => 'Wrong username or password'
				)
			);
			die();
		}else{
            echo json_encode(
                array(
                    'status' => true,
                    'message' => 'Login successful, redirecting...'
                )
            );
            die();
        }
    }
}