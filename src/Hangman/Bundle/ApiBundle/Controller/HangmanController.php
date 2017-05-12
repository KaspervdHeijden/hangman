<?php

namespace Hangman\Bundle\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Hangman\Bundle\ApiBundle\Entity\Game;

/**
 * The HangmanController class. All Hangman logic is contained here.
 */
class HangmanController extends Controller
{
	/**
	 * Generates a success response.
	 * 
	 * @param Game $game
	 * @return JsonResponse
	 */
	private function generateResponse(Game $game, string $message) : JsonResponse
	{
		return new JsonResponse([
			'tries_left' => $game->getTriesLeft(),
			'word' => $game->getWordObvuscated(),
			'status' => $game->getStatus(),
			'message' => $message
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
	
	/**
	 * Get PUT variables.
	 * 
	 * @param Request $request
	 * @return array
	 */
	private function getPutVars(Request $request) : array
	{
		/* Force the x-www-form-urlencoded content-type
		$contentType = $request->headers->get('Content-Type');
		if (empty($contentType) || strcasecmp($contentType, 'application/x-www-form-urlencoded') === 0) {
			return array();
		} //*/
		
		$content = $request->getContent();
		parse_str($content, $putData);
		return $putData;
	}
	
	/**
	 * Controller to create a new game.
	 * 
	 * @return JsonResponse
	 */
	public function gameStartAction()
	{
		$doctrine = $this->getDoctrine();
		
		// We need to pick a random word
		$random_word = $doctrine
					->getRepository('HangmanApiBundle:Word')
					->findRandomWord();
		
		if (empty($random_word)) {
			return $this->generateResponseError('No random words available!', 404); // 404 because a random word cannot be found.
		}
		
		$game = new Game();
		$game->setWord($random_word);
		$game->setStatus(Game::STATUS_BUSY);
		
		$manager = $doctrine->getManager();
		$manager->persist($game);
		$manager->flush();
		
		return $this->generateResponse($game, 'Game started. Good luck!');
	}
	
	/**
	 * Controller to guess a character for a given game.
	 * 
	 * @param int $id
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function gameGuessAction($id, Request $request)
	{
		$game = $this->getDoctrine()
					->getRepository('HangmanApiBundle:Game')
					->find($id);
		
		if (!$game) {
			return $this->generateResponseError('Requested game cannot be found!', 404); // Returns a 404 Not Found.
		}
		
		if ($game->getStatus() !== Game::STATUS_BUSY) {
			return $this->generateResponseError('Requested is over.', 400); // Returns a 400 Bad Request.
		}
		
		$putData = $this->getPutVars($request);
		if (!isset($putData['char']) || empty($putData['char'])) {
			return $this->generateResponseError('Please guess a character.', 400); // Returns a 400 Bad Request.
		}
		
		$char = $putData['char'];
		if (strlen($char) !== 1) {
			return $this->generateResponseError('Please only guess one character.', 400); // Returns a 400 Bad Request.
		}
		
		$message = $this->get('app.game_engine')
						->guessCharacter($game, $char);
		
		return $this->generateResponse($game, $message);
	}
}