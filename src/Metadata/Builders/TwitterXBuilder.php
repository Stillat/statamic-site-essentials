<?php

namespace Stillat\StatamicSiteEssentials\Metadata\Builders;

class TwitterXBuilder extends AbstractMetaTagBuilder
{
    public function all()
    {
        return $this
            ->site()->siteId()
            ->creator()->creatorId()
            ->card()
            ->appNameIpad()->appIdIpad()->appUrlIpad()
            ->appNameIphone()->appIdIphone()->appUrlIphone()
            ->appNameGooglePlay()->appIdGooglePlay()->appUrlGooglePlay();
    }

    public function card($card = null): self
    {
        if ($card == null) {
            $card = ConfigResolver::makeConfigResolver('twitter.card');
        }

        return $this->property('twitter:card', $card);
    }

    public function site($site = null): self
    {
        if ($site == null) {
            $site = ConfigResolver::makeConfigResolver('twitter.site');
        }

        return $this->property('twitter:site', $site);
    }

    public function siteId($siteId = null): self
    {
        if ($siteId == null) {
            $siteId = ConfigResolver::makeConfigResolver('twitter.site_id');
        }

        return $this->property('twitter:site:id', $siteId);
    }

    public function creator($creator = null): self
    {
        if ($creator == null) {
            $creator = ConfigResolver::makeConfigResolver('twitter.creator');
        }

        return $this->property('twitter:creator', $creator);
    }

    public function creatorId($creatorId = null): self
    {
        if ($creatorId == null) {
            $creatorId = ConfigResolver::makeConfigResolver('twitter.creator_id');
        }

        return $this->property('twitter:creator:id', $creatorId);
    }

    public function appNameIphone($appNameIphone = null): self
    {
        if ($appNameIphone == null) {
            $appNameIphone = ConfigResolver::makeConfigResolver('twitter.app_name_iphone');
        }

        return $this->property('twitter:app:name:iphone', $appNameIphone);
    }

    public function appIdIphone($appIdIphone = null): self
    {
        if ($appIdIphone == null) {
            $appIdIphone = ConfigResolver::makeConfigResolver('twitter.app_id_iphone');
        }

        return $this->property('twitter:app:id:iphone', $appIdIphone);
    }

    public function appUrlIphone($appUrlIphone = null): self
    {
        if ($appUrlIphone == null) {
            $appUrlIphone = ConfigResolver::makeConfigResolver('twitter.app_url_iphone');
        }

        return $this->property('twitter:app:url:iphone', $appUrlIphone);
    }

    public function appNameIpad($appNameIpad = null): self
    {
        if ($appNameIpad == null) {
            $appNameIpad = ConfigResolver::makeConfigResolver('twitter.app_name_ipad');
        }

        return $this->property('twitter:app:name:ipad', $appNameIpad);
    }

    public function appIdIpad($appIdIpad = null): self
    {
        if ($appIdIpad == null) {
            $appIdIpad = ConfigResolver::makeConfigResolver('twitter.app_id_ipad');
        }

        return $this->property('twitter:app:id:ipad', $appIdIpad);
    }

    public function appUrlIpad($appUrlIpad = null): self
    {
        if ($appUrlIpad == null) {
            $appUrlIpad = ConfigResolver::makeConfigResolver('twitter.app_url_ipad');
        }

        return $this->property('twitter:app:url:ipad', $appUrlIpad);
    }

    public function appNameGooglePlay($appNameGooglePlay = null): self
    {
        if ($appNameGooglePlay == null) {
            $appNameGooglePlay = ConfigResolver::makeConfigResolver('twitter.app_name_googleplay');
        }

        return $this->property('twitter:app:name:googleplay', $appNameGooglePlay);
    }

    public function appIdGooglePlay($appIdGooglePlay = null): self
    {
        if ($appIdGooglePlay == null) {
            $appIdGooglePlay = ConfigResolver::makeConfigResolver('twitter.app_id_googleplay');
        }

        return $this->property('twitter:app:id:googleplay', $appIdGooglePlay);
    }

    public function appUrlGooglePlay($appUrlGooglePlay = null): self
    {
        if ($appUrlGooglePlay == null) {
            $appUrlGooglePlay = ConfigResolver::makeConfigResolver('twitter.app_url_googleplay');
        }

        return $this->property('twitter:app:url:googleplay', $appUrlGooglePlay);
    }
}
