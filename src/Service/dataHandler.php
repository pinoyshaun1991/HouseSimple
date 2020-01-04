<?php

require_once(__DIR__.'/../Controller/URLShortController.php');

use Controller\URLShortController;

if (isset($_POST['url'])) {
    $controller = new URLShortController();
    $result = $controller->shortenURLAPI();
    echo json_encode($result);

    return;
}

if (isset($_POST['urlDatabase'])) {
    $controller = new URLShortController();
    $result = $controller->shortenURLDatabase();
    echo json_encode($result);

    return;
}