<?php

namespace SE\SDK\Factories;

use Illuminate\Http\Request;

class SERequest
{
    /** @var Request $request */
    protected $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function setType(string $type)
    {
        $this->request->setMethod(strtoupper($type));

        return $this;
    }

    public function setData(array $data)
    {
        $this->request->request->add($data);

        return $this;
    }

    public function getRequest()
    {
        return $this->request;
    }
}