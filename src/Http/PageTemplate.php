<?php

namespace Jonathanrixhon\Contents\Http;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Route;
use Jonathanrixhon\Contents\Models\Page;
use Illuminate\Database\Eloquent\Collection;

class PageTemplate
{
    /**
     * The page model
     */
    protected ?Page $page;

    /**
     * The page's main title tag content
     */
    protected ?string $title;

    /**
     * The page's contents
     */
    protected Collection $contents;

    /**
     * The page's title suffix when defined
     */
    protected ?string $suffix;

    /**
     * The page's social share image
     */
    protected string $image;

    /**
     * The page's social media meta tags (properties) that needs to be replaced
     */
    protected array $properties = [];

    /**
     * Create a new page instance
     *
     * @return void
     */
    public function __construct()
    {
        $this->suffix(env('APP_NAME'));
        $this->image('img/social.png');
    }

    /**
     * Set the page's with route name
     *
     * @return $this
     */
    public function load(?string $route = null): static
    {
        $page = Page::where('route', $route ?? Route::currentRouteName())
            ->first();
        if ($page) {
            $this->page = $page;
            $this->title($page->title);
            $this->contents = $page->contents()
                ->where('visible', true)
                ->ordered()
                ->get();
        }

        return $this;
    }

    /**
     * Set the page's title
     *
     * @return $this
     */
    public function title(?string $title = null, ?string $suffix = null): static
    {
        $this->title = (is_string($title) ? trim($title, ' •') : null) ?: null;

        if (!$suffix) {
            return $this;
        }

        return $this->suffix($suffix);
    }

    /**
     * Set the page's title suffix
     *
     * @return $this
     */
    public function suffix(?string $suffix = null): static
    {
        $this->suffix = (is_string($suffix) ? trim($suffix, ' •') : null) ?: null;

        return $this;
    }

    /**
     * Return the defined page title
     *
     * @param  bool  $suffixed
     */
    public function getTitle(?bool $suffixed = true): string
    {
        if (Route::currentRouteName() == 'home') {
            return $this->suffix;
        }

        return trim($this->title . ($suffixed ? ' • ' . $this->suffix : ''), ' •') ?: $this->suffix;
    }

    /**
     * Return the defined page suffix
     */
    public function getSuffix(): string
    {
        return $this->suffix;
    }

    /**
     * Set the page's social share image
     *
     * @return $this
     */
    public function image(string $path): static
    {
        $this->image = $path;

        return $this;
    }

    /**
     * Return the page's social share image
     */
    public function getImage(bool $twitter = false): string
    {
        if ($twitter) {
            return Vite::asset('resources/img/socials_small.jpg');
        }
        return Vite::asset('resources/img/socials.jpg');
    }

    /**
     * Set a page's meta property
     *
     * @return $this
     */
    public function property(string $property, ?string $value = null): static
    {
        $this->properties[$property] = $value;

        return $this;
    }

    /**
     * Return the page's meta properties
     */
    public function getProperties(array $extra = []): array
    {
        $defaults = [
            'description' => $this->page?->meta_description ?? null,
            'keywords' => 'portfolio, developer, fullstack, backend, frontend, web design, web, php, mysql, laravel, vue, javascript, Whitecube, Jonathan Rixhon',
            'og:description' => $this->page?->meta_og ?? null,
            'og:image' => $this->getImage(),
            'og:title' => $this->getTitle(false),
            'og:url' => $this->getPageUrl(),
            'twitter:description' => $this->page?->meta_twitter ?? null,
            'twitter:title' => $this->getTitle(false),
            'twitter:image' => $this->getImage(true),
        ];

        $properties = array_merge($defaults, array_filter($this->properties), $extra);

        ksort($properties);

        return $properties;
    }

    /**
     * Return the page's meta properties
     */
    public function getMetas(): array
    {
        return $this->getProperties([
            'og:locale' => 'en',
            'og:site_name' => $this->suffix,
            'og:type' => 'website',
            'twitter:card' => 'summary_large_image',
            'twitter:creator' => '@jonathanrixhon'
        ]);
    }

    /**
     * Return the defined page's URL
     */
    public function getPageUrl(): string
    {
        return url()->full();
    }

    /**
     * Return the page contents
     */
    public function getContents(): Collection
    {
        return $this->contents->filter(function ($content) {
            return $content->content;
        });
    }

    /**
     * Magically access the page's attribute.
     */
    public function __get(string $attribute): mixed
    {
        return $this->page?->$attribute ?? null;
    }
}
