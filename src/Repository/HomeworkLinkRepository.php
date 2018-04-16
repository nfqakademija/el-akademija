<?php

namespace App\Repository;

use App\Entity\HomeworkLink;
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
}
