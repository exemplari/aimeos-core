<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2015-2022
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds locale records to tables.
 */
class MShopAddLocaleData extends Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function after() : array
	{
		return ['MShopAddLocaleLangCurData', 'Log'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function before() : array
	{
		return ['MShopSetLocale'];
	}


	/**
	 * Creates new locale data if necessary
	 */
	public function up()
	{
		$this->info( 'Adding locale data if not yet present', 'v' );

		// Set editor for further tasks
		$this->context()->setEditor( 'core:setup' );

		$code = $this->context()->config()->get( 'setup/site', 'default' );

		$localeManager = \Aimeos\MShop\Locale\Manager\Factory::create( $this->context(), 'Standard' );
		$siteManager = $localeManager->getSubManager( 'site' );

		try {
			$siteItem = $siteManager->insert( $siteManager->create()->setLabel( $code )->setCode( $code ) );
		} catch( \Aimeos\MW\DB\Exception $e ) {
			$siteItem = $siteManager->find( $code );
		}

		try
		{
			$localeItem = $localeManager->create();
			$localeItem->set( 'site_id', $siteItem->getId() );
			$localeItem->setSiteId( $siteItem->getSiteId() );
			$localeItem->setLanguageId( 'en' );
			$localeItem->setCurrencyId( 'EUR' );
			$localeItem->setStatus( 1 );

			$localeManager->save( $localeItem, false );
		}
		catch( \Aimeos\MW\DB\Exception $e ) {} // already in the database
	}


	/**
	 * Adds locale site data.
	 *
	 * @param \Aimeos\MShop\Common\Manager\Iface $localeManager Locale manager
	 * @param array $data Associative list of locale site data
	 * @param string $manager Manager implementation name
	 * @param string|null $parentId Parent id of the locale item
	 * @return array Associative list of keys from the data and generated site ID
	 */
	protected function addLocaleSiteData( \Aimeos\MShop\Common\Manager\Iface $localeManager, array $data, $manager = 'Standard', $parentId = null )
	{
		$this->info( 'Adding data for MShop locale sites', 'v', 1 );

		$siteIds = [];
		$manager = $localeManager->getSubManager( 'site', $manager );

		foreach( $data as $key => $dataset )
		{
			try {
				$item = $manager->insert( $manager->create()->fromArray( $dataset ), $parentId );
			} catch( \Aimeos\MW\DB\Exception $e ) {
				$item = $manager->find( $key );
			}

			$siteIds[$key] = ['id' => $item->getId(), 'site' => $item->getSiteId()];
		}

		return $siteIds;
	}


	/**
	 * Adds locale currency data.
	 *
	 * @param \Aimeos\MShop\Common\Manager\Iface $localeManager Locale manager
	 * @param array $data Associative list of locale currency data
	 */
	protected function addLocaleCurrencyData( \Aimeos\MShop\Common\Manager\Iface $localeManager, array $data )
	{
		$this->info( 'Adding data for MShop locale currencies', 'v', 1 );

		$manager = $localeManager->getSubManager( 'currency', 'Standard' );
		$items = $manager->search( $manager->filter()->slice( 0, 0x7fffffff ) );

		foreach( $data as $key => $dataset ) {
			$items->has( $key ) ?: $manager->save( $manager->create()->fromArray( $dataset, true ) );
		}
	}


	/**
	 * Adds locale language data.
	 *
	 * @param \Aimeos\MShop\Common\Manager\Iface $localeManager Locale manager
	 * @param array $data Associative list of locale language data
	 */
	protected function addLocaleLanguageData( \Aimeos\MShop\Common\Manager\Iface $localeManager, array $data )
	{
		$this->info( 'Adding data for MShop locale languages', 'v', 1 );

		$manager = $localeManager->getSubManager( 'language', 'Standard' );
		$items = $manager->search( $manager->filter()->slice( 0, 0x7fffffff ) );

		foreach( $data as $key => $dataset ) {
			$items->has( $key ) ?: $manager->save( $manager->create()->fromArray( $dataset, true ) );
		}
	}


	/**
	 * Adds locale data.
	 *
	 * @param \Aimeos\MShop\Common\Manager\Iface $localeManager Locale manager
	 * @param array $data Associative list of locale data
	 */
	protected function addLocaleData( \Aimeos\MShop\Common\Manager\Iface $localeManager, array $data, array $siteIds )
	{
		$this->info( 'Adding data for MShop locales', 'v', 1 );

		foreach( $data as $dataset )
		{
			if( !isset( $siteIds[$dataset['site']] ) ) {
				throw new \RuntimeException( sprintf( 'No ID for site for key "%1$s" found', $dataset['site'] ) );
			}

			$item = $localeManager->create()->fromArray( $dataset, true )
				->set( 'site_id', $siteIds[$dataset['site']]['id'] )
				->setSiteId( $siteIds[$dataset['site']]['site'] );

			try {
				$localeManager->save( $item );
			} catch( \Aimeos\MW\DB\Exception $e ) { ; } // if locale combination was already available
		}
	}
}
