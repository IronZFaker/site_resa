<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <style>
        .red {
            background-color: red;
        }
        .green {
            background-color: green;
        }
    </style>

    <body style="text-align: center">
        <p>Zone 1: <?=$t_zone1?>€</p>
        <div class="">
            <?php
            foreach ($p_zone1 as $p) { ?>
                <a href="../controler/panier.ctrl.php?id=<?=$p->getidPlace();?>">
                <button type="button" name="button" class="green">
                    <?=$p->getSiege()?>
                </button></a>
            <?php }
             ?>
        </div>
        <p>Zone 2: <?=$t_zone2?>€</p>
        <div class="">
            <?php
            foreach ($p_zone1 as $p) { ?>
                <a href="../controler/panier.ctrl.php?id=<?=$p->getidPlace();?>">
                <button type="button" name="button" class="green">
                    <?=$p->getSiege()?>
                </button></a>
            <?php }
             ?>
        </div>
        <p>Zone 3: <?=$t_zone3?>€</p>
        <div class="">
            <?php
            foreach ($p_zone1 as $p) { ?>
                <a href="../controler/panier.ctrl.php?id=<?=$p->getidPlace();?>">
                <button type="button" name="button" class="green">
                    <?=$p->getSiege()?>
                </button></a>
            <?php }
             ?>
        </div>
    </body>
</html>
