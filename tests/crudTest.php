<?php

namespace App\Tests\Tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ListeApiTest extends WebTestCase
{
    private $client;
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }
    public function testAll(): void
    {
        $client = $this->client; 
        $crawler = $client->request('GET', '/elec');

        $this->assertResponseIsSuccessful();

    }

    


    public function testOne(): void
    {
        $client = $this->client; 
        $crawler = $client->request('GET', '/elec/653b7639530acaa3d4581d2a');

        $this->assertResponseIsSuccessful();
    }
    public function testOneFilter(): void{
        $client = $this->client; 
        $crawler = $client->request('GET', '/elecgaz/code_epci/653b7639530acaa3d4581d2a');

        $this->assertResponseIsSuccessful();
    }
    
    public function testOneDelete(): void{
        $client = $this->client; 
        $crawler = $client->request('DELETE', '/elec/653b7639530acaa3d4581d27');

        $this->assertResponseIsSuccessful();
    }
}