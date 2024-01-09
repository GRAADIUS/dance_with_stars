<?php
$parool="opilane";
$skip="epsilon";
$kryp=crypt($parool, $skip);
echo $kryp;