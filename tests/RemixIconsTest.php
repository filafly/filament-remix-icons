<?php

namespace Filafly\Icons\Remix\Tests;

use BladeUI\Icons\Factory;
use Filafly\Icons\Remix\Enums\Remix;
use Filafly\Icons\Remix\Enums\RemixStyle;
use Filafly\Icons\Remix\RemixIcons;
use Filament\Facades\Filament;
use Filament\Panel;
use Filament\Support\Enums\IconSize;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Icons\IconManager;
use InvalidArgumentException;
use ReflectionClass;

class RemixIconsTest extends TestCase
{
    /**
     * Every alias Filament defines in its *IconAlias classes, read from the installed version.
     *
     * @return array<string, string> constant => alias
     */
    public static function filamentAliases(): array
    {
        $aliases = [];

        foreach (glob(dirname(__DIR__).'/vendor/filament/*/src/View/*IconAlias.php') as $file) {
            preg_match('/^namespace\s+([^;]+);/m', file_get_contents($file), $matches);
            $class = $matches[1].'\\'.basename($file, '.php');

            foreach ((new ReflectionClass($class))->getConstants() as $name => $alias) {
                $aliases[class_basename($class).'::'.$name] = $alias;
            }
        }

        return $aliases;
    }

    /**
     * Filament's own alias normalization, or the alias unchanged on 4.0 and 4.1,
     * which have no normalizeAlias() and no renamed keys.
     */
    private static function normalize(string $alias): string
    {
        return method_exists(IconManager::class, 'normalizeAlias')
            ? IconManager::normalizeAlias($alias)
            : $alias;
    }

    /** @return array<string, Remix> */
    private function iconMap(): array
    {
        $property = (new ReflectionClass(RemixIcons::class))->getProperty('iconMap');

        return $property->getValue(new RemixIcons);
    }

    public function test_it_finds_filaments_alias_classes(): void
    {
        $this->assertGreaterThan(150, count(self::filamentAliases()));
    }

    public function test_every_filament_alias_is_mapped(): void
    {
        $mapped = array_map(self::normalize(...), array_keys($this->iconMap()));

        $missing = array_filter(
            self::filamentAliases(),
            fn (string $alias): bool => ! in_array(self::normalize($alias), $mapped, true),
        );

        $this->assertSame([], $missing, 'Filament aliases with no Remix icon: '.implode(', ', array_keys($missing)));
    }

    public function test_icons_are_mapped_to_their_line_version(): void
    {
        foreach ($this->iconMap() as $alias => $icon) {
            $this->assertInstanceOf(Remix::class, $icon, "{$alias} is not mapped to a Remix case");
            $this->assertFalse(str_ends_with($icon->value, '-fill'), "{$alias} is mapped to a fill icon");

            if (! str_ends_with($icon->value, '-line')) {
                $this->assertNull(Remix::tryFrom("{$icon->value}-line"), "{$alias} should use {$icon->value}-line");
            }
        }
    }

    public function test_every_enum_case_has_an_svg_in_blade_remix_icon(): void
    {
        $factory = app(Factory::class);
        $missing = [];

        foreach (Remix::cases() as $case) {
            try {
                $factory->svg($case->getIconForSize(IconSize::Medium));
            } catch (\Throwable) {
                $missing[] = $case->value;
            }
        }

        $this->assertSame([], $missing, 'Enum cases with no SVG: '.implode(', ', $missing));
    }

    public function test_enum_cases_resolve_to_the_ri_blade_prefix(): void
    {
        $this->assertSame('ri-delete-bin-line', Remix::DeleteBinLine->getIconForSize(IconSize::Small));
        $this->assertSame('ri-24-hours-fill', Remix::Icon24HoursFill->getIconForSize(IconSize::Large));
    }

    public function test_registering_replaces_filaments_icons_with_line_icons(): void
    {
        RemixIcons::make()->registerIcons();

        $this->assertSame('ri-search-line', FilamentIcon::resolve('panels::global-search.field'));
        $this->assertSame('ri-delete-bin-line', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('ri-bold', FilamentIcon::resolve('forms:components.rich-editor.toolbar.bold'));
        $this->assertSame('ri-text', FilamentIcon::resolve('tables::filters.query-builder.constraints.text'));

        foreach (self::filamentAliases() as $constant => $alias) {
            $this->assertStringStartsWith('ri-', (string) FilamentIcon::resolve($alias), "{$constant} is not a Remix icon");
        }
    }

    public function test_fill_switches_every_icon_that_has_a_fill_version(): void
    {
        RemixIcons::make()->fill()->registerIcons();

        $this->assertSame('ri-home-5-fill', FilamentIcon::resolve('panels::pages.dashboard.navigation-item'));
        $this->assertSame('ri-delete-bin-fill', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('ri-bold', FilamentIcon::resolve('forms:components.rich-editor.toolbar.bold'));

        foreach ($this->iconMap() as $alias => $icon) {
            if (str_ends_with($icon->value, '-line') && Remix::tryFrom(substr($icon->value, 0, -5).'-fill')) {
                $this->assertStringEndsWith('-fill', FilamentIcon::resolve($alias), "{$alias} did not switch to fill");
            }
        }
    }

    public function test_style_can_be_overridden_per_alias_and_per_icon_without_a_global_style(): void
    {
        RemixIcons::make()
            ->overrideStyleForAlias('actions::delete-action', RemixStyle::Fill)
            ->overrideStyleForIcon(Remix::SearchLine, 'fill')
            ->registerIcons();

        $this->assertSame('ri-delete-bin-fill', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('ri-delete-bin-line', FilamentIcon::resolve('actions::force-delete-action'));
        $this->assertSame('ri-search-fill', FilamentIcon::resolve('tables::search-field'));
        $this->assertSame('ri-home-5-line', FilamentIcon::resolve('panels::pages.dashboard.navigation-item'));
    }

    public function test_line_can_be_kept_for_some_icons_when_the_rest_are_fill(): void
    {
        RemixIcons::make()
            ->fill()
            ->overrideStyleForAlias(['actions::delete-action', 'actions::edit-action'], 'line')
            ->registerIcons();

        $this->assertSame('ri-delete-bin-line', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('ri-edit-box-line', FilamentIcon::resolve('actions::edit-action'));
        $this->assertSame('ri-search-fill', FilamentIcon::resolve('tables::search-field'));
    }

    public function test_aliases_and_icons_can_be_overridden(): void
    {
        RemixIcons::make()
            ->overrideAlias('actions::delete-action', Remix::EraserLine)
            ->overrideIcons([Remix::SearchLine->value => Remix::Search2Line])
            ->registerIcons();

        $this->assertSame('ri-eraser-line', FilamentIcon::resolve('actions::delete-action'));
        $this->assertSame('ri-delete-bin-line', FilamentIcon::resolve('actions::force-delete-action'));
        $this->assertSame('ri-search-2-line', FilamentIcon::resolve('tables::search-field'));
    }

    public function test_legacy_query_builder_keys_do_not_overwrite_an_override(): void
    {
        RemixIcons::make()
            ->overrideAlias('query-builder::constraints.text', Remix::StarLine)
            ->registerIcons();

        $this->assertSame('ri-star-line', FilamentIcon::resolve('query-builder::constraints.text'));
        $this->assertSame('ri-hashtag', FilamentIcon::resolve('query-builder::constraints.number'));
    }

    public function test_legacy_query_builder_keys_are_kept_only_where_filament_uses_them(): void
    {
        $map = $this->iconMap();
        $legacy = 'tables::filters.query-builder.constraints.text';

        if (self::normalize($legacy) === $legacy) {
            $this->assertArrayHasKey($legacy, $map, 'Filament without the renamed keys still needs the legacy one');
        } else {
            $this->assertArrayNotHasKey($legacy, $map, 'The legacy key would overwrite the current one');
            $this->assertArrayHasKey(self::normalize($legacy), $map);
        }
    }

    public function test_rich_editor_toolbar_aliases_are_mapped(): void
    {
        // Filament's own toolbar constants (only in later 4.x releases), so a renamed
        // prefix shows up here instead of silently falling back to Heroicons.
        $toolbar = array_filter(
            self::filamentAliases(),
            fn (string $constant): bool => str_contains($constant, 'RICH_EDITOR_TOOLBAR_'),
            ARRAY_FILTER_USE_KEY,
        );

        if ($toolbar === []) {
            $this->markTestSkipped('This Filament version has no rich editor toolbar aliases.');
        }

        RemixIcons::make()->registerIcons();

        foreach ($toolbar as $constant => $alias) {
            $this->assertArrayHasKey($alias, $this->iconMap(), "{$constant} is not in the icon map");
            $this->assertStringStartsWith('ri-', FilamentIcon::resolve($alias), "{$constant} is not a Remix icon");
        }
    }

    public function test_unknown_styles_are_rejected(): void
    {
        $this->assertSame(['line', 'fill'], RemixIcons::make()->getAvailableStyleNames());

        $this->expectException(InvalidArgumentException::class);

        RemixIcons::make()->style('duotone');
    }

    public function test_the_plugin_registers_icons_when_a_panel_boots(): void
    {
        $panel = Panel::make()->id('admin')->default()->plugin(RemixIcons::make()->fill());
        Filament::registerPanel($panel);

        $panel->getPlugin('filafly-filament-remix-icons')->boot($panel);

        $this->assertSame('ri-home-5-fill', FilamentIcon::resolve('panels::pages.dashboard.navigation-item'));
    }
}
