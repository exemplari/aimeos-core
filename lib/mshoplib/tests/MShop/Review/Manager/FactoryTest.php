<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2020-2022
 */


namespace Aimeos\MShop\Review\Manager;


class FactoryTest extends \PHPUnit\Framework\TestCase
{
	public function testCreateManager()
	{
		$manager = \Aimeos\MShop\Review\Manager\Factory::create( \TestHelperMShop::context() );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $manager );
	}


	public function testCreateManagerName()
	{
		$manager = \Aimeos\MShop\Review\Manager\Factory::create( \TestHelperMShop::context(), 'Standard' );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $manager );
	}


	public function testCreateManagerInvalidName()
	{
		$this->expectException( \Aimeos\MShop\Review\Exception::class );
		\Aimeos\MShop\Review\Manager\Factory::create( \TestHelperMShop::context(), '%^&' );
	}


	public function testCreateManagerNotExisting()
	{
		$this->expectException( \Aimeos\MShop\Exception::class );
		\Aimeos\MShop\Review\Manager\Factory::create( \TestHelperMShop::context(), 'test' );
	}
}
