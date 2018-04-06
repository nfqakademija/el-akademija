<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment extends JsonEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Question")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $question;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $user;

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

	public function getQuestion(): ?Question
	{
		return $this->question;
	}

	public function setQuestion(?Question $question): self
	{
		$this->question = $question;
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

	public function jsonSerialize()
	{
		return [
			'question' => $this->question,
			'user' => $this->user,
			'text' => $this->text,
			'created' => $this->formatDate($this->created)
		];
	}
}
