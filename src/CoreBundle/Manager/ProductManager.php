<?php

namespace Shop\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Shop\CoreBundle\Entity\Product;
use Shop\CoreBundle\Services\FileService;

class ProductManager
{
    protected $em;
    protected $repository;
    protected $fileService;

    /**
     * ProductManager constructor.
     *
     * @param ObjectManager    $em
     * @param EntityRepository $repository
     * @param FileService      $fileService
     */
    public function __construct(ObjectManager $em, EntityRepository $repository, FileService $fileService)
    {
        $this->em = $em;
        $this->repository = $repository;
        $this->fileService = $fileService;
    }

    public function save(Product $product)
    {
        $this->em->persist($product);
        $this->em->flush();
    }
    
    public function delete($product_id)
    {
        /** @var Product $product */
        $product = $this->repository->findOneBy(['id' => $product_id]);
        if ($image = $product->getImage()) {
            $this->fileService->delete($image);
        }

        $this->em->remove($product);
        $this->em->flush();
    }
}
