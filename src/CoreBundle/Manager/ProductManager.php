<?php

namespace Shop\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Shop\CoreBundle\Entity\Product;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Form;

class ProductManager
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

    public function save(Product $product)
    {
        $this->em->persist($product);
        $this->em->flush();
    }
    
    public function delete($product_id)
    {
        $product = $this->repository->findOneBy(['id' => $product_id]);

        $this->em->remove($product);
        $this->em->flush();
    }
}
