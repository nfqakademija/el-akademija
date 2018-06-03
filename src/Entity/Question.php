<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 * @ORM\Table(indexes={@Index(name="search", columns={"title", "text"}, flags={"fulltext"})})
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
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $user;

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

	public function getUser(): ?User
	{
		return $this->user;
	}

	public function setUser(?User $user): self
	{
		$this->user = $user;
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

	public function getCreated(): ?\DateTimeInterface
	{
		return $this->created;
	}

	public function setCreated(?\DateTimeInterface $created): self
	{
		$this->created = $created;
		return $this;
	}

	public function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'category' => $this->category,
			'user' => $this->user,
			'title' => $this->title,
			'text' => $this->text,
			'created' => $this->formatDateTime($this->created)
		];
	}

	public static function whiteListedFields(): array
	{
		return ['id', 'created'];
	}

	public static function getLimit(): int
	{
		return 5;
	}
}
