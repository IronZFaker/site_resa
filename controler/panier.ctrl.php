<?php
    include_once("../model/DAO.class.php");
    include_once("../framework/view.class.php");
    $dao = new DAO();
    $view = new View();
    $place_id = $_GET['id'];

    $dao->addIntoPanier(1, $place_id);

    $view->display("panier.view.php");
?>
