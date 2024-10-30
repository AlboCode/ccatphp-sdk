<?php

namespace Albocode\CcatphpSdk;

use Albocode\CcatphpSdk\Clients\HttpClient;
use Albocode\CcatphpSdk\Clients\WSClient;
use Albocode\CcatphpSdk\Endpoints\AbstractEndpoint;
use Symfony\Component\PropertyInfo\Extractor\ConstructorExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @method \Albocode\CcatphpSdk\Endpoints\AdminsEndpoint admins()
 * @method \Albocode\CcatphpSdk\Endpoints\AuthHandlerEndpoint authHandler()
 * @method \Albocode\CcatphpSdk\Endpoints\EmbedderEndpoint embedder()
 * @method \Albocode\CcatphpSdk\Endpoints\LargeLanguageModelEndpoint largeLanguageModel()
 * @method \Albocode\CcatphpSdk\Endpoints\MemoryEndpoint memory()
 * @method \Albocode\CcatphpSdk\Endpoints\MessageEndpoint message()
 * @method \Albocode\CcatphpSdk\Endpoints\PluginsEndpoint plugins()
 * @method \Albocode\CcatphpSdk\Endpoints\PluginFileManagerEndpoint pluginFileManager()
 * @method \Albocode\CcatphpSdk\Endpoints\RabbitHoleEndpoint rabbitHole()
 * @method \Albocode\CcatphpSdk\Endpoints\SettingsEndpoint settings()
 * @method \Albocode\CcatphpSdk\Endpoints\UsersEndpoint users()
 */
class CCatClient
{
    private WSClient $wsClient;
    private HttpClient $httpClient;
    private Serializer $serializer;

    public function __construct(WSClient $wsClient, HttpClient $httpClient, ?string $token = null)
    {
        $this->wsClient = $wsClient;
        $this->httpClient = $httpClient;

        if ($token) {
            $this->addToken($token);
        }

        $phpDocExtractor = new PhpDocExtractor();
        $typeExtractor = new PropertyInfoExtractor(
            typeExtractors: [ new ConstructorExtractor([$phpDocExtractor]), $phpDocExtractor,]
        );
        $normalizer = new ObjectNormalizer(
            null,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            propertyTypeExtractor: $typeExtractor
        );

        $encoder = new JsonEncoder();

        $this->serializer = new Serializer([$normalizer, new ArrayDenormalizer()], [$encoder]);
    }

    public function addToken(string $token): self
    {
        $this->wsClient->setToken($token);
        $this->httpClient->setToken($token);
        return $this;
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }

    public function getWsClient(): WSClient
    {
        return $this->wsClient;
    }

    public function getSerializer(): Serializer
    {
        return $this->serializer;
    }

    public function __call(string $method, $args): AbstractEndpoint
    {
        return CCatFactory::build(
            __NAMESPACE__ . CcatUtility::classize($method),
            $this
        );
    }
}
