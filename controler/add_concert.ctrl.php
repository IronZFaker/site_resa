<?php
echo "before";
include_once("../framework/view.class.php");
echo "framework";
include_once("../model/DAO.class.php");
echo "include dao";
$dao = new DAO();
echo "new dao";
$view = new View();
echo "new view";
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
