<?php

namespace Hangman\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Game entity class.
 * 
 * @ORM\Entity
 */
class Game
{
	/**
	 * Any character which is not yet guessed is replaced by this character (typically a dot). 
	 */
	/*public*/ const REPLACE_CHAR = '.';
	
	/**
	 * Maximum number of tries before you hang :).
	 */
	/*public*/ const MAX_TRIES = 11;
	
	/**
	 * Game stati: busy/fail/success.
	 */
	/*public*/ const STATUS_SUCCESS = 'success';
	/*public*/ const STATUS_BUSY = 'busy';
	/*public*/ const STATUS_FAIL = 'fail';
	
	/**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
	 * @var int
	 * 
	 * @ORM\Column(name="tries_left", type="integer")
	 */
	private $triesLeft = self::MAX_TRIES;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="word", type="string", length=255)
	 */
	private $word;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="characters_guessed", type="json_array")
	 */
	private $characters_guessed = array();
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="status", length=255)
	 */
	private $status = self::STATUS_BUSY;
	
    /**
     * Get the id.
     * 
     * @return int
     */
    public function getId() // : int
    {
        return $this->id;
    }
	
	/**
	 * Gets the number of tries left.
	 * 
	 * @return int
	 */
	public function getTriesLeft() // : int
	{
		return $this->triesLeft;
	}
	
	/**
	 * Decrement the number of tries left.
	 * 
	 * @return Game
	 */
	public function decrementTriesLeft() // : Game
	{
		--$this->triesLeft;
		return $this;
	}
	
	/**
	 * Get the word.
	 * 
	 * @return string
	 */
	public function getWord() // : string
	{
		return $this->word;
	}
	
	/**
	 * Set the word.
	 * 
	 * @param string $word
	 * @return Game
	 */
	public function setWord(/*string*/ $word) // : Game
	{
		$this->word = $word;
		return $this;
	}
	
	/**
	 * Get the guessed characters.
	 * 
	 * @return array
	 */
	public function getCharacters_guessed() // : array
	{
		return $this->characters_guessed;
	}
	
	/**
	 * Adds a character to the guessed characters list.
	 * 
	 * @param string $character
	 * @return \Hangman\Bundle\ApiBundle\Entity\Game
	 */
	public function addGuessedCharacter(/*string*/ $character) // : Game
	{
		if (!$this->isCharacterAlreadyGuessed($character)) {
			$this->characters_guessed[] = $character;
		}
		
		return $this;
	}
	
	/**
	 * Get the game status (busy/fail/succes)
	 * 
	 * @see Game::STATUS_BUSY
	 * @see Game::STATUS_FAIL
	 * @see Game::STATUS_SUCCESS
	 * @return string
	 */
	public function getStatus() // : string
	{
		return $this->status;
	}
	
	/**
	 * Sets the game status.
	 * 
	 * @param string $status
	 * @return \Hangman\Bundle\ApiBundle\Entity\Game
	 */
	public function setStatus(/*string*/ $status) // : Game
	{
		$this->status = $status;
		return $this;
	}
	
	/**
	 * Determines if a character was already guessed.
	 * 
	 * @param string $character
	 * @return bool
	 */
	public function isCharacterAlreadyGuessed(/*string*/ $character) // : bool
	{
		return in_array($character, $this->getCharacters_guessed());
	}
	
	/**
	 * Gets the version of the word with all non-guessed characters obvuscated.
	 * 
	 * @see Game::REPLACE_CHAR
	 * @return string
	 */
	public function getWordObvuscated() // : string
	{
		$characters_guessed = $this->getCharacters_guessed();
		$word = $this->getWord();
		$len = strlen($word);
		$result = '';
		
		for ($i = 0; $i < $len; ++$i) {
			$char = $word[$i];
			
			if (in_array($char, $characters_guessed)) {
				$result .= $char;
			} else {
				$result .= self::REPLACE_CHAR;
			}
		}
		
		return $result;
	}
}