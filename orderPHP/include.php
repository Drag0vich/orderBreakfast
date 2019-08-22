<?php

foreach (glob($_SERVER['DOCUMENT_ROOT'] . "/classes/*.php") as $filename) {
    require_once $filename;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/define.php';
