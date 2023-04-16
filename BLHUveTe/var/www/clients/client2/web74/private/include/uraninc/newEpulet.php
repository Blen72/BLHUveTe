<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../../../web74/web/css/hallgato.css" rel="stylesheet">
    <title>Epulet Felvetele</title>
</head>
<body>
<form action="updateNewEpulet.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="epulet_neve"><b>Epulet neve</b></label>
  <input type="text" name="epulet_neve" placeholder="Epulet neve" autoComplete="off" maxlength="100" required>
  <label for="epulet_cime"><b>Epulet cime</b></label>
  <input type="text" name="epulet_cime" placeholder="Epulet cime" autoComplete="off" maxlength="100" required>
  <button type="submit" name="submit-new">Uj epulet hozzadasa</button>
  </div>
</form>
</body>
</html>