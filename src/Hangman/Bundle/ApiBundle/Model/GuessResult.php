<?php

namespace Hangman\Bundle\ApiBundle\Model;

/**
 * GuessResult class. Holds information about a guess.
 *
 * @author KasH.
 */
class GuessResult
{
    /**
     * @var string
     */
    private $message;
    
    /**
     * @var bool
     */
    private $saveRequired;
    
    /**
     * @param string $message A descriptive message as feedback for a guess.
     * @param bool $saveRequired A boolean indicating if the game needs to be saved.
     */
    public function __construct(string $message, bool $saveRequired)
    {
        $this->saveRequired = $saveRequired;
        $this->message = $message;
    }
    
    /**
     * Gets a value indicating if a game needs to be saved.
     * 
     * @return bool TRUE if the game needs to be saved, FALSE otherwise.
     */
    public function isSaveRequired() : bool
    {
        return $this->saveRequired;
    }
    
    /**
     * Gets a response message about a guess.
     * 
     * @return string A descriptive message as feedback for a guess.
     */
    public function getMessage() : string
    {
        return $this->message;
    }
}