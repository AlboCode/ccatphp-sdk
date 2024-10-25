<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\TokenOutput;
use Albocode\CcatphpSdk\DTO\Api\User\UserOutput;
use GuzzleHttp\Exception\GuzzleException;

class UsersEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/users';

    /**
     * @throws GuzzleException
     */
    public function token(string $username, string $password): TokenOutput
    {
        $httpClient = $this->client->getHttpClient()->createHttpClient();

        $response = $httpClient->post('/auth/token', [
            'json' => [
                'username' => $username,
                'password' => $password,
            ],
        ]);

        /** @var TokenOutput $result */
        $result = $this->deserialize($response->getBody()->getContents(), TokenOutput::class);

        $this->client->addToken($result->accessToken);

        return $result;
    }

    /**
     * @throws GuzzleException
     */
    public function getAvailablePermissions(?string $agentId = null, ?string $userId = null): array
    {
        $response = $this->getHttpClient($agentId, $userId)->get('/auth/available-permissions');

        return $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
    }

    /**
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function postUser(
        string $username,
        string $password,
        ?array $permissions = null,
        ?string $agentId = null,
        ?string $requestUserId = null
    ): UserOutput {
        $payload = [
            'username' => $username,
            'password' => $password,
        ];
        if ($permissions !== null) {
            $payload['permissions'] = $permissions;
        }

        return $this->postJson(
            $this->prefix,
            UserOutput::class,
            $payload,
            $agentId,
            $requestUserId,
        );
    }

    /**
     * @return UserOutput[]
     * @throws GuzzleException|\JsonException
     */
    public function getUsers(?string $agentId = null, ?string $requestUserId = null): array
    {
        $response = $this->getHttpClient($agentId, $requestUserId)->get($this->prefix);

        $response = $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
        $result = [];
        foreach ($response as $item) {
            $result[] = $this->deserialize(
                json_encode($item, JSON_THROW_ON_ERROR), UserOutput::class, 'json'
            );
        }
        return $result;
    }

    /**
     * @throws GuzzleException
     */
    public function getUser(string $userId, ?string $agentId = null, ?string $requestUserId = null): UserOutput
    {
        return $this->get(
            $this->formatUrl($userId),
            UserOutput::class,
            $agentId,
            $requestUserId
        );
    }

    /**
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function putUser(
        string $userId,
        ?string $username = null,
        ?string $password = null,
        ?array $permissions = null,
        ?string $agentId = null,
        ?string $requestUserId = null,
    ): UserOutput {
        $payload = [];
        if ($username !== null) {
            $payload['username'] = $username;
        }
        if ($password !== null) {
            $payload['password'] = $password;
        }
        if ($permissions !== null) {
            $payload['permissions'] = $permissions;
        }

        return $this->put(
            sprintf('/users/%s', $userId),
            UserOutput::class,
            $payload,
            $agentId,
            $requestUserId,
        );
    }

    public function deleteUser(string $userId, ?string $agentId = null, ?string $requestUserId = null): UserOutput
    {
        return $this->delete(
            sprintf('/users/%s', $userId),
            UserOutput::class,
            $agentId,
            $requestUserId
        );
    }
}