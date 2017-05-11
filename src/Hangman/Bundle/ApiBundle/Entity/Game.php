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
	/**
	 * Maximum number of tries.
	 */
	const MAX_TRIES = 10;
	
	/**
	 * Game Stati. Unused for now.
	 */
	const STATUS_INITIALIZED = 'Initialized';
	const STATUS_PLAYING = 'Playing';
	const STATUS_OVER = 'Over';
	
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
	private $status = '';
	
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
	 * Sets name
	 * 
	 * @param int $triesLeft
	 * @return Game
	 */
	public function setTriesLeft(int $triesLeft) : Game
	{
		$this->triesLeft = $triesLeft;
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
	 * Get the guessed words
	 * 
	 * @return string
	 */
	public function getCharacters_guessed() : string
	{
		return $this->characters_guessed;
	}
	
	/**
	 * Set the guessed words
	 * 
	 * @param string $characters_guessed
	 * @return Game
	 */
	public function setCharacters_guessed(string $characters_guessed) : Game
	{
		$this->characters_guessed = $characters_guessed;
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
}