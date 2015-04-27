<?php

include_once "../ext/connexion.php";
include_once "Personne.php";

class Eleve extends Personne{
    
    private $id_e;
    private $password;
    
    public function getId_e(){
        return $this->id_e;
    }
    
    public function setId_e($id){
        $this->id_e = $id;
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function setPassword($password){
        $this->password = $password;
    }
    
    public function select(){
        global $server, $db, $user, $password;
        try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query="select password,id_personne from eleve where id = :id";
                $stmt = $dbh->prepare($query);
                $array=array(
                    ":id"=>$this->id_e
                );
                $stmt->execute($array);
                $res = $stmt->fetchAll();
                foreach($res as $line){
                    $this->setId($line["id_personne"]); 
                    $this->password = $line["password"];
                }
                $dbh->commit();
            } catch (Exception $ex) {
                $dbh->rollBack();
                echo "erreur : ".$ex->getMessage();
            }
            $dbh = null;
        } catch (Exception $ex) {
            echo "erreur : ".$ex->getMessage();
        }      
        parent::select();
    }
    
    public function insert(){
        global $server, $db, $user, $password;
        parent::insert();
        try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query = "INSERT INTO eleve(id_personne,password) VALUES(:id_personne,:password)";
                $stmt = $dbh->prepare($query);
                $array = array(
                    ":id_personne" => parent::getid(),
                    ":password" => $this->password
                );
                $stmt->execute($array);
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
    
    public function update() {
        global $server, $db, $user, $password;
        parent::update();
        try{
            $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            try{
                $dbh->beginTransaction();
                $query="UPDATE eleve SET password = :password";
                $stmt = $dbh->prepare($query);
                $array=array(
                    ":password"=>$this->password
                );
                $stmt->execute($array);
                $dbh->commit();
            } catch (Exception $ex) {
                $dbh->rollBack();
                echo "erreur : ".$ex->getMessage();
            }
            $dbh = null;
        } catch (Exception $ex) {
            echo "erreur : ".$ex->getMessage();
        }      
    }
    
    public function remove(){
        global $server, $db, $user, $password;
        try{
           $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
           $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           try{
               $dbh->beginTransaction();
               $query="delete from eleve where id = :id";
               $stmt = $dbh->prepare($query);
               $array =array(
                   ":id" => $this->id_e
               );
               $stmt->execute($array);
               $dbh->commit();
           } catch (Exception $ex) {
               $dbh->rollBack();
               echo "erreur : ".$ex->getMessage();
           }
           
        }catch (Exception $ex) {
            echo "erreur: ".$ex->getMessage();
        }
        parent::remove();
    }
    
    /**
     * retourne tout les élève enregistrée dans la base de donnée.
     * @global type $server
     * @global type $db
     * @global type $user
     * @global type $password
     * @return array() un tableau d'éléve;
     */
    public function findAll(){
        global $server, $db, $user, $password;
        $findAll = array();
        try{
           $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
           $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           try{
               $dbh->beginTransaction();
               $query="select e.id, e.password,e.id_personne, p.nom, p.prenom from eleve as e"
                       ." inner join personne as p on p.id = e.id_personne";
               $stmt = $dbh->prepare($query);
               $stmt->execute();
               $res = $stmt->fetchAll();
               foreach($res as $line){
                   $eleve = new Eleve();
                   $eleve->setId($line["id_personne"]);
                   $eleve->setNom($line["nom"]);
                   $eleve->setPrenom($line["prenom"]);
                   $eleve->setId_e($line["id"]);
                   $eleve->setPassword($line["password"]);
                   $findAll[] = $eleve;
               }
               $dbh->commit();
           } catch (Exception $ex) {
               $dbh->rollBack();
               echo "erreur : ".$ex->getMessage();
           }
           
        }catch (Exception $ex) {
            echo "erreur: ".$ex->getMessage();
        }
        return $findAll;
    }
    
}
?>