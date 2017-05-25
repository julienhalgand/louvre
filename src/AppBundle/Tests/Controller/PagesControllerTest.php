<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagesControllerTest extends WebTestCase
{
    public function testValidatestep1()
    {
        $this->tearDown();
        $client = static::createClient();

        $crawler = $client->request('GET', '/validateStep1');
    }

    public function testValidatestep2()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/validateStep2');
    }

    public function testValidatestep3()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/validateStep3');
    }

}
