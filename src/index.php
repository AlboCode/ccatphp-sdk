<?php
require dirname(__DIR__).'/vendor/autoload.php';

use Albocode\CcatphpSdk\CCatClient;
use Albocode\CcatphpSdk\Clients\HttpClient;
use Albocode\CcatphpSdk\Clients\WSClient;


$cCatClient = new CCatClient(new WSClient('cheshire_cat_core'), new HttpClient('cheshire_cat_core'));

$response = $cCatClient->deleteDeclarativeMemoryByMetadata(["source" => "FastAPI - Swagger UI.pdf"]);
//try {
//    $response = $cCatClient->sendMessage(new Message('Hello message', 'user', []));
//} catch (Exception $e) {
//    var_dump($e->getMessage());
//}

var_dump($response);
