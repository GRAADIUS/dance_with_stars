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

if (isset($_REQUEST["punktid_null"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsud set punktid=0 where id = ?");
    $kask->bind_param("i", $_REQUEST["punktid_null"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}
if (isset($_REQUEST["peitamine"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsud set avalik=0 where id = ?");
    $kask->bind_param("i", $_REQUEST["peitamine"]);
    $kask->execute();
    header("Location: $_SERVER[PHP_SELF]");
    $yhendus->close();
    exit();
}
if (isset($_REQUEST["naitmine"])){
    global $yhendus;
    $kask=$yhendus->prepare("update tantsud set avalik=1 where id = ?");
    $kask->bind_param("i", $_REQUEST["naitmine"]);
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
        <a href="halduse_leht.php">Kasutaja leht</a>
    </nav>
    <h2>Administreeremis leht</h2>
</header>
<body>
<table border="1" bgcolor="#f5f5f5">
    <tr>
        <th>Tantsuspaari nimi</th>
        <th>Punktid</th>
        <th>Date</th>
        <th>Kommentäärid</th>
        <th>Avalik</th>
    </tr>
<?php
global $yhendus;
    $kask=$yhendus->prepare("select id, tantsuspar, punktid, ava_paev, kommentaarid, avalik from tantsud");
    $kask->bind_result($id, $tantsuspar, $punktid, $ava_paev, $komentaarid, $avalik);
    $kask->execute();

    while($kask->fetch()){
        $text="Näita";
        $seitsud="naitmine";
        $text2="Kasutaja ei näe";
        if ($avalik==1){
            $text="Peida";
            $seitsud="peitamine";
            $text2="Kasutaja näe";
        }
        echo "<tr>";
        $tantsuspar=htmlspecialchars($tantsuspar);
        echo "<td>", $tantsuspar, "</td>";
        echo "<td>", $punktid, "</td>";
        echo "<td>", $ava_paev, "</td>";
        echo "<td>", $komentaarid, "</td>";
        echo "<td>", $avalik, " / ", $text2, "</td>";
        echo "<td><a href='?heatants=$id'>+1</a></td>";
        echo "<td><a href='?bad=$id'>-1</a></td>";
        echo "<td><a href='?delpaarinimi=$id'>delete</a></td>";
        echo "<td><a href='?punktid_null=$id'>0</a></td>";
        echo "<td><a href='?$seitsud=$id'>$text</a></td>";
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
