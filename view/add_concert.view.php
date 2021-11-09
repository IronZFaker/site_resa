<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form action="../controler/add_concert.ctrl.php" method="get">
          <div>
            <input type="hidden" name="id" id="id" value="-1">
          </div>
          <div>
            <label for="nom">Nom du concert : </label>
            <input type="text" name="nom" id="nom" required>
          </div>
          <div>
            <label for="date">Date du concert : </label>
            <input type="date" name="date" id="date" required>
          </div>
          <div>
            <label for="zone1">Tarif zone 1 : </label>
            <input type="number" id="zone1" name="zone1" min="1" max="1000" required>
            <br>
            <label for="zone2">Tarif zone 2 : </label>
            <input type="number" id="zone2" name="zone2" min="1" max="1000" required>
            <br>
            <label for="zone3">Tarif zone 3 : </label>
            <input type="number" id="zone3" name="zone3" min="1" max="1000" required>
          </div>
          <div>
            <input type="submit" value="submit">
          </div>
        </form>
    </body>
</html>
