<?php

add_action( 'wp_ajax_form_submit', 'endpoint' );

function endpoint() {
    $data = $_POST['data']; 
    foreach($data as $d) {
        if($d === '') {
            echo json_encode(["code" => 500, "message" => "Some field not filled"]); 
              exit();
        }    
    }

    if(preg_match('/\S+@\S+\.\S+/', $data['email']) === false) {
        echo json_encode(["code" => 501, "message" => "Email incorrect"]);
        die();
    }

    $mail = mail($_POST['email'], $_POST['subject'], $_POST['message']);

    $hubSpot = \HubSpot\Factory::createWithAccessToken('pat-eu1-7d6028c8-92d2-47f6-a237-67fbf355c40b');

    $contactInput = new \HubSpot\Client\Crm\Contacts\Model\SimplePublicObjectInput();
    $contactInput->setProperties([
        'email' => $_POST['email'],
        'firstname' => $_POST['firstName'],
        'lastname' => $_POST['lastName']
    ]);

    $contact = $hubSpot->crm()->contacts()->basicApi()->create($contactInput);
 
    //if($mail !== true) {
    //    echo json_encode(["code" => 502, "message" => "Not send"]);
    //    die();
    //}

    echo json_encode(["code" => 200, "message" => "OK"]);
    die();
 
    return $data;
}
