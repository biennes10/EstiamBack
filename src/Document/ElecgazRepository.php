<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Repository\DocumentRepository;
/**
 * Description of StationRepository
 *
 * @author fabrice
 */
class ElecgazRepository extends DocumentRepository {
    
    public function getElecgazByPrix($filtre, $value)
    {
        return $this->createQueryBuilder()
              ->find()
              ->field('fields.'.$filtre)->equals($value)
              ->getQuery()
              ->execute();
    }
    
}
