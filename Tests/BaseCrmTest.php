<?php

namespace prgTW\BaseCRM\Tests;

use prgTW\BaseCRM\BaseCrm;
use prgTW\BaseCRM\Client\GuzzleClient;
use prgTW\BaseCRM\Service\Account;
use prgTW\BaseCRM\Service\Contacts;
use prgTW\BaseCRM\Service\Deals;
use prgTW\BaseCRM\Service\Leads;
use prgTW\BaseCRM\Service\Sources;
use prgTW\BaseCRM\Service\Tags;

class BaseCrmTest extends AbstractTest
{
	public function testSubResources()
	{
		$expectedSubResources = [
			'account'  => Account::class,
			'deals'    => Deals::class,
			'contacts' => Contacts::class,
			'sources'  => Sources::class,
			'leads'    => Leads::class,
			'tags'     => Tags::class,
		];
		$baseCrm              = new BaseCrm('', \Mockery::mock(GuzzleClient::class));
		$subResources         = $baseCrm->getSubResources();
		$this->assertEquals(array_keys($expectedSubResources), array_keys($subResources));
		foreach ($expectedSubResources as $resouceName => $resourceClass)
		{
			$this->assertInstanceOf($resourceClass, $subResources[$resouceName]);
		}
	}
}
