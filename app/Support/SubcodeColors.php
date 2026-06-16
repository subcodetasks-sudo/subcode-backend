<?php

namespace App\Support;

use Filament\Support\Colors\Color;

class SubcodeColors
{
    /** Subcode blue — replaces Howeyah lime primary */
    public const PRIMARY = '#3D8EBF';

    /** Dark blue for active nav labels */
    public const PRIMARY_DARK = '#1E4A6E';

    /** Icon / accent blue */
    public const PRIMARY_ICON = '#2D7AB8';

    /** Radial glow (RGB of primary) */
    public const GLOW = 'rgba(61, 142, 191, 0.12)';

    public const GLOW_SOFT = 'rgba(61, 142, 191, 0.1)';

    /**
     * @return array<string, array<int, string>>
     */
    public static function filamentPalette(): array
    {
        return [
            'primary' => Color::hex(self::PRIMARY),
            'gray' => Color::hex('#4B5563'),
            'success' => Color::hex('#22C55E'),
            'warning' => Color::hex('#F5C84C'),
            'danger' => Color::hex('#E86A6A'),
            'info' => Color::hex('#6BB8F5'),
        ];
    }
}
