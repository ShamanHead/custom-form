<?php

add_action( 'wp_ajax_form_submit', 'endpoint' );

use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

function endpoint() {
    $data = $_POST['data'];
    $hubSpotKey = wpsf_get_setting( 'custom_forms', 'general', 'hubspot-key' );

    $log = new Logger('main');
    $log->pushHandler(
        new StreamHandler(
        CustomForm::$pluginPath . "/logs/main.log",
        Level::Info)
    );

    foreach($data as $d) {
        if($d === '') {
            echo json_encode(["code" => 500, "message" => "Some field not filled"]); 
              exit();
        }    
    }

    if(preg_match('/\S+@\S+\.\S+/', $data['email']) === 0) {
        echo json_encode(["code" => 501, "message" => "Email incorrect"]);
        die();
    } 

    $hubSpot = \HubSpot\Factory::createWithAccessToken($hubSpotKey);

    $filter = new \HubSpot\Client\Crm\Contacts\Model\Filter();
    $filter
        ->setOperator('EQ')
        ->setPropertyName('email')
        ->setValue($data['email']);
    
    $filterGroup = new \HubSpot\Client\Crm\Contacts\Model\FilterGroup();
    $filterGroup->setFilters([$filter]);
    
    $searchRequest = new \HubSpot\Client\Crm\Contacts\Model\PublicObjectSearchRequest();
    $searchRequest->setFilterGroups([$filterGroup]);
    
    $contactsPage = $hubSpot->crm()->contacts()->searchApi()->doSearch($searchRequest);

    $searchResult = $contactsPage->getResults();

    $contactProperties = new \HubSpot\Client\Crm\Contacts\Model\SimplePublicObjectInput();
    $contactProperties->setProperties([
        'email' => $data['email'],
        'firstname' => $data['firstName'],
        'lastname' => $data['lastName']       
    ]);

    try{
        if(count($searchResult) > 0) {        
            $hubSpot->crm()
                    ->contacts()
                    ->basicApi()
                    ->update($searchResult[0]->getId(), $contactProperties);
        } else {
            $hubSpot->crm()
                    ->contacts()
                    ->basicApi()
                    ->create($contactProperties);    
        }
    } catch(Exception $e) {
        echo json_encode(["code" => 501, "message" => "Email incorrect"]);
        die();
    } 

    $mail = mail($data['email'], $data['subject'], $data['message']); 

    if($mail !== true) {
        echo json_encode(["code" => 502, "message" => "Not send"]);
        die();
    } else {
        $log->info("New mail arrived. {$data['email']}");
    }

    echo json_encode(["code" => 200, "message" => "OK"]);
    die();
 
    return $data;
}
