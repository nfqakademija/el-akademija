<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=150)
	 * @Assert\NotBlank()
	 * @Assert\Email()
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $firstname;

	/**
	 * @ORM\Column(type="string", length=50)
	 */
	private $lastname;

	/**
	 * @ORM\Column(type="string", length=60)
	 * @Assert\NotBlank()
	 */
	private $password;

	public function getId()
	{
		return $this->id;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;
		return $this;
	}

	public function getFirstname(): ?string
	{
		return $this->firstname;
	}

	public function setFirstname(string $firstname): self
	{
		$this->firstname = $firstname;
		return $this;
	}

	public function getLastname(): ?string
	{
		return $this->lastname;
	}

	public function setLastname(string $lastname): self
	{
		$this->lastname = $lastname;
		return $this;
	}

	public function getPassword(): ?string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;
		return $this;
	}

	public function getUsername()
	{
		return $this->email;
	}

	public function getSalt()
	{
		return null;
	}

	public function getRoles()
	{
		return ['ROLE_STUDENT', 'ROLE_LECTOR', 'ROLE_ADMIN'];
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}
}
