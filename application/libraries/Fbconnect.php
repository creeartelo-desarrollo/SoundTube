<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require("Facebook/autoload.php");
class Fbconnect extends Facebook\Facebook 
{
    public function __construct($config) 
    {
        parent::__construct($config);
    }
}