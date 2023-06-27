<?php

namespace OnrampLab\CustomFields\Tests\Unit\Concerns;

use Illuminate\Validation\ValidationException;
use OnrampLab\CustomFields\Models\CustomField;
use OnrampLab\CustomFields\Tests\Classes\Account;
use OnrampLab\CustomFields\Tests\Classes\User;
use OnrampLab\CustomFields\Tests\TestCase;
use OnrampLab\CustomFields\ValueObjects\AvailableOption;

class CustomizableTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create();
        $attributes = [
            'key' => 'zip_code',
            'type' => 'text',
            'model_class' => User::class,
            'contextable_id' => $this->account->id,
            'contextable_type' => $this->account->getMorphClass()
        ];
        $this->customField = CustomField::factory()->create($attributes);
        $this->user = User::factory()->create(['account_id' => $this->account->id, 'custom' => ['zip_code' => '12345']]);
    }

    /**
     * @test
     */
    public function custom_field_values_relationship_should_work(): void
    {
        $customFieldValues = $this->user->customFieldValues;
        $this->assertCount(1, $customFieldValues);
        $this->assertEquals($this->user->id, $customFieldValues->first()->customizable_id);
        $this->assertEquals(get_class($this->user), $customFieldValues->first()->customizable_type);
    }

    /**
     * @test
     */
    public function validate_custom_fields_should_work()
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create(['account_id' => $this->account->id, 'custom' => ['zip_code' => 123]]);
    }

    /**
     * @test
     * @dataProvider customFieldDataProvider
     */
    public function custom_load_custom_field_values_should_work($type, $value, $expected): void
    {
        $attributes = [
            'key' => 'field',
            'type' => $type,
            'model_class' => User::class,
            'contextable_id' => $this->account->id,
            'contextable_type' => $this->account->getMorphClass()
        ];
        if ($type == 'select') {
            $attributes['available_options'] = [
                new AvailableOption([
                    'name' => 'Option 1',
                    'value' => 'Option 1',
                ]),
                new AvailableOption([
                    'name' => 'Option 2',
                    'value' => 'Option 2',
                ])
            ];
        }
        $customField = CustomField::factory()->create($attributes);
        $user = User::factory()->create(['account_id' => $this->account->id, 'custom' => ['field' => $value]]);
        $user->loadCustomFieldValues();
        $this->assertEquals($expected, $user->custom_field);
    }

    public function customFieldDataProvider(): array
    {
        return [
            'Text field' => ['text', 'Value', 'Value'],
            'Integer field' => ['integer', '42', 42],
            'Float field' => ['float', '3.14', 3.14],
            'Datetime field' => ['datetime', '2023-05-16 12:34:56', '2023-05-16 12:34:56'],
            'Select field' => ['select', 'Option 1', 'Option 1'],
            'Boolean field' => ['boolean', '1', true],
        ];
    }
}
