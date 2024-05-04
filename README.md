# Contents

This is a Laravel Filament package to manage single view rendering with various components.
This package also include a Filament Page resource to manage your application's pages.

## TODO

- Multilingual component support DONE,
- write better documentation
- better namespace / folder hierarchy
- Tests
- better way to set component default folder (in config menu)

## Import serviceprovider

```php
'providers' => ServiceProvider::defaultProviders()->merge([
    //…
    ContentsServiceProvider::class,
])->toArray(),
```

## Guides

### Add components to a model and its resource

First, create a model and its migrations.

```sh
 php artisan make:model -m Post  
```

_Don't forget to migrate the new table_

Then, add this trait to your model. It will simply add the content's morphMany relation to your model

```php
use Jonathanrixhon\Contents\Models\Concerns\HasContents;
class Post extends Model
{
    use HasContents;
   // … 
}
```

When your model is ready to go, create your filament Resource by running this command :

```sh
php artisan make:filament-resource Post
```

Now you can configure your resource like you want. If you want to allow the user to interact with the model's components, just add it the `contentRepeater` section by adding the `Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents` trait like so:

```php
use Jonathanrixhon\Contents\Filament\Resources\Concerns\HasContents;

class PostResource extends Resource
{
    use HasContents;
    
    // classic resource configuration…

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')->required(),
                self::contentRepeater()
            ]);
    }
}
```

Congratulations, your model now supports contents !

To customize the available components in your resource, simply edit the `availableComponents()` method to return an array of component classes.

```php
/**
 * List all the available for the current resource.
 */
public static function availableComponents(): array {
    return [
        ExampleComponent::class
    ];
}
```

Or edit the default component array in the `contents.php` config file.

### Creating components

To create a component, just run the Laravel command:

```sh
php artisan make:component ExampleComponent
```

Once your component is created, extends this component with `Jonathanrixhon\Contents\View\Components\Concerns\Component`. This class is already extends the `Illuminate\View\Component`.

you can now add the required methods and properties to make it work.

```php
<?php

namespace Jonathanrixhon\Contents\View\Components;

use Filament\Forms\Components\RichEditor;

class ExampleComponent extends Concerns\Component
{
    public static string $view = 'example-component';

    /**
     * Get the component label
     */
    public static function label(): string
    {
        return "Example component";
    }

    /**
     * Get the component label
     */
    public static function description(): string
    {
        return "A description";
    }

    /**
     * Get the admin fields
     */
    public static function fields(): array
    {
        return [
            RichEditor::make('content.text')
                ->columnSpanFull()
                ->rules(['required'])
        ];
    }
}

```