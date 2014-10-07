<?php

namespace LlevaUno\Bancard\Core;

use LlevaUno\Bancard\Core\Config;
use LlevaUno\Bancard\Core\HTTP;
use Closure;

/**
 *
 * Response class that handles all confirmation responses for sent operations.
 *   
 **/

class Response
{
    private $token;
    private $shop_process_id;
    private $response;

    protected $environment;
    protected $url;

    public $public_key;
    public $operation;
    public $data = array();
    
    /**
     *
     * Get post data sent by VPOS.
     *
     * @return Response object
     *
     **/

    static public function read()
    {
        $self = new self;
        $self->response = HTTP::read();
        return $self;
    }
    
    /**
     *
     * Return response object.
     *
     * @return string
     *
     **/

    public function get()
    {
        return $this->response;
    }
    
    /**
     *
     * Return representation of json 
     *
     * @return stdClass
     *
     **/

    public function json()
    {
        return json_decode($this->response);
    }
}
