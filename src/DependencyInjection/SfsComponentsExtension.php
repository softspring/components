<?php

namespace Softspring\Component\Components\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SfsComponentsExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
    }

    public function prepend(ContainerBuilder $container): void
    {
        $assetsPath = \dirname(__DIR__, 2).'/assets';
        $publicPath = \dirname(__DIR__, 2).'/public';

        if (!is_dir($assetsPath) && !is_dir($publicPath)) {
            return;
        }

        $assetMapperPaths = [];
        if (is_dir($assetsPath)) {
            $assetMapperPaths[$assetsPath] = 'sfscomponents-src';
        }
        if (is_dir($publicPath)) {
            $assetMapperPaths[$publicPath] = 'sfscomponents';
        }

        $container->prependExtensionConfig('framework', [
            'asset_mapper' => [
                'paths' => $assetMapperPaths,
            ],
        ]);
    }
}
