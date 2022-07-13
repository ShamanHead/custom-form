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

require_once __DIR__ . "/classes/custom-form.php";
require_once __DIR__ . "/classes/hubspot.php";

define("FORM_PATH", plugin_dir_path(__FILE__));

function addContact($email, $firstName, $lastName) {
        $arr = array(
            'properties' => array(
                array(
                    'property' => 'email',
                    'value' => $email
                ),
                array(
                    'property' => 'firstname',
                    'value' => $firstName
                ),
                array(
                    'property' => 'lastname',
                    'value' => $lastName
                )
            )
        );
        $post_json = json_encode($arr);
        $hapikey = "eu1-f4e4-2852-4a39-a317-82db1ad6499b";
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $hapikey;
        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
    }

if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
	//require_once( AKISMET__PLUGIN_DIR . 'class.form-admin.php' );
	//add_action( 'init', array( 'Akismet_Admin', 'init' ) );
}
add_action('init', function() {
  if (isset($_GET['custom-form']) && !isset($_GET['json'])) {
    require_once __DIR__ . "/page.php";  
    exit();

    //$load = locate_template('single.php', true);
    // if ($load) {
    //    exit(); // just exit if template was found and loaded
    // } else die("here");
  } else if(isset($_GET['custom-form']) && isset($_GET['json'])) {
      $data = $_POST;

      foreach($data as $d) {
          if($d === '') {
              echo json_encode(["code" => 500, "message" => "Some error occurs"]); 
                exit();
          }    
      }

      if(preg_match('/\S+@\S+\.\S+/', $data['email']) === false) {
          echo json_encode(["code" => 501, "message" => "Email incorrect"]);
          die();
      }

      $mail = mail($_POST['email'], $_POST['subject'], $_POST['message']);

      addContact($_POST['email'], $_POST['firstName'], $_POST['lastName']);

      if($mail !== true) {
        echo json_encode(["code" => 502, "message" => "Not send"]);
      }
//eu1-f4e4-2852-4a39-a317-82db1ad6499b
      echo json_encode(["code" => 200, "message" => "OK"]);
      die();
  }
});

