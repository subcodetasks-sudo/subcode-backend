<?php

namespace App\Http\Controllers;

use App\Support\SitemapXmlBuilder;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __construct(
        private readonly SitemapXmlBuilder $builder,
    ) {}

    public function index(): Response
    {
        return response($this->builder->index(), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function pages(string $locale): Response
    {
        return response($this->builder->pages($locale), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    public function posts(string $locale): Response
    {
        return response($this->builder->posts($locale), 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
