<?php

namespace Albocode\CcatphpSdk\Tests;

use Albocode\CcatphpSdk\CcatUtility;
use Albocode\CcatphpSdk\Tests\Traits\TestTrait;
use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;

class SettingsEndpointTest extends TestCase
{
    use TestTrait;

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetSettingsSuccess(): void
    {
        $expected = [
            'settings' => [
                [
                    'name' => 'testSettingFirst',
                    'value' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                    'setting_id' => '123456789',
                    'updated_at' => '120323503863468943',
                ],
                [
                    'name' => 'testSettingSecond',
                    'value' => [
                        'property_first' => 'value_first',
                        'property_second' => 'value_second',
                    ],
                    'setting_id' => '234567890',
                    'updated_at' => '120323503863468243',
                ],
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->settings();
        $result = $endpoint->getSettings();

        foreach ($expected['settings'] as $key => $setting) {
            self::assertEquals($setting['name'], $result->settings[$key]->name);
            self::assertEquals($setting['setting_id'], $result->settings[$key]->settingId);
            self::assertEquals($setting['updated_at'], $result->settings[$key]->updatedAt);
            foreach ($setting['value'] as $property => $value) {
                self::assertEquals($value, $result->settings[$key]->value[$property]);
            }
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPostSettingSuccess(): void
    {
        $expected = [
            'setting' => [
                'name' => 'testSettingFirst',
                'value' => [
                    'property_first' => 'value_first',
                    'property_second' => 'value_second',
                ],
                'setting_id' => '234567890',
                'updated_at' => '120323503863468243',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->settings();
        $result = $endpoint->postSetting($expected);

        foreach ($expected['setting'] as $property => $value) {
            $p = CcatUtility::camelCase($property);
            self::assertEquals($value, $result->setting->{$p});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testGetSettingSuccess(): void
    {
        $expected = [
            'setting' => [
                'name' => 'testSettingFirst',
                'value' => [
                    'property_first' => 'value_first',
                    'property_second' => 'value_second',
                ],
                'setting_id' => '123456789',
                'updated_at' => '120323503863468943',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->settings();
        $result = $endpoint->getSetting('123456789');

        foreach ($expected['setting'] as $property => $value) {
            $p = CcatUtility::camelCase($property);
            self::assertEquals($value, $result->setting->{$p});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testPutSettingSuccess(): void
    {
        $expected = [
            'setting' => [
                'name' => 'testSettingFirst',
                'value' => [
                    'property_first' => 'value_first',
                    'property_second' => 'value_second',
                ],
                'setting_id' => '234567890',
                'updated_at' => '120323503863468243',
            ],
        ];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->settings();
        $result = $endpoint->putSetting('234567890', $expected);

        foreach ($expected['setting'] as $property => $value) {
            $p = CcatUtility::camelCase($property);
            self::assertEquals($value, $result->setting->{$p});
        }
    }

    /**
     * @throws GuzzleException|Exception|\JsonException
     */
    public function testDeleteSettingSuccess(): void
    {
        $expected = ['deleted' => true];

        $cCatClient = $this->getCCatClient($this->apikey, $expected);

        $endpoint = $cCatClient->settings();
        $result = $endpoint->deleteSetting('234567890');

        self::assertTrue($result->deleted);
    }
}