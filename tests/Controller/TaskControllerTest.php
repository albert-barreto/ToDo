<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShow(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tasks/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
