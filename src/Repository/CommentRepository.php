<?php

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Comment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comment[]    findAll()
 * @method Comment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Comment::class);
	}

	/**
	 * @param Question $question
	 * @param mixed ...$args
	 * @return Comment[]
	 */
	public function findByQuestion(Question $question, ...$args)
	{
		return $this->findBy(
			['question' => $question],
			...$args
		);
	}
}
