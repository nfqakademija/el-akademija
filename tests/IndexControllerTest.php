<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
	public function testSchedule()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/schedule');

		$this->assertSame(200, $client->getResponse()->getStatusCode());
		$this->assertSame(1, $crawler->filter('.card > .card-header:contains("Kalendorius")')->count());
	}
}
