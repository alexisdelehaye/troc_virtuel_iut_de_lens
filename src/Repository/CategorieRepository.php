<?php

namespace App\Repository;

use App\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    private const ID_PARENT_CATEGORY = -1;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categorie::class);
    }


    /**
     * @return Categorie[] Returns an array of Categorie objects
     */
    public function findAllParentCategory()
    {
        return $this->createQueryBuilder('c')
            ->orWhere('c.categoriePere = :val')
            ->setParameter('val', self::ID_PARENT_CATEGORY)
            ->orWhere('c.categoriePere IS NULL')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Categorie[] Returns an array of Categorie objects
     */
    public function findAllChildrenCategoryByParent($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.idcategoriePere = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Categorie
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
