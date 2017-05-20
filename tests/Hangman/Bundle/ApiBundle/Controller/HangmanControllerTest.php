<?php

namespace Tests\Hangman\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Hangman\Bundle\ApiBundle\Entity\Game;

/**
 * HangmanControllerTest class.
 *
 * @author KasH.
 */
class HangmanControllerTest extends WebTestCase
{
    
    protected static function createKernel(array $options = array())
    {
       // $_SERVER['KERNEL_DIR'] = '../../../../../app';
        return parent::createKernel($options);
    }
    
    public function testHangmanGame()
    {
        $client = static::createClient();
        
        $client->request('POST', '/games');
        $response = $client->getResponse();
        
        $this->assertTrue($response->isSuccessful());
        $data = json_decode($response->getContent(), true);
        
        $game_id = $data['game_id'];
        $int_a = ord('a');
        $int_z = ord('z');
        
        while ($data['status'] === Game::STATUS_BUSY) {
            $client->request('PUT', "/game/$game_id", [], [], [], 'char=' . chr(random_int($int_a, $int_z)));
            $response = $client->getResponse();
            
            $this->assertTrue($response->isSuccessful());
            $data = json_decode($response->getContent(), true);
        }
    }
}