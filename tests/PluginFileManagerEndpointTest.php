<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\Builders\SettingInputBuilder;
use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class PluginFileManagerEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetPluginFileManagersSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'testPluginFileManager',
                    'value' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                ],
            ],
            'selected_configuration' => 'testPluginFileManager',
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->pluginFileManager();
        $result = $endpoint->getPluginFileManagersSettings();

        foreach ($expected['settings'] as $key => $setting) {
            self::assertEquals($setting['name'], $result->settings[$key]->name);
            foreach ($setting['value'] as $property => $value) {
                self::assertEquals($value, $result->settings[$key]->value[$property]);
            }
        }
        self::assertEquals($expected['selected_configuration'], $result->selectedConfiguration);
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testGetPluginFileManagerSettingsSuccess(): void
    {
        $expected = [
            'name' => 'testPluginFileManager',
            'value' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
            'scheme' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->pluginFileManager();
        $result = $endpoint->getPluginFileManagerSettings('testPluginFileManager');

        foreach ($expected as $property => $value) {
            /** @var array<string, string> $property */
            if (in_array($property, ['scheme', 'value'])) {
                /** @var array<string, string> $value */
                foreach ($value as $subProperty => $subValue) {
                    self::assertEquals($subValue, $result->scheme[$subProperty]);
                }
            } else {
                self::assertEquals($value, $result->$property);
            }
        }
    }

    /**
     * @throws GuzzleException|\JsonException|Exception
     */
    public function testPutPluginFileManagerSettingsSuccess(): void
    {
        $expected = [
            'name' => 'testPluginFileManager',
            'value' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
            'scheme' => [
                'property_first' => 'value_first',
                'property_second' => 'value_second',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);
        $settingInput = SettingInputBuilder::create()
            ->setName($expected['name'])
            ->setValue($expected['value'])
            ->setCategory('testCategory')
            ->build();

        $endpoint = $cCatClient->pluginFileManager();
        $result = $endpoint->putPluginFileManagerSettings('testPluginFileManager', $settingInput);

        foreach ($expected as $property => $value) {
            /** @var array<string, string> $property */
            if (in_array($property, ['scheme', 'value'])) {
                /** @var array<string, string> $value */
                foreach ($value as $subProperty => $subValue) {
                    self::assertEquals($subValue, $result->scheme[$subProperty]);
                }
            } else {
                self::assertEquals($value, $result->$property);
            }
        }
    }
}