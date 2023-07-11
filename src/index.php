<?php

require dirname(__DIR__).'/vendor/autoload.php';

$cCatClient = new \Albocode\CcatphpSdk\CCatClient(new \Albocode\CcatphpSdk\Clients\WSClient('cheshire_cat_core'), new \Albocode\CcatphpSdk\Clients\HttpClient('cheshire_cat_core'));

$response = $cCatClient->sendMessage(new \Albocode\CcatphpSdk\Model\Message('chi e\' Marco?'));

var_dump($response);
