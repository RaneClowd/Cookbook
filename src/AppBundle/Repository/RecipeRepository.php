<?php

namespace AppBundle\Repository;

/**
 * RecipeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RecipeRepository extends \Doctrine\ORM\EntityRepository
{
    public function findOneByIdJoinedToFooditems($id)
    {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT r, i, f, s FROM AppBundle:Recipe r
                JOIN r.ingredients i
                JOIN i.fooditem f
                JOIN r.steps s
                WHERE r.id = :id'
            )->setParameter('id', $id);
        
        return $query->getSingleResult();
    }
    
    public function findByIdsJoinedToFooditems($ids) {
        $query = $this->getEntityManager()
            ->createQuery(
                'SELECT r, i, f FROM AppBundle:Recipe r
                JOIN r.ingredients i
                JOIN i.fooditem f
                WHERE r.id in (:ids)'
            )->setParameter('ids', $ids);
        
        return $query->getResult();
    }
}
