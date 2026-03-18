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

namespace PrestaShop\TranslationToolsBundle\Translation;

class MultilanguageCatalog
{
    /** @var [] (key/locale) */
    private array $messages = [];

    /**
     * @param string|int $key
     * @param string|int $locale
     */
    public function has($key, $locale = null): bool
    {
        return !empty($this->messages[$key]) && (is_null($locale) || !empty($this->messages[$key][$locale]));
    }

    /**
     * @param string|int $key
     * @param string|int $locale
     */
    public function get($key, $locale = null)
    {
        if (is_null($locale)) {
            return $this->messages[$key];
        }

        return $this->messages[$key][$locale];
    }

    /**
     * @param string|int $key
     * @param string|int $locale
     */
    public function set($key, $locale, $translation): static
    {
        if (!isset($this->messages[$key])) {
            $this->messages[$key] = [];
        }

        $this->messages[$key][$locale] = $translation;

        return $this;
    }
}
