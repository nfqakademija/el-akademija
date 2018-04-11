<?php

namespace App\Model;

class QueryArgs
{
	/**
	 * @var string $orderBy
	 * @var string $order
	 * @var int|null $limit
	 * @var int|null $offset
	 */
	private $orderBy, $order, $limit, $offset;

	/**
	 * QueryArgs constructor.
	 * @param string $orderBy
	 * @param string $order
	 * @param int|null $limit
	 * @param int|null $offset
	 */
	public function __construct($orderBy = 'id', $order = 'DESC', $limit = null, $offset = null)
	{
		$this->orderBy = $orderBy;
		$this->order = $order;
		$this->limit = $limit;
		$this->offset = $offset;
	}

	/**
	 * @return mixed
	 */
	public function getOrderBy()
	{
		return $this->orderBy;
	}

	/**
	 * @param mixed $orderBy
	 * @return QueryArgs
	 */
	public function setOrderBy($orderBy): self
	{
		$this->orderBy = $orderBy;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * @param mixed $order
	 * @return QueryArgs
	 */
	public function setOrder($order): self
	{
		$this->order = $order;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLimit()
	{
		return $this->limit;
	}

	/**
	 * @param mixed $limit
	 * @return QueryArgs
	 */
	public function setLimit($limit): self
	{
		$this->limit = $limit;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOffset()
	{
		return $this->offset;
	}

	/**
	 * @param mixed $offset
	 * @return QueryArgs
	 */
	public function setOffset($offset): self
	{
		$this->offset = $offset;
		return $this;
	}

	public function getArray(): array
	{
		return [[$this->orderBy => $this->order], $this->limit, $this->offset];
	}
}