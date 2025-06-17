<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Wundii\AfterbuySdk\SymfonyBundle\AfterbuySdkBundle;
use Wundii\AfterbuySdk\SymfonyBundle\DependencyInjection\AfterbuySdkExtension;

final class AfterbuySkdBundleTest extends TestCase
{
    public function testBundleReturnsCorrectExtension(): void
    {
        $bundle = new AfterbuySdkBundle();
        $extension = $bundle->getContainerExtension();
        self::assertInstanceOf(AfterbuySdkExtension::class, $extension);
    }
}
