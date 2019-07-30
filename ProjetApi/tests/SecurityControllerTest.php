<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function teste()
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/api/partenaire',[],[],['Content-Type'=>'Application/json'],
    '{"nom":"warizou","ninea":"1250xc","registrecommerce":"45ads","adresse":"dakar","tel":"774521478","mail":"wari@gmail.com","numcompte":12400"}');
        $rep=$client->getResponse($crawler);
        var_dump($rep);
       
        $this->assertSame(201,$client->getResponse()->getStatuscode());
        $this->assertJsonStringEqualsJsonString($rep,$client->getContent());
    }
}
