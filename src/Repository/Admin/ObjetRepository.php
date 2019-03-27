<?php

namespace App\Repository\Admin;

use App\Entity\Admin\ObjetSearch;
use App\Entity\Objet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Objet::class);
    }

    public function findAllByCustomSearch(ObjetSearch $search)
    {
        $query = $this->createQueryBuilder('o');

        if($search->getCategories()->count() > 0){
            $tabCat = [];
            foreach($search->getCategories() as $k => $v)
            {
                $tabCat[] = $v->getIdcategorie();
            }
            $query->andWhere('o.idcategorie IN (:cat)')
                ->setParameter('cat', $tabCat);
        }

        if($search->getUsers()->count() > 0){
            $tabUser = [];
            foreach($search->getUsers() as $k => $v)
            {
                $tabUser[] = $v->getIduser();
            }
            $query->andWhere('o.idproprietaire IN (:user)')
                ->setParameter('user', $tabUser);
        }

        return $query->getQuery()->execute();
    }


    public function searchObjetByName($name): array
    {
        $qb = $this->createQueryBuilder('o')
            ->where('o.nomobjet LIKE :val')
            ->setParameter('val', $name)
            ->getQuery();

        return $qb->execute();
    }


}
