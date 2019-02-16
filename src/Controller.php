<?php

namespace Swover\Framework;

class Controller
{
    protected $action = '';
    protected $data = [];

    public function __construct($request)
    {
        $this->action = $request['action'];
        $this->data = isset($request['data']) ? $request['data'] : [];
    }

    public function __destruct()
    {
    }
}