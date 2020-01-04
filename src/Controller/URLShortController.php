<?php

namespace Controller;

require_once(__DIR__.'/../Service/api/URLShort.php');
require_once(__DIR__.'/../Controller/View.php');
require_once(__DIR__.'/../Model/URLShortModel.php');

use Model\URLShortModel;
use PDO;
use PDOException;
use Service\API\URLShort;

class URLShortController extends URLShort
{

    private $message;
    private $apiKey;
    private $workSpaceId;
    private $servername;
    private $username;
    private $password;
    private $codeLength;
    private $chars;
    private $shortHost;

    public function __construct()
    {
        $this->message     = array();
        $this->apiKey      = '5cfdde1b6d1d4606ab7755e24db68c9c';
        $this->workSpaceId = 'e4deae83507b4c28a3a4706abbb009fa';
        $this->servername  = 'localhost';
        $this->username    = 'root';
        $this->password    = '';
        $this->codeLength  = 7;
        $this->chars       = 'abcdfghjkmnpqrstvwxyz|ABCDFGHJKLMNPQRSTVWXYZ|0123456789';
        $this->shortHost   = 'bit.ly/';

    }

    /**
     * Method to shorten given URL via API
     *
     * @return array
     * @throws \Exception
     */
    public function shortenURLAPI()
    {
        try {
            $url    = $this->isValidURL($_POST['url']);
            $params = array(
                'domain'      => array('fullName' => 'rebrand.ly'),
                'destination' => $url,
                'apiKey'      => $this->apiKey,
                'workspace'   => $this->workSpaceId
            );

            $request = $this->sendRequest('https://api.rebrandly.com/v1/links', $params, 'post');

            $this->message = array(
                'shortURL'    => $request->shortUrl,
                'destination' => $request->destination,
                'code'        => 200
            );
        } catch (Exception $e) {
            $this->message[] = $e->getMessage();
        }

        return $this->message;
    }

    /**
     * Method to shorten given URL via database
     *
     * @return string
     * @throws \Exception
     */
    public function shortenURLDatabase()
    {
        try {
            $connection    = $this->connectDB();
            $URLShortModel = new URLShortModel();

            $url = $this->isValidURL($_POST['urlDatabase']);

            $params = array(
                'destination' => $url,
                'shortUrl'    => $this->shortHost.$this->createShortCode(),
                'code'        => 200
            );

            $URLShortModel->insert($connection, $params);

            $this->message = array(
                'shortURL'    => $params['shortUrl'],
                'destination' => $params['destination'],
                'code'        => 200
            );
        } catch (Exception $e) {
            $this->message[] = $e->getMessage();
        }

        return $this->message;
    }

    /**
     * Render the view page
     *
     * @return View
     */
    public function viewPage()
    {
        return new View('formPage');
    }

    /**
     * Connect to database via PDO
     *
     * @return PDO|void
     */
    private function connectDB()
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=house_simple", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $conn;
        } catch(PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }

        return;
    }

    /**
     * Create shortcode for URL to be saved into db
     *
     * @return string
     */
    protected function createShortCode()
    {
        $shortCode = $this->generateRandomString($this->codeLength);

        return $shortCode;
    }

    /**
     * Generate random string for shortcode
     *
     * @param $length
     * @return string
     */
    protected function generateRandomString($length)
    {
        $sets       = explode('|', $this->chars);
        $all        = '';
        $randString = '';

        foreach ($sets as $set) {
            $randString .= $set[array_rand(str_split($set))];
            $all        .= $set;
        }

        $all = str_split($all);

        for ($i = 0; $i < $length - count($sets); $i++) {
            $randString .= $all[array_rand($all)];
        }

        $randString = str_shuffle($randString);

        return $randString;
    }
}