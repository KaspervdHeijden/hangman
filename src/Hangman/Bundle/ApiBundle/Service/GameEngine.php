<?php

namespace Hangman\Bundle\ApiBundle\Service;

use Hangman\Bundle\ApiBundle\Model\GuessResult;
use Hangman\Bundle\ApiBundle\Entity\Game;

/**
 * GameEngine service.
 *
 * @author KasH.
 */
class GameEngine
{
    /**
     * Guesses a character for a given game, and modifies the game state accordingly.
     * 
     * @param Game $game
     * @param string $char
     * @return GuessResult Results of this guess.
     */
    public function guessCharacter(Game $game, string $char) : GuessResult
    {
        if ($game->getStatus() !== Game::STATUS_BUSY) {
            return new GuessResult('Game over.', false);
        }
        
        //* Defensive; shouldn't need to do this.
        if ($game->getTriesLeft() === 0) {
            $game->setStatus(Game::STATUS_FAIL);
            return new GuessResult('Game over.', true);
        } //*/
        
        // Don't do anything when the character was already guessed.
        if ($game->isCharacterAlreadyGuessed($char)) {
            return new GuessResult("Character '$char' already guessed.", false);
        }
        
        $word = $game->getWord();
        if (strpos($word, $char) === false) {
            // Decrement tries. If 0, set status to 'fail'.
            
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
        
        return new GuessResult($message, true);
    }
}