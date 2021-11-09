<?php
echo "before";
//echo include_once("../model/DAO.class.php");
echo "aftetr include";
//$dao = new DAO();
echo "aftetr new DAO";

$id = $_GET['id'];
$nom = $_GET['nom'];
$date = $_GET['date'];
$zone1 = $_GET['zone1'];
$zone2 = $_GET['zone2'];
$zone3 = $_GET['zone3'];

var_dump($date);


// $dao->addConcert($id, $nom, $date, $zone1, $zone2, $zone3);
echo "after";
// include("../view/accueil.view.php");
?>
