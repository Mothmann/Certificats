<?php

namespace App\Repository;

use App\Entity\Etudiant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etudiant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etudiant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etudiant[]    findAll()
 * @method Etudiant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtudiantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etudiant::class);
    }

    // /**
    //  * @return Etudiant[] Returns an array of Etudiant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Etudiant
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function certificat(int $id): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT et.nom, et.prenom, et.date_naissance,et.cne,et.annee_1ere_inscription_universite
              FROM App\Entity\Categories ca INNER JOIN App\Entity\Certificats ce WITH ca.id=ce.categories INNER JOIN App\Entity\User u WITH ce.user=u.id INNER JOIN App\Entity\Etudiant et WITH u.etudiant=et.id
             WHERE ce.id = :id'
        )->setParameter('id',$id);
        return $query->getResult();
    }
    public function note($userid): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT m.libelle,no.note
             FROM App\Entity\Note no INNER JOIN App\Entity\Module m WITH no.module=m.id INNER JOIN App\Entity\User u WITH no.user=u.id
             WHERE no.user = :id'
        )->setParameter('id',$userid);
        return $query->getResult();
    }
    public function stage($userid): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT et.nom,et.prenom,s.entreprise,s.responsable_de_stage,s.ville
             FROM App\Entity\Stage s INNER JOIN App\Entity\user u WITH s.user=u.id INNER JOIN App\Entity\Etudiant et WITH u.etudiant=et.id 
             WHERE s.user = :id'
        )->setParameter('id',$userid);
        return $query->getResult();
    }
    public function nom($idd): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT et.nom,et.prenom
              FROM App\Entity\User u INNER JOIN App\Entity\Etudiant et WITH u.etudiant=et.id
             WHERE u.id = :id'
        )->setParameter('id',$idd);
        return $query->getResult();
    }
}
