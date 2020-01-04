<?php

require_once('src/Controller/URLShortController.php');

use Controller\URLShortController;

$viewPage = new URLShortController();

return $viewPage->viewPage();



