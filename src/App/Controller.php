<?php
declare(strict_types=1);

namespace QuickSoft;

abstract class Controller
{
    protected Response $response;

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
    
    public function beforeRoute(){}
    public function afterRoute(){}
}