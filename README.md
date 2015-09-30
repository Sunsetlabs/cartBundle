### Instlacion

#### via composer

````json
{
    "require": {
        "sunsetlabs/cart-bundle" : "dev-master"
    },
    "repositories" : [
        {
            "type" : "vcs",
            "url"  : "https://github.com/Sunsetlabs/cartBundle.git"
        }
    ]
}
````

### Configuracion

Registrar en el kernel de la aplicacion

````php
<?php
// app/AppKernel.php

$bundles = array(
    new Sunsetlabs\OrderBundle\SunsetlabsCartBundle()
);
````

El plugin provee dos clases Cart y CartItem la cuales pueden ser extendidas. La forma mas basica:

````php
// AppBundle/Entity/Cart.php
<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunsetlabs\CartBundle\Entity\Cart as BaseCart;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cart")
 */
class Cart extends BaseCart
{

	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	/**
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", cascade={"persist", "remove"}, orphanRemoval=true)
     */
	protected $items;

}

// AppBundle/Entity/CartItem.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sunsetlabs\CartBundle\Entity\CartItem as BaseCartItem;

/**
 * @ORM\Entity
 */
class CartItem extends BaseCartItem
{
	/**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	/**
     * @ORM\Column(type="integer")
     */
	protected $quantity;
	/**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     * @ORM\JoinColumn(name="my_cart_id", referencedColumnName="id")
     */
	protected $cart;
	/**
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="SET NULL")
     **/
	protected $product;
}


````
