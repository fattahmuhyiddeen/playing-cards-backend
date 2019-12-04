<?php
namespace App\Test\TestCase\Controller;

use App\Controller\PagesController;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Http\ServerRequest;
use Cake\TestSuite\IntegrationTestCase;
use Cake\View\Exception\MissingTemplateException;

class CardsControllerTest extends IntegrationTestCase
{
    public function testPositiveInteger()
    {
        $this->get('/deal?number=9');
        $this->assertResponseOk();
        $this->assertEquals(9, count(json_decode($this->_response->getBody())));
    }

    public function testNegativeInteger()
    {
        $this->get('/deal?number=-3');
        $this->assertResponseCode(400);
        $this->assertEquals('Input value does not exist or value is invalid', json_decode($this->_response->getBody())->error);
    }

    public function testNoParameter()
    {
        $this->get('/deal');
        $this->assertResponseCode(400);
        $this->assertEquals('Input value does not exist or value is invalid', json_decode($this->_response->getBody())->error);
    }

    public function testMoreThan53()
    {
        $this->get('/deal?number=60');
        $this->assertResponseOk();
        $this->assertEquals(60, count(json_decode($this->_response->getBody())));
    }
}