<?php

namespace App\Repository;

use App\Entity\Course;
use App\Model\QueryArgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Course|null find($id, $lockMode = null, $lockVersion = null)
 * @method Course|null findOneBy(array $criteria, array $orderBy = null)
 * @method Course[]    findAll()
 * @method Course[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CourseRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Course::class);
	}

	/**
	 * @param QueryArgs $args
	 * @return Course[]
	 */
	public function findByFilter(QueryArgs $args)
	{
		$query = $this->createQueryBuilder('c');
		$filter = $args->getFilter();
		if ($filter && isset($filter['notEnded']))
			$query->where('c.end > CURRENT_TIMESTAMP()');
		return $query
			->orderBy('c.' . $args->getOrderBy(), $args->getOrder())
			->setMaxResults($args->getLimit())
			->setFirstResult($args->getOffset())
			->getQuery()
			->execute();
	}
}
