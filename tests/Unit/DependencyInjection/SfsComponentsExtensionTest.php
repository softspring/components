<?php

declare(strict_types=1);

namespace Softspring\Component\Components\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Softspring\Component\Components\DependencyInjection\SfsComponentsExtension;
use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class SfsComponentsExtensionTest extends TestCase
{
    public function testLoadDoesNotRequireConfiguration(): void
    {
        $container = new ContainerBuilder();

        (new SfsComponentsExtension())->load([], $container);

        self::assertSame(['service_container'], array_keys($container->getDefinitions()));
    }

    public function testItPrependsAssetMapperConfigWhenAssetMapperIsAvailable(): void
    {
        $this->ensureAssetMapperInterfaceExists();
        $container = new ContainerBuilder();

        (new SfsComponentsExtension())->prepend($container);

        $frameworkConfig = $container->getExtensionConfig('framework')[0];

        self::assertSame(
            '@softspring/components',
            array_values($frameworkConfig['asset_mapper']['paths'])[0]
        );
    }

    private function ensureAssetMapperInterfaceExists(): void
    {
        if (interface_exists(AssetMapperInterface::class)) {
            return;
        }

        eval('namespace Symfony\Component\AssetMapper; interface AssetMapperInterface {}');
    }
}
