<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question extends JsonEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

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
	private $title;

	/**
	 * @ORM\Column(type="text")
	 * @Assert\NotBlank()
	 * @Assert\Length(max=1000)
	 */
	private $text;

	/**
	 * @ORM\Column(type="datetime")
	 */
	private $created;

	public function __construct()
	{
		$this->created = new \DateTime();
	}

	public function getId()
	{
		return $this->id;
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

	public function getTitle(): ?string
	{
		return $this->title;
	}

	public function setTitle(string $title): self
	{
		$this->title = $title;
		return $this;
	}

	public function getText(): ?string
	{
		return $this->text;
	}

	public function setText(string $text): self
	{
		$this->text = $text;
		return $this;
	}

	public function getCreated(): ?\DateTime
	{
		return $this->created;
	}

	public function jsonSerialize()
	{
		return [
			'category' => $this->category,
			'title' => $this->title,
			'text' => $this->text,
			'created' => $this->formatDate($this->created)
		];
	}
}
