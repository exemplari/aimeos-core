<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Index
 */


namespace Aimeos\MShop\Index\Manager\Text;


/**
 * MySQL based index text for searching in product tables.
 *
 * @package MShop
 * @subpackage Index
 */
class MySQL
	extends \Aimeos\MShop\Index\Manager\Text\Standard
{
	private $searchConfig = array(
		'index.text:relevance' => array(
			'code' => 'index.text:relevance()',
			'internalcode' => ':site AND mindte."langid" = $1 AND MATCH( mindte."content" ) AGAINST( $2 IN BOOLEAN MODE )',
			'label' => 'Product texts, parameter(<language ID>,<search term>)',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
			'public' => false,
		),
		'sort:index.text:relevance' => array(
			'code' => 'sort:index.text:relevance()',
			'internalcode' => 'MATCH( mindte."content" ) AGAINST( $2 IN BOOLEAN MODE )',
			'label' => 'Product text sorting, parameter(<language ID>,<search term>)',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
			'public' => false,
		),
	);


	/**
	 * Initializes the object
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$this->searchConfig['index.text:relevance']['function'] = function( $source, array $params ) {

			if( isset( $params[1] ) )
			{
				$str = '';
				$regex = '/(\&|\||\!|\-|\+|\>|\<|\(|\)|\~|\*|\:|\"|\'|\@|\\| )+/';
				$search = trim( mb_strtolower( preg_replace( $regex, ' ', $params[1] ) ), "' \t\n\r\0\x0B" );

				foreach( explode( ' ', $search ) as $part )
				{
					if( $part ) {
						$str .= $part . '* ';
					}
				}

				$params[1] = '\'' . $str . '"' . $search . '"\'';
			}

			return $params;
		};

		$name = 'index.text:relevance';
		$siteIds = $context->getLocale()->getSitePath();
		$expr = $siteIds ? $this->toExpression( 'mindte."siteid"', $siteIds ) : '1=1';
		$this->searchConfig[$name]['internalcode'] = str_replace( ':site', $expr, $this->searchConfig[$name]['internalcode'] );
	}


	/**
	 * Returns a list of objects describing the available criterias for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return \Aimeos\MW\Criteria\Attribute\Iface[] List of search attriubte items
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$list = parent::getSearchAttributes( $withsub );

		foreach( $this->searchConfig as $key => $fields ) {
			$list[$key] = new \Aimeos\MW\Criteria\Attribute\Standard( $fields );
		}

		return $list;
	}
}
