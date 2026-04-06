# Filament Quick Add Select

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cocosmos/filament-quick-add-select.svg?style=flat-square)](https://packagist.org/packages/cocosmos/filament-quick-add-select)
[![Total Downloads](https://img.shields.io/packagist/dt/cocosmos/filament-quick-add-select.svg?style=flat-square)](https://packagist.org/packages/cocosmos/filament-quick-add-select)

Speed up data entry in Filament by enabling users to create and select new relationship options directly from the search dropdown - no modals, no interruptions.

## The Problem

When using Filament's Select component with relationships, users must:
1. Search for an option
2. Realize it doesn't exist
3. Click "Create new option"
4. Fill in a modal form
5. Submit the modal
6. Find and select the newly created option

This workflow interrupts the user's flow and slows down data entry.

## The Solution

Quick Add Select adds a "+ Add 'search term'" option directly in the search results. When clicked, it:
- Instantly creates the new record using the search term
- Automatically selects it
- Continues the workflow without interruption

![Quick Add Select Demo](screenshots/demo.gif)

## Installation

You can install the package via composer:

```bash
composer require cocosmos/filament-quick-add-select
```

## Usage

Simply add `->quickAdd()` to any Select component with a relationship:

```php
use Filament\Forms\Components\Select;

Select::make('profession_id')
    ->relationship('profession', 'name')
    ->searchable()
    ->quickAdd()
```

That's it! Now when users search for a term that doesn't exist, they'll see an "+ Add 'term'" option.

### Multiple Select

Works seamlessly with multiple selects:

```php
Select::make('skills')
    ->multiple()
    ->relationship('skills', 'name')
    ->searchable()
    ->quickAdd()
```

### Custom Label

Customize the "Add" button label:

```php
Select::make('category_id')
    ->relationship('category', 'name')
    ->searchable()
    ->quickAdd(label: fn(string $search) => "Create new: {$search}")
```

Or use a simple string template:

```php
->quickAdd(label: "New category: {search}")
```

### Reset Search After Creation

By default, after creating a new record, only the "Add" option is removed from the dropdown while keeping the current search text and results intact. This lets users continue working in the same context.

If you prefer to fully clear the search input and results after creation:

```php
->quickAdd(resetSearch: true)
```

### Disable Quick Add

You can conditionally disable the feature:

```php
->quickAdd(enabled: auth()->user()->can('create', Category::class))
```

## Translations

The plugin includes translations for the default "Add" label in multiple languages:

- 🇬🇧 English: "+ Add ':term'"
- 🇫🇷 French: "+ Ajouter « :term »"
- 🇩🇪 German: "+ Hinzufügen ':term'"
- 🇪🇸 Spanish: "+ Añadir ':term'"
- 🇮🇩 Indonesia: "+ Tambah ':term'"
- 🇮🇹 Italian: "+ Aggiungi ':term'"
- 🇵🇹 Portuguese: "+ Adicionar ':term'"

### Publishing Translations

To customize translations, publish the language files:

```bash
php artisan vendor:publish --tag=quick-add-translations
```

Then edit the files in `lang/vendor/quick-add/`.

### Adding New Languages

Create a new translation file in `lang/vendor/quick-add/{locale}/quick-add.php`:

```php
<?php

return [
    'add' => '+ Your translation ":term"',
];
```

## Screenshots

### With Quick Add
![With Quick Add](screenshots/with-quick-add.png)
*New workflow: Search, click "Add", done!*

### Multiple Selection
![Multiple Selection](screenshots/multiple.png)
*Works perfectly with multiple selects*

## How It Works

The plugin extends Filament's Select component using Laravel's macro system. When you add `->quickAdd()`:

1. It overrides the search results to include a special "Add" option when no exact match is found
2. When the "Add" option is selected, it creates the record immediately
3. The newly created record's ID replaces the temporary selection
4. The component displays the proper label from the database
5. The "Add" option is removed from the dropdown to prevent duplicate creation

All of this happens client-side with Livewire, so there's no page refresh.

## Requirements

- PHP 8.2+
- Laravel 11.0+
- Filament 4.0+ / 5.0+

## Compatibility

- ✅ Works with single and multiple selects
- ✅ Compatible with all Filament themes
- ✅ Supports dark mode
- ✅ Multi-language support
- ✅ Works in panels, resources, forms, and custom pages

## Limitations

- Only works with relationship selects (not options-based selects)
- Creates records with only the title attribute populated (usually 'name')
- For complex models requiring additional fields, use the traditional `createOptionForm()` approach

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Cocosmos](https://github.com/cocosmos)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
