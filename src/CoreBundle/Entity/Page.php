<?php

namespace Shop\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Sluggable\Util;

/**
 * @ORM\Table(
 *     name="page", 
 *     indexes={
 *         @ORM\Index(name="active", columns={"active"}),
 *         @ORM\Index(name="user_id", columns={"user_id"}),
 *         @ORM\Index(name="title", columns={"title"})
 * })
 * @ORM\Entity(repositoryClass="Shop\CoreBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Page 
{
    use Base;
    
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $slug;
    
    /**
     * @ORM\ManyToOne(targetEntity="Shop\CoreBundle\Entity\User", inversedBy="page")
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
     * Set user.
     *
     * @param User $user
     *
     * @return $this
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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     *
     * @return $this
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedDatetimeFields()
    {
        $title = $this->getTitle() !== null ? Util\Urlizer::transliterate($this->getTitle()) : md5(time());
        $this->setSlug($title);
    }
}
