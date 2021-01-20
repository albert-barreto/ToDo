<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TodoControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/todo');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'My To do List');
    }
}
