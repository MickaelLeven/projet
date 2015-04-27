<?php
/*
 * les information servant à se connecter à la base de données
 */
 $server="localhost";
$db="m2i";
$user = "root";
$password="";


try{
 $dbh= new PDO("mysql:host=".$server.";dbname=".$db,$user,$password);
 $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 try{
     $dbh->beginTransaction();
     
      //Creation de la table Personne
    $query_personne = "create table if not exists personne(id INT NOT NULL AUTO_INCREMENT, prenom VARCHAR(128), nom VARCHAR(128), PRIMARY KEY(id));";
    $stmt = $dbh->prepare($query_personne);
    $stmt->execute();
    
     //Creation de la table Eleve
    $query_eleve = "create table if not exists eleve(id INT NOT NULL AUTO_INCREMENT, id_personne INT NOT NULL, password INT, PRIMARY KEY(id), CONSTRAINT FOREIGN KEY(id_personne) REFERENCES personne(id))";
    $stmt= $dbh->prepare($query_eleve);
    $stmt->execute();
    //creation de la table Animateur
    $query_animateur = "create table if not exists animateur(id INT NOT NULL AUTO_INCREMENT, id_personne INT NOT NULL, entreprise VARCHAR(50), PRIMARY KEY(id), CONSTRAINT FOREIGN KEY(id_personne) REFERENCES personne(id))";
    $stmt = $dbh->prepare($query_animateur);
    $stmt->execute();
   //creation de la table formation
    $query_formation ="create table if not exists formation(id INT NOT NULL AUTO_INCREMENT, titre VARCHAR(50), prix FLOAT, PRIMARY KEY(id))";
    $stmt = $dbh->prepare($query_formation);
    $stmt->execute();
    //creation de la table Centre
    $query_centre="create table if not exists centre(id INT NOT NULL AUTO_INCREMENT,lieu VARCHAR(50), nom VARCHAR(50), PRIMARY KEY(id))";
    $stmt=$dbh->prepare($query_centre);
    $stmt->execute();
    //création de la table appartient
    $query_appartient="create table if not exists appartient(id_formation INT NOT NULL AUTO_INCREMENT,id_centre INT NOT NULL, CONSTRAINT FOREIGN KEY(id_formation) "
            . "REFERENCES formation(id),CONSTRAINT FOREIGN KEY(id_centre) REFERENCES centre(id))";
    $stmt=$dbh->prepare($query_appartient);
    $stmt->execute();
    //création de la table session
    $query_session="create table if not exists session(id INT NOT NULL AUTO_INCREMENT, id_formation INT NOT NULL, id_centre INT NOT NULL,id_animateur INT NOT NULL, "
            ."date DATETIME, description TEXT, PRIMARY KEY(id),CONSTRAINT FOREIGN KEY(id_formation) REFERENCES formation(id),"
            . "CONSTRAINT FOREIGN KEY(id_centre) REFERENCES centre(id),"
            . "CONSTRAINT FOREIGN KEY(id_animateur) REFERENCES animateur(id))";
    $stmt = $dbh->prepare($query_session);
    $stmt->execute();
    //création de la table participation
    $query_participation="create table if not exists participation(id_eleve INT NOT NULL AUTO_INCREMENT, id_session INT NOT NULL,"
            . "CONSTRAINT FOREIGN KEY(id_eleve) REFERENCES eleve(id),"
            . "CONSTRAINT FOREIGN KEY(id_session) REFERENCES session(id))";
    $stmt = $dbh->prepare($query_participation);
    $stmt->execute();
    $stmt->closeCursor();
    $dbh->commit();
    $dbh = null;
     
 } catch (Exception $ex) {
     $dbh->rollBack();
     echo "failed".$ex->getMessage();
 }
 
} 
catch (Exception $ex) {
  echo "failed".$ex->getMessage();
}
?>