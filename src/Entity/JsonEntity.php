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

	/**
	 * @param \DateTimeInterface $dateTime
	 * @return string
	 */
	protected function formatDateTime(\DateTimeInterface $dateTime)
	{
		return $dateTime->format('Y-m-d H:i:s');
	}
}