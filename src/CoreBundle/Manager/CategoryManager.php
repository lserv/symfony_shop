<?php

namespace Shop\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Shop\CoreBundle\Entity\Category;

class CategoryManager
{
    protected $em;
    protected $repository;
    
    /**
     * CategoryManager constructor.
     *
     * @param ObjectManager $em
     * @param EntityRepository $repository
     */
    public function __construct(ObjectManager $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function save(Category $category)
    {
        $this->em->persist($category);
        $this->em->flush();
    }
    
    public function delete($category_id)
    {
        $category = $this->repository->findOneBy(['id' => $category_id]);

        $this->em->remove($category);
        $this->em->flush();
    }
}
