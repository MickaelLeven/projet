<?php
include_once "../ext/connexion.php";

class Personne{
    private $id;
    private $prenom;
    private $nom;
    
    public function getid(){
        return $this->id;
    }
            
    public function setId($id){
        $this->id = $id;
    }
    
    public function getPrenom(){
        return $this->prenom;
    }
    
    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }
    
    public function getNom(){
        return $this->nom;
    }
    
    public function setNom($nom){
        $this->nom = $nom;
    }
    
     public function select(){
         global $server, $db, $user, $password;
         try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query = "Select nom,prenom from personne where id = :id";
                $stmt = $dbh->prepare($query);
                $array = array(
                    ":id" => $this->id
                );
                $stmt->execute($array);
                $res = $stmt->fetchAll();
                foreach($res as $line){
                    $this->nom = $line["nom"];
                    $this->prenom = $line["prenom"];
                }
                $dbh->commit();
            }
            catch (Exception $ex){
                $dbh->rollBack();
                echo "failed".$ex->getMessage();
            }
        }
        catch(Exception $ex){
            echo "failed".$ex->getMessage();
        }
        $dbh=null;
    }
    
    public function insert(){
        global $server, $db, $user, $password;
        try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query = "INSERT INTO personne(prenom,nom) VALUES(:prenom,:nom)";
                $stmt = $dbh->prepare($query);
                $array = array(
                    ":prenom" => $this->prenom,
                    ":nom" => $this->nom
                );
                $stmt->execute($array);
                $this->id = $dbh->lastInsertId();
                $dbh->commit();
            }
            catch (Exception $ex){
                $dbh->rollBack();
                echo "failed".$ex->getMessage();
            }
            $dbh = null;
        }
        catch(Exception $ex){
            echo "failed".$ex->getMessage();
        }       
    }
    
    public function update(){
        global $server, $db, $user, $password;
        try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query = "UPDATE personne SET nom= :nom, prenom =:prenom where id = :id";
                $stmt = $dbh->prepare($query);
                $array = array(
                    ":nom" => $this->nom,
                    ":prenom" => $this->prenom,
                    ":id" => $this->id
                );
                $stmt->execute($array);
                $dbh->commit();
            }
            catch (Exception $ex){
                $dbh->rollBack();
                echo "failed".$ex->getMessage();
            }
            $dbh=null;
        }
        catch(Exception $ex){
            echo "failed".$ex->getMessage();
        }
     }
    
    
    public function remove(){
      global $server, $db, $user, $password;
      try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query = "delete from personne where id = :id";
                $stmt = $dbh->prepare($query);
                $array = array(
                    ":id" => $this->id
                );
                $stmt->execute($array);
                $dbh->commit();
            }
            catch (Exception $ex){
                $dbh->rollBack();
                echo "failed".$ex->getMessage();
            }
        }
        catch(Exception $ex){
            echo "failed".$ex->getMessage();
        } 
        $dbh=null;
    }
    
    public function findAll(){
        global $server, $db, $user, $password;
        $findAll=array();
        try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query = "Select id,nom,prenom from personne";
                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $res = $stmt->fetchAll();
                foreach($res as $line){
                    $personne = new Personne();
                    $personne->setId($line["id"]);
                    $personne->setNom($line["nom"]);
                    $personne->setPrenom($line["prenom"]);
                    $findAll[]= $personne;
                }
                $dbh->commit();
            }
            catch (Exception $ex){
                $dbh->rollBack();
                echo "failed".$ex->getMessage();
            }
        }
        catch(Exception $ex){
            echo "failed".$ex->getMessage();
        } 
        $dbh=null;
        return $findAll;
    }
}
?>
