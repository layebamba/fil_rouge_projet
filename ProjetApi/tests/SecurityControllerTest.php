<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    // public function teste()
    // {
    //     $client = static::createClient();
    //     $crawler = $client->request('POST','/api/partenaire',[],[],
    //     ['CONTENT-TYPE'=>"Application/json"],
    // '{"nom":"warima","ninea":"125kxc","registrecommerce":"45Mads","adresse":"pikine","tel":775521478,"mail":"wari@gmail.com","numcompte":12450}');
    //     $rep=$client->getResponse();
    //      var_dump($rep);
       
    //     $this->assertSame(201,$client->getResponse()->getStatusCode());
        
    // }
    // public function testtrans(){
    //     $client=static::createClient();
    //     $crawler=$client->request('POST','/api/transaction',[],[],
    //     ['CONTENT-TYPE'=>"Application/json"],'{
    //         "partenaire_id":1,"somme":1500000,"datetransaction":"2019-01-20"
    //     }');
    //     $rep=$client->getResponse();
    //     var_dump($rep);
    //     $this->assertSame(201,$client->getResponse()->getStatusCode());
    // }
    // public function testcompt(){
    //     $client=static::createClient();
    //     $scrawler=$client->request('GET','/api/compte',[],[],
    // ['CONTENT-TYPE'=>"Application/json"],'{
    //         "partenaire_id":2,"montant":25000000
    //     }');
    //     $rep=$client->getResponse();
    //     var_dump($rep);
    //     $this->assertSame(201,$client->getResponse()->getStatusCode());
    // }
    public function testuser()
    {
        $client=static::createClient();
        $crawler=$client->request('POST','/api/register',[],[],
        ['CONTENT-TYPE'=>"Application/json"],'{
            "username":"laye","password":"1234","nom":"ly",
            "prenom":"yaya","adresse":"pikine","tel":"778521420",
            "matricule":"RJ45","status":"actif","email":"lyya@gmail.com",
            "partenaire_id":2
        }');
        $rep=$client->getResponse();
        var_dump($rep);
        $this->assertSame(201,$client->getResponse()->getStatusCode());
    } 
}
