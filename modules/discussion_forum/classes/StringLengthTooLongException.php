<?php

/**
 * Created by PhpStorm.
 * User: adityajthakker
 * Date: 15/12/16
 * Time: 2:54 PM
 */
class StringLengthTooLongException extends Exception {

    public function __construct($message){
        parent::__construct($message, null, null);
    }
}