<?php


namespace Jman\Core;


class JsonResponse
{

    private $payload;
    private $statusCode;

    public function __construct($data, $status_code = 200)
    {
        $this->payload['data'] = $data;
        $this->statusCode = $status_code;

        $this->setStatusCode200();
    }

    public function setStatusCode200()
    {
        $this->payload['status'] = 200;
        $this->statusCode = 200;
    }

    public function setStatusCode400()
    {
        $this->payload['status'] = 400;
        $this->statusCode = 400;
    }

    public function emit()
    {
        header("Access-Control-Allow-Origin: http://localhost/");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        http_response_code($this->statusCode);

        echo json_encode($this->payload);
    }

}