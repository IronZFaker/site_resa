<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form action="../view/concert.view" method="get">
          <div>
            <label for="nom">Nom du concert : </label>
            <input type="text" name="nom" id="nom" required>
          </div>
          <div>
            <label for="date">Date du concert : </label>
            <input type="date" name="date" id="date" required>
          </div>
          <div>
            <label for="nom">Tarif zone 1 : </label>
            <input type="number" id="zone1" name="zone1" min="1" max="1000">
            <br>
            <label for="nom">Tarif zone 2 : </label>
            <input type="number" id="zone2" name="zone2" min="1" max="1000">
            <br>
            <label for="nom">Tarif zone 3 : </label>
            <input type="number" id="zone2" name="zone2" min="1" max="1000">
          </div>
          <div>
            <input type="submit" value="submit">
          </div>
        </form>
    </body>
</html>
