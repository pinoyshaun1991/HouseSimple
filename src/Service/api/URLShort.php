<?php

namespace Service\API;
use Exception;

require_once('URLShortInterface.php');

class URLShort implements URLShortInterface
{

    /**
     * Use API to shorten given URL
     *
     * @param $url
     * @param array $params
     * @param string $method
     * @return mixed
     */
    public function sendRequest($url, $params = array(), $method = '')
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        if ($method === 'post') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . $method === 'post' ? strlen(json_encode($params)) : 0,
                'apikey: '.$params['apiKey'],
                'workspace: '.$params['workspace']
            )
        );

        $result = curl_exec($ch);

        return json_decode($result);
    }

    /**
     * Validate URL
     *
     * @param $url
     * @return bool
     * @throws Exception
     */
    public function isValidURL($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return (string) $url;
        } else {
            throw new Exception('Invalid URL');
        }

        return false;
    }
}