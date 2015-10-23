<?php

namespace Rth\MotorbikeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($crawler->filter('html:contains("welcome")')->count() > 0);
    }
    
    public function testShow()
    {
        
        $client = static::createClient();
        $crawler = $client->request('GET', '/motorbike/1/x/y');

        $this->assertTrue($crawler->filter('html:contains("model")')->count() > 0);
    }
}
