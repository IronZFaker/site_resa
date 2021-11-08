<?php
    require_once("../model/Panier.class.php");
    require_once("../model/Place.class.php");
    require_once("../model/Zone.class.php");
    require_once("../model/Siege.class.php");
    require_once("../model/Concert.class.php");
    // Le Data Access Object
    // Il représente la base de donnée
    class DAO {
        // L'objet local PDO de la base de donnée
        private $db;
        // Le type, le chemin et le nom de la base de donnée
        private $database = 'sqlite:../data/resa.db';

        // Constructeur chargé d'ouvrir la BD
        function __construct() {
            try {
              $this->db = new PDO($this->database);
            } catch (\Exception $e) {
              die("Erreur de connexion à la base de données:".$e->getMessage());  // Vérifie si la base de données est bien accessible
            }
        }

        // Cherche dans la base de données un utilisateur ayant pour adresse et mot de passe : "adresse" et "mdp"
        function findUser($adresse,$mdp): int {
          $sql="SELECT * FROM utilisateur WHERE adresse = '$adresse'";
          $request = $this->db->query($sql);
          $res = $request->fetchall(PDO::FETCH_CLASS, "Utilisateur");
          if(count($res) != 0){
            if (password_verify($mdp, $res[0]->getMdp())) {
              return $res[0]->getNum();
            } else {
              return -1;
            }
          } else {
            return -1;
          }
        }

        // Cherche dans la base de données si un utilisateur existe déjà avec cette adresse ($adresse)
        function verifExist($adresse): bool {
          $sql="SELECT * FROM utilisateur WHERE adresse = '$adresse'";
          $request = $this->db->query($sql);
          $res = $request->fetchall(PDO::FETCH_CLASS, "Utilisateur");
          if(count($res) == 0){
            return false;
          } else {
            return true;
          }
        }

        // Récupère l'utilisateur d'identifiant "num"
        function getUtilisateur($num): Utilisateur {
          $sql="SELECT * FROM utilisateur WHERE num = '$num'";
          $request = $this->db->query($sql);
          $res = $request->fetchall(PDO::FETCH_CLASS, "Utilisateur");
          return $res[0];
        }

        // Enregistre les informations d'un nouveau véhicule dans la base de données
        function AddAnnonce($num,$titre,$km,$annee,$energie,$boite,$marque,$chevaux,$modele,$poids,$equipement,$description,$localisation,$prix,$image){
          $datePost = date("j/n/Y");
          $sql="INSERT INTO annonce VALUES
          ((select max(ref)+1 from annonce),'$num',false,
          '$titre','$description','$km','$prix','$energie','$annee','$datePost',
          '$marque','$boite','$poids','$chevaux',
          '$equipement',
          '$modele','$localisation','$image')";
          $request = $this->db->exec($sql);
        }

        // Enregistre les informations d'un nouveau véhicule dans la base de données
        function valideAnnonce($ref){
          $sql="UPDATE annonce SET valide = true WHERE ref = '$ref'";
          $request = $this->db->exec($sql);
        }

        // supprime l'annonce de reference ref
        function supprAnnonce($ref){
          $sql="DELETE from annonce WHERE ref = '$ref'";
          $request = $this->db->exec($sql);
        }

        // Enregistre les informations d'un nouvel utilisateur dans la base de données
        function regUser($nom,$prenom,$adresse,$mdpcrypt){
          $sql="INSERT INTO utilisateur VALUES((select max(num)+1 from utilisateur),'$prenom','$nom','$adresse','$mdpcrypt',false)";
          $request = $this->db->exec($sql);
        }

        // Génère une chaine aléatoirement pour valider une inscription
        function genererChaine(){
           $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
           $longueurMax = strlen($caracteres);
           $chaineAleatoire = '';
           for ($i = 0; $i < 6; $i++){
             $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
           }
           return $chaineAleatoire;
        }

        //retourne l'annonce correspondant à la référence donnée en paramètre
        function getArticle($ref) : Annonce {
            $req = $this->db->query("SELECT * FROM annonce WHERE ref=$ref");
            $result= $req->fetchAll(PDO::FETCH_CLASS,"annonce");
            return $result[0];
        }

        // retourne une array de voitures répondant aux critères de sélection
        // indiqués par l'utilisateur / si tout les paramètres sont nulles
        // retourne toutes les voitures
        function triArticle($km,$prix,$energie,$annee,$marque):array {
          $sql ="SELECT * FROM annonce WHERE ref not null and valide = true";
          if($km!=NULL){
            $sql = $sql." and km<='$km'";
          }
          if($prix!=NULL){
            $sql = $sql." and prix<='$prix'";
          }
          if($energie!=NULL){
            $sql = $sql." and energie='$energie'";
          }
          if($annee!=NULL){
            $sql = $sql." and annee<='$annee'";
          }
          if($marque!=NULL){
            $sql = $sql." and marque='$marque'";
          }
          $req = $this->db->query($sql);
          $result = $req->fetchAll(PDO::FETCH_CLASS,"annonce");
          return $result;
        }

        // Recherche les articles qui ne sont pas encore validés
        function ArticlesNV():array {
          $sql ="SELECT * FROM annonce WHERE valide = false";
          $req = $this->db->query($sql);
          $result = $req->fetchAll(PDO::FETCH_CLASS,"annonce");
          return $result;
        }
      }
?>