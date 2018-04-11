<?php

namespace App\Repository;

use App\Entity\Course;
use App\Entity\Homework;
use App\Model\QueryArgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Homework|null find($id, $lockMode = null, $lockVersion = null)
 * @method Homework|null findOneBy(array $criteria, array $orderBy = null)
 * @method Homework[]    findAll()
 * @method Homework[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeworkRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Homework::class);
	}

	/**
	 * @param Course $course
	 * @param QueryArgs $args
	 * @return Homework[]
	 */
	public function findByCourse(Course $course, QueryArgs $args)
	{
		return $this->createQueryBuilder('h')
			->leftJoin('h.lecture', 'l')
			->leftJoin('l.course', 'c')
			->where('c.id = :course')
			->orderBy('h.' . $args->getOrderBy(), $args->getOrder())
			->setMaxResults($args->getLimit())
			->setFirstResult($args->getOffset())
			->setParameter('course', $course)
			->getQuery()
			->execute();
	}
}
