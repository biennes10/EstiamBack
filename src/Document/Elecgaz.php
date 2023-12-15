<?php 

namespace App\Document;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

#[MongoDB\Document(repositoryClass: "App\Document\ElecgazRepository")]
class Elecgaz {
    #[MongoDB\Id]
    protected $id;
    #[MongoDB\EmbedOne(targetDocument:Data::Class)]
    private $fields;

    public function getId():string{
        return $this->id;
    }
    public function getFields(){
        return $this->fields;
    }

    public function setId(string $id):void{
        $this->id = $id;
    }
    public function setFields(array $fields):void{
        $this->fields = $fields;
    }
}