<?php

namespace Shop\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Shop\CoreBundle\Entity\Category;

class CategoryManager
{
    protected $em;
    protected $repository;
    
    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('CoreBundle:Category');
    }
    
    public function getRepository()
    {
        return $this->repository;    
    }
    
    public function persist(Category $category)
    {
        $this->em->persist($category);
        $this->em->flush();
    }
    
    public function delete($category_id)
    {
        $category = $this
            ->repository
            ->findOneBy(['id' => $category_id]);

        $this->em->remove($category);
        $this->em->flush();
    }
    
    public function findAll()
    {
        return $this
            ->repository
            ->findAll();
    }
}
