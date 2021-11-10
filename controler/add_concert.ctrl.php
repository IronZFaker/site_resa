<?php
    include_once("../framework/view.class.php");
    include_once("../model/DAO.class.php");
    $dao = new DAO();
    $view = new View();
    // echo "new view";
    $id = $_GET['id'];
    $nom = $_GET['nom'];
    $date = $_GET['date'];
    $zone1 = $_GET['zone1'];
    $zone2 = $_GET['zone2'];
    $zone3 = $_GET['zone3'];

    $dao->addConcert($id, $nom, $date, $zone1, $zone2, $zone3);
    //$dao->test_select();
    include("../controler/accueil.ctrl.php");
?>
