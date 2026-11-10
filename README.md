<p class="filament-hidden" align="center">
    <img src="https://raw.githubusercontent.com/filafly/filament-remix-icons/main/art/screenshot.png" alt="A Filament panel using Remix Icon" style="width: 100%; max-width: 800px;" />
</p>

# Filament Remix Icons

A [Remix Icon](https://remixicon.com) set for [Filament Icons](https://github.com/filafly/filament-icons). Register one plugin and every icon in Filament's own UI (sidebar, tables, forms, actions, notifications, the rich editor toolbar, multi-factor auth and the rest) switches to Remix Icon, in line or fill style. All 3,229 Remix icons are also available as an enum for your own resources.

Works with Filament 4 and 5.

More about this package on FilaFly: [Remix Icon for Filament on FilaFly](https://filafly.com/plugins/remix-icons?utm_source=github&utm_medium=readme&utm_campaign=remix-icons).

## Installation

You can install the package via composer:

```bash
composer require filafly/filament-remix-icons
```

Not sure which Laravel and PHP versions your Filament version needs? See the [Filament version compatibility guide](https://filafly.com/guides/filament-version-compatibility).

After the package is installed, you must register the plugin in your Filament Panel provider:

```php
use Filafly\Icons\Remix\RemixIcons;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugin(RemixIcons::make());
}
```

That's it. Every Filament icon alias (all 223 in Filament 5) is mapped to a Remix icon.

## Setting the global icon style

Remix Icon comes in two styles:

- Line (default)
- Fill

```php
RemixIcons::make()->line(); // (default)
RemixIcons::make()->fill();
```

A few icons, mostly in the rich editor toolbar (bold, italic, headings), only exist in one style and look the same in both.

## Setting style for a subset of icons

If you need some icons in a different style, you can use either icon aliases or icon enum cases.

### Using icon aliases
Use the `overrideStyleForAlias` method with a [Filament Icon Alias](https://filamentphp.com/docs/styling/icons#available-icon-aliases). It takes a single alias or an array of aliases.

```php
use Filafly\Icons\Remix\RemixIcons;
use Filafly\Icons\Remix\Enums\RemixStyle;
use Filament\Tables\View\TablesIconAlias;
use Filament\Actions\View\ActionsIconAlias;

// Override a single alias
RemixIcons::make()->overrideStyleForAlias(TablesIconAlias::ACTIONS_FILTER, RemixStyle::Fill);

// Override several aliases at once
RemixIcons::make()->overrideStyleForAlias([
    TablesIconAlias::ACTIONS_FILTER,
    ActionsIconAlias::DELETE_ACTION,
], RemixStyle::Fill);
```

### Using icon enum cases
Use the `overrideStyleForIcon` method with Remix enum case(s). Like the alias method, it takes a single case or an array.

```php
use Filafly\Icons\Remix\RemixIcons;
use Filafly\Icons\Remix\Enums\Remix;
use Filafly\Icons\Remix\Enums\RemixStyle;

// Override a single icon
RemixIcons::make()->overrideStyleForIcon(Remix::SearchLine, RemixStyle::Fill);

// Override several icons at once
RemixIcons::make()->overrideStyleForIcon([
    Remix::SearchLine,
    Remix::Filter3Line,
], RemixStyle::Fill);
```

## Specifying exact icons to use

You can also specify exactly which icon you would like to use in given situations. This can be done via icon aliases or icon enum cases.

### Override icon aliases

Use `overrideAlias()` to change which icon is used for specific Filament icon aliases:

```php
use Filafly\Icons\Remix\RemixIcons;
use Filafly\Icons\Remix\Enums\Remix;
use Filament\View\PanelsIconAlias;
use Filament\Tables\View\TablesIconAlias;

RemixIcons::make()
    ->overrideAlias(PanelsIconAlias::SIDEBAR_EXPAND_BUTTON, Remix::ArrowRightDoubleLine)
    ->overrideAlias(TablesIconAlias::ACTIONS_FILTER, Remix::FilterLine);
```

Or use `overrideAliases()` to override multiple aliases at once by passing an array:

```php
RemixIcons::make()
    ->overrideAliases([
        PanelsIconAlias::SIDEBAR_EXPAND_BUTTON => Remix::ArrowRightDoubleLine,
        TablesIconAlias::ACTIONS_FILTER => Remix::FilterLine,
    ]);
```

### Override individual icons

Use `overrideIcon()` to replace a Remix icon everywhere this pack uses it:

```php
RemixIcons::make()
    ->overrideIcon(Remix::DeleteBinLine, Remix::DeleteBin7Line)
    ->overrideIcon(Remix::EditBoxLine, Remix::PencilLine);
```

Or use `overrideIcons()` to override multiple icons at once by passing an array:

```php
RemixIcons::make()
    ->overrideIcons([
        Remix::DeleteBinLine->value => Remix::DeleteBin7Line,
        Remix::EditBoxLine->value => Remix::PencilLine,
    ]);
```
> PHP arrays do not support enums as keys so `->value` is necessary if you want to reference the enum

Exact overrides win over styles, so pick the line or fill case you want.

## Icon enum

All Remix icons are available through an enum providing convenient usage throughout Filament. For more information, check the [Filament docs](https://filamentphp.com/docs/styling/icons).

```php
use Filament\Forms\Components\Toggle;
use Filafly\Icons\Remix\Enums\Remix;

Toggle::make('is_starred')
    ->onIcon(Remix::StarFill)
```

The icons come from [andreiio/blade-remix-icon](https://github.com/andreiio/blade-remix-icon), so `<x-ri-star-line />` and `@svg('ri-star-line')` work in your own Blade views too.

## Testing

```bash
composer test
```

The suite checks that every icon alias in the installed Filament version is mapped, that every enum case has an SVG, and that `fill()` switches every icon that has a fill version.

## From FilaFly

FilaFly also makes premium themes for Filament panels: Lucent, Prizm, Cypher and Citrus. [Browse the themes](https://filafly.com/themes?utm_source=github&utm_medium=readme&utm_campaign=remix-icons).

## License

The MIT License (MIT). Please see [License](LICENSE.md) for more information. This package contains no icon files: the icons are installed by andreiio/blade-remix-icon.

Remix Icon is © Remix Design and is used under the [Remix Icon License](https://github.com/Remix-Design/RemixIcon/blob/master/License), which allows use in commercial and non-commercial apps but not selling the icons on their own.
