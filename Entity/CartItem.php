<?php

namespace Sunsetlabs\CartBundle\Entity;

use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Cart\CartItemInterface;
use Sunsetlabs\EcommerceResourceBundle\Interfaces\Product\ProductInterface;
use Sunsetlabs\EcommerceResourceBundle\Utils\Identifier;


class CartItem implements CartItemInterface
{
	protected $id;
	protected $product;
	protected $quantity;
	protected $cart;
	
	public function getId()
	{
		return $this->id;
	}
	public function getIdentifier()
	{
		$i = new Identifier();
		if ($this->getProduct()){
			$i->addPk('product_id', $this->getProduct()->getId());
		}else{
			$i->addPk('cart_item_id', 0);
		}
		return $i;
	}
	public function getProduct()
	{
		return $this->product;
	}
	public function getCart()
	{
		return $this->cart;
	}
	public function getQuantity()
	{
		return $this->quantity;
	}
	public function setProduct(ProductInterface $product)
	{
		$this->product = $product;
		return $this;
	}
	public function setQuantity($quantity = 0)
	{
		$this->quantity = $quantity;
		return $this;
	}
	public function setCart(CartInterface $cart = null)
	{
		$this->cart = $cart;
		return $this;
	}
	public function merge(CartItemInterface $item)
	{
		$this->setQuantity($this->getQuantity() + $item->getQuantity());
	}
}



