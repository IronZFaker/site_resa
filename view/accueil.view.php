<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
    </head>
    <body style="text-align: center">
        <div class="">
            <h1>Concerts disponibles</h1>
            <?php
            foreach ($concerts as $c){?>
                <a href="../controler/concert.ctrl.php?id=<?=$c->getidConcert();?>">
                    <div>
                        <p><?=$c->getNom();?> - <?=$c->getDate();?></p>
                    </div>
                </a>
            <?php } ?>
        </div>
    </body>
</html>
