<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HomeworkGradeRepository")
 * @UniqueEntity(
 *     fields={"homeworkLink"}
 * )
 */
class HomeworkGrade extends JsonEntity
{
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\HomeworkLink")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $homeworkLink;

	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User")
	 * @ORM\JoinColumn(nullable=false)
	 * @Assert\NotBlank()
	 */
	private $user;

	/**
	 * @ORM\Column(type="smallint", nullable=false)
	 * @Assert\NotBlank()
	 * @Assert\Range(min=0, max=10)
	 */
	private $grade;

	/**
	 * @ORM\Column(type="text", nullable=false)
	 * @Assert\NotBlank()
	 * @Assert\Length(max=1000)
	 */
	private $comment;

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

	public function getHomeworkLink(): ?HomeworkLink
	{
		return $this->homeworkLink;
	}

	public function setHomeworkLink(?HomeworkLink $homeworkLink): self
	{
		$this->homeworkLink = $homeworkLink;
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

	public function getGrade(): ?int
	{
		return $this->grade;
	}

	public function setGrade(int $grade): self
	{
		$this->grade = $grade;
		return $this;
	}

	public function getComment(): ?string
	{
		return $this->comment;
	}

	public function setComment(string $comment): self
	{
		$this->comment = $comment;
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
			'homeworkLink' => $this->homeworkLink,
			'user' => $this->user,
			'grade' => $this->grade,
			'comment' => $this->comment,
			'created' => $this->formatDateTime($this->created)
		];
	}

	public static function whiteListedFields(): array
	{
		return ['id', 'homeworkLink', 'grade', 'comment', 'created'];
	}

	public static function getLimit(): int
	{
		return 10;
	}
}
