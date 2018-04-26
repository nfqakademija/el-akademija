<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category extends JsonEntity
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
	 * @Assert\Length(max=50)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=7)
	 * @Assert\NotBlank()
	 * @Assert\Length(max=7)
	 */
	private $color;

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

	public function getColor(): ?string
	{
		return $this->color;
	}

	public function setColor(string $color): self
	{
		$this->color = $color;
		return $this;
	}

	public function jsonSerialize()
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'color' => $this->color
		];
	}

	public static function whiteListedFields(): array
	{
		return ['id', 'name', 'color'];
	}

	public static function getLimit(): int
	{
		return 10;
	}
}
