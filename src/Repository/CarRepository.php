<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;
use Exception;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    private BrandRepository $brandRepo;
    private ModelRepository $modelRepo;
    public function __construct(ManagerRegistry $registry, BrandRepository $repo, ModelRepository $modRepo)
    {
        parent::__construct($registry, Car::class);
        $this->brandRepo = $repo;
        $this->modelRepo = $modRepo;
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Car[] Returns an array of Car objects
    */
   public function findByFilter($data): array
   {
        $modelsId = [];
        if(count($data->models) == 0 || empty($data->models[0])){
            $data->models = $this->modelRepo->findBy(['brand' => $this->brandRepo->findBy(['id' => $data->brands])]);
            if(!(count($data->models)>0)) throw new Exception("Rien de retourne");
            $modelsId = array_map(function($model){
                return $model->getId();
            }, $data->models);
        }else $modelsId = $data->models;
        if(count($data->energy) == 0 || empty($data->energy[0]))
            $data->energy = ["Essence","Diesel","Electrique","Hybride"];
        if(count($data->gearbox) == 0 || empty($data->gearbox[0]))
            $data->gearbox = ["Automatique", "Manuelle"];

            
        $qb = $this->getEntityManager()->createQueryBuilder();
        return $qb->select('c')
            ->from('App\Entity\Car', 'c')
            ->innerJoin('c.characteristics', 'carac')
            ->where($qb->expr()->andX($qb->expr()->in('c.model', ':models'), $qb->expr()->between('c.price', ':minPrice', ':maxPrice')))
            ->andWhere($qb->expr()->andX($qb->expr()->in('carac.gearbox', ':gearbox') ,$qb->expr()->between('YEAR(carac.year_of_launch)', ':minYear', ':maxYear')))
            ->setParameters(new ArrayCollection([
            new Parameter(':models', $modelsId),
            new Parameter(':minPrice', $data->minPrice),
            new Parameter(':maxPrice', $data->maxPrice),
            new Parameter(':gearbox', $data->gearbox),
            new Parameter(':minYear', $data->minYear),
            new Parameter(':maxYear', $data->maxYear),
           ]))
           ->orderBy('c.id', 'ASC')
           ->getQuery()
           ->getResult();
    
    // $qb->select('c') /**Debug request */
    //         ->from('App\Entity\Car', 'c')
    //         ->innerJoin('c.characteristics', 'carac')
    //         ->where($qb->expr()->andX($qb->expr()->in('c.model', $modelsId), $qb->expr()->between('c.price', $data->minPrice, $data->maxPrice)))
    //        ->andWhere("carac.gearbox = :gearbox")
    //        ->andWhere($qb->expr()->between('YEAR(carac.year_of_launch)', $data->minYear, $data->maxYear))
    //        ->setParameter(':gearbox', $data->gearbox[0])
    //        ->orderBy('c.id', 'ASC');
        
        // $sql = $qb->getQuery()->getSQL();
        // throw new Exception($sql." Résultats: ".implode(',',$qb->getQuery()->getResult())); /**Print the sql request */
   }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
