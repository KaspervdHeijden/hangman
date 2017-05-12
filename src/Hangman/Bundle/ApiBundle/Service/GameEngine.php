<?php

namespace Hangman\Bundle\ApiBundle\Service;

use Hangman\Bundle\ApiBundle\Entity\Game;
use Doctrine\ORM\EntityManager;

/**
 * GameEngine service class.
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
	
	/**
	 * Helper method to save a game.
	 * 
	 * @param Game $game
	 * @return void
	 */
	private function saveGame(Game $game) // : void
	{
		$this->em->persist($game);
		$this->em->flush();
	}
	
	/**
	 * Guesses a character for a given game.
	 * 
	 * @param Game $game
	 * @param string $char
	 * @return string A description about the guess and Game status.
	 */
	public function guessCharacter(Game $game, /*string*/ $char) // : string
	{
		if ($game->getStatus() !== Game::STATUS_BUSY) {
			return 'Game over.';
		}
		
		//* Defensive; shouldn't need to do this.
		if ($game->getTriesLeft() === 0) {
			$game->setStatus(Game::STATUS_FAIL);
			$this->saveGame($game);
			return 'Game over.';
		} //*/
		
		// Don't do anything when the character was already guessed. This behaviour was undefined in the assignment.
		if ($game->isCharacterAlreadyGuessed($char)) {
			return "Character '$char' already guessed.";
		}
		
		$word = $game->getWord();
		if (strpos($word, $char) === false) {
			// Decrement tries; if 0, set status to 'fail'.
			
			$message = "Character '$char' not found.";
			$game->addGuessedCharacter($char);
			$game->decrementTriesLeft();
			
			if ($game->getTriesLeft() === 0) {
				$game->setStatus(Game::STATUS_FAIL);
				$message .= ' Game over.';
			}
		} else {
			$message = "Character '$char' found.";
			$game->addGuessedCharacter($char);
			
			if ($word === $game->getWordObvuscated()) {
				$game->setStatus(Game::STATUS_SUCCESS);
				$message .= ' Win!';
			}
		}
		
		$this->saveGame($game);
		return $message;
	}
}