<?php
$kasutaja='egorfedorenkopv22';
$serverinimi='localhost';
$parool='123456';
$db='egorfedorenkopv22';
$yhendus=new mysqli($serverinimi, $kasutaja, $parool, $db);
$yhendus->set_charset('UTF8');