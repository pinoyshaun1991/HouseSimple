<?php

namespace Service\API;
/**
 * Interface for downloading reports.
 */
interface URLShortInterface
{
    public function sendRequest($url, $params = array(), $method = '');

    public function isValidURL($url);
}