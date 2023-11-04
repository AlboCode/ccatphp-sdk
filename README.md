# ccatphp-sdk

----

**CCat PHP SDK (Cheshire cat PHP SDK)** is a library to help the implementation
of [Cheshire Cat](https://github.com/cheshire-cat-ai/core) on a PHP Project

* [Installation](#installation)
* [Usage](#usage)

## Installation

To install CCatPHP-SDK you can run this command:
```cmd
composer require albocode/ccatphp-sdk
```


## Usage
Initialization and usage:

```php
use Albocode\CcatphpSdk\CCatClient;
use Albocode\CcatphpSdk\Clients\HttpClient;
use Albocode\CcatphpSdk\Clients\WSClient;


$cCatClient = new CCatClient(
new WSClient('cheshire_cat_core', 1865, null),
new HttpClient('cheshire_cat_core', 1865, null)
);
```
Send a message to the websocket:

```php
$notificationClosure = function (string $message) {
 // handle websocket notification, like chat token stream
}

// result is the result of the message
$result = $cCatClient->sendMessage(
new Message("Hello world!", 'user', []),  // message body
$notificationClosure // websocket notification closure handle
);

```

Load data to the rabbit hole:
```php
//file
$promise = $this->client->rabbitHole($uploadedFile->getPathname(), null, null);
$promise->wait();

//url
$promise = $this->client->rabbitHoleWeb($url, null,null);
$promise->wait();
```

Memory management utilities:

```php
$this->client->getMemoryCollection(); // get number of vectors in the working memory
$this->client->getMemoryRecall("HELLO"); // recall memories by text

//delete memory points by metadata, like this example delete by source
$this->client->deleteDeclarativeMemoryByMetadata(["source" => $url]);
```