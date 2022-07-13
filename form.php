<?php
/**
 * @package Form
 * @version 1
 */
/*
Plugin Name: Form 
Description: Just a form plugin
Author: Arseniy Romanovskiy
Version: 1
Author URI: https://github.com/ShamanHead 
*/

//some code here
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	//require_once( AKISMET__PLUGIN_DIR . 'class.form-admin.php' );
	//add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/lib/classes/custom-form.php";
require_once __DIR__ . "/lib/actions/form-ajax.php";

class CustomForm {

    private static $instance;

    public static function getInstance() {
    
      if ( null == self::$instance ) {
        self::$instance = new CustomForm();
      } 
    
      return self::$instance;
    
    }

    function __construct() {
       add_action('init', function() {
           if (isset($_GET['custom-form']) && !isset($_GET['json'])) {
               require_once __DIR__ . "/page.php";  
               exit();
           } 
       });
    }
}

add_action( 'plugins_loaded', array( 'CustomForm', 'getInstance' ) );
