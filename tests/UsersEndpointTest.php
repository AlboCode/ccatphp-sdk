<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class UsersEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws Exception|\JsonException|GuzzleException
     */
    public function testTokenSuccess(): void
    {
        $expected = [
            'access_token' => 'token',
            'token_type' => 'bearer',
        ];

        $cCatClient = $this->getCCatClient(null, $expected);
        try {
            $cCatClient->getHttpClient()->getClient();
        } catch (\Exception $e) {
            self::assertInstanceOf(\InvalidArgumentException::class, $e);
            self::assertEquals('You must provide an apikey or a token', $e->getMessage());
        }

        $endpoint = $cCatClient->users();
        $result = $endpoint->token('test-user', 'test-pass');

        self::assertEquals($expected['access_token'], $result->accessToken);
        self::assertEquals($expected['token_type'], $result->tokenType);

        $httpClient = $cCatClient->getHttpClient()->getClient();

        self::assertInstanceOf(Client::class, $httpClient);
    }

    /**
     * @throws \JsonException|GuzzleException|Exception
     */
    public function testPostUserSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'password' => 'password',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->users();
        $result = $endpoint->postUser($expected['username'], $expected['password'], $expected['permissions']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetUsersSuccess(): void
    {
        $expected = [
            [
                'username' => 'username',
                'permissions' => [
                    'permission' => ['permission'],
                ],
                'id' => 'id',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->users();
        $result = $endpoint->getUsers();

        self::assertCount(1, $result);
        self::assertEquals($expected[0]['username'], $result[0]->username);
        self::assertEquals($expected[0]['permissions'], $result[0]->permissions);
        self::assertEquals($expected[0]['id'], $result[0]->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetUserSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->users();
        $result = $endpoint->getUser($expected['id']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testPutUserSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'password' => 'password',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->users();
        $result = $endpoint->putUser(
            $expected['id'], $expected['username'], $expected['password'], $expected['permissions']
        );

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testDeleteUserSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->users();
        $result = $endpoint->deleteUser($expected['id']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetAvailablePermissionsSuccess(): void
    {
        $expected = [
            "STATUS" => ["READ"],
            "MEMORY" => ["READ", "LIST"],
            "CONVERSATION" => ["WRITE", "EDIT", "LIST", "READ", "DELETE"],
            "STATIC" => ["READ"],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->users();
        $result = $endpoint->getAvailablePermissions();

        self::assertEquals($expected, $result);
    }
}