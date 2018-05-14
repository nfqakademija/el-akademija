<?php

namespace App\Entity;

abstract class JsonEntity implements \JsonSerializable
{
	/**
	 * White-listed database order / full text fields
	 * @return array
	 */
	// abstract public static function whiteListedFields(): array;

	/**
	 * Max rows per page
	 * @return int
	 */
	// abstract public static function getLimit(): int;

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
		return $dateTime->format('c');
	}
}