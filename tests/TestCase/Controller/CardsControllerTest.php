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
        $result = $this->get('/deal?number=9');
        $this->assertResponseOk();
        echo $this->_response->getBody();
        $this->assertEquals(9, count(json_decode($this->_response->getBody())));
    }
}