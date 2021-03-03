<?php
declare(strict_types=1);

namespace QuickSoft;


use QuickSoft\File\Directory;

class Request
{
    private Response $response;
    private Application $application;
    private string $absoluteUri;

    public function __construct(Application &$application)
    {
        $this->application = &$application;
        $this->init();
    }

    private function init()
    {
        $this->response = new Response();
        $dir = new Directory($this->application->getFileName());
        $this->absoluteUri = $dir->getAbsoluteUri();
        print_r($dir->scanFiles(APP_PATH. DS .'Controllers')->getClassControllerNameArray());
    }
    
    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }

    /**
     * @param Application $application
     */
    public function setApplication(Application $application): void
    {
        $this->application = $application;
    }

    /**
     * @return string
     */
    public function getAbsoluteUri(): string
    {
        return $this->absoluteUri;
    }

    /**
     * @param string $absoluteUri
     */
    public function setAbsoluteUri(string $absoluteUri): void
    {
        $this->absoluteUri = $absoluteUri;
    }




}