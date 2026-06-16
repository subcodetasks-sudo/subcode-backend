<?php

namespace App\Observers;

use App\Models\Redirect;
use App\Support\RedirectPathBuilder;
use App\Support\RedirectStatusCodes;
use App\Support\SlugRedirectTarget;
use Illuminate\Support\Facades\Auth;

class RedirectObserver
{
    public function saving(Redirect $redirect): void
    {
        $redirect->source_path = RedirectPathBuilder::normalizePath($redirect->source_path);

        $sourceParsed = SlugRedirectTarget::parse($redirect->source_path, $redirect->source_locale);
        $redirect->source_slug = $sourceParsed['slug'] ?? $this->slugFromPath($redirect->source_path);

        if (! $redirect->source_locale && $sourceParsed['locale']) {
            $redirect->source_locale = $sourceParsed['locale'];
        }

        if (RedirectStatusCodes::requiresTarget((int) $redirect->status_code) && $redirect->target_path) {
            $targetParsed = SlugRedirectTarget::parse($redirect->target_path, $redirect->source_locale);
            $redirect->target_path = $targetParsed['path'];
            $redirect->target_slug = $targetParsed['slug'];
            $redirect->target_locale = $targetParsed['locale'] ?? $redirect->source_locale;
        } else {
            $redirect->target_slug = null;
            $redirect->target_path = null;
            $redirect->target_locale = null;
        }
    }

    public function creating(Redirect $redirect): void
    {
        if (! $redirect->created_by && Auth::guard('admin')->id()) {
            $redirect->created_by = Auth::guard('admin')->id();
        }
    }

    private function slugFromPath(string $path): string
    {
        $parts = explode('/', trim($path, '/'));

        return (string) (end($parts) ?: '');
    }
}
