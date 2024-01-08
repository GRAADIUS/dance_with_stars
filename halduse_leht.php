<?php
require ('conf.php');
if (isset($_REQUEST["paarinimi"]) && !empty($_REQUEST["paarinimi"])){
    global $yhendus;
    $kask=$yhendus->prepare("insert into tantsud (tantsuspar, ava_paev) values(?, now())");
    $kask->bind_param("s", $_REQUEST["paarinimi"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}

if (isset($_REQUEST["heatants"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsud set punktid=punktid+1 where id = ?");
    $kask->bind_param("i", $_REQUEST["heatants"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}

if (isset($_REQUEST["bad"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsud set punktid=punktid-1 where id = ?");
    $kask->bind_param("i", $_REQUEST["bad"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}


if (isset($_REQUEST["delpaarinimi"]) && !empty($_REQUEST["delpaarinimi"])){
    global $yhendus;
    $kask=$yhendus->prepare("DELETE FROM tantsud WHERE id = ?");
    $kask->bind_param("s", $_REQUEST["delpaarinimi"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="stile.css">
    <title>Dance</title>
</head>
<header>
    <h1>Tantsud tähtetega</h1>
    <nav>
        <a href="admin_leht.php">Admin leht</a>
    </nav>
    <h2>Kasutaja lisamine</h2>
</header>
<body>
<table border="1" bgcolor="#f5f5f5">
    <tr>
        <th>Tantsuspaari nimi</th>
        <th>Punktid</th>
        <th>Date</th>
    </tr>
<?php
global $yhendus;
    $kask=$yhendus->prepare("select id, tantsuspar, punktid, ava_paev from tantsud where avalik = 1");
    $kask->bind_result($id, $tantsuspar, $punktid, $ava_paev);
    $kask->execute();

    while($kask->fetch()){
        echo "<tr>";
        $tantsuspar=htmlspecialchars($tantsuspar);
        echo "<td>", $tantsuspar, "</td>";
        echo "<td>", $punktid, "</td>";
        echo "<td>", $ava_paev, "</td>";
        echo "<td><a href='?heatants=$id'>+1</a></td>";
        echo "<td><a href='?bad=$id'>-1</a></td>";
        echo "<td><a href='?delpaarinimi=$id'>delete</a></td>";
        echo "<tr>";
    }
?>
    <form action="?">
        <label for="uuspaar"></label>
        <input type="text" name="paarinimi" id="paarinimi">
        <input type="submit" value="Lisa paar">
    </form>

</table>
</body>
</html>

<?php
