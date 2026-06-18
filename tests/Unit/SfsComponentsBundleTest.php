<?php

declare(strict_types=1);

namespace Softspring\Component\Components\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Softspring\Component\Components\SfsComponentsBundle;

final class SfsComponentsBundleTest extends TestCase
{
    public function testItReturnsPackagePath(): void
    {
        self::assertSame(\dirname(__DIR__, 2), (new SfsComponentsBundle())->getPath());
    }
}
