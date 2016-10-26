<?php

namespace Shop\CoreBundle\Entity;

use Shop\CoreBundle\Entity\Category;
use Shop\CoreBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity()
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
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $title;

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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\DateTime()
     */
    private $createdAt;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\DateTime()
     */
    private $updatedAt;
    
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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_keywords", type="string", length=255, nullable=true)
     */
    private $metaKeywords;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", type="string", length=255, nullable=true)
     */
    private $metaTitle;
    
    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", length=255, nullable=true)
     */
    private $metaDescription;

    /**
     * @ORM\Column(type="string", nullable=true, length=150)
     */
    private $image;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

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
     * @return \DateTime
     */
    public function getCreatedAt() 
    {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt) 
    {
        $this->createdAt = $createdAt;
    }
    
    /**
     * @return \DateTime
     */
    public function getUpdatedAt() 
    {
        return $this->updatedAt;
    }
    
    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt) 
    {
        $this->updatedAt = $updatedAt;
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
     * @return string
     */
    public function getDescription() 
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     */
    public function setDescription($description) 
    {
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function getMetaKeywords() 
    {
        return $this->metaKeywords;
    }
    
    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords) 
    {
        $this->metaKeywords = $metaKeywords;
    }
    
    /**
     * @return string
     */
    public function getMetaTitle() 
    {
        return $this->metaTitle;
    }
    
    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle) 
    {
        $this->metaTitle = $metaTitle;
    }
    
    /**
     * @return string
     */
    public function getMetaDescription() 
    {
        return $this->metaDescription;
    }
    
    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription) 
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedDatetimeFields()
    {
        $this->setUpdatedAt(new \DateTime());

        if ($this->getCreatedAt() == null) {
            $this->setCreatedAt(new \DateTime());
        }
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
