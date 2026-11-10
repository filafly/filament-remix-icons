<?php

namespace Filafly\Icons\Remix\Enums;

use Filafly\Icons\Contracts\StyleEnum;

enum RemixStyle: string implements StyleEnum
{
    case Line = '-line';
    case Fill = '-fill';

    public function getStyleName(): string
    {
        return match ($this) {
            self::Line => 'line',
            self::Fill => 'fill',
        };
    }

    public function getEnumSuffix(): string
    {
        return match ($this) {
            self::Line => 'Line',
            self::Fill => 'Fill',
        };
    }

    public static function getStyleNames(): array
    {
        return ['line', 'fill'];
    }

    public static function fromStyleName(string $styleName): ?self
    {
        return match (strtolower($styleName)) {
            'line' => self::Line,
            'fill' => self::Fill,
            default => null,
        };
    }
}
