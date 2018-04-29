<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class HomeworkGrades
{
	private $grades;

	public function __construct()
	{
		$this->grades = new ArrayCollection();
	}

	public function getGrades(): ?ArrayCollection
	{
		return $this->grades;
	}
}
