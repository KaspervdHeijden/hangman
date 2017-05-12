<?php

namespace Hangman\Bundle\ApiBundle\Controller;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Hangman\Bundle\ApiBundle\Entity\Game;

/**
 * HangManRESTController class.
 *
 * @author KasH.
 */
class HangmanController extends Controller
{
	/**
	 * Generates a success response.
	 * 
	 * @param Game $game
	 * @return JsonResponse
	 */
	private function generatereResponse(Game $game) : JsonResponse
	{
		return new JsonResponse([
			'tries_left' => $game->getTriesLeft(),
			'word' => $game->getScrambledWord(),
			'status' => $game->getStatus(),
		]);
	}
	
	/**
	 * Generates a failure response.
	 * 
	 * @param string $message
	 * @return JsonResponse
	 */
	private function generateResponseError(string $message, int $status) : JsonResponse
	{
		return new JsonResponse(['message' => $message], $status);
	}
	
	public function gameStartAction()
	{
		$doctrine = $this->getDoctrine();
		
		// We need to pick a random word
		$random_word = $doctrine->getRepository('HangmanApiBundle:Word')->findRandomWord();
		if (empty($random_word)) {
			return $this->generateResponseError('No random words available!', 404); // 404 because a random word cannot be found.
		}
		
		// Initialize and save the Game
		$game = new Game();
		$game->setWord($random_word);
		$game->setStatus(Game::STATUS_INITIALIZED);
		
		$manager = $doctrine->getManager();
		$manager->persist($game);
		$manager->flush();
		
		return $this->generatereResponse($game);
	}
	
	public function gameGuessAction($id, Request $request)
	{
		$game = $this->getDoctrine()
					->getRepository('HangmanApiBundle:Game')
					->find($id);
		
		if (!$game) {
			return $this->generateResponseError('Requested game cannot be found!', 404);
		}
		
		$char = $request->get('char');
		if (empty($char)) {
			return $this->generateResponseError('Please guess a character.', 400);
			
		}
		
		if (strlen($char) !== 1) {
			return $this->generateResponseError('Please only guess one character.', 400);
		}
		
		$result = $this->get('app.game_engine')
						->guessCharacter($game, $char);
		
		$em = $this->getDoctrine()
					->getManager();
		
		$em->persist($game);
		$em->flush();
		
		return $this->generatereResponse($game);
	}
}