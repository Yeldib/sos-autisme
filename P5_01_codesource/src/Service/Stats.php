<?php 

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class Stats {
   private $manager;
   
   public function __construct(EntityManagerInterface $manager)
   {
        $this->manager = $manager;
   }

   public function getStats()
   {
        $users        = $this->getUsersCount();
        $comments     = $this->getCommentsCount();
        $proUsers     = $this->getProUsersCount();

        return compact('users', 'comments', 'proUsers');
   }

   public function getUsersCount()
   {
    return $this->manager
                ->createQuery('SELECT COUNT(u) FROM App\Entity\User u')
                ->getSingleScalarResult();
   }

   public function getCommentsCount()
   {
       return $this->manager
                   ->createQuery('SELECT COUNT(c) FROM App\Entity\Comment c')
                   ->getSingleScalarResult();
   }

   public function getProUsersCount()
   {
       return $this->manager
                   ->createQuery('SELECT COUNT(p) FROM App\Entity\ProUser p')
                   ->getSingleScalarResult();
   }

   public function getProUsersStats($direction)
   {
        return $this->manager
                    ->createQuery(
                    'SELECT AVG(c.rating) as note, p.firstName, p.lastName, p.id, p.jobCategory, p.picture
                    FROM App\Entity\Comment c
                    JOIN c.proUser p
                    JOIN c.author u
                    GROUP BY p
                    ORDER BY note ' . $direction
                    )
                    ->setMaxResults(4)
                    ->getResult();
   }

}
