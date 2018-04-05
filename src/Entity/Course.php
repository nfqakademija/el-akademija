<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseRepository")
 */
class Course
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=50)
	 * @Assert\NotBlank()
	 */
	private $name;

	/**
	 * @ORM\Column(type="date")
	 * @Assert\NotBlank()
	 * @Assert\Date()
	 */
	private $start;

	/**
	 * @ORM\Column(type="date")
	 * @Assert\NotBlank()
	 * @Assert\Date()
	 * @Assert\GreaterThan(propertyPath="start")
	 */
	private $end;

	public function getId()
	{
		return $this->id;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function setName(string $name): self
	{
		$this->name = $name;
		return $this;
	}

	public function getStart(): ?\DateTimeInterface
	{
		return $this->start;
	}

	public function setStart(?\DateTimeInterface $start): self
	{
		$this->start = $start;
		return $this;
	}

	public function getEnd(): ?\DateTimeInterface
	{
		return $this->end;
	}

	public function setEnd(?\DateTimeInterface $end): self
	{
		$this->end = $end;
		return $this;
	}
}
