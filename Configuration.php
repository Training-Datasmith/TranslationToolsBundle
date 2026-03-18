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

namespace PrestaShop\TranslationToolsBundle;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Yaml\Yaml;

class Configuration
{
    private static array $paths = [];

    private static array $excludeFiles = [];

    /**
     * @var string
     */
    private static $projectDirectory = '';

    /**
     * @var string
     */
    private static $cacheDir;

    public static function fromArray(array $arr): void
    {
        $optionsResolver = new OptionsResolver();
        $options = $optionsResolver->setRequired([
            'paths',
            'exclude_files',
        ])
            ->setDefaults([
                'cache_dir' => null,
            ])
            ->addAllowedTypes('paths', 'array')
            ->addAllowedTypes('exclude_files', ['array', 'null'])
            ->addAllowedTypes('cache_dir', ['string', 'null'])
            ->resolve($arr);

        self::$paths = (array) $options['paths'];
        self::$excludeFiles = (array) $options['exclude_files'];
        self::$cacheDir = $options['cache_dir'];
    }

    /**
     * @param string $yamlFile
     */
    public static function fromYamlFile($yamlFile): void
    {
        self::$projectDirectory = realpath(dirname($yamlFile));
        self::fromArray(Yaml::parse(file_get_contents($yamlFile)));
    }

    /**
     * @return array
     */
    public static function getPaths()
    {
        return self::$paths;
    }

    /**
     * @return array
     */
    public static function getExcludeFiles()
    {
        return self::$excludeFiles;
    }

    /**
     * @return string
     */
    public static function getProjectDirectory()
    {
        return self::$projectDirectory;
    }

    public static function getRelativePath(string $path, ?string $rootDir = null): string
    {
        $realpath = realpath($path);
        $path = empty($realpath) ? $path : $realpath;

        if (!empty($rootDir)) {
            $rootDir = rtrim($rootDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        } else {
            $rootDir = '';
        }

        return str_replace($rootDir, '', $path);
    }

    /**
     * @return string
     */
    public static function getCacheDir()
    {
        return empty(self::$cacheDir) ? sys_get_temp_dir().DIRECTORY_SEPARATOR : self::$cacheDir;
    }
}
