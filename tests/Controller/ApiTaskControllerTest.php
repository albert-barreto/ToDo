<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTaskControllerTest extends WebTestCase
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

//    public function testCreate(): void
//    {
//        $client = static::createClient();
//
//        $client->request('POST', '/tasks/', ['title' => 'test']);
//
//        $this->assertEquals(201, $client->getResponse()->getStatusCode());
//    }

    public function testCreateBadRequestError(): void
    {
        $client = static::createClient();

        $client->request('POST', '/tasks/');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

//    public function testUpdate(): void
//    {
//        $client = static::createClient();
//        $client->request('PUT', '/tasks/1', ['title' => 'test', 'status' => false]);
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//    }

    public function testUpdateBadRequestError(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/tasks/1');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}
