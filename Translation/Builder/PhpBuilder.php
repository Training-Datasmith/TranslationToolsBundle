<?php
/**
 * This file is authored by PrestaShop SA and Contributors <contact@prestashop.com>
 *
 * It is distributed under MIT license.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PrestaShop\TranslationToolsBundle\Translation\Builder;

class PhpBuilder
{
    public const POS_NEWLINE = 0;
    public const POS_VAR = 1;
    public const POS_ARRAY_KEY = 2;
    public const POS_ASSIGN = 3;
    public const POS_VALUE = 4;

    protected $fileName;

    protected $output;

    protected $pos = self::POS_NEWLINE;

    public function __construct()
    {
        $this->open();
    }

    /**
     * @return string
     */
    public function build()
    {
        return $this->output;
    }

    /**
     * @param string $varName
     */
    public function appendGlobalDeclaration($varName): void
    {
        $this->output .= 'global ';
        $this->appendVar($varName);
        $this->appendEndOfLine();
        $this->output .= PHP_EOL;
    }

    /**
     * @param string $varName
     * @param string $key
     *
     *
     * @throws \Exception
     */
    public function appendStringLine($varName, $key, string $value): static
    {
        if ($this->pos !== self::POS_NEWLINE) {
            throw new \Exception('Unable to append new line (current pos is ' . $this->pos . ')');
        }

        $this->appendVar($varName)
            ->appendKey($key)
            ->appendVarAssignation()
            ->appendValue("'" . $value . "'")
            ->appendEndOfLine();

        return $this;
    }

    protected function open(): static
    {
        $this->output .= '<?php' . PHP_EOL . PHP_EOL;
        $this->pos = self::POS_NEWLINE;

        return $this;
    }

    protected function appendVar(string $varName): static
    {
        $this->output .= '$' . $varName;
        $this->pos = self::POS_VAR;

        return $this;
    }

    protected function appendKey(string $key): static
    {
        $this->output .= "['" . $key . "']";
        $this->pos = self::POS_ARRAY_KEY;

        return $this;
    }

    protected function appendVarAssignation(): static
    {
        $this->output .= ' = ';
        $this->pos = self::POS_ASSIGN;

        return $this;
    }

    /**
     * @param string $value
     */
    protected function appendValue($value): static
    {
        $this->output .= (string) $value;
        $this->pos = self::POS_VALUE;

        return $this;
    }

    protected function appendEndOfLine(): static
    {
        $this->output .= ';' . PHP_EOL;
        $this->pos = self::POS_NEWLINE;

        return $this;
    }
}
