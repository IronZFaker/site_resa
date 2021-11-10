<?php
    include_once("../model/DAO.class.php");
    include_once("../framework/view.class.php");
    $dao = new DAO();
    $view = new View();

    $concerts = $dao->getAllconcert();
    foreach ($concerts as $c) {
        $tarif = $dao->getPlageTarif($c->getidConcert());
        $c->tarif = $tarif;
    }

    $view->assign('concerts', $concerts);
    $view->display("accueil.view.php");
?>
