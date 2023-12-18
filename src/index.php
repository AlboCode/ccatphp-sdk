<?php
//
//require dirname(__DIR__).'/vendor/autoload.php';
//
//use Albocode\CcatphpSdk\CCatClient;
//use Albocode\CcatphpSdk\Clients\HttpClient;
//use Albocode\CcatphpSdk\Clients\WSClient;
//
//$cCatClient = new CCatClient(new WSClient('cheshire_cat_core'), new HttpClient('cheshire_cat_core', null, 'meow'));
//
//try {
//    //    $response = $cCatClient->putPluginSettings("cat_advanced_tools", [
//    //
//    //        "prompt_prefix" => "You are a supportive AI that help during hard time" ,
//    //        "episodic_memory_k" => 3,
//    //        "episodic_memory_threshold" => 0.7,
//    //        "declarative_memory_k" => 3,
//    //        "declarative_memory_threshold" => 0.7,
//    //        "procedural_memory_k" => 3,
//    //        "procedural_memory_threshold" => 0.7,
//    //        "user_name" => "Human",
//    //        "language" => "English"
//    //
//    //    ]);
//    //    $response = $cCatClient->deleteConversationHistory();
//    echo "<pre>";
//    //    var_dump($response);
//    echo "</pre>";
//
//} catch (Exception $exception) {
//    var_dump($exception->getMessage());
//}
////$response = $cCatClient->sendMessage(new \Albocode\CcatphpSdk\Model\Message("Ciao come stai?", "test"), fn($message) => var_dump($message));
////var_dump($response);
