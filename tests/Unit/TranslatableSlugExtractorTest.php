<?php

namespace Tests\Unit;

use App\Support\TranslatableSlugExtractor;
use PHPUnit\Framework\TestCase;

class TranslatableSlugExtractorTest extends TestCase
{
    public function test_for_locale_returns_only_that_locale_value(): void
    {
        $slug = [
            'ar' => 'نظام-crm-عقاري',
            'en' => 'real-estate-crm-system',
            'tr' => '',
        ];

        $this->assertSame('نظام-crm-عقاري', TranslatableSlugExtractor::forLocale($slug, 'ar'));
        $this->assertSame('real-estate-crm-system', TranslatableSlugExtractor::forLocale($slug, 'en'));
        $this->assertNull(TranslatableSlugExtractor::forLocale($slug, 'tr'));
    }

    public function test_for_locale_ignores_plain_strings(): void
    {
        $this->assertNull(TranslatableSlugExtractor::forLocale('nesem', 'ar'));
    }

    public function test_map_trims_and_nulls_empty_locales(): void
    {
        $mapped = TranslatableSlugExtractor::map([
            'ar' => '  arabic-slug  ',
            'en' => ' english-slug',
            'tr' => '   ',
        ]);

        $this->assertSame([
            'ar' => 'arabic-slug',
            'en' => 'english-slug',
            'tr' => null,
        ], $mapped);
    }

    public function test_map_does_not_clone_string_across_locales(): void
    {
        $this->assertSame([
            'ar' => null,
            'en' => null,
            'tr' => null,
        ], TranslatableSlugExtractor::map('nesem'));
    }
}
