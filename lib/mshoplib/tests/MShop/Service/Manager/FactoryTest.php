<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2022
 */


namespace Aimeos\MShop\Service\Manager;


/**
 * Test class for \Aimeos\MShop\Service\Manager\Factory.
 */
class FactoryTest extends \PHPUnit\Framework\TestCase
{
	public function testCreateManager()
	{
		$manager = \Aimeos\MShop\Service\Manager\Factory::create( \TestHelperMShop::context() );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $manager );
	}


	public function testCreateManagerName()
	{
		$manager = \Aimeos\MShop\Service\Manager\Factory::create( \TestHelperMShop::context(), 'Standard' );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $manager );
	}


	public function testCreateManagerInvalidName()
	{
		$this->expectException( \Aimeos\MShop\Service\Exception::class );
		\Aimeos\MShop\Service\Manager\Factory::create( \TestHelperMShop::context(), '%^&' );
	}


	public function testCreateManagerNotExisting()
	{
		$this->expectException( \Aimeos\MShop\Exception::class );
		\Aimeos\MShop\Service\Manager\Factory::create( \TestHelperMShop::context(), 'unknown' );
	}
}
