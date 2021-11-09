<?php
    include_once("../model/DAO.class.php");
    $dao = new DAO();

    $id = $_GET['id'];
    $nom = $_GET['nom'];
    $date = $_GET['date'];
    $zone1 = $_GET['zone1'];
    $zone2 = $_GET['zone2'];
    $zone3 = $_GET['zone3'];


    echo "before";
    $dao->addConcert($id, $nom, $date, $zone1, $zone2, $zone3);
    echo "after";
    include("../view/accueil.view.php");
?>
