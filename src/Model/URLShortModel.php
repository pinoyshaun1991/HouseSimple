<?php

namespace Model;

use PDO;

class URLShortModel
{
    /**
     * Insert into urls table
     *
     * @param PDO $connection
     * @param $params
     */
    public function insert(PDO $connection, $params)
    {
        $destination = addslashes($params['destination']);
        $sql         = $connection->prepare("INSERT INTO urls (url_destination, url_short) 
                VALUES (:url_destination, :url_short)");

        /*** bind the parameters ***/
        $sql->bindParam(':url_destination', $destination, PDO::PARAM_STR);
        $sql->bindParam(':url_short', $params['shortUrl'], PDO::PARAM_STR);

        $sql->execute();
    }
}