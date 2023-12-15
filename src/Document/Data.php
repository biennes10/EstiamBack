<?php 

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\EmbeddedDocument]
class Data {
    #[MongoDB\Field(type:'collection')]
    private array $coordonnees = [];
    #[MongoDB\Field(type:'string')]
    private $date_des_donnees;
    #[MongoDB\Field(type:'string')]
    private $code_epci;

    public function getCoordonnes():array{
        return $this->coordonnees;
    }
    public function getDateDesDonnees():string{
        return $this->date_des_donnees;
    }
    public function getCodeEpci():string{
        return $this->code_epci;
    }
    public function setCoordonnees(array $coordonnees):void{
        $this->coordonnees = $coordonnees;
    }
    public function setDateDesDonnees(string $date_des_donnees):void{
        $this->date_des_donnees = $date_des_donnees;
    }
    public function setCodeEpci(string $code_epci):void{
        $this->code_epci = $code_epci;
    }

}