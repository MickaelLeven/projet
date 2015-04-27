<?php
include_once "../ext/connexion.php";

class Formation{
    
    private $id;
    private $titre;
    private $prix;
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getTitre(){
        return $this->titre;
    }
    
    public function setTitre($titre){
        $this->titre = $titre;
    }
    
    public function getPrix(){
        return $this->prix;
    }
    
}
?>