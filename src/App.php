<?php

namespace Swover\Framework;

class App
{
    private $request = null;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function execute()
    {
        try {
            $this->before($this->request);

            $result = Route::getInstance()->dispatch($this->request);

            return $this->after($result);

        } catch (SwoverException $e) {
            return $e->getMessage();
        }
    }

    private function before($request)
    {
        if (!isset($request['action'])) {
            throw new SwoverException('Has Not Action!');
        }
        /*if (Sign::verify() !== true) {
            return Response::getInstance()->bad('Token is error!');
        }*/
    }

    private function after($result)
    {
        return $result;
    }
}