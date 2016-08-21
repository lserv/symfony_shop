<?php
namespace Shop\CoreBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table("users")
 * @ORM\Entity()
 */
class User extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     * 
     * @return integer
     */
    public function getId() 
    {
        return $this->id;
    }

    /**
     * @ORM\OneToMany(
     *      targetEntity="Product",
     *      mappedBy="user",
     *      orphanRemoval=true
     * ) 
     */
    private $products;

    public function __construct() 
    {
        parent::__construct();
        $this->products = new ArrayCollection();
    }

    /**
     * Add product.
     * 
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product) 
    {
        $this->products[] = $product;
        
        return $this;
    }

    /**
     * Remove product.
     * 
     * @param Product $product
     */
    public function removeProducts(Product $product) 
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products.
     * 
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts() 
    {
        return $this->products;
    }
}