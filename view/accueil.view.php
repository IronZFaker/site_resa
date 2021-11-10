<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
    </head>
    <body>
        <div class="">
            <h1 style="text-align: center">Concerts disponibles</h1>
            <?php
            foreach ($concerts as $c){?>
                <a href="../controler/concert.ctrl.php?id=<?=$c->getidConcert();?>">
                    <div>
                        <p><?=$c->getidConcert();?></p>
                        <p><?=$c->getNom();?></p>
                        <p><?=$c->getDate();?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </body>
</html>
