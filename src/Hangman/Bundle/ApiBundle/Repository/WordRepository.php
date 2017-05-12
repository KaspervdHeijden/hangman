<?php

namespace Hangman\Bundle\ApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * WordRepository class. Extends the default doctrine entity repository.
 * 
 * @author KasH.
 */
class WordRepository extends EntityRepository
{
	/**
     * Get a random word.
     * 
     * @return string
     */
	public function findRandomWord()
	{
		$num_words = $this->createQueryBuilder('w')
             ->select('COUNT(w)')
             ->getQuery()
             ->getSingleScalarResult();
		
		$words = $this->createQueryBuilder('w')
				->select('w.word')
				->setFirstResult(rand(0, $num_words - 1))
				->setMaxResults(1)
				->getQuery()
				->getResult();
		
		return (empty($words)) ? '' : $words[0]['word'];
	}
}