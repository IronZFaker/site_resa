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


        function isInPanier($idPlace): bool {
            $sql="SELECT * FROM panier WHERE idPlace = '$idPlace'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Panier");
            if(count($res) == 0){
                return false;
            }
            else {
                if ($res[0]->getTimeExp() > new DateTime("NOW")){
                    $sql="DELETE from panier WHERE idPlace = '$idPlace'";
                    $request = $this->db->exec($sql);
                    $sql="UPDATE place SET dispo = true WHERE idPlace = '$idPlace'";
                    $request = $this->db->exec($sql);
                    return false;
                }
                else{
                    return true
                }
            }
        }

        function addConcert($id,$nom,$date,$prix_z1,$prix_z2,$prix_z3){
            if ($id == -1){
                $sql="INSERT INTO concert(nom,event_date) VALUES('$nom','$date')";
                $request = $this->db->exec($sql);

                $sql="SELECT * FROM concert WHERE nom = '$nom'";
                $request = $this->db->query($sql);
                $id_concert = $request->fetchall(PDO::FETCH_CLASS, "Panier")[0]->getidConcert();

                $sql="INSERT INTO tarif(idConcert,idZone,tarif) VALUES('$id_concert','1','$prix_z1')";
                $request = $this->db->exec($sql);
                $sql="INSERT INTO tarif(idConcert,idZone,tarif) VALUES('$id_concert','2','$prix_z2')";
                $request = $this->db->exec($sql);
                $sql="INSERT INTO tarif(idConcert,idZone,tarif) VALUES('$id_concert','3','$prix_z3')";
                $request = $this->db->exec($sql);

                for ($i=1;$i<=90;$i++){
                    $sql="INSERT INTO place(idConcert,dispo,numSiege) VALUES('$id_concert','true','$i')";
                    $request = $this->db->exec($sql);
                    switch($i){
                        case <=30:
                            $n_zone=1;
                            break;
                        case <=60:
                            $n_zone=2;
                            break;
                        case <=90:
                            $n_zone=3;
                            break;
                    }
                    $sql="INSERT INTO siege(numSiege,idZone) VALUES('$i','$n_zone')";
                    $request = $this->db->exec($sql);
                }
            }
            else{

                    $sql = "UPDATE concert set nom=$nom, date=$date WHERE idConcert=$id";
                    $request = $this->db->exec($sql);
                    $sql = "UPDATE tarif set tarif=$prix_z1 WHERE idConcert=$id and idZone='1'";
                    $request = $this->db->exec($sql);
                    $sql = "UPDATE tarif set tarif=$prix_z2 WHERE idConcert=$id and idZone='2'";
                    $request = $this->db->exec($sql);
                    $sql = "UPDATE tarif set tarif=$prix_z3 WHERE idConcert=$id and idZone='3'";
                    $request = $this->db->exec($sql);

            }


        }
        function addIntoPanier($idClient,$idPlace) : bool{
            $d =new DateTime("NOW");
            $d->modify('+10 minutes');
            if(!isInPanier($idPlace)){
                $sql="INSERT INTO panier(idClient,idPlace,timeExp) VALUES('$idClient','$idPlace','$d')";
                $request = $this->db->exec($sql);
                $sql="UPDATE place SET dispo = false WHERE idPlace = '$idPlace'";
                $request = $this->db->exec($sql);
                return true;
            }
            return false;
        }

        function getConcert($idConcert): Concert{
            $sql="SELECT * FROM concert WHERE idConcert = '$idConcert'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Concert");
            return $res[0];
        }

        function getPlageTarif($idConcert): string {
            $sql="SELECT min(tarif) max(tarif) FROM tarif WHERE idConcert = '$idConcert'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Concert");
            return $res[0] ."€ - ". $res[1]."€";
        }

        function getPlace($idConcert): array {
            $sql="SELECT  FROM tarif WHERE idConcert = '$idConcert'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Concert");
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
