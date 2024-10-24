<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Admins\ResetOutput;
use Albocode\CcatphpSdk\DTO\Api\TokenOutput;
use Albocode\CcatphpSdk\DTO\Api\Admins\AdminOutput;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AdminsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/admins';

    /**
     * @throws GuzzleException
     */
    public function token(string $username, string $password): TokenOutput
    {
        $httpClient = new Client([
            'base_uri' => $this->client->getHttpClient()->getHttpUri()
        ]);

        $response = $httpClient->post($this->formatUrl('/auth/token'), [
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
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function postAdmin(
        string $username,
        string $password,
        ?array $permissions = null,
        ?string $agentId = null,
        ?string $requestUserId = null
    ): AdminOutput {
        $payload = [
            'username' => $username,
            'password' => $password,
        ];
        if ($permissions !== null) {
            $payload['permissions'] = $permissions;
        }

        return $this->postJson(
            $this->prefix,
            AdminOutput::class,
            $payload,
            $agentId,
            $requestUserId,
        );
    }

    /**
     * @return AdminOutput[]
     * @throws GuzzleException|\JsonException
     */
    public function getAdmins(
        ?int $limit = null,
        ?int $skip = null,
        ?string $agentId = null,
        ?string $requestUserId = null
    ): array {
        $query = [];
        if ($limit) {
            $query['limit'] = $limit;
        }
        if ($skip) {
            $query['skip'] = $skip;
        }

        $response = $this->getHttpClient($agentId, $requestUserId)->get(
            $this->prefix,
            $query ? ['query' => $query] : []
        );

        $response = $this->client->getSerializer()->decode($response->getBody()->getContents(), 'json');
        $result = [];
        foreach ($response as $item) {
            $result[] = $this->deserialize(
                json_encode($item, JSON_THROW_ON_ERROR), AdminOutput::class, 'json'
            );
        }
        return $result;
    }

    /**
     * @throws GuzzleException
     */
    public function getAdmin(string $userId, ?string $agentId = null, ?string $requestUserId = null): AdminOutput
    {
        return $this->get(
            $this->formatUrl($userId),
            AdminOutput::class,
            $agentId,
            $requestUserId
        );
    }

    /**
     * @param array<string, mixed>|null $permissions
     *
     * @throws GuzzleException
     */
    public function putAdmin(
        string $userId,
        ?string $username = null,
        ?string $password = null,
        ?array $permissions = null,
        ?string $agentId = null,
        ?string $requestUserId = null,
    ): AdminOutput {
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
            $this->formatUrl($userId),
            AdminOutput::class,
            $payload,
            $agentId,
            $requestUserId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deleteAdmin(string $userId, ?string $agentId = null, ?string $requestUserId = null): AdminOutput
    {
        return $this->delete(
            $this->formatUrl($userId),
            AdminOutput::class,
            $agentId,
            $requestUserId
        );
    }

    /**
     * @throws GuzzleException
     */
    public function factoryReset(?string $agentId = null, ?string $requestUserId = null): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/utils/factory_reset/'),
            ResetOutput::class,
            [],
            $agentId,
            $requestUserId
        );
    }

    /**
     * @throws GuzzleException
     */
    public function agentReset(?string $agentId = null, ?string $requestUserId = null): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/utils/agent_reset/'),
            ResetOutput::class,
            [],
            $agentId,
            $requestUserId
        );
    }
}