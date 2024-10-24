<?php

namespace Albocode\CcatphpSdk\Tests;

use GuzzleHttp\Exception\GuzzleException;

class AdminsEndpointTest extends BaseTest
{
    /**
     * @throws \JsonException|GuzzleException
     */
    public function testPostAdminSuccess(): void
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

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->postAdmin($expected['username'], $expected['password'], $expected['permissions']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    public function testGetAdminsSuccess(): void
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

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->getAdmins();

        self::assertCount(1, $result);
        self::assertEquals($expected[0]['username'], $result[0]->username);
        self::assertEquals($expected[0]['permissions'], $result[0]->permissions);
        self::assertEquals($expected[0]['id'], $result[0]->id);
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    public function testGetAdminSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->getAdmin($expected['id']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    public function testPutAdminSuccess(): void
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

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->putAdmin(
            $expected['id'], $expected['username'], $expected['password'], $expected['permissions']
        );

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    public function testDeleteAdminSuccess(): void
    {
        $expected = [
            'username' => 'username',
            'permissions' => [
                'permission' => ['permission'],
            ],
            'id' => 'id',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->deleteAdmin($expected['id']);

        self::assertEquals($expected['username'], $result->username);
        self::assertEquals($expected['permissions'], $result->permissions);
        self::assertEquals($expected['id'], $result->id);
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    public function testFactoryResetSuccess(): void
    {
        $expected = [
            'deleted_settings' => true,
            'deleted_memories' => true,
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->factoryReset();

        self::assertTrue($result->deletedSettings);
        self::assertTrue($result->deletedMemories);
    }

    /**
     * @throws GuzzleException|\JsonException
     */
    public function testAgentResetSuccess(): void
    {
        $expected = [
            'deleted_settings' => true,
            'deleted_memories' => true,
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $adminsEndpoint = $cCatClient->admins();
        $result = $adminsEndpoint->agentReset();

        self::assertTrue($result->deletedSettings);
        self::assertTrue($result->deletedMemories);
    }
}