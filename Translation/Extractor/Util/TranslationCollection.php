<?php

declare(strict_types=1);
/**
 * This file is authored by PrestaShop SA and Contributors <contact@prestashop.com>
 *
 * It is distributed under MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PrestaShop\TranslationToolsBundle\Translation\Extractor\Util;

class TranslationCollection
{
    private array $translations = [];

    /**
     * Creates a new translation item. Note that it is not added to the collection.
     *
     * @param string $source Wording
     * @param int $line
     * @param string $domain
     *
     * @return array Translation item
     */
    public static function newTranslationItem($source, $line, $domain = ''): array
    {
        return [
            'source' => $source,
            'line' => $line,
            'domain' => $domain,
        ];
    }

    /**
     * Adds an array of translations to the collection.
     *
     * @param array[] $translations Array of translation items
     */
    public function add(array $translations): void
    {
        if (!empty($translations)) {
            $this->translations = array_merge($this->translations, $translations);
        }
    }

    /**
     * Applies the provided translation domain for all translation items that don't specify a domain
     *
     * @param string $domain
     */
    public function applyDefaultTranslationDomain($domain): void
    {
        foreach ($this->translations as &$translation) {
            if (empty($translation['domain'])) {
                $translation['domain'] = $domain;
            }
        }
    }

    /**
     * Returns all the translations as an array.
     *
     * @return array[]
     */
    public function getTranslations()
    {
        return $this->translations;
    }
}
