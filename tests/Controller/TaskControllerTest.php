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

    public function testCreate(): void
    {
        $client = static::createClient();

        $client->request('POST', '/tasks/', ['title' => 'test']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUpdate(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/tasks/1', ['title' => 'test']);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
