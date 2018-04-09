<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LectureRepository")
 */
class Lecture extends JsonEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Course")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $course;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Category")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $category;

	/**
	 * @ORM\Column(type="string", length=100)
	 * @Assert\NotBlank()
	 * @Assert\Length(max=100)
	 */
	private $name;

	/**
	 * @ORM\Column(type="datetime")
	 * @Assert\NotBlank()
	 * @Assert\Date()
	 */
	private $start;

	public function getId()
	{
		return $this->id;
	}

	public function getCourse(): ?Course
	{
		return $this->course;
	}

	public function setCourse(?Course $course): self
	{
		$this->course = $course;
		return $this;
	}

	public function getCategory(): ?Category
	{
		return $this->category;
	}

	public function setCategory(?Category $category): self
	{
		$this->category = $category;
		return $this;
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

	public function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'course' => $this->course,
			'category' => $this->category,
			'name' => $this->name,
			'start' => $this->formatDateTime($this->start)
		];
	}

	public static function whiteListedFields(): array
	{
		return ['id', 'name', 'start'];
	}

	public static function getLimit(): int
	{
		return 10;
	}
}
