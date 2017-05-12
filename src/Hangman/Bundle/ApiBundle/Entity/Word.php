<?php

namespace Hangman\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Word entity class.
 * 
 * @ORM\Entity(repositoryClass="Hangman\Bundle\ApiBundle\Repository\WordRepository")
 */
class Word
{
	/**
     * @var int
     * 
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
	
	/**
	 * @var string
	 * 
	 * @ORM\Column(name="word", type="string", length=255)
	 */
	private $word;
	
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
	 * @return Word
	 */
	public function setWord(string $word) : Word
	{
		$this->word = $word;
		return $this;
	}
}