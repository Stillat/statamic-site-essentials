<?php

namespace Stillat\StatamicSiteEssentials\View;

use Illuminate\Contracts\View\View;

class ViewObserver
{
    /**
     * A mapping of view names to the number of times they were rendered.
     */
    protected array $viewNames = [];

    /**
     * Adds a view to the internal list, incrementing the count.
     */
    public function observe(View $view): void
    {
        $name = $view->name();

        $name = str_replace('_', '', $name);
        $name = str_replace('.', '/', $name);

        if (! array_key_exists($name, $this->viewNames)) {
            $this->viewNames[$name] = 0;
        }

        $this->viewNames[$name]++;
    }

    /**
     * Returns the observed view names and their counts.
     */
    public function getObservedViews(): array
    {
        return $this->viewNames;
    }

    /**
     * Determines if the provided view name has been observed.
     *
     * @param  string  $viewName Thew view name to check.
     */
    public function hasObserved(string $viewName): bool
    {
        return array_key_exists($viewName, $this->viewNames);
    }

    /**
     * Resets the internal list of observed views.
     */
    public function reset(): void
    {
        $this->viewNames = [];
    }

    /**
     * Sets up the view observer.
     */
    public static function setupObserver(): void
    {
        view()->composer('*', function (View $view) {
            app(ViewObserver::class)->observe($view);
        });
    }
}
