<?php
if($_SESSION["user"]["oktato"]>1){
    echo "<h3>Rednszergazdasági ügyek</h3>";
    echo "<h4>Hallgató féléveinek frissítése</h4>";
    echo "<form action='UranIndex.php' method='post'>";
    echo "</form>";
    if(isset($_POST["gomb"])){
        header("Location: UranIndex.php");
    }
}
?>