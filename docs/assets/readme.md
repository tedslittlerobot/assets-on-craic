Assets
======

A bit more than a wrapper around assetic.

## Installation

Add the service provider to your service providers array in `config/app.php`:

```php
        Tlr\Display\Assets\AssetServiceProvider::class,
```

## Usage

### Setup

Place the tags in the appropriate places in your templates:

```php
app(\Tlr\Display\Assets\Output\TagGenerator::class)->scripts();
app(\Tlr\Display\Assets\Output\TagGenerator::class)->styles();
```

### Registering assets

You can register an asset using the register function:

```php
app('assets.collection')->register('jquery', function($asset) {
    $asset->scripts()
        ->file(app_path('assets/js/jquery.js'))
        ->glob(app_path('assets/js/*.js'))
        ->link('//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js');
});
```

This registers the "jquery" asset, and shows three ways of adding files to the asset (using Assetic's File, Glob and Link sources).

### Dependancies

You can declare an asset as "depending" on another:

```php
app('assets.collection')->register('login-form', function($asset) {
    $asset->dependsOn('jquery');

    $asset->scripts()->file(app_path('assets/js/login.js'));
    $asset->styles()->file(app_path('assets/css/login.css'));
});
```

When you come to use the login-form asset, the jquery asset will be loaded before.

### Using

When you need to use the asset, you should declare it like so:

```php
app('assets.active')->activate('login-form');
```

That's all - it will add that asset to the list of assets requested in the tags (that we set up above). This retrieves the assets from the controller routes that the service provider sets up.
