<?php

namespace Stillat\StatamicSiteEssentials\Metadata;

use DOMDocument;
use DOMXPath;
use Illuminate\Support\Str;

class MetadataCleaner
{
    protected array $rules = [
    ];

    protected array $observedTagIndex = [];

    public function withRules(array $rules): self
    {
        $this->rules = $rules;

        return $this;
    }

    public function withConfiguredRules(): self
    {
        $this->rules = config('site_essentials.metadata_rules.rules', []);

        return $this;
    }

    protected function findApplicableRule($tag, $rules)
    {
        $applicableRule = null;
        $highestMatchCount = 0;

        foreach ($rules as $rule) {
            $matchCount = 0;

            foreach ($rule as $attribute) {
                $tagCheck = $tag->C14N();

                if (Str::endsWith($attribute, '"*"')) {
                    $checkAttribute = Str::before($attribute, '"');

                    if (str_contains($tagCheck, $checkAttribute)) {
                        $matchCount++;

                        continue;
                    }
                }

                if (str_contains($tagCheck, $attribute)) {
                    $matchCount++;
                }
            }

            // If this rule has more matches than the previous, it's a better match
            if ($matchCount > $highestMatchCount) {
                $highestMatchCount = $matchCount;
                $applicableRule = $rule;
            }
        }

        if ($applicableRule == null && array_key_exists($tag->tagName, $this->rules) && count($this->rules[$tag->tagName]) == 0) {
            return [];
        }

        return $applicableRule;
    }

    protected function getTagKey(string $tagName, array $attributes): string
    {
        return $tagName.json_encode($attributes);
    }

    protected function getValuesFromRule(string $tagName, array $rule, array $tagAttributes): string
    {
        if (count($rule) == 0) {
            return $tagName;
        }

        $tagAttributes = array_change_key_case($tagAttributes, CASE_LOWER);
        $tagValues = [];

        foreach ($rule as $ruleAttribute) {
            $ruleAttribute = strtolower($ruleAttribute);

            if (str_contains($ruleAttribute, '=')) {
                $parts = explode('=', $ruleAttribute);
                $ruleAttribute = $parts[0];
                $ruleValue = $parts[1];
            } else {
                $ruleValue = null;
            }

            if (is_string($ruleValue)) {
                if (Str::startsWith($ruleValue, '"') && Str::endsWith($ruleValue, '"')) {
                    $ruleValue = substr($ruleValue, 1, -1);
                } elseif (Str::startsWith($ruleValue, "'") && Str::endsWith($ruleValue, "'")) {
                    $ruleValue = substr($ruleValue, 1, -1);
                }
            }

            if (array_key_exists($ruleAttribute, $tagAttributes)) {
                if ($ruleValue != null) {
                    if ($ruleValue == '*' || $tagAttributes[$ruleAttribute] == $ruleValue) {
                        $tagValues[] = $ruleAttribute.'="'.$tagAttributes[$ruleAttribute].'"';
                    } else {
                        // Skip this rule.
                        continue;
                    }
                } else {
                    if (! str_contains($ruleAttribute, '=')) {
                        $tagValues[] = $ruleAttribute;

                        continue;
                    }
                    $tagValues[] = $ruleAttribute.'="'.$tagAttributes[$ruleAttribute].'"';
                }
            }
        }

        return $tagName.'>'.implode('|', $tagValues);
    }

    public function clean(string $content): string
    {
        $html = '<html><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><body>'.$content.'</body></html>';
        $newTags = [];

        $dom = new DOMDocument();
        @$dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXPath($dom);

        $metaTags = $xpath->query('//body/*');
        $seenTags = [];

        // Iterate in reverse order (to keep the last occurrence)
        for ($i = $metaTags->length - 1; $i >= 0; $i--) {
            $tag = $metaTags->item($i);
            $tagName = $tag->tagName;
            $attributes = [];

            if ($tagName == 'body') {
                continue;
            }

            foreach ($tag->attributes as $attr) {
                $attributes[$attr->name] = $attr->value;
            }

            $key = $this->getTagKey($tagName, $attributes);

            if (! isset($seenTags[$key])) {
                if (array_key_exists($tagName, $this->rules)) {
                    $applicableRule = $this->findApplicableRule($tag, $this->rules[$tagName]);

                    if ($applicableRule != null || is_array($applicableRule)) {
                        $ruleValue = $this->getValuesFromRule($tagName, $applicableRule, $attributes);

                        if (array_key_exists($ruleValue, $this->observedTagIndex)) {
                            continue;
                        }

                        $this->observedTagIndex[$ruleValue] = true;
                    }
                }
                $seenTags[$key] = true;
                $newTags[] = $dom->saveHTML($tag);
            }

            $tag->parentNode?->removeChild($tag);
        }

        return implode("\n", array_reverse($newTags));
    }
}
