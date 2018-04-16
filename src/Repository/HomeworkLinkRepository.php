<?php

namespace App\Repository;

use App\Entity\Homework;
use App\Entity\HomeworkLink;
use App\Model\QueryArgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HomeworkLink|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeworkLink|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeworkLink[]    findAll()
 * @method HomeworkLink[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeworkLinkRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, HomeworkLink::class);
	}

	/**
	 * @param Homework $homework
	 * @param QueryArgs $args
	 * @return HomeworkLink[]
	 */
	public function findByHomework(Homework $homework, QueryArgs $args)
	{
		return $this->createQueryBuilder('hl')
			->leftJoin('hl.homework', 'h')
			->where('h.id = :homework')
			->orderBy('hl.' . $args->getOrderBy(), $args->getOrder())
			->setMaxResults($args->getLimit())
			->setFirstResult($args->getOffset())
			->setParameter('homework', $homework)
			->getQuery()
			->execute();
	}
}
