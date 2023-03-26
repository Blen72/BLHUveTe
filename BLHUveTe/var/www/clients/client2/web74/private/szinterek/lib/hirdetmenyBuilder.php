<div style="border: 2px solid aqua">
    <h1>Add new Hirdetmény</h1>
    <form action="ECoospaceIndex.php" method="post">
        <label>Hirdetmény címe: <input type="text" name="hname"/></label><br>
        <label>Hirdetmény tartalma: <textarea name="hirdetmenyContent"></textarea></label><br>
        <input type="submit" name="addhirdetmeny" value="Hirdetmény hozzáadása"/><br>
        <input style="display: none" type="text" name="toshow" value="<?php echo $_POST["toshow"]; ?>"/>
    </form>
</div>