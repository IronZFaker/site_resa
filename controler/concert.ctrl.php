<?php
    include_once("../model/DAO.class.php");
    include_once("../framework/view.class.php");
    $dao = new DAO();
    $view = new View();

    $places = $dao->getPlace($_GET['id'];

    $p_zone1 = array();
    $p_zone2 = array();
    $p_zone3 = array();
    foreach ($places as $p) {
        $dao->isInPanier($p->getidPlace());
        if($p->getSiege()<=30){
            array_push($p_zone1, $p);
        }
        elseif($p->getSiege()<=60){
            array_push($p_zone2, $p);
        }
        else{
            array_push($p_zone3, $p);
        }
    }

    $view->assign('p_zone1', $p_zone1);
    $view->assign('p_zone2', $p_zone2);
    $view->assign('p_zone3', $p_zone3);

    $view->assign('t_zone1', $dao->getTarifbyZone(1,$_GET['id']));
    $view->assign('t_zone2', $dao->getTarifbyZone(2,$_GET['id']));
    $view->assign('t_zone3', $dao->getTarifbyZone(3,$_GET['id']));

    $view->display("concert.view.php");
?>
