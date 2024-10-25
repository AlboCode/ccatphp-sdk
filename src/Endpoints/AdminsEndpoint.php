<?php

namespace Albocode\CcatphpSdk\Endpoints;

use Albocode\CcatphpSdk\DTO\Api\Admins\ResetOutput;
use Albocode\CcatphpSdk\DTO\Api\TokenOutput;
use Albocode\CcatphpSdk\DTO\Api\Admins\AdminOutput;
use GuzzleHttp\Exception\GuzzleException;

class AdminsEndpoint extends AbstractEndpoint
{
    protected string $prefix = '/admins';

    /**
     * @throws GuzzleException
     */
    public function token(string $username, string $password): TokenOutput
    {
        $httpClient = $this->client->getHttpClient()->createHttpClient();

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
        ?string $adminId = null
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
            $this->systemId,
            $adminId,
        );
    }

    /**
     * @return AdminOutput[]
     * @throws GuzzleException|\JsonException
     */
    public function getAdmins(?int $limit = null, ?int $skip = null, ?string $adminId = null): array
    {
        $query = [];
        if ($limit) {
            $query['limit'] = $limit;
        }
        if ($skip) {
            $query['skip'] = $skip;
        }

        $response = $this->getHttpClient($this->systemId, $adminId)->get(
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
    public function getAdmin(string $adminId, ?string $loggedAdminId = null): AdminOutput
    {
        return $this->get(
            $this->formatUrl($adminId),
            AdminOutput::class,
            $this->systemId,
            $loggedAdminId
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
        ?string $adminId = null,
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
            $this->systemId,
            $adminId,
        );
    }

    /**
     * @throws GuzzleException
     */
    public function deleteAdmin(string $adminId, ?string $loggedUserId = null): AdminOutput
    {
        return $this->delete(
            $this->formatUrl($adminId),
            AdminOutput::class,
            $this->systemId,
            $loggedUserId
        );
    }

    /**
     * @throws GuzzleException
     */
    public function factoryReset(?string $adminId = null): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/utils/factory_reset/'),
            ResetOutput::class,
            [],
            $this->systemId,
            $adminId
        );
    }

    /**
     * @throws GuzzleException
     */
    public function agentReset(?string $adminId = null): ResetOutput
    {
        return $this->postJson(
            $this->formatUrl('/utils/agent_reset/'),
            ResetOutput::class,
            [],
            $this->systemId,
            $adminId
        );
    }
}