<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserProviderInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

	public function loadUserByUsername($email)
	{
		$user = $this->findOneBy(['email' => $email]);
		if (!$user)
			throw new AuthenticationCredentialsNotFoundException('Invalid credentials');
		return $user;
	}

	public function refreshUser(UserInterface $user)
	{
		$class = get_class($user);
		if (!$this->supportsClass($class)) {
			throw new UnsupportedUserException(
				sprintf(
					'Instances of "%s" are not supported.',
					$class
				)
			);
		}

		return $this->find($user->getId());
	}

	public function supportsClass($class)
	{
		return $this->getEntityName() === $class
			|| is_subclass_of($class, $this->getEntityName());
	}
}
