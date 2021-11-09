<!DOCTYPE html>
<html lang="fr" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <form action="../controler/add_concert.ctrl.php" method="get">
          <div>
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" required>
          </div>
          <div>
            <label for="nom">Prénom : </label>
            <input type="text" name="prenom" id="prenom" required>
          </div>
          <div>
            <label for="cb">Numero de carte : </label>
            <input type="text" name="cb" id="cbq" required>
          </div>
          <div>
            <label for="date">Date d'expiration de la carte: </label>
            <select name='expireYY' id='expireYY'>
                <option value='1'>01</option>
                <option value='3'>02</option>
                <option value='3'>03</option>
                <option value='4'>04</option>
                <option value='5'>05</option>
                <option value='6'>06</option>
                <option value='7'>07</option>
                <option value='8'>08</option>
                <option value='9'>09</option>
                <option value='10'>10</option>
                <option value='11'>11</option>
                <option value='12'>12</option>
            </select>
            <select name='expireYY' id='expireYY'>
                <option value='21'>21</option>
                <option value='22'>22</option>
                <option value='23'>23</option>
                <option value='24'>24</option>
            </select>
          </div>
          <div>
            <label for="ccv">CCV : </label>
            <input type="text" name="ccv" id="ccv" required>
          </div>
          <div>
            <input type="submit" value="PAYER">
          </div>
        </form>
    </body>
</html>