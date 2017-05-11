<?php

namespace Hangman\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Hangman\Bundle\ApiBundle\Entity\Game;

/**
 * HangManRESTController class.
 *
 * @author KasH.
 */
class HangmanRESTController extends Controller
{
	public function gameStartAction(Request $request)
	{
		$doctrine = $this->getDoctrine();
		
		// We need to pick a random word
		$random_word = $doctrine->getRepository('HangmanApiBundle:Word')->findRandomWord();
		if (empty($random_word)) {
			throw $this->createNotFoundException('No random words available!');
		}
		
		// Initialize and save the Game
		$game = new Game();
		$game->setWord($random_word);
		$game->setStatus(Game::STATUS_INITIALIZED);
		
		
		$manager = $doctrine->getManager();
		$manager->persist($game);
		$manager->flush();
		
		// Pass game id back to caller
		return new JsonResponse(['game_id' => $game->getID()]);
	}
}