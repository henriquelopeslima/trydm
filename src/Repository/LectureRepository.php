<?php

namespace App\Repository;

use App\Entity\Lecture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Lecture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Lecture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Lecture[]    findAll()
 * @method Lecture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LectureRepository extends ServiceEntityRepository
{
    private $manager;
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Lecture::class);
        $this->manager = $manager;
    }

    public function save(Lecture $event)
    {
        $this->manager->persist($event);
        $this->manager->flush();
    }

    public function delete(Lecture $event)
    {
        $this->manager->remove($event);
        $this->manager->flush();
    }

    // /**
    //  * @return Lecture[] Returns an array of Lecture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Lecture
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
