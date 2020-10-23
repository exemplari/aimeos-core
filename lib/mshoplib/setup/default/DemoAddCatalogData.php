<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds demo records to catalog tables.
 */
class DemoAddCatalogData extends \Aimeos\MW\Setup\Task\MShopAddDataAbstract
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['DemoAddProductData'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['DemoRebuildIndex'];
	}


	/**
	 * Insert catalog nodes and relations.
	 */
	public function migrate()
	{
		$this->msg( 'Processing catalog demo data', 0 );

		$context = $this->getContext();
		$value = $context->getConfig()->get( 'setup/default/demo', '' );

		if( $value === '' )
		{
			$this->status( 'OK' );
			return;
		}


		$item = null;
		$manager = \Aimeos\MShop::create( $context, 'catalog' );

		try
		{
			// Don't delete the catalog node because users are likely use it for production
			$item = $manager->getTree( null, [], \Aimeos\MW\Tree\Manager\Base::LEVEL_ONE );

			$this->removeItems( $item->getId(), 'catalog/lists', 'catalog', 'media' );
			$this->removeItems( $item->getId(), 'catalog/lists', 'catalog', 'text' );
			$this->removeListItems( $item->getId(), 'catalog/lists', 'product' );
		}
		catch( \Exception $e ) {; } // If no root node was already inserted into the database

		$search = $manager->createSearch();
		$search->setConditions( $search->compare( '=~', 'catalog.code', 'demo-' ) );
		$manager->deleteItems( $manager->search( $search )->getId()->toArray() );


		if( $value === '1' )
		{
			$ds = DIRECTORY_SEPARATOR;
			$path = __DIR__ . $ds . 'data' . $ds . 'demo-catalog.php';

			if( ( $data = include( $path ) ) == false ) {
				throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for catalog domain', $path ) );
			}

			if( $item === null )
			{
				$item = $manager->createItem()->fromArray( $data );
				$item = $manager->insertItem( $item );
			}


			if( isset( $data['media'] ) ) {
				$this->addMedia( $item->getId(), $data['media'], 'catalog' );
			}

			if( isset( $data['product'] ) ) {
				$this->addProducts( $item->getId(), $data['product'], 'catalog' );
			}

			if( isset( $data['text'] ) ) {
				$this->addTexts( $item->getId(), $data['text'], 'catalog' );
			}

			if( isset( $data['catalog'] ) ) {
				$this->addCatalog( $item->getId(), $data['catalog'], 'catalog' );
			}

			$this->status( 'added' );
		}
		else
		{
			$this->status( 'removed' );
		}
	}


	/**
	 * Adds the catalog items including referenced items
	 *
	 * @param string $id Unique ID of the parent category
	 * @param array $data List of category data
	 * @param string $domain Parent domain name (catalog)
	 */
	protected function addCatalog( string $id, array $data, string $domain )
	{
		$context = $this->getContext();
		$manager = \Aimeos\MShop::create( $context, $domain );

		foreach( $data as $entry )
		{
			$item = $manager->createItem()->fromArray( $entry );
			$item = $manager->insertItem( $item, $id );

			if( isset( $entry['media'] ) ) {
				$this->addMedia( $item->getId(), $entry['media'], $domain );
			}

			if( isset( $entry['product'] ) ) {
				$this->addProducts( $item->getId(), $entry['product'], $domain );
			}

			if( isset( $entry['text'] ) ) {
				$this->addTexts( $item->getId(), $entry['text'], $domain );
			}

			if( isset( $data['catalog'] ) ) {
				$this->addCatalog( $item->getId(), $data['catalog'], $domain );
			}
		}
	}
}
