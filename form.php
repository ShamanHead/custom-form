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
require_once __DIR__ . "/lib/actions/form-ajax.php";
require_once __DIR__ . "/wp-settings-framework/wp-settings-framework.php";

class CustomForm {

    private static $instance;
    private static $pluginPath;
    private static $templatePath;
    
    private $wpsf;

    protected $templates;

    public static function getInstance() 
    { 
        if ( null == self::$instance ) {
            self::$pluginPath = plugin_dir_path(__FILE__);
            self::$templatePath = self::$pluginPath . "/templates/";
            self::$instance = new CustomForm();
        } 
    
        return self::$instance;
    
    }

    function __construct() {
        $this->wpsf = new WordPressSettingsFramework(
            self::$pluginPath . 'settings-api/example-settings.php',
            'custom_forms' 
        );
        
        add_action( 'admin_menu', array( $this, 'setupSettingsPage' ), 20 );

        $this->templates = [
            'custom-form' => self::$templatePath . "/page.php"
        ]; 

        add_action( "wp_footer", [$this, "addJavascript"] );
        add_action( "wp_head", [$this, "addStyle"] );
        add_filter( "template_include", [$this, "templateInclude"] );

        //die(print_r($this->wpsf->get_settings()));

    }

    public function setupSettingsPage() 
    {
        $this->wpsf->add_settings_page( array(
			'page_title'  => __( 'Page Title', 'text-domain' ),
			'menu_title'  => __( 'menu Title', 'text-domain' ),
		) );
    }

    public function templateInclude($template)
    {
        $uri = explode("/", $_SERVER['REQUEST_URI']);
        $templateRequest = end($uri);

        for($i = 0, $keys = array_keys($this->templates);
            $i < count($keys);
            $i++) {
            if($templateRequest === $keys[$i]) {
                return $this->templates[$keys[$i]];
            }
        }

        return $template;

    }

    public function addStyle () 
    {
        wp_enqueue_style("custom-form-style", plugins_url() . "/form/public/assets/css/style.css"); 
   
    }

    public function addJavascript() 
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'the-script-handle', 
                           plugins_url() . "/form/public/assets/js/index.js", 
                           [ 'jquery' ], 
                           '1.0', 
                           true);

    }
}

add_action( 'plugins_loaded', array( 'CustomForm', 'getInstance' ) );
