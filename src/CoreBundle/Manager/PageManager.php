<?php

namespace Shop\CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;

use Shop\CoreBundle\Entity\Page;

class PageManager
{
    protected $em;
    protected $repository;
    
    /**
     * PageManager constructor.
     *
     * @param ObjectManager $em
     * @param EntityRepository $repository
     */
    public function __construct(ObjectManager $em, EntityRepository $repository)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    public function save(Page $page)
    {
        $this->em->persist($page);
        $this->em->flush();
    }
    
    public function delete($page_id)
    {
        $page = $this->repository->findOneBy(['id' => $page_id]);

        $this->em->remove($page);
        $this->em->flush();
    }
}
