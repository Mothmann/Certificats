<?php

namespace App\Repository;

use App\Entity\Limite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Limite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Limite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Limite[]    findAll()
 * @method Limite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LimiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Limite::class);
    }

    // /**
    //  * @return Limite[] Returns an array of Limite objects
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
    public function findOneBySomeField($value): ?Limite
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function GetUserId($id): array
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('SELECT l
        FROM App\Entity\Limite l
        WHERE l.user=:id')->setParameter('id',$id);
        return $sql->getResult();
    }
    public function scolarite($id): int
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('UPDATE App\Entity\Limite li
        SET li.att_scolarite=li.att_scolarite-1
        WHERE li.user=:id')->setParameter('id',$id);
        return $sql->getResult();
    }
    public function stage(int $id): int
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('UPDATE App\Entity\Limite li
        SET li.conv_stage=li.conv_stage-1
        WHERE li.user=:id')->setParameter('id',$id);
        return $sql->getResult();
    }
    public function note(int $id): int
    {
        $entityManager = $this->getEntityManager();
        $sql = $entityManager->createQuery('UPDATE App\Entity\Limite li
        SET li.rel_note=li.rel_note-1
        WHERE li.user=:id')->setParameter('id',$id);
        return $sql->getResult();
    }
}
