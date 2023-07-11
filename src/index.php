<?php

require dirname(__DIR__).'/vendor/autoload.php';

$cCatClient = new \Albocode\CcatphpSdk\CCatClient('cheshire_cat_core');
//$promise = $cCatClient->rabbitHole('test.txt', null, null);
//$promise->wait();
$response = $cCatClient->sendMessage(new \Albocode\CcatphpSdk\Model\Message('chi e\' Marco?'));

var_dump($response);
