<?php

namespace Sunsetlabs\CartBundle\Entity;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartItemInterface;
use Doctrine\Common\Collections\ArrayCollection;

abstract class Cart implements CartInterface
{
	protected $id;
	protected $items;

	function __construct() {
		$this->items = new ArrayCollection();
	}
	public function getId()
	{
		return $this->id;
	}
	public function getItems()
	{
		return $this->items;
	}
	public function addItem(CartItemInterface $item)
	{
		$i = $this->getItem($item);
		if (!$i) {
			$this->items->add($item);
			$item->setCart($this);
			return $this;
		}
		$i->merge($item);
		return $this;
	}
	public function removeItem(CartItemInterface $item, $all = true)
	{
		$key = $this->getItemKey($item);
		if ($key === false) {
			return $this;
		}

		$item->setQuantity(-$item->getQuantity());

		$i = $this->items->get($key);

		if ($all) {
			$this->items->remove($key);
			$i->setCart();
		}else{
			$i->merge($item);
		}
		return $this;
	}
	public function hasItem(CartItemInterface $item)
	{
		return ($this->getItem($item) != false);
	}
	public function clear()
	{
		$this->items->clear();
		return $this;
	}
	public function isEmpty()
	{
		return $this->items->isEmpty();
	}
	public function getItem(CartItemInterface $item)
	{
		foreach ($this->items as $i) {
			if ($i->getIdentifier()->equals($item->getIdentifier())) {
				return $i;
			}
		}
		return false;
	}
	protected function getItemKey(CartItemInterface $item)
	{
		foreach ($this->items as $key => $i) {
			if ($i->getIdentifier()->equals($item->getIdentifier())) {
				return $key;
			}
		}
		return false;
	}
}





