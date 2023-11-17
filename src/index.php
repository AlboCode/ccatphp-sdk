<?php
require dirname(__DIR__).'/vendor/autoload.php';

use Albocode\CcatphpSdk\CCatClient;
use Albocode\CcatphpSdk\Clients\HttpClient;
use Albocode\CcatphpSdk\Clients\WSClient;


$cCatClient = new CCatClient(new WSClient('cheshire_cat_core'), new HttpClient('cheshire_cat_core', null, 'meow'));

$response = $cCatClient->getMemoryCollection();
$response = $cCatClient->sendMessage(new \Albocode\CcatphpSdk\Model\Message("Ciao come stai?"));
var_dump($response);
