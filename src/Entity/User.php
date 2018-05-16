<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends JsonEntity implements UserInterface
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

	/**
	 * @ORM\Column(type="array")
	 */
	private $roles;

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
		return array_unique(array_merge(['ROLE_USER'], $this->roles));
	}

	public function setRoles(array $roles)
	{
		$this->roles = $roles;
	}

	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	public function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'email' => $this->email,
			'firstname' => $this->firstname,
			'lastname' => $this->lastname
		];
	}
}
