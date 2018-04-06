<?php

namespace App\Entity;

abstract class JsonEntity implements \JsonSerializable
{
	/**
	 * @param \DateTimeInterface $date
	 * @return string
	 */
	protected function formatDate(\DateTimeInterface $date)
	{
		return $date->format('Y-m-d');
	}
}