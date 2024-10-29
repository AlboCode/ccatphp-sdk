<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\DTO\Api\Plugin\PluginsSettingsOutput;
use Albocode\CcatphpSdk\DTO\Api\Plugin\Settings\PluginSettingsOutput;
use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PluginsEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetAvailablePluginsSuccess(): void
    {
        $expected = [
            'filters' => [
                'query' => null,
            ],
            'installed' => [
                [
                    'id' => '1',
                    'name' => 'Plugin 1',
                    'description' => 'Description 1',
                    'author_name' => 'Author 1',
                    'author_url' => 'https://author1.com',
                    'plugin_url' => 'https://plugin1.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb1.com',
                    'version' => '1.0.0',
                    'active' => true,
                    'hooks' => [],
                    'tools' => []
                ],
                [
                    'id' => '2',
                    'name' => 'Plugin 2',
                    'description' => 'Description 2',
                    'author_name' => 'Author 2',
                    'author_url' => 'https://author2.com',
                    'plugin_url' => 'https://plugin2.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb2.com',
                    'version' => '1.0.0',
                    'active' => true,
                    'hooks' => [],
                    'tools' => []
                ]
            ],
            'registry' => [
                [
                    'id' => '1',
                    'name' => 'Plugin 1',
                    'description' => 'Description 1',
                    'author_name' => 'Author 1',
                    'author_url' => 'https://author1.com',
                    'plugin_url' => 'https://plugin1.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb1.com',
                    'version' => '1.0.0',
                    'url' => 'https://plugin1.com',
                ],
                [
                    'id' => '2',
                    'name' => 'Plugin 2',
                    'description' => 'Description 2',
                    'author_name' => 'Author 2',
                    'author_url' => 'https://author2.com',
                    'plugin_url' => 'https://plugin2.com',
                    'tags' => 'tag1, tag2',
                    'thumb' => 'https://thumb2.com',
                    'version' => '1.0.0',
                    'url' => 'https://plugin2.com',
                ]
            ]
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->plugins();
        $result = $endpoint->getAvailablePlugins();

        self::assertEquals($expected, $result->toArray());
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testTogglePluginSuccess(): void
    {
        $pluginId = 'plugin_1';
        $expected = [
            'info' => 'Plugin plugin_1 toggled',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->plugins();
        $result = $endpoint->togglePlugin($pluginId);

        self::assertEquals($expected['info'], $result->info);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetPluginsSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'setting1',
                    'value' => [
                        'type' => 'string',
                        'value' => 'value1',
                    ],
                    'scheme' => [
                        'title' => 'Setting 1',
                        'type' => 'hook',
                        'properties' => [
                            'property1' => [
                                'title' => 'Property 1',
                                'type' => 'string',
                                'default' => 'default1',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'setting2',
                    'value' => [
                        'type' => 'string',
                        'value' => 'value2',
                    ],
                    'scheme' => [
                        'title' => 'Setting 2',
                        'type' => 'form',
                        'properties' => [
                            'property1' => [
                                'title' => 'Property 2',
                                'type' => 'string',
                                'default' => 'default2',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->plugins();
        $result = $endpoint->getPluginsSettings();

        self::assertInstanceOf(PluginsSettingsOutput::class, $result);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetPluginSettingsSuccess(): void
    {
        $expected = [
            'name' => 'setting1',
            'value' => [
                'type' => 'string',
                'value' => 'value1',
            ],
            'scheme' => [
                'title' => 'Setting 1',
                'type' => 'hook',
                'properties' => [
                    'property1' => [
                        'title' => 'Property 1',
                        'type' => 'string',
                        'default' => 'default1',
                    ],
                ],
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->plugins();
        $result = $endpoint->getPluginSettings($expected['name']);

        self::assertInstanceOf(PluginSettingsOutput::class, $result);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPutPluginSettingsSuccess(): void
    {
        $expected = [
            'name' => 'setting1',
            'value' => [
                'type' => 'string',
                'value' => 'value1',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->plugins();
        $result = $endpoint->putPluginSettings(
            $expected['name'], ['setting_a' => 'some value', 'setting_b' => 'another value']
        );

        self::assertInstanceOf(PluginSettingsOutput::class, $result);
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetPluginDetailsSuccess(): void
    {
        $expected = [
            'data' => [
                'title' => 'Setting 1',
                'active' => true,
                'hooks' => [
                    ['name' => 'hook1', 'priority' => 1],
                    ['name' => 'hook2', 'priority' => 0],
                ],
                'tools' => [
                    ['name' => 'tool1', 'priority' => 1],
                    ['name' => 'tool2', 'priority' => 0],
                ],
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->plugins();
        $result = $endpoint->getPluginDetails('setting1');

        self::assertEquals($expected['data'], $result->data);
    }
}