<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomeworkLinkRepository")
 */
class HomeworkLink extends JsonEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Homework")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $homework;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $user;

	/**
	 * @ORM\Column(type="string", length=200)
	 * @Assert\NotBlank()
	 * @Assert\Length(max=200)
	 */
	private $link;

	/**
	 * @ORM\Column(type="datetime")
	 * @Assert\LessThan(propertyPath="homework.deadline", message="You cannot submit homework after its deadline")
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

	public function getHomework(): ?Homework
	{
		return $this->homework;
	}

	public function setHomework(?Homework $homework): self
	{
		$this->homework = $homework;
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

	public function getLink(): ?string
	{
		return $this->link;
	}

	public function setLink(string $link): self
	{
		$this->link = $link;
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
			'homework' => $this->homework,
			'user' => $this->user,
			'link' => $this->link,
			'created' => $this->formatDateTime($this->created)
		];
	}

	public static function whiteListedFields(): array
	{
		return ['id', 'homework', 'created'];
	}

	public static function getLimit(): int
	{
		return 10;
	}
}
