<?php

namespace Rth\MotorbikeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminControllerTest extends WebTestCase
{
    public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/motorbike');
        $this->assertTrue($crawler->filter('html:contains("list")')->count() > 0);
    }
    
    public function testNew()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/motorbike/new');
        $this->assertTrue($crawler->filter('html:contains("model")')->count() > 0);
    }
}
