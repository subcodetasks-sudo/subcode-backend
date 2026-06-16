<?php

namespace App\Support;

use Illuminate\Support\Carbon;

final class SitemapXmlBuilder
{
    public function __construct(
        private readonly SlugResourceCollector $slugCollector = new SlugResourceCollector,
    ) {}

    public function index(): string
    {
        $baseUrl = config('sitemap.frontend_url');
        $files = [];

        foreach (config('sitemap.locales', ['ar', 'en', 'tr']) as $locale) {
            $files[] = "pages-{$locale}.xml";
            $files[] = "posts-{$locale}.xml";
        }

        $entries = array_map(
            fn (string $file): string => '  <sitemap>'."\n"
                .'    <loc>'.htmlspecialchars("{$baseUrl}/{$file}", ENT_XML1).'</loc>'."\n"
                .'  </sitemap>',
            $files
        );

        return implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
            ...$entries,
            '</sitemapindex>',
        ]);
    }

    public function posts(string $locale): string
    {
        $this->assertLocale($locale);

        $entries = [
            $this->urlEntry($this->frontendPath($locale, 'blogs'), 'daily', '0.9'),
        ];

        foreach ($this->slugCollector->collectForLocale('categories', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'blogs', 'category', $slug), 'weekly', '0.8');
        }

        foreach ($this->slugCollector->collectForLocale('blogs', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'blogs', $slug), 'weekly', '0.7');
        }

        return $this->wrapUrlSet($entries);
    }

    public function pages(string $locale): string
    {
        $this->assertLocale($locale);

        $entries = [];

        foreach (config('sitemap.static_pages', []) as $page) {
            $path = (string) ($page['path'] ?? '');
            $entries[] = $this->urlEntry(
                $this->frontendPath($locale, ...($path !== '' ? explode('/', $path) : [])),
                (string) ($page['changefreq'] ?? 'weekly'),
                (string) ($page['priority'] ?? '0.8'),
            );
        }

        foreach ($this->slugCollector->collectForLocale('services', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'services', $slug), 'weekly', '0.8');
        }

        foreach ($this->slugCollector->collectForLocale('packages', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'packages', $slug), 'weekly', '0.8');
        }

        foreach ($this->slugCollector->collectForLocale('projects', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'projects', $slug), 'weekly', '0.8');
        }

        foreach ($this->slugCollector->collectForLocale('websites', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'websites', $slug), 'weekly', '0.8');
        }

        foreach ($this->slugCollector->collectForLocale('departments', $locale) as $slug) {
            $entries[] = $this->urlEntry($this->frontendPath($locale, 'projects', 'department', $slug), 'weekly', '0.7');
        }

        return $this->wrapUrlSet($entries);
    }

    /**
     * @param  list<string>  $segments
     */
    private function frontendPath(string $locale, string ...$segments): string
    {
        $baseUrl = rtrim((string) config('sitemap.frontend_url'), '/');
        $filtered = array_values(array_filter($segments, static fn (string $segment): bool => $segment !== ''));
        $encoded = array_map(static fn (string $segment): string => rawurlencode($segment), $filtered);

        if ($encoded === []) {
            return "{$baseUrl}/{$locale}";
        }

        return "{$baseUrl}/{$locale}/".implode('/', $encoded);
    }

    private function urlEntry(string $loc, string $changefreq, string $priority): string
    {
        return implode("\n", [
            '  <url>',
            '    <loc>'.htmlspecialchars($loc, ENT_XML1).'</loc>',
            '    <lastmod>'.Carbon::now()->toAtomString().'</lastmod>',
            '    <changefreq>'.$changefreq.'</changefreq>',
            '    <priority>'.$priority.'</priority>',
            '  </url>',
        ]);
    }

    /**
     * @param  list<string>  $entries
     */
    private function wrapUrlSet(array $entries): string
    {
        return implode("\n", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
            ...$entries,
            '</urlset>',
        ]);
    }

    private function assertLocale(string $locale): void
    {
        if (! in_array($locale, config('sitemap.locales', ['ar', 'en', 'tr']), true)) {
            abort(404);
        }
    }
}
