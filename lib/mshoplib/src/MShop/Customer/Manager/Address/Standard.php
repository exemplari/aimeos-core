<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Address;


/**
 * Implementation for customer address manager.
 *
 * @package MShop
 * @subpackage Customer
 */
class Standard
	extends \Aimeos\MShop\Common\Manager\Address\Base
	implements \Aimeos\MShop\Customer\Manager\Address\Iface, \Aimeos\MShop\Common\Manager\Factory\Iface
{
	private $searchConfig = array(
		'customer.address.id' => array(
			'label' => 'Address ID',
			'code' => 'customer.address.id',
			'internalcode' => 'mcusad."id"',
			'internaldeps' => array( 'LEFT JOIN "mshop_customer_address" AS mcusad ON ( mcus."id" = mcusad."parentid" )' ),
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.address.siteid' => array(
			'code' => 'customer.address.siteid',
			'internalcode' => 'mcusad."siteid"',
			'label' => 'Customer address site ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.address.parentid' => array(
			'label' => 'Address parent ID',
			'code' => 'customer.address.parentid',
			'internalcode' => 'mcusad."parentid"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.address.company' => array(
			'label' => 'Address company',
			'code' => 'customer.address.company',
			'internalcode' => 'mcusad."company"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.vatid' => array(
			'label' => 'Address Vat ID',
			'code' => 'customer.address.vatid',
			'internalcode' => 'mcusad."vatid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.salutation' => array(
			'label' => 'Address salutation',
			'code' => 'customer.address.salutation',
			'internalcode' => 'mcusad."salutation"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.title' => array(
			'label' => 'Address title',
			'code' => 'customer.address.title',
			'internalcode' => 'mcusad."title"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.firstname' => array(
			'label' => 'Address firstname',
			'code' => 'customer.address.firstname',
			'internalcode' => 'mcusad."firstname"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.lastname' => array(
			'label' => 'Address lastname',
			'code' => 'customer.address.lastname',
			'internalcode' => 'mcusad."lastname"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.address1' => array(
			'label' => 'Address address part one',
			'code' => 'customer.address.address1',
			'internalcode' => 'mcusad."address1"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.address2' => array(
			'label' => 'Address address part two',
			'code' => 'customer.address.address2',
			'internalcode' => 'mcusad."address2"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.address3' => array(
			'label' => 'Address address part three',
			'code' => 'customer.address.address3',
			'internalcode' => 'mcusad."address3"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.postal' => array(
			'label' => 'Address postal',
			'code' => 'customer.address.postal',
			'internalcode' => 'mcusad."postal"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.city' => array(
			'label' => 'Address city',
			'code' => 'customer.address.city',
			'internalcode' => 'mcusad."city"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.state' => array(
			'label' => 'Address state',
			'code' => 'customer.address.state',
			'internalcode' => 'mcusad."state"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.languageid' => array(
			'label' => 'Address language',
			'code' => 'customer.address.languageid',
			'internalcode' => 'mcusad."langid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.countryid' => array(
			'label' => 'Address country',
			'code' => 'customer.address.countryid',
			'internalcode' => 'mcusad."countryid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.telephone' => array(
			'label' => 'Address telephone',
			'code' => 'customer.address.telephone',
			'internalcode' => 'mcusad."telephone"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.email' => array(
			'label' => 'Address email',
			'code' => 'customer.address.email',
			'internalcode' => 'mcusad."email"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.telefax' => array(
			'label' => 'Address telefax',
			'code' => 'customer.address.telefax',
			'internalcode' => 'mcusad."telefax"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.website' => array(
			'label' => 'Address website',
			'code' => 'customer.address.website',
			'internalcode' => 'mcusad."website"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address.longitude' => array(
			'label' => 'Address longitude',
			'code' => 'customer.address.longitude',
			'internalcode' => 'mcusad."longitude"',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
			'public' => false,
		),
		'customer.address.latitude' => array(
			'label' => 'Address latitude',
			'code' => 'customer.address.latitude',
			'internalcode' => 'mcusad."latitude"',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
			'public' => false,
		),
		'customer.address.position' => array(
			'code' => 'customer.address.position',
			'internalcode' => 'mcusad."pos"',
			'label' => 'Address position',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.address.birthday' => array(
			'code' => 'customer.address.birthday',
			'internalcode' => 'mcusad."birthday"',
			'label' => 'Address birthday',
			'type' => 'date',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.address.ctime' => array(
			'code' => 'customer.address.ctime',
			'internalcode' => 'mcusad."ctime"',
			'label' => 'Address create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.address.mtime' => array(
			'code' => 'customer.address.mtime',
			'internalcode' => 'mcusad."mtime"',
			'label' => 'Address modify date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.address.editor' => array(
			'code' => 'customer.address.editor',
			'internalcode' => 'mcusad."editor"',
			'label' => 'Address editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
	);


	/**
	 * Initializes the object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );
		$this->setResourceName( 'db-customer' );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param iterable $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Customer\Manager\Address\Iface Manager object for chaining method calls
	 */
	public function clear( iterable $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/address/submanagers';
		foreach( $this->context()->config()->get( $path, [] ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/address/delete' );
	}


	/**
	 * Returns the available manager types
	 *
	 * @param bool $withsub Return also the resource type of sub-managers if true
	 * @return string[] Type of the manager and submanagers, subtypes are separated by slashes
	 */
	public function getResourceType( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/address/submanagers';

		return $this->getResourceTypeBase( 'customer/address', $path, [], $withsub );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return \Aimeos\MW\Criteria\Attribute\Iface[] List of search attribute items
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		/** mshop/customer/manager/address/submanagers
		 * List of manager names that can be instantiated by the customer address manager
		 *
		 * Managers provide a generic interface to the underlying storage.
		 * Each manager has or can have sub-managers caring about particular
		 * aspects. Each of these sub-managers can be instantiated by its
		 * parent manager using the getSubManager() method.
		 *
		 * The search keys from sub-managers can be normally used in the
		 * manager as well. It allows you to search for items of the manager
		 * using the search keys of the sub-managers to further limit the
		 * retrieved list of items.
		 *
		 * @param array List of sub-manager names
		 * @since 2014.03
		 * @category Developer
		 */
		$path = 'mshop/customer/manager/address/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for address extensions.
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g type, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		/** mshop/customer/manager/address/name
		 * Class name of the used customer address manager implementation
		 *
		 * Each default customer address manager can be replaced by an alternative imlementation.
		 * To use this implementation, you have to set the last part of the class
		 * name as configuration value so the manager factory knows which class it
		 * has to instantiate.
		 *
		 * For example, if the name of the default class is
		 *
		 *  \Aimeos\MShop\Customer\Manager\Address\Standard
		 *
		 * and you want to replace it with your own version named
		 *
		 *  \Aimeos\MShop\Customer\Manager\Address\Myaddress
		 *
		 * then you have to set the this configuration option:
		 *
		 *  mshop/customer/manager/address/name = Myaddress
		 *
		 * The value is the last part of your own class name and it's case sensitive,
		 * so take care that the configuration value is exactly named like the last
		 * part of the class name.
		 *
		 * The allowed characters of the class name are A-Z, a-z and 0-9. No other
		 * characters are possible! You should always start the last part of the class
		 * name with an upper case character and continue only with lower case characters
		 * or numbers. Avoid chamel case names like "MyAddress"!
		 *
		 * @param string Last part of the class name
		 * @since 2014.03
		 * @category Developer
		 */

		/** mshop/customer/manager/address/decorators/excludes
		 * Excludes decorators added by the "common" option from the customer address manager
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "mshop/common/manager/decorators/default" before they are wrapped
		 * around the customer address manager.
		 *
		 *  mshop/customer/manager/address/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\MShop\Common\Manager\Decorator\*") added via
		 * "mshop/common/manager/decorators/default" for the customer address manager.
		 *
		 * @param array Address of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/common/manager/decorators/default
		 * @see mshop/customer/manager/address/decorators/global
		 * @see mshop/customer/manager/address/decorators/local
		 */

		/** mshop/customer/manager/address/decorators/global
		 * Adds a list of globally available decorators only to the customer address manager
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\MShop\Common\Manager\Decorator\*") around the customer address manager.
		 *
		 *  mshop/customer/manager/address/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\MShop\Common\Manager\Decorator\Decorator1" only to the customer
		 * address manager.
		 *
		 * @param array Address of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/common/manager/decorators/default
		 * @see mshop/customer/manager/address/decorators/excludes
		 * @see mshop/customer/manager/address/decorators/local
		 */

		/** mshop/customer/manager/address/decorators/local
		 * Adds a list of local decorators only to the customer address manager
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\MShop\Customer\Manager\Address\Decorator\*") around the customer
		 * address manager.
		 *
		 *  mshop/customer/manager/address/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\MShop\Customer\Manager\Address\Decorator\Decorator2" only to the
		 * customer address manager.
		 *
		 * @param array Address of decorator names
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/common/manager/decorators/default
		 * @see mshop/customer/manager/address/decorators/excludes
		 * @see mshop/customer/manager/address/decorators/global
		 */

		return $this->getSubManagerBase( 'customer', 'address/' . $manager, $name );
	}


	/**
	 * Creates a new address item
	 *
	 * @param array $values List of attributes for address item
	 * @return \Aimeos\MShop\Customer\Item\Address\Iface New address item
	 */
	protected function createItemBase( array $values = [] ) : \Aimeos\MShop\Common\Item\Address\Iface
	{
		return new \Aimeos\MShop\Customer\Item\Address\Standard( $this->getPrefix(), $values );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path
	 */
	protected function getConfigPath() : string
	{
		/** mshop/customer/manager/address/insert/mysql
		 * Inserts a new customer address record into the database table
		 *
		 * @see mshop/customer/manager/address/insert/ansi
		 */

		/** mshop/customer/manager/address/insert/ansi
		 * Inserts a new customer address record into the database table
		 *
		 * Items with no ID yet (i.e. the ID is NULL) will be created in
		 * the database and the newly created ID retrieved afterwards
		 * using the "newid" SQL statement.
		 *
		 * The SQL statement must be a string suitable for being used as
		 * prepared statement. It must include question marks for binding
		 * the values from the customer list item to the statement before they are
		 * sent to the database server. The number of question marks must
		 * be the same as the number of columns listed in the INSERT
		 * statement. The order of the columns must correspond to the
		 * order in the save() method, so the correct values are
		 * bound to the columns.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for inserting records
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/customer/manager/address/update/ansi
		 * @see mshop/customer/manager/address/newid/ansi
		 * @see mshop/customer/manager/address/delete/ansi
		 * @see mshop/customer/manager/address/search/ansi
		 * @see mshop/customer/manager/address/count/ansi
		 */

		/** mshop/customer/manager/address/update/mysql
		 * Updates an existing customer address record in the database
		 *
		 * @see mshop/customer/manager/address/update/ansi
		 */

		/** mshop/customer/manager/address/update/ansi
		 * Updates an existing customer address record in the database
		 *
		 * Items which already have an ID (i.e. the ID is not NULL) will
		 * be updated in the database.
		 *
		 * The SQL statement must be a string suitable for being used as
		 * prepared statement. It must include question marks for binding
		 * the values from the customer list item to the statement before they are
		 * sent to the database server. The order of the columns must
		 * correspond to the order in the save() method, so the
		 * correct values are bound to the columns.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for updating records
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/customer/manager/address/insert/ansi
		 * @see mshop/customer/manager/address/newid/ansi
		 * @see mshop/customer/manager/address/delete/ansi
		 * @see mshop/customer/manager/address/search/ansi
		 * @see mshop/customer/manager/address/count/ansi
		 */

		/** mshop/customer/manager/address/newid/mysql
		 * Retrieves the ID generated by the database when inserting a new record
		 *
		 * @see mshop/customer/manager/address/newid/ansi
		 */

		/** mshop/customer/manager/address/newid/ansi
		 * Retrieves the ID generated by the database when inserting a new record
		 *
		 * As soon as a new record is inserted into the database table,
		 * the database server generates a new and unique identifier for
		 * that record. This ID can be used for retrieving, updating and
		 * deleting that specific record from the table again.
		 *
		 * For MySQL:
		 *  SELECT LAST_INSERT_ID()
		 * For PostgreSQL:
		 *  SELECT currval('seq_mcusad_id')
		 * For SQL Server:
		 *  SELECT SCOPE_IDENTITY()
		 * For Oracle:
		 *  SELECT "seq_mcusad_id".CURRVAL FROM DUAL
		 *
		 * There's no way to retrive the new ID by a SQL statements that
		 * fits for most database servers as they implement their own
		 * specific way.
		 *
		 * @param string SQL statement for retrieving the last inserted record ID
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/customer/manager/address/insert/ansi
		 * @see mshop/customer/manager/address/update/ansi
		 * @see mshop/customer/manager/address/delete/ansi
		 * @see mshop/customer/manager/address/search/ansi
		 * @see mshop/customer/manager/address/count/ansi
		 */

		/** mshop/customer/manager/address/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/customer/manager/address/delete/ansi
		 */

		/** mshop/customer/manager/address/delete/ansi
		 * Deletes the items matched by the given IDs from the database
		 *
		 * Removes the records specified by the given IDs from the customer database.
		 * The records must be from the site that is configured via the
		 * context item.
		 *
		 * The ":cond" placeholder is replaced by the name of the ID column and
		 * the given ID or list of IDs while the site ID is bound to the question
		 * mark.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for deleting items
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/customer/manager/address/insert/ansi
		 * @see mshop/customer/manager/address/update/ansi
		 * @see mshop/customer/manager/address/newid/ansi
		 * @see mshop/customer/manager/address/search/ansi
		 * @see mshop/customer/manager/address/count/ansi
		 */

		/** mshop/customer/manager/address/search/mysql
		 * Retrieves the records matched by the given criteria in the database
		 *
		 * @see mshop/customer/manager/address/search/ansi
		 */

		/** mshop/customer/manager/address/search/ansi
		 * Retrieves the records matched by the given criteria in the database
		 *
		 * Fetches the records matched by the given criteria from the customer
		 * database. The records must be from one of the sites that are
		 * configured via the context item. If the current site is part of
		 * a tree of sites, the SELECT statement can retrieve all records
		 * from the current site and the complete sub-tree of sites.
		 *
		 * As the records can normally be limited by criteria from sub-managers,
		 * their tables must be joined in the SQL context. This is done by
		 * using the "internaldeps" property from the definition of the ID
		 * column of the sub-managers. These internal dependencies specify
		 * the JOIN between the tables and the used columns for joining. The
		 * ":joins" placeholder is then replaced by the JOIN strings from
		 * the sub-managers.
		 *
		 * To limit the records matched, conditions can be added to the given
		 * criteria object. It can contain comparisons like column names that
		 * must match specific values which can be combined by AND, OR or NOT
		 * operators. The resulting string of SQL conditions replaces the
		 * ":cond" placeholder before the statement is sent to the database
		 * server.
		 *
		 * If the records that are retrieved should be ordered by one or more
		 * columns, the generated string of column / sort direction pairs
		 * replaces the ":order" placeholder. In case no ordering is required,
		 * the complete ORDER BY part including the "\/*-orderby*\/...\/*orderby-*\/"
		 * markers is removed to speed up retrieving the records. Columns of
		 * sub-managers can also be used for ordering the result set but then
		 * no index can be used.
		 *
		 * The number of returned records can be limited and can start at any
		 * number between the begining and the end of the result set. For that
		 * the ":size" and ":start" placeholders are replaced by the
		 * corresponding values from the criteria object. The default values
		 * are 0 for the start and 100 for the size value.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for searching items
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/customer/manager/address/insert/ansi
		 * @see mshop/customer/manager/address/update/ansi
		 * @see mshop/customer/manager/address/newid/ansi
		 * @see mshop/customer/manager/address/delete/ansi
		 * @see mshop/customer/manager/address/count/ansi
		 */

		/** mshop/customer/manager/address/count/mysql
		 * Counts the number of records matched by the given criteria in the database
		 *
		 * @see mshop/customer/manager/address/count/ansi
		 */

		/** mshop/customer/manager/address/count/ansi
		 * Counts the number of records matched by the given criteria in the database
		 *
		 * Counts all records matched by the given criteria from the customer
		 * database. The records must be from one of the sites that are
		 * configured via the context item. If the current site is part of
		 * a tree of sites, the statement can count all records from the
		 * current site and the complete sub-tree of sites.
		 *
		 * As the records can normally be limited by criteria from sub-managers,
		 * their tables must be joined in the SQL context. This is done by
		 * using the "internaldeps" property from the definition of the ID
		 * column of the sub-managers. These internal dependencies specify
		 * the JOIN between the tables and the used columns for joining. The
		 * ":joins" placeholder is then replaced by the JOIN strings from
		 * the sub-managers.
		 *
		 * To limit the records matched, conditions can be added to the given
		 * criteria object. It can contain comparisons like column names that
		 * must match specific values which can be combined by AND, OR or NOT
		 * operators. The resulting string of SQL conditions replaces the
		 * ":cond" placeholder before the statement is sent to the database
		 * server.
		 *
		 * Both, the strings for ":joins" and for ":cond" are the same as for
		 * the "search" SQL statement.
		 *
		 * Contrary to the "search" statement, it doesn't return any records
		 * but instead the number of records that have been found. As counting
		 * thousands of records can be a long running task, the maximum number
		 * of counted records is limited for performance reasons.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for counting items
		 * @since 2014.03
		 * @category Developer
		 * @see mshop/customer/manager/address/insert/ansi
		 * @see mshop/customer/manager/address/update/ansi
		 * @see mshop/customer/manager/address/newid/ansi
		 * @see mshop/customer/manager/address/delete/ansi
		 * @see mshop/customer/manager/address/search/ansi
		 */

		return 'mshop/customer/manager/address/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig() : array
	{
		return $this->searchConfig;
	}
}
