<?php

namespace App\Framework\Support;

use Doctrine\Common\Collections\ArrayCollection;

class Collection extends ArrayCollection
{
	/**
	 * Collection constructor.
	 * @param array $elements
	 */
	public function __construct(array $elements = [])
	{
		parent::__construct($elements);
	}

	/**
	 * Determine if collection have this key.
	 *
	 * @param $key
	 * @return bool
	 */
	public function has($key)
	{
		return $this->get($key) ? true : false;
	}

	/**
	 * Determine if collection have some elements.
	 *
	 * @return bool
	 */
	public function any()
	{
		return !$this->isEmpty();
	}

	/**
	 * Return all elements of collection.
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->toArray();
	}

	/**
	 * Merge 2 tables and create a collection instance with these tables.
	 *
	 * @param array|Collection $tab1
	 * @param array|Collection $tab2
	 * @return Collection
	 */
	public static function merge($tab1, $tab2): Collection
	{
		if ($tab1 instanceof Collection) {
			$tab1 = $tab1->all();
		}

		if ($tab2 instanceof Collection) {
			$tab2 = $tab2->all();
		}

		$tabMerged = array_merge($tab1, $tab2);

		return new Collection($tabMerged);
	}
}