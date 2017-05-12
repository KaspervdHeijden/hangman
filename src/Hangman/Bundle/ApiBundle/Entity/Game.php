<?php

namespace Hangman\Bundle\ApiBundle\Entity;

//use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Game class.
 *
 * @author KasH.
 * @ORM\Entity
 */
class Game
{
	const REPLACE_CHAR = '.';
	
	/**
	 * Maximum number of tries.
	 */
	const MAX_TRIES = 10;
	
	/**
	 * Game Stati.
	 */
	const STATUS_SUCCESS = 'success';
	const STATUS_BUSY = 'busy';
	const STATUS_FAIL = 'fail';
	
	/**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
	 *
	 * @var int
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
	 * @ORM\Column(name="characters_guessed", type="text")
	 */
	private $characters_guessed = '';
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="status", length=255)
	 */
	private $status = self::STATUS_BUSY;
	
    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }
	
	/**
	 * Gets tries left
	 * 
	 * @return int
	 */
	public function getTriesLeft() : int
	{
		return $this->triesLeft;
	}
	
	/**
	 * Decrement the tries left.
	 * 
	 * @return Game
	 */
	public function decrementTriesLeft() : Game
	{
		--$this->triesLeft;
		return $this;
	}
	
	/**
	 * Get word
	 * 
	 * @return string
	 */
	public function getWord() : string
	{
		return $this->word;
	}
	
	/**
	 * Set the word
	 * 
	 * @param string $word
	 * @return Game
	 */
	public function setWord(string $word) : Game
	{
		$this->word = $word;
		return $this;
	}
	
	/**
	 * Get the guessed characters.
	 * 
	 * @return array
	 */
	public function getGuessedCharacters() : array
	{
		return json_decode($this->characters_guessed);
	}
	
	/**
	 * Add A character to the guessed characters list.
	 * 
	 * @param string $character
	 * @return \Hangman\Bundle\ApiBundle\Entity\Game
	 */
	public function addGuessedCharacter(string $character) : Game
	{
		$characters = $this->getGuessedCharacters();
		if (!in_array($character, $characters)) {
			$characters[] = $character;
		}
		
		$this->characters_guessed = json_encode($characters);
		return $this;
	}
	
	/**
	 * Get status
	 * 
	 * @return string
	 */
	public function getStatus() : string
	{
		return $this->status;
	}
	
	/**
	 * Set status
	 * 
	 * @param string $status
	 * @return \Hangman\Bundle\ApiBundle\Entity\Game
	 */
	public function setStatus(string $status) : Game
	{
		$this->status = $status;
		return $this;
	}
	
	/**
	 * Gets the version of the word with all non guessed characters replaced with dots.
	 * 
	 * @return string
	 */
	public function getScrambledWord() : string
	{
		return str_replace($this->getGuessedCharacters(), self::REPLACE_CHAR, $this->getWord());
	}
}