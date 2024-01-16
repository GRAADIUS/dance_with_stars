<?php
$kasutaja='egorfedorenkopv22';
$serverinimi='localhost';
$parool='1234567890';
$db='egorfedorenkopv22';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $db);
$yhendus->set_charset('UTF8');