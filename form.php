<?php
/**
 * @package Hello_Dolly
 * @version 1.7.2
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

require_once __DIR__ . "/classes/custom-form.php";

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	//require_once( AKISMET__PLUGIN_DIR . 'class.form-admin.php' );
	//add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}
add_action('init', function() {
  if (isset($_GET['custom-form'])) {
    require_once __DIR__ . "/page.php";  
    exit();

    //$load = locate_template('single.php', true);
    // if ($load) {
    //    exit(); // just exit if template was found and loaded
    // } else die("here");
  }
});

