<?php

namespace App\Filament\Schemas\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Illuminate\Database\Eloquent\Model;

final class SlugField
{
    /** @var list<string> */
    private const LOCALES = ['ar', 'en', 'tr'];

    public static function make(string $sourceField = 'title'): Group
    {
        return Group::make([
            Hidden::make('slug_locks')
                ->dehydrated(false)
                ->default(fn (?Model $record) => self::defaultLocks($record, $sourceField)),

            TextInput::make('slug')
                ->label(__('admin.slug'))
                ->maxLength(255)
                ->translatableTabs()
                ->modifyFieldsUsing(
                    fn (Field $component, string $locale): Field => self::customizeSlugField($component, $locale, $sourceField),
                ),
        ])->columnSpanFull();
    }

    public static function sourceCustomizer(string $sourceField = 'title'): \Closure
    {
        return function (Field $component, string $locale) use ($sourceField): void {
            $component
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set, callable $get) use ($locale, $sourceField): void {
                    if (! self::isLocaleLocked($get, $locale)) {
                        return;
                    }

                    $set('slug.'.$locale, self::generatePreviewSlug(is_string($state) ? $state : ''));
                });
        };
    }

    private static function customizeSlugField(Field $component, string $locale, string $sourceField): Field
    {
        return $component
            ->hint(fn (callable $get): string => self::isLocaleLocked($get, $locale)
                ? __('admin.slug_linked_to_title')
                : __('admin.slug_manual_edit'))
            ->hintColor(fn (callable $get): string => self::isLocaleLocked($get, $locale) ? 'gray' : 'warning')
            ->hintIcon(fn (callable $get): string => self::isLocaleLocked($get, $locale)
                ? 'heroicon-m-lock-closed'
                : 'heroicon-m-lock-open')
            ->hintAction(
                Action::make("toggle_slug_lock_{$locale}")
                    ->label(fn (callable $get): string => self::isLocaleLocked($get, $locale)
                        ? __('admin.slug_linked_to_title')
                        : __('admin.slug_manual_edit'))
                    ->icon(fn (callable $get): string => self::isLocaleLocked($get, $locale)
                        ? 'heroicon-m-lock-closed'
                        : 'heroicon-m-lock-open')
                    ->color(fn (callable $get): string => self::isLocaleLocked($get, $locale) ? 'gray' : 'warning')
                    ->action(function (callable $set, callable $get) use ($locale, $sourceField): void {
                        $locks = $get('slug_locks') ?? self::defaultLocks(null, $sourceField);
                        $locked = ! self::isLocaleLocked($get, $locale);
                        $locks[$locale] = $locked;
                        $set('slug_locks', $locks);

                        if ($locked) {
                            $source = $get($sourceField.'.'.$locale);
                            $set('slug.'.$locale, self::generatePreviewSlug(is_string($source) ? $source : ''));
                        }
                    }),
            )
            ->disabled(fn (callable $get): bool => self::isLocaleLocked($get, $locale))
            ->placeholder(fn (callable $get): ?string => self::isLocaleLocked($get, $locale)
                ? self::generatePreviewSlug((string) ($get($sourceField.'.'.$locale) ?? ''))
                : null);
    }

    /**
     * @return array<string, bool>
     */
    private static function defaultLocks(?Model $record, string $sourceField): array
    {
        if (! $record || ! method_exists($record, 'getTranslation')) {
            return array_fill_keys(self::LOCALES, true);
        }

        $locks = [];

        foreach (self::LOCALES as $locale) {
            $slug = trim((string) $record->getTranslation('slug', $locale, false));
            $source = trim((string) $record->getTranslation($sourceField, $locale, false));
            $preview = self::generatePreviewSlug($source);
            $locks[$locale] = $slug === '' || $slug === $preview;
        }

        return $locks;
    }

    private static function isLocaleLocked(callable $get, string $locale): bool
    {
        $locks = $get('slug_locks') ?? [];

        return ($locks[$locale] ?? true) === true;
    }

    public static function generatePreviewSlug(string $string, string $separator = '-'): string
    {
        $string = trim(strip_tags($string));

        if ($string === '') {
            return '';
        }

        $slug = mb_strtolower($string, 'UTF-8');
        $slug = str_replace(['/', '\\'], $separator, $slug);
        $slug = preg_replace("/[^a-z0-9_\sءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", '', $slug);
        $slug = preg_replace("/[\s-]+/", ' ', $slug);
        $slug = preg_replace("/[\s_]/", $separator, $slug);

        return trim($slug, $separator);
    }
}
