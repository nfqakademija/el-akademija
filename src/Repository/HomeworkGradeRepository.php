<?php

namespace App\Repository;

use App\Entity\HomeworkGrade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HomeworkGrade|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeworkGrade|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeworkGrade[]    findAll()
 * @method HomeworkGrade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeworkGradeRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, HomeworkGrade::class);
	}
}
