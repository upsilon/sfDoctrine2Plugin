<?php

use \Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
	public function getEditUser(\Doctrine\ORM\QueryBuilder $qb)
	{
		$qb->innerJoin('a.profile', 'p')
			 ->addSelect('p');

    return $qb;
	}
}