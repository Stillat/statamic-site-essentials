<?php

namespace Stillat\StatamicSiteEssentials\Favicons;

use InvalidArgumentException;
use Statamic\Support\Str;
use Stillat\StatamicSiteEssentials\Contracts\FaviconGenerator;
use Stillat\StatamicSiteEssentials\Events\GeneratedNewFavicon;
use Stillat\StatamicSiteEssentials\Events\GeneratingNewFavicons;
use Stillat\StatamicSiteEssentials\Events\RemovedGeneratedFavicon;
use Stillat\StatamicSiteEssentials\Events\RemovingGeneratedFavicons;

class Generator
{
    protected FaviconGenerator $driver;

    protected array $icons = [];

    protected bool $removeExisting = true;

    protected string $tmpDirectory = '';

    public function __construct(FaviconGenerator $driver)
    {
        $this->driver = $driver;
    }

    public function setRemoveExisting(bool $removeExisting): self
    {
        $this->removeExisting = true;

        return $this;
    }

    public function setIcons(array $icons): self
    {
        $this->icons = $icons;

        return $this;
    }

    public function setTmpDirectory(string $tmpDirectory): self
    {
        $this->tmpDirectory = Str::finish($tmpDirectory, DIRECTORY_SEPARATOR);

        return $this;
    }

    public function getIcons(): array
    {
        return $this->icons;
    }

    public function generateFavicons(string $sourceImage)
    {
        if (! file_exists($sourceImage)) {
            throw new InvalidArgumentException('Source image does not exist:.');
        }

        $faviconCachePath = $this->tmpDirectory.'favicons.json';

        if ($this->removeExisting && file_exists($faviconCachePath)) {
            $createdPaths = json_decode(file_get_contents($faviconCachePath), true);

            RemovingGeneratedFavicons::dispatch($createdPaths);

            foreach ($createdPaths as $createdPath) {
                $path = base_path($createdPath);

                if (file_exists($path)) {
                    unlink($path);
                }

                RemovedGeneratedFavicon::dispatch($createdPath);
            }
        }

        $createdPaths = [];

        GeneratingNewFavicons::dispatch($this->icons);

        foreach ($this->icons as $icon) {
            $fileName = Icons::getFileName($icon['size'], $icon['format']);
            [$width, $height] = explode('x', $icon['size']);
            $targetFileName = public_path($fileName);

            $this->driver->resize($sourceImage, $targetFileName, $height, $width);

            GeneratedNewFavicon::dispatch($targetFileName);

            $createdPaths[] = $targetFileName;
        }

        dd($this->tmpDirectory);

        file_put_contents($faviconCachePath, json_encode($createdPaths, JSON_PRETTY_PRINT));
    }
}
