<?php

use Albocode\CcatphpSdk\Model\Message;

require dirname(__DIR__).'/vendor/autoload.php';

$cCatClient = new \Albocode\CcatphpSdk\CCatClient(new \Albocode\CcatphpSdk\Clients\WSClient('cheshire_cat_core'), new \Albocode\CcatphpSdk\Clients\HttpClient('cheshire_cat_core'));

$response = $cCatClient->deleteDeclarativeMemoryByMetadata(["source" => "FastAPI - Swagger UI.pdf"]);
//try {
//    $response = $cCatClient->sendMessage(new Message('Hello message', 'user', []));
//} catch (Exception $e) {
//    var_dump($e->getMessage());
//}

var_dump($response);
