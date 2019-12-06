<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CardsController extends AppController
{

    /**
     * Deal cards to n players
     *
     * query parameter `number` accept non-negative integer
     * @return \Cake\Http\Response|null
     */
    public function deal(){
        $this->response->header('Access-Control-Allow-Origin', '*');
        
        $number_of_players = $this->request->getQuery('number');

        // return 400 when parameter number is not defined, or not a number or negative number
        if(!is_numeric($number_of_players) || (int)$number_of_players < 0){
            $this->response->statusCode(400);
            $this->set([
                'my_response' => ['error'=>'Input value does not exist or value is invalid'],
                '_serialize' => 'my_response',
            ]);
            $this->RequestHandler->renderAs($this, 'json');
            return;
        }

        // define all cards
        $data = [
            ['A', 'D'], ['2', 'D'], ['3', 'D'], ['4', 'D'], ['5', 'D'], ['6', 'D'], ['7', 'D'], ['8', 'D'], ['9', 'D'], ['X', 'D'], ['J', 'D'], ['Q', 'D'], ['K', 'D'],
            ['A', 'H'], ['2', 'H'], ['3', 'H'], ['4', 'H'], ['5', 'H'], ['6', 'H'], ['7', 'H'], ['8', 'H'], ['9', 'H'], ['X', 'H'], ['J', 'H'], ['Q', 'H'], ['K', 'H'],
            ['A', 'S'], ['2', 'S'], ['3', 'S'], ['4', 'S'], ['5', 'S'], ['6', 'S'], ['7', 'S'], ['8', 'S'], ['9', 'S'], ['X', 'S'], ['J', 'S'], ['Q', 'S'], ['K', 'S'],
            ['A', 'C'], ['2', 'C'], ['3', 'C'], ['4', 'C'], ['5', 'C'], ['6', 'C'], ['7', 'C'], ['8', 'C'], ['9', 'C'], ['X', 'C'], ['J', 'C'], ['Q', 'C'], ['K', 'C'],
        ];

        // shuffle arrangement of the cards
        shuffle($data);
        $number_of_players = (int)$number_of_players;
        $response = [];

        // if number is more than 0, then distribute to all players
        if($number_of_players > 0){
            for($i=0; $i < $number_of_players; $i++){
                $response[$i] = [];
            }

            for($i=0; $i < count($data);$i++){
                array_push($response[$i % $number_of_players], $data[$i]);
            }
        }

        $this->set([
            'my_response' => $response,
            '_serialize' => 'my_response',
        ]);

        $this->RequestHandler->renderAs($this, 'json');
    }
}
