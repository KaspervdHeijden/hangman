<?php

namespace Hangman\Bundle\ApiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Wordrepository class.
 *
 * @author KasH.
 */
class WordRepository extends EntityRepository
{
	/**
     * Get random words
     *
     * @return array
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
		
		if (empty($words)) {
			return '';
		} else {
			return $words[0]['word'];
		}
	}
}