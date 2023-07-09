<?php

require dirname(__DIR__).'/vendor/autoload.php';

$cCatClient = new \Albocode\CcatphpSdk\CCatClient('cheshire_cat_core');
$response = $cCatClient->sendMessage(new \Albocode\CcatphpSdk\Model\Message('Ciao mi chiamo Marco'));

var_dump($response);