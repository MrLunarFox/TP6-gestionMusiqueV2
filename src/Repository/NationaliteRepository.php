<?php

namespace App\Repository;

use Doctrine\ORM\Query;
use App\Entity\Nationalite;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Nationalite>
 *
 * @method Nationalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Nationalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Nationalite[]    findAll()
 * @method Nationalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NationaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Nationalite::class);
    }

    
    public function listeNationaliteComplete(): ?Query
    {
        return $this->createQueryBuilder('n')
            ->select('n, art')
            ->leftJoin('n.artistes', 'art')
            ->orderBy('n.libelle', 'ASC')
            ->getQuery()
        ;
    }

    public function listeNationaliteCompleteAdmin($libelle = null): ?Query
    {
        $query = $this->createQueryBuilder('n')
            ->select('n, art')
            ->leftJoin('n.artistes', 'art')
            ->orderBy('n.libelle', 'ASC');
            if($libelle != null)
            {
                $query->andWhere('n.libelle like :libelleChercher')
                ->setParameter('libelleChercher', "%{$libelle}%");
            }
        ;
        return $query->getQuery();
    }


//    /**
//     * @return Nationalite[] Returns an array of Nationalite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Nationalite
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
