<?php

namespace OnrampLab\CustomFields\Tests\Unit\Concerns;

use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use OnrampLab\CustomFields\Models\CustomField;
use OnrampLab\CustomFields\Tests\Classes\Account;
use OnrampLab\CustomFields\Tests\Classes\User;
use OnrampLab\CustomFields\Tests\Classes\UserAutoTransform;
use OnrampLab\CustomFields\Tests\TestCase;
use OnrampLab\CustomFields\ValueObjects\AvailableOption;

class CustomizableAutoTransformTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create();
        $attributes = [
            'key' => 'zip_code',
            'type' => 'text',
            'required' => false,
            'model_class' => User::class,
            'contextable_id' => $this->account->id,
            'contextable_type' => $this->account->getMorphClass()
        ];
        $this->customField = CustomField::factory()->create($attributes);
        $this->user = UserAutoTransform::factory()->create(['account_id' => $this->account->id, 'custom' => ['zip_code' => '12345']]);
    }

    /**
     * @test
     * @dataProvider customFieldDataProvider
     */
    public function custom_load_custom_field_values_should_work($type, $value, $expected, $required, $defaultValue): void
    {
        $attributes = [
            'key' => 'field',
            'type' => $type,
            'required' => $required,
            'default_value' => $defaultValue,
            'model_class' => UserAutoTransform::class,
            'contextable_id' => $this->account->id,
            'contextable_type' => $this->account->getMorphClass()
        ];

        $customField = CustomField::factory()->create($attributes);
        $user = UserAutoTransform::factory()->create(['account_id' => $this->account->id, 'custom' => ['field' => $value]]);
        $user->loadCustomFieldValues();
        $this->assertEquals($expected, $user->custom_field);
    }

    public function customFieldDataProvider(): array
    {
        return [
            'Text field from int' => ['text', 10, '10', true, ''],
            'Text field from float' => ['text', 10.1, '10.1', true, ''],
            'Text field from datetime' => ['text', Carbon::parse("2024/01/01 11:11:59"), '2024-01-01 11:11:59', true, ''],
        ];
    }
}
