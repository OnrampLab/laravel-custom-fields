# laravel-custom-fields

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![CircleCI](https://circleci.com/gh/OnrampLab/laravel-custom-fields.svg?style=shield)](https://circleci.com/gh/OnrampLab/laravel-custom-fields)
[![Total Downloads](https://img.shields.io/packagist/dt/onramplab/laravel-custom-fields.svg?style=flat-square)](https://packagist.org/packages/onramplab/laravel-custom-fields)

The purpose of this package is to enable custom field support for any Laravel models.

Custom fields can be utilized to extend a model and offer a more flexible approach for incorporating additional fields, without requiring the addition of new attributes to the database model.
## Requirements

- PHP >= 8;
- Laravel >= 8
- composer.

## Features

- **Dynamic Custom Fields**: The package allows you to define and manage custom fields for your models dynamically. You can add, update, and remove custom fields without modifying the underlying database structure.

- **Polymorphic Relationship**: The package supports a polymorphic relationship between custom fields and the models that provide the context. This means you can associate custom fields with different types of models, providing flexibility and customization in managing and retrieving custom field data based on the context.

- **Flexible Field Types**: The package supports various field types, including string, integer, float, datetime, select, and boolean. You can choose the appropriate field type based on your requirements.

- **Validation**: Custom fields can be validated using Laravel's validation rules. You can define validation rules for each custom field to ensure the entered values meet the specified criteria.

- **Default Values**: You can set default values for custom fields, which will be automatically populated if no value is provided during data entry.

- **User-Friendly Naming**: Custom fields can be assigned user-friendly names to enhance readability and usability within your application.

- **Description**: You can provide descriptions for custom fields to give more context and guidance to users when interacting with those fields.

- **Easy Access to Custom Field Values**: With this package, accessing custom field values is as simple as accessing regular model attributes. You can use the familiar `$model->customField` syntax to retrieve the value of a custom field, making it seamless and intuitive to work with custom field data alongside other model properties.

- **Easy Integration**: The package is designed to seamlessly integrate with your existing Laravel application. It follows Laravel's conventions and leverages Laravel's features and functionalities to provide a smooth development experience.

- **Observer Support**: The package includes an observer that automatically updates the custom field values on the associated model whenever changes are made. This ensures consistency and synchronization between the custom fields and their corresponding values.

- **Validation and Error Handling**: The package provides validation capabilities for custom fields, allowing you to validate user input based on the defined rules. It also handles error handling and validation messages in line with Laravel's validation system.

- **Extensibility**: The package is built with extensibility in mind. You can easily extend and customize its functionality to meet your specific needs by leveraging Laravel's powerful features such as model events, custom validation rules, and more.


## Installation

Install the package via composer

```
composer require onramplab/laravel-custom-fields
```
Publish migration files and run command to build tables needed in the package

```
 php artisan vendor:publish --tag="custom-fields-migrations"
```

Run the migration to create the necessary tables in the database

```
php artisan migrate
```

## Usage
### Defining Custom Fields

### Custom field attributes

- `friendly_name`: A user-friendly name for the custom field.
- `key`: A unique name for the custom field.
- `type`: The type of the custom field. It can be one of the following: `string`, `integer`, `float`, `datetime`, `select`, `boolean`.
- `available_options`: The available options for a custom field of type `select`.
- `required`: Indicates whether the custom field is required. The default value is `false`.
- `default_value`: The default value for the custom field.
- `description`: A description of the custom field.
- `model_class`: The namespace of the model to which the custom field applies.
- `contextable_id`: This field is used to store the ID of the related model that provides the context for the custom fields. It acts as a foreign key to establish the relationship between the custom fields and the model that defines the context. 
For example, if you have a Lead model that has custom fields and the context for those fields is provided by an associated Account model, the contextable_id field will store the ID of the associated Account.
- `contextable_type`: This field is used to store the class name or type of the related model that provides the context for the custom fields. It helps identify the specific model class that defines the context for the custom fields. Continuing with the previous example, the contextable_type field will store the class name or type of the associated Account model.
 
- Together, `contextable_id` and `contextable_type` provide a way to establish a polymorphic relationship between the custom fields and the model that defines the context. They allow you to associate custom fields with different types of models, providing flexibility and customization in managing and retrieving custom field data based on the context.

Here's an example of the Lead model and Account model code snippets along with their usage:


1. To define custom fields for lead model, we need to use the `Customizable` trait in the Lead model class.
```php
use OnrampLab\CustomFields\Concerns\Customizable;

class Lead extends Model 
{
    use Customizable;

    protected $guarded = [];
    
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    
    public function getContext(): Model
    {
        return $this->account;
    }
}

```
2. Since the context for those fields is provided by an associated Account model, we need to use `Contextable` trait in the Account model class and overwrite the `getContext` method of the `Customizable`trait.
By overriding the `getContext()` method in the Lead model, we specify that the context for the Lead model is the associated Account model. This ensures that the custom fields defined for the Lead model are associated with the respective Account.



```php
use OnrampLab\CustomFields\Concerns\Contextable;

class Account extends Model 
{
    use Contextable;
    
    public function leads()
    {
        return $this->hasMany(Lead::class);
    }
}

```

```php
use OnrampLab\CustomFields\Concerns\Customizable;

class Lead extends Model 
{
    use Customizable;

    protected $guarded = [];
    
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    
    public function getContext(): Model
    {
        return $this->account;
    }
}

```

After setting up the above configurations, you can proceed with the following steps:

1. Define custom fields using the `CustomField` model.
2. Create leads as you normally would, but include additional custom fields under the custom key, as defined in the previous step. 
```php
[
    'phone' => '12345678',
    'custom' => [
        'zip' => '123'
    ] 
]

```
3. If the custom field value passes validation, it will be stored in the `CustomFieldValue` table.
4. Retrieve custom field values just like any other attribute of the Lead model but with the prefix `custom`. For example, you can access a custom field value using `$lead->custom_zip`.

By following these steps, you can seamlessly work with custom fields for the Lead model and access their values as if they were regular attributes.


## Running Tests:

    composer test


## Contributing

1. Fork it.
2. Create your feature branch (git checkout -b my-new-feature).
3. Make your changes.
4. Run the tests, adding new ones for your own code if necessary (phpunit).
5. Commit your changes (git commit -am 'Added some feature').
6. Push to the branch (git push origin my-new-feature).
7. Create new pull request.

Also please refer to [CONTRIBUTION.md](https://github.com/Onramplab/laravel-custom-fields/blob/master/CONTRIBUTION.md).

## License

Please refer to [LICENSE](https://github.com/Onramplab/laravel-custom-fields/blob/master/LICENSE).
