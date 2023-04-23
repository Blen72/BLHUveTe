<?php
session_start();
$kurzuskod = $_GET['varname'];
$urancode = $_SESSION['uran_code'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/hallgato.css" rel="stylesheet">
    <title>Forum Uzenet</title>
</head>
<body>
<form action="updateForumUzenet.php" method="POST" class="new-form">
  <div class="new-container">
  <label for="uzenet"><b>Uzenet</b></label>
  <textarea rows="5" cols="50" name="uzenet" placeholder="Uzenet" maxlength="450" required></textarea>
  <input type="hidden" name="kurzuskod" value="<?=$kurzuskod?>">
  <input type="hidden" name="urancode" value="<?=$urancode?>">
  <button type="submit" name="submit-new">Forum uzenet kuldese</button>
  </div>
</form>
</body>
</html>