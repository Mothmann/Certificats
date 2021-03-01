<?php

namespace App\Repository;

use App\Entity\Limit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Limit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Limit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Limit[]    findAll()
 * @method Limit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LimitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Limit::class);
    }

    // /**
    //  * @return Limit[] Returns an array of Limit objects
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
    public function findOneBySomeField($value): ?Limit
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function scolarite(int $id): int
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('UPDATE App\Entity\Limit li
        SET li.att_scolarite=li.att_scolarite-1
        WHERE li.user=:id AND li.att_scolarite=:numb')->setParameter('id',$id)->setParameter('numb',$numb);
        return $sql->getResult();
    }
    public function stage(int $id): int
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('UPDATE App\Entity\Limit li
        SET li.conv_stage=li.conv_stage-1
        WHERE li.user=:id')->setParameter('id',$id);
        return $sql->getResult();
    }
    public function note(int $id): int
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('UPDATE App\Entity\Limit li
        SET li.rel_note=li.rel_note-1
        WHERE li.user=:id')->setParameter('id',$id);
        return $sql->getResult();
    }
}
