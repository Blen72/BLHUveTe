<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Szak Felvetele</title>
</head>
<body>
<form action="updateNewSzak.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="szakkod"><b>Szakkod</b></label>
  <input type="text" name="szakkod" placeholder="Szakkod" autoComplete="off" maxlength="10" required>
  <label for="szaknev"><b>Szaknev</b></label>
  <input type="text" name="szaknev" placeholder="Szaknev" autoComplete="off" maxlength="100" required>
  <button type="submit" name="submit-new">Uj szak hozzadasa</button>
  </div>
</form>
</body>
</html>