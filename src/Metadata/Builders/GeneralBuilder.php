<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

use Closure;
use Illuminate\Support\Arr;
use Stillat\StatamicSiteEssentials\Data\Entries\EntryLocales;
use Stillat\StatamicSiteEssentials\Metadata\DataHelpers;
use Stillat\StatamicSiteEssentials\Metadata\MetaBuilder;

class GeneralBuilder extends AbstractMetaTagBuilder
{
    public function charset($charset = 'utf-8'): self
    {
        $this->getManager()->queue([
            'charset' => $this->value($charset),
        ]);

        return $this;
    }

    public function description($description = ''): self
    {
        $this->getManager()->queue([
            'name' => 'description',
            'content' => $this->value($description),
        ]);

        return $this;
    }

    public function keywords($keywords = ''): self
    {
        if (is_array($keywords)) {
            $keywords = implode(', ', $keywords);
        }

        $this->getManager()->queue([
            'name' => 'keywords',
            'content' => $this->value($keywords),
        ]);

        return $this;
    }

    public function author($author = ''): self
    {
        $this->getManager()->queue([
            'name' => 'author',
            'content' => $this->value($author),
        ]);

        return $this;
    }

    public function httpEquiv($httpEquiv, $content): self
    {
        $this->getManager()->queue([
            'http-equiv' => $this->value($httpEquiv),
            'content' => $this->value($content),
        ]);

        return $this;
    }

    public function xUaCompatible($content = 'IE=edge'): self
    {
        return $this->httpEquiv('X-UA-Compatible', $content);
    }

    public function title($title = '$title'): self
    {
        $this->getManager()->queue([
            '_template' => '<title>{{ title }}</title>',
            'title' => $this->value($title),
        ]);

        return $this;
    }

    public function canonical($url = ''): self
    {
        $this->getManager()->queueLink([
            'rel' => 'canonical',
            'href' => $this->value($url),
        ]);

        return $this;
    }

    public function first($url = ''): self
    {
        $this->getManager()->queueLink([
            'rel' => 'first',
            'href' => $this->value($url),
        ]);

        return $this;
    }

    public function last($url = ''): self
    {
        $this->getManager()->queueLink([
            'rel' => 'last',
            'href' => $this->value($url),
        ]);

        return $this;
    }

    public function self($url = '$current_full_url'): self
    {
        $this->getManager()->queueLink([
            'rel' => 'self',
            'href' => $this->value($url),
        ]);

        return $this;
    }

    public function pagination(array $paginate): self
    {
        $this->getManager()->general()
            ->next($paginate['next_page'] ?? null)
            ->prev($paginate['prev_page'] ?? null)
            ->self();

        $allLinks = Arr::get($paginate, 'links.all', []);

        if (count($allLinks) > 0) {
            $first = $allLinks[0];
            $last = $allLinks[count($allLinks) - 1];

            if (array_key_exists('url', $first)) {
                $this->getManager()->general()->first($first['url']);
            }

            if (array_key_exists('url', $last)) {
                $this->getManager()->general()->last($last['url']);
            }
        }

        return $this;
    }

    public function prev($url = ''): self
    {
        $this->getManager()->queueLink([
            'rel' => 'prev',
            'href' => $this->value($url),
        ]);

        return $this;
    }

    public function next($url = ''): self
    {
        $this->getManager()->queueLink([
            'rel' => 'next',
            'href' => $this->value($url),
        ]);

        return $this;
    }

    public function viewport($viewport = 'width=device-width, initial-scale=1'): self
    {
        $valueToUse = $viewport;

        if ($viewport instanceof Closure) {
            $originalClosure = $viewport;

            $valueToUse = function ($context, $attributes) use ($originalClosure) {
                return $originalClosure(new ViewportBuilder(), $context, $attributes);
            };
        }

        $this->getManager()->queue([
            'name' => 'viewport',
            'content' => $this->value($valueToUse),
        ]);

        return $this;
    }

    public function localeAlternate(): self
    {
        $this->getManager()->queue(function ($context, MetaBuilder $builder) {
            $entry = DataHelpers::getEntryFromContext($context);

            if (! $entry) {
                return;
            }

            /** @var EntryLocales $entryLocales */
            $entryLocales = app(EntryLocales::class);
            // Use 'getAllLocales' to have a self-referencing alternate link.
            $variants = $entryLocales->getAllLocales($entry);

            foreach ($variants as $locale => $variant) {
                $builder->ephemeralLink([
                    'rel' => 'alternate',
                    'hreflang' => $locale,
                    'href' => $variant->absoluteUrl(),
                ]);
            }
        });

        return $this;
    }
}
