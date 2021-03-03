<?php
declare(strict_types=1);

namespace QuickSoft;

use QuickSoft\File\Directory;
use QuickSoft\HttpMethod\Http;

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
        $this->resolveClasses($dir->scanFiles(APP_PATH. DS .'Controllers')->getClassControllerNameArray());

    }

    private function resolveClasses(array $classes)
    {
        $has_controller = false;
        foreach($classes as $class) {
            $reflectionClass = new \ReflectionClass($class);
            $this->analystClass($reflectionClass, $has_controller);
        }
        if (!$has_controller) throw new \ErrorException('Can not find any default controller.');
    }

    private function analystClass(ReflectionClass $reflectionClass, &$has_controller)
    {
        $attributesClass = $reflectionClass->getAttributes(Route::class, \ReflectionAttribute::IS_INSTANCEOF);
        if (count($attributesClass) > 0) {
            $has_controller = true;
            $className = $attributesClass[0]->newInstance();
            $this->analystMethods($reflectionClass, $className);
        }
    }

    private function analystMethods(ReflectionClass $reflectionClass, $className)
    {
        foreach ($reflectionClass->getMethods() as $method) {
            $attributes = $method->getAttributes(Http::class, \ReflectionAttribute::IS_INSTANCEOF);
            if (!$has_at_least_one_controller) throw new \ErrorException('Can not find any default controller.');
            foreach($attributes as $attribute) {
                $listener = $attribute->newInstance();
                var_dump($listener);
            }
        }
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