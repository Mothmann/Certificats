<?php

namespace App\Repository;

use App\Entity\Categories;
use App\Entity\Certificats;
use App\Entity\Etudiant;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);

    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Certificats[]
     */
    public function demande(): array

    {   $entityManager = $this->getEntityManager();

        $sql =$entityManager->createQuery( 'SELECT ce.id, ca.name,et.nom,et.prenom,ce.created_at
            FROM App\Entity\Categories ca INNER JOIN App\Entity\Certificats ce WITH ca.id=ce.categories INNER JOIN App\Entity\User u WITH ce.user=u.id INNER JOIN App\Entity\Etudiant et WITH u.etudiant=et.id
            WHERE ce.active = 1') ;


        return $sql->getResult();
    }
    public function mesdemandes(int $id): array

    {   $entityManager = $this->getEntityManager();

        $sql =$entityManager->createQuery( 'SELECT ca.name,ce.created_at
            FROM App\Entity\Categories ca INNER JOIN App\Entity\Certificats ce WITH ca.id=ce.categories INNER JOIN App\Entity\User u WITH ce.user=u.id INNER JOIN App\Entity\Etudiant et WITH u.etudiant=et.id
            WHERE u.id= :id')->setParameter('id',$id) ;


        return $sql->getResult();
    }
}