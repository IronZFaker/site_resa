<?php
    echo "in dao class";
    require_once("../model/Panier.class.php");
    require_once("../model/Place.class.php");
    require_once("../model/Zone.class.php");
    require_once("../model/Siege.class.php");
    require_once("../model/Concert.class.php");
    echo "in dao class after require once";
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
                    return true;
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

        function getTarifbyPlace($idPlace) : int{
            $sql="SELECT tarif FROM tarif WHERE
                idConcert = (select idConcert from place where idPlace='$idPlace')
                AND idZone= (select idZone from siege where
                numSiege = (select numSiege from place where idPlace='$idPlace'))";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Zone");
            return $res[0]->getTarif();
        }

        function getPanier($idClient) : Panier{
            $sql="SELECT * FROM panier WHERE idClient = '$idClient'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Panier");
            return $res[0];
        }
        function getConcert($idPlace): Concert{
            $sql="SELECT * FROM concert WHERE idConcert = select idConcert from place where idPlace = '$idPlace'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Concert");
            return $res[0];
        }

        function getPlace($idConcert): array {
            $sql="SELECT * FROM place WHERE idConcert = '$idConcert'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "Place");
            return $res;
        }

        function getTarifbyZone($idZone,$idConcert):int{
            $sql="SELECT tarif FROM tarif WHERE idConcert = '$idConcert' AND idZone = '$idZone'";
            $request = $this->db->query($sql);
            $res = $request->fetchall(PDO::FETCH_CLASS, "tarif");
            return $res[0];
        }

        function removePanier($idClient){
            $sql="DELETE from panier WHERE idClient = '$idClient'";
            $request = $this->db->exec($sql);
        }

        function removePlaceFromPanier($idPlace){
            $sql="DELETE from panier WHERE idPlace = '$idPlace'";
            $request = $this->db->exec($sql);
        }
      }
?>
