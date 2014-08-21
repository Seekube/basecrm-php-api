<?php

namespace prgTW\BaseCRM\Tests\Service;

use prgTW\BaseCRM\BaseCrm;
use prgTW\BaseCRM\Client\GuzzleClient;
use prgTW\BaseCRM\Resource\Resource;
use prgTW\BaseCRM\Service\Lead;
use prgTW\BaseCRM\Tests\AbstractTest;

class LeadsTest extends AbstractTest
{
	public function testGet()
	{
		$client = \Mockery::mock(GuzzleClient::class);
		$client
			->shouldReceive('request')
			->once()
			->with('GET', sprintf('%s/%s/leads.json', Resource::ENDPOINT_LEADS, Resource::PREFIX), $this->getQuery([
				'query' => [
					'page' => 1
				]
			]))
			->andReturn($this->getResponse(200, '
				{
					"success": true,
					"metadata": {
						"count": 2
					},
					"items": [
						{
							"success": true,
							"lead": {
								"id": 1,
								"user_id": 2,
								"account_id": 3,
								"owner_id": 2,
								"first_name": "Lead",
								"last_name": "One",
								"company_name": null,
								"created_at": "2013-04-10T15:04:24+00:00",
								"state": null,
								"display_name": "Lead One",
								"conversion_name": "Lead One",
								"added_on": "2013-04-10T15:04:24+00:00"
							},
							"metadata": {
							}
						},
						{
							"success": true,
							"lead": {
								"id": 2,
								"user_id": 2,
								"account_id": 3,
								"owner_id": 2,
								"first_name": "Lead",
								"last_name": "Two",
								"company_name": null,
								"created_at": "2013-04-10T15:04:00+00:00",
								"state": null,
								"display_name": "Lead Two",
								"conversion_name": "Lead Two",
								"added_on": "2013-04-10T15:04:00+00:00"
							},
							"metadata": {
							}
						}
					]
				}
			'));
		$client
			->shouldReceive('request')
			->once()
			->with('GET', sprintf('%s/%s/leads.json', Resource::ENDPOINT_LEADS, Resource::PREFIX), $this->getQuery([
				'query' => [
					'page' => 2
				]
			]))
			->andReturn($this->getResponse(200, '
				{
					"success": true,
					"metadata": {
						"count": 0
					},
					"items": [
					]
				}
			'));

		$baseCrm = new BaseCrm('', $client);
		$leads   = $baseCrm->getLeads();
		$i       = 1;
		/** @var Lead $lead */
		foreach ($leads as $lead)
		{
			$this->assertInstanceOf(Lead::class, $lead);
			$this->assertEquals($i, $lead->getId());
			++$i;
		}
	}
}
