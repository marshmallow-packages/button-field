![alt text](https://marshmallow.dev/cdn/media/logo-red-237x46.png "marshmallow.")

# Nova Button Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marshmallow/button-field.svg?style=flat-square)](https://packagist.org/packages/marshmallow/button-field)
[![Total Downloads](https://img.shields.io/packagist/dt/marshmallow/button-field.svg?style=flat-square)](https://packagist.org/packages/marshmallow/button-field)
[![Issues](https://img.shields.io/github/issues/marshmallow-packages/button-field?style=flat-square)](https://github.com/marshmallow-packages/button-field/issues)
[![License](https://img.shields.io/packagist/l/marshmallow/button-field?style=flat-square)](https://github.com/marshmallow-packages/button-field)

A Laravel Nova field that renders a button on your resource — link out, trigger a download, run a Nova action, or execute custom code on click.

## Installation

You can install the package via composer:

```bash
composer require marshmallow/button-field
```

## Usage

Add the field to your Nova resource. By default the field resolves its link from the column you pass to `make()`. As with any Nova field, you can return your own value with `resolveUsing()`.

```php
use Marshmallow\ButtonField\ButtonField;

ButtonField::make('Certificate')->resolveUsing(function () {
    return '___YOUR_LINK_GOES_HERE___';
}),
```

The field is hidden on the create form and never writes back to the model (its `fillUsing` is a no-op), so it is safe to use as a pure action/link field.

## Methods

### button()

When you call the `button` method, this will return a default Laravel Nova Button. This should have the same styling as the Update and Update & Continue Editing buttons in your Nova installation. This method is called by default so this behaviour should be available out of the box.

```php
$button_field->button();
```

### target()

You can call the `target` method to change the behaviour of your button.

```php
$button_field->target('_blank'); // DEFAULT
$button_field->target('_self');
```

### download()

When you call the `download` method, the styling of the button will change. It will be a smaller button with a download icon next to it. We will also add the “download” tag to the button so the browser knows you want to download something. You can see an example of this in the screenshot at the top of this page.

```php
$button_field->download();
```

### setButtonText()

The default text of the created button is “Download”. You can change this by calling the `setButtonText` method.

```php
$button_field->setButtonText('Go to user profile');
```

### text()

Call the `text` method to render the button as a plain text-style button instead of the default Nova button. This is the type required by the `onClick` method below.

```php
$button_field->text();
```

### icon()

Add an icon to the button by passing an icon name to the `icon` method.

```php
$button_field->icon('download');
```

### visibleWhen()

You can use the `visibleWhen` method if a button should only be visible when a condition applies.

```php
$button_field->visibleWhen(function() {
    // Call methods on your resource
    return $this->certificateIsAvailable();
}, __('Certificate is not generated yet'));
```

### onClick()

You can use the `onClick` method to run any kind of action to your model. This is a very powerfull method that allows you to do anything! This currently only works on the text type button so we must set it to `text()`. Please check the example below how to implement this on your Nova Resource.

```php
ButtonField::make(__('Send invoice'))
	->text()
	->setButtonText(__('Send invoice'))
	->onClick(SendInvoice::class),
```

Now we need to create an action class that will be run when the button is clicked. You can create this anywhere you like. This could be the location app/Actions/Nova/SendInvoice.php. In this file you create a class that implements the OnClickInterface interface. You need to create 3 methods in this class. Please check the example below.

```php
<?php

namespace App\Actions\Nova;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Marshmallow\ButtonField\Contracts\OnClickInterface;

class SendInvoice implements OnClickInterface
{
    public function execute(Model $model, $value = null, $key = null): void
    {
        // Run your code!
    }

    public function success(): string
    {
        return __('Invoice is end successfully');
    }

    public function error(Exception $exception): string
    {
        return __('Something went wrong: :exception', [
            'exception' => $exception->getMessage(),
        ]);
    }
}
```

### Run Nova Actions

You can now run your Nova Actions using the button field. This means its now possible to run a nova action from the form view as well. Make sure the action is registered in your resources actions method and then use the example code below.

```php
ButtonField::make(__('Nova Action'))
    ->action(
        action: new \App\Nova\Actions\DemoAction,
        resourceId: $this->resource->id,
        label: 'Run the demo dude!'
    ),
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Security

If you discover any security related issues, please email stef@marshmallow.dev instead of using the issue tracker.

## Credits

-   [Stef van Esch](https://github.com/stefvanesch)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT).
