<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Question;
use App\Model\QueryArgs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
	public function __construct(RegistryInterface $registry)
	{
		parent::__construct($registry, Question::class);
	}

	/**
	 * @param Category $category
	 * @param mixed ...$args
	 * @return Question[]
	 */
	public function findByCategory(Category $category, ...$args)
	{
		return $this->findBy(
			['category' => $category],
			...$args
		);
	}

	/**
	 * @param string $param
	 * @param QueryArgs $args
	 * @return Question[]
	 */
	public function search($param, QueryArgs $args)
	{
		return $this->createQueryBuilder('q')
			->where('MATCH_AGAINST (q.title, q.text, :param) > 0')
			->setParameter('param', $param)
			->orderBy('q.' . $args->getOrderBy(), $args->getOrder())
			->setMaxResults($args->getLimit())
			->setFirstResult($args->getOffset())
			->getQuery()
			->execute();
	}

	/**
	 * @param string $param
	 * @return int
	 * @throws \Doctrine\ORM\NonUniqueResultException
	*/
	public function searchCount($param)
	{
		return $this->createQueryBuilder('q')
			->select('count(q.id)')
			->where('MATCH_AGAINST (q.title, q.text, :param) > 0')
			->setParameter('param', $param)
			->getQuery()
			->getSingleScalarResult();
	}
}
