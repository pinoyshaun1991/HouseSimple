<?php

namespace Controller;

use Exception;

class View
{
    private $data   = array();
    private $render = false;

    /**
     * View constructor check to see whether file exists.
     * @param $template
     */
    public function __construct($template)
    {
        try {
            $file = __DIR__.'/../View/'.$template.'.html';

            if (file_exists($file)) {
                $this->render = $file;
            } else {
                throw new Exception('View file '.$template.' not found!');
            }
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Assign any params to view
     *
     * @param $variable
     * @param $value
     */
    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    public function __destruct()
    {
        extract($this->data);
        include($this->render);

    }
}