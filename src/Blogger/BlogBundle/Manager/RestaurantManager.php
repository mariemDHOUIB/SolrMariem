<?php


namespace Blogger\BlogBundle\Manager;

use Doctrine\ORM\EntityManager;

class RestaurantManager
{
    private $em;
    private $repository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('BloggerBlogBundle:Restaurant');
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }
    
    public function doFlush($sheet)
    {
        $this->em->persist($sheet);
        $this->em->flush();

        return $sheet;
    }
}