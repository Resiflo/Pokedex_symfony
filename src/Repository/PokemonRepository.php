<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * @method Pokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pokemon[]    findAll()
 * @method Pokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    // /**
    //  * @return Pokemon[] Returns an array of Pokemon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pokemon
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */



    /**
  * Récupère une liste d'article paginés et triés par date de création.
  *
  * @param int $page Le numéro de la page
  * @param int $nbMaxByPage Nombre maximum d'articles par page     
  *
  * @throws InvalidArgumentException
  * @throws NotFoundHttpException
  *
  * @return Paginator
  */
  public function findAllPagedAndSorted($page, $nbMaxByPage, $sqlfilters=[])
    {
        if (!is_numeric($page)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }
  
        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }
  
        if (!is_numeric($nbMaxByPage)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . $nbMaxByPage . ').'
            );
        }
  
        
        $qb = $this->createQueryBuilder('pokemon')
            ->andWhere('pokemon.nom like :nom')
            ->setParameter('nom', "%$sqlfilters[nom]%")
            ->leftJoin('pokemon.type1', 'type1')
            ->andWhere('type1.name like :type1')
            ->setParameter('type1', "%$sqlfilters[type1]%")
            ->leftJoin('pokemon.type2', 'type2')
            ->andWhere('type2.name like :type2')
            ->setParameter('type2', "%$sqlfilters[type2]%")
            ->leftJoin('pokemon.generation', 'generation')
            ->andWhere('generation.name like :generation')
            ->setParameter('generation', "%$sqlfilters[generation]%")
            ->orderBy('pokemon.numero', 'ASC');
            
  
        $query = $qb->getQuery();
        $firstResult = ($page - 1) * $nbMaxByPage;
        $query->setFirstResult($firstResult)->setMaxResults($nbMaxByPage);
        $paginator = new Paginator($query);
  
        if ( ($paginator->count() <= $firstResult) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }
  
        return $paginator;
    }
}



           