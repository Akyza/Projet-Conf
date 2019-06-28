<?php

namespace App\Repository;

use App\Entity\Conference;
use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Conference|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conference|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conference[]    findAll()
 * @method Conference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    public function getConferences($firstResult, $maxResult = 10){
        $qb = $this->createQueryBuilder('c');
        $qb
            ->orderBy('c.date', 'desc')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResult);

        $pag = new Paginator($qb);
        dump($pag);
        $c = count($pag);
        return $pag;
    }

    public function getConferencesHome()
    {
        $queryBuilder = $this->createQueryBuilder('c');
        $queryBuilder
            ->select('c.id, c.titre, AVG(v.note) AS score, c.date, c.description')
            ->innerJoin(Vote::class,'v' ,Join::WITH,'v.conference = c.id')
            ->groupBy('c.id')
            ->orderBy('c.date', 'desc')
            ->setMaxResults('6');
        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function getTopConferences()
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c.titre, AVG(v.note) AS score')
            ->innerJoin(Vote::class,'v' ,Join::WITH,'v.conference = c.id')
            ->groupBy('c.id')
            ->orderBy('score', 'DESC')
            ->setMaxResults('10');
        return $queryBuilder->getQuery()->getArrayResult();
    }

    public function getNoVoteConferences($firstResult, $maxResult = 10)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->leftJoin(Vote::class, 'v', join::WITH, 'v.conference = c.id')
            ->where('v.note is null')
            ->orderBy('c.date', 'desc')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResult);

        $pag = new Paginator($qb);
        $c = count($pag);
        return $pag;
    }

    public function getVoteConferences($firstResult, $maxResult = 10)
    {
        $qb = $this->createQueryBuilder('c');
        $qb
            ->innerJoin(Vote::class, 'v', join::WITH, 'v.conference = c.id')
            ->groupBy('c.id')
            ->orderBy('c.date', 'desc')
            ->setFirstResult($firstResult)
            ->setMaxResults($maxResult);

        $pag = new Paginator($qb);
        $c = count($pag);
        return $pag;
    }

    // /**
    //  * @return Conference[] Returns an array of Conference objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Conference
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
