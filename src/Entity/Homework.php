<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomeworkRepository")
 */
class Homework extends JsonEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Lecture")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $lecture;

	/**
	 * @ORM\Column(type="string", length=50)
	 * @Assert\NotBlank()
	 * @Assert\Length(max=50)
	 */
	private $name;

	/**
	 * @ORM\Column(type="datetime")
	 * @Assert\NotBlank()
	 * @Assert\GreaterThan("today")
	 */
	private $deadline;

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

	public function getLecture(): ?Lecture
	{
		return $this->lecture;
	}

	public function setLecture(?Lecture $lecture): self
	{
		$this->lecture = $lecture;
		return $this;
	}

	public function getDeadline(): ?\DateTimeInterface
	{
		return $this->deadline;
	}

	public function setDeadline(?\DateTimeInterface $deadline): self
	{
		$this->deadline = $deadline;
		return $this;
	}

	public function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'lecture' => $this->lecture,
			'name' => $this->name,
			'deadline' => $this->formatDateTime($this->deadline)
		];
	}

	public static function whiteListedFields(): array
	{
		return ['id', 'lecture', 'name', 'deadline'];
	}

	public static function getLimit(): int
	{
		return 10;
	}
}
