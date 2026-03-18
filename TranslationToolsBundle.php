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

use PrestaShop\TranslationToolsBundle\DependencyInjection\CompilerPass\ExtractorCompilerPass;
use PrestaShop\TranslationToolsBundle\DependencyInjection\CompilerPass\TranslationCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class TranslationToolsBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ExtractorCompilerPass());
        $container->addCompilerPass(new TranslationCompilerPass());
    }
}
