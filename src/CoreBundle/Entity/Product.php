<?php

namespace Shop\CoreBundle\Entity;

use Shop\CoreBundle\Entity\Category;
use Shop\CoreBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Shop\CoreBundle\Repository\ProductRepository")
 * @ORM\Table(
 *     name="products", 
 *     indexes={
 *         @ORM\Index(name="active", columns={"active"}), 
 *         @ORM\Index(name="category_id", columns={"category_id"}), 
 *         @ORM\Index(name="user_id", columns={"user_id"}),    
 *         @ORM\Index(name="cost", columns={"cost"}), 
 *         @ORM\Index(name="title", columns={"title"}), 
 *         @ORM\Index(name="article", columns={"article"})
 *     }
 * )
 * @ORM\HasLifecycleCallbacks
 **/
class Product
{
    use Base;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\CoreBundle\Entity\Category", inversedBy="product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="Shop\CoreBundle\Entity\User", inversedBy="product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
    
    /**
     * @var float
     *
     * @ORM\Column(name="cost", type="float", precision=10, scale=0)
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $cost;
   
    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=150)
     * @Assert\NotBlank()
     */
    private $article;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=150)
     */
    private $image;

    /**
     * Set category.
     *
     * @param Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category.
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set user.
     *
     * @param User $user
     *
     * @return Product
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * @return boolean
     */
    public function isActive() 
    {
        return $this->active;
    }
    
    /**
     * @param boolean $active
     */
    public function setActive($active) 
    {
        $this->active = $active;
    }
    
    /**
     * @return float
     */
    public function getCost() 
    {
        return $this->cost;
    }
    
    /**
     * @param float $cost
     */
    public function setCost($cost) 
    {
        $this->cost = $cost;
    }
    
    /**
     * @return string
     */
    public function getArticle() 
    {
        return $this->article;
    }
    
    /**
     * @param string $article
     */
    public function setArticle($article) 
    {
        $this->article = $article;
    }
    
    /**
     * @return mixed
     */
    public function getImage() 
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     *
     * @return $this
     */
    public function setImage($image) 
    {
        $this->image = $image;

        return $this;
    }
}
