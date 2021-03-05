<?php
declare(strict_types=1);

namespace QuickSoft;

use stdClass;

class Dispatcher
{
    private Application $application;
    private stdClass $dispatcher;
    private Response $response;
    

    public function __construct(Application &$application)
    {
        $this->application = &$application;
    }
    
    public function setDispatcher(stdClass $dispatcher, Response &$response)
    {
        $this->dispatcher = $dispatcher;
        $this->response = &$response;
    }
    
    public function invoke()
    {
        $class = new $this->dispatcher->class;
        $class->beforeRoute();
        $class->setResponse($this->response);
        $method = $this->dispatcher->method;
        $params = $this->dispatcher->params;
        call_user_func_array([$class, $method], $params);
        $class->afterRoute();
    }

        /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }
}