Components
==========

## Installation

Add the following to your app/Providers folder:

`ComponentServiceProvider.php`
```php
<?php

namespace App\Providers;

use Tlr\Display\Components\ComponentServiceProvider as BaseServiceProvider;

class ComponentServiceProvider extends BaseServiceProvider
{

    /**
     * A map of components
     *
     * @var array
     */
    protected $components = [];

}

```

And add it to your services providers array in `config/app.php`:

```php
        App\Providers\ComponentServiceProvider::class,
```

## Adding a Component

Make a new class - let's say `App\Components\Button` for a simple example.

```php
<?php

namespace App\Components;

use Tlr\Display\Components\Traits\ComponentTrait;
use Illuminate\Contracts\Support\Htmlable;

class Button implements Htmlable {
    use ComponentTrait;

    /**
     * The blade template to use
     *
     * @type string
     */
    protected $view = 'components.button';
}
```

And add it to the `$components` array of the `ComponentServiceProvider`:

```php
    protected $components = [
        'button' => \App\Components\Button::class,
    ];
```

Now you can use the button component in your views:

```php

{{ app('components')->button() }}

```

This will render the button view.


### Adding data

Let's say the button view expects a `$title` and `$link` variable. We can simply change our view code to:

```php
{{ app('components')->button()->title('hello!')->link(route('welcome')) }}

```

### Default data

But what if we wanted `$title` to be optional - we can add a default value in the `Button` class:

```php
...
class Button implements Htmlable {

    /**
     * The data to be passed to the view
     *
     * @type array
     */
    protected $data = [
        'title' => 'Hello World',
    ];

    ...
}
```

## Wrapping Content

You can define some content for a component as well. Let's say we have a `sidebar` component:

```php
@wrapComponent('sidebar')

    <h1>Hello!</h1>

    <h4>This is a sidebar</h4>

    <marquee>Wooooooo</marquee>

@endWrapComponent
```

The view for the sidebar component will be passed the wrapped content as a `$content` variable.

NB - at present, you cannot nest wrapped components.

### Scope and options when wrapping content

Here is an example to demonstrate these points:

```php

<?php $title = 'Hello, Everyone'; ?>

@wrapComponent('sidebar')

    <?php $component->colour('pink') ?>
    <h1>{{$title}}</h1>

    <h4>This is a sidebar</h4>

    <marquee>Wooooooo</marquee>

@endWrapComponent
```

The wrapped content will have the scope of the surrounding environment (ie. not the internal component's view scope). Hence `$title` refers to the variable defined just before the wrapper.

Inside the wrapped block, you can use the `$component` variable to pass other values to the component, just like you could in the basic example above. So the sidebar's view will be passed a `$colour` variable, with the value pink.

## Advanced

### IOC

Components are always resolved out of the IOC container, so you can add any dependancies to the constructor. So the following has laravel's auth / guard injected into it, and uses it to pass the `$user` variable to the view.

```php
...
use Illuminate\Contracts\Auth\Guard;
...
class Button {
    ...

    public function __construct(Guard $auth) {
        $this->auth = $auth;
        $this->data['user'] = $auth->user();
    }
    ...
}
```

### Escaping

You may have noticed the above examples implement `Htmlable` (the `ComponentTrait` has the necessary code to fulfill this). This means that you can use regular `{{}}` blade brackets for components. As they are likely to alway contain html, they are responsible for escaping anything else inside them. This is how you would probably expect this to work.

This does not mean that no escaping can ever occur inside them - simply use `{{}}` in your component's views to escape those values as normal - this just means that the HTML that *you have written* will not be escaped.
