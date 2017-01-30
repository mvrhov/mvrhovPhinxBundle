<?php
/**
 * Released under the MIT License.
 *
 * Copyright (c) 2017 Miha Vrhovnik <miha.vrhovnik@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace mvrhov\PhinxBundle\DependencyInjection;

use Phinx\Config\Config;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class mvrhovPhinxExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $options = [];

        if (isset($config['paths'])) {
            $options['paths'] = $config['paths'];
        }
        if (isset($config['migration_base_class'])) {
            $options['migration_base_class'] = $config['migration_base_class'];
        }

        $options['environments']['default_database'] = 'default';

        if (isset($config['environment']['migration_table'])) {
            $options['environments']['default_migration_table'] = $config['environment']['migration_table'];
        }

        $options['environments']['default'] = $config['environment']['connection'];

        if (isset($config['environment']['table_prefix'])) {
            $options['environments']['default']['table_prefix'] = $config['environment']['table_prefix'];
        }
        if (isset($config['environment']['table_suffix'])) {
            $options['environments']['default']['table_suffix'] = $config['environment']['table_suffix'];
        }

        $env = $container->register('phinx.config', Config::class);
        $env->setArguments([$options]);

        if (isset($config['adapters'])) {
            $container->setParameter('phinx.adapters', $config['adapters']);
        }
    }

}
