<?php

namespace Albocode\CcatphpSdk;

use Albocode\CcatphpSdk\Endpoints\AbstractEndpoint;

class CCatFactory
{
    public static function build(string $class, CCatClient $client): AbstractEndpoint
    {
        if (!class_exists($class)) {
            throw new \BadMethodCallException();
        }

        return new $class($client);
    }
}
