<?php

namespace prgTW\BaseCRM\Tests\Resource;

use prgTW\BaseCRM\Resource\ResourceCollection;
use prgTW\BaseCRM\Service\Account;
use prgTW\BaseCRM\Service\Source;
use prgTW\BaseCRM\Transport\Transport;

class ResourceCollectionTest extends \PHPUnit_Framework_TestCase
{
	/** @var array|Resource[] */
	protected $resources;

	/** @var ResourceCollection */
	protected $collection;

	public function testGetItems()
	{
		$this->assertEquals($this->resources, $this->collection->getItems());
	}

	public function testArrayAccess()
	{
		$this->assertCount(3, $this->collection);

		foreach ([0, 1, 2] as $key)
		{
			$this->assertTrue(isset($this->collection[$key]));
			$this->assertInstanceOf(Account::class, $this->collection[$key]);
			$this->collection[$key] = new Source(\Mockery::mock(Transport::class), '');
			$this->assertInstanceOf(Source::class, $this->collection[$key]);
		}

		unset($this->collection[2]);
		unset($this->collection[1]);
		unset($this->collection[0]);

		$this->assertCount(0, $this->collection);
		$this->assertNull($this->collection->key());
	}

	public function testIterator()
	{
		foreach ($this->collection as $resource)
		{
			$this->assertInstanceOf(Account::class, $resource);
		}
	}

	protected function setUp()
	{
		$client           = \Mockery::mock(Transport::class);
		$this->resources  = [
			new Account($client, ''),
			new Account($client, ''),
			new Account($client, ''),
		];
		$this->collection = new ResourceCollection($this->resources);
	}
}
