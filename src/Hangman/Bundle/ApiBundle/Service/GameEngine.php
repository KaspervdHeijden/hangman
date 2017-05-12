<?php

namespace Hangman\Bundle\ApiBundle\Service;

use Hangman\Bundle\ApiBundle\Entity\Game;
use Doctrine\ORM\EntityManager;

/**
 * GameEngine class.
 *
 * @author KasH.
 */
class GameEngine
{
	/**
     * @var EntityManager 
     */
	private $em;
	
	public function __construct(EntityManager $entityManager)
	{
		$this->em = $entityManager;
	}
	
	private function saveGameStatus(Game $game, string $status)
	{
		$this->em->persist($game);
		$this->em->flush();
	}
	
	public function guessCharacter(Game $game, string $char) : bool
	{
		if ($game->getStatus() !== Game::STATUS_BUSY) {
			return false;
		}
		
		// Defensive
		if ($game->getTriesLeft() === 0) {
			$game->saveGameStatus($game, Game::STATUS_FAIL);
			return false;
		}
		
		$word = $game->getWord(); 
		if (strpos($word, $char) === false) {
			// Decrement tries. If 0, set status to 'Over'.
			
			$game->addGuessedCharacter($char);
			$game->decrementTriesLeft();
			
			if ($game->getTriesLeft() === 0) {
				$game->saveGameStatus($game, Game::STATUS_FAIL);
			}
			
			return false;
		} else {
			if ($word === $game->getScrambledWord()) {
				$game->saveGameStatus($game, Game::STATUS_SUCCESS);
			}
			
			return true;
		}
	}
}