<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'AbstractOverall.php';

class Test extends AbstractOverall
{

    public function __construct()
    {
        parent::__construct();
        // $this->methods['token_post']['limit'] = 10000;
    }

    public function setModel() 
    { 
        return 'signin_m';
    }

    public function index_get()
    {
        dump('ok');
    }

}