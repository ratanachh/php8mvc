<?php
declare(strict_types=1);

namespace QuickSoft;


class Request
{
    private Response $response;

    public function __construct(string $absoluteUri)
    {
        $this->response = new Response();

        print_r(dirToArray(realpath(APP_PATH.DS.'Controllers')));
        echo realpath(APP_PATH.DS.'Controllers');
    }
    
    

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}