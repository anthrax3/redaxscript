<?php
namespace Redaxscript\Tests;

use Redaxscript\Cache;
use org\bovigo\vfs\vfsStream as Stream;

/**
 * CacheTest
 *
 * @since 3.0.0
 *
 * @package Redaxscript
 * @category Tests
 * @author Henry Ruhs
 */

class CacheTest extends TestCaseAbstract
{
	/**
	 * setUp
	 *
	 * @since 3.0.0
	 */

	public function setUp()
	{
		Stream::setup('root', 0777);
	}

	/**
	 * providerStore
	 *
	 * @since 3.0.0
	 *
	 * @return array
	 */

	public function providerStore()
	{
		return $this->getProvider('tests/provider/cache_store.json');
	}

	/**
	 * testStore
	 *
	 * @since 3.0.0
	 *
	 * @param array $bundleArray
	 * @param array $expectArray
	 *
	 * @dataProvider providerStore
	 */

	public function testStore($bundleArray = [], $expectArray = [])
	{
		/* setup */

		$cache = new Cache();
		$cache->init(Stream::url('root'));
		foreach ($bundleArray as $key => $value)
		{
			$cache->store($value, $key);
		}

		/* actual */

		$actualArray = scandir(Stream::url('root'));

		/* compare */

		$this->assertEquals($actualArray, $expectArray);
	}

	/**
	 * testRetrieve
	 *
	 * @since 3.0.0
	 */

	public function testRetrieve()
	{
		/* setup */

		$cache = new Cache();
		$cache->init(Stream::url('root'));
		$cache->store('test', 'test');

		/* actual */

		$actual = $cache->retrieve('test');

		/* compare */

		$this->assertEquals($actual, 'test');
	}

	/**
	 * testValidate
	 *
	 * @since 3.0.0
	 */

	public function testValidate()
	{
		/* setup */

		$cache = new Cache();
		$cache->init(Stream::url('root'));
		$cache->store('test1', 'test');
		$cache->store('test2', 'test');
		touch($cache->getPath('test2'), time() - 3600);

		/* compare */

		$this->assertTrue($cache->validate('test1'));
		$this->assertFalse($cache->validate('test2'));
		$this->assertFalse($cache->validate('invalid'));
	}
}
