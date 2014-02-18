<?php

require_once '../src/autoload.php';

$bl = new \Botblocker\Botblocker();
$bl->addIp('127.0.0.*');
$bl->addIp('172.17.6.67');
printf('IP %s %s blocked', $bl->getRemoteIp(), $bl->isBlocked() ? 'is' : 'is not');