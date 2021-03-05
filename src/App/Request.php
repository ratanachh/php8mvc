<?php
declare(strict_types=1);

namespace QuickSoft;

use QuickSoft\Exception\{ConflictClassRouteException,
    ConflictMethodRouteException,
    ControllerNotFoundException,
    MethodNotFoundException};
use QuickSoft\HttpMethod\{
    Http,
    HttpGet,
    HttpDelete,
    HttpPost,
    HttpPut
};
use QuickSoft\File\Directory;
use ReflectionAttribute;
use ReflectionClass;
use ErrorException;
use Exception;
use stdClass;

class Request
{
    
    private Application $application;
    private string $absoluteUri;
    private bool $has_controller;
    private bool $has_method;
    private array $patternClasses = [];
    private array $patternMethods = [];

    public function __construct(Application &$application)
    {
        $this->application = &$application;
        $this->init();
    }

    private function init()
    {
        $dir = new Directory($this->application->getFileName());
        $this->absoluteUri = $dir->getAbsoluteUri();
        $this->resolveClasses($dir->scanFiles(APP_PATH . DS . 'Controllers')->getClassControllerNameArray());
    }

    private function resolveClasses(array $classes)
    {
        $this->has_controller = false;
        foreach($classes as $class) {
            try {
                $reflectionClass = new ReflectionClass($class);
                $this->analystClass($reflectionClass);
            } catch (Exception $e) {
                throw new ErrorException($e->getMessage());
            }
        }
        
        if ($this->has_controller) {
            $matchClass = $this->matchClassPattern();
            if ($matchClass != false) {
                $this->analystMethods($matchClass);
                if ($this->has_method) {
                    $matchMethod = $this->matchMethodPattern($matchClass->partUrl);
                    if ($matchMethod !== false) {
                        $dispatcher = (object)[
                            'class' => $matchClass->class->name,
                            'method' => $matchMethod->name,
                            'params' => $matchMethod->params
                        ];
                        $this->application->dispatcher->setDispatcher($dispatcher, $this->application->response);
                    }
                    else throw new MethodNotFoundException(); 
                }
            }
            else throw new ControllerNotFoundException();
        }
        else throw new ErrorException('Does not has any controllers.');
    }

    private function analystClass(ReflectionClass $reflectionClass)
    {
        $attributesClass = $reflectionClass->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF);
        if (count($attributesClass) > 0) {
            $this->has_controller = true;
            $className = $attributesClass[0]->newInstance();
            $pattern = $className->getPattern();
            if (array_key_exists($pattern, $this->patternClasses)) {
                throw new ConflictClassRouteException($pattern);
            } else {
                $this->patternClasses[$pattern] = (object)['class' => $reflectionClass, 'partUrl'=>$pattern];
            }
        }
    }
    
    private function matchClassPattern()
    {
        foreach ($this->patternClasses as $pattern) {
            if (stripos($this->absoluteUri, $pattern->partUrl) !== false) {
                if (substr($this->absoluteUri, 0, strlen($pattern->partUrl)) == $pattern->partUrl) {
                    $partUrl = substr($this->absoluteUri, strlen($pattern->partUrl));
                    return (object)['class' => $pattern->class, 'partUrl' => $partUrl];
                }
            }
        }
        return false;
    }
    
    private function matchMethodPattern($partUrl): object|bool|string
    {
        foreach ($this->patternMethods as $patternMethod) {
            switch ($partUrl) {
                case $patternMethod->partUrl: return (object)['name' => $patternMethod->method, 'params' => []];
                default:
                    if (str_contains($patternMethod->partUrl, '{') && str_contains($patternMethod->partUrl, '}')) {
                        $urlArray = trim_to_array($patternMethod->partUrl);
                        $partUrlArray = trim_to_array($partUrl);
                        if (count($urlArray) === count($partUrlArray)) {
                            $matches = [];
                            $index = 0;
                            foreach($urlArray as $block) {
                                if((str_contains($block, '{') && str_contains($block, '}'))) {
                                    $matches[] = $partUrlArray[$index];
                                }
                                $index++;
                            }
                            if (count($matches) > 0)
                                return (object)['name' => $patternMethod->method, 'params' => $matches];
                        }
                    }
                break;
            }
        }
        return false;
    }



    private function analystMethods(stdClass $matchClass)
    {
        $reflectionClass = $matchClass->class;
        $this->has_method = false;
        foreach ($reflectionClass->getMethods() as $method) {
            $attributes = match ($this->getMethod()) {
                Http::GET => $method->getAttributes(HttpGet::class, ReflectionAttribute::IS_INSTANCEOF),
                Http::POST => $method->getAttributes(HttpPost::class, ReflectionAttribute::IS_INSTANCEOF),
                Http::PUT => $method->getAttributes(HttpPut::class, ReflectionAttribute::IS_INSTANCEOF),
                Http::DELETE => $method->getAttributes(HttpDelete::class, ReflectionAttribute::IS_INSTANCEOF),
            };
            if (count($attributes) > 0) {
                $this->has_method = true;
                foreach ($attributes as $attribute) {
                    $methodName = $attribute->newInstance();
                    $pattern = $methodName->getRoutePath();
                    if (array_key_exists($pattern, $this->patternMethods)) {
                            throw new ConflictMethodRouteException($method->class, $method->name, $pattern);
                    } else {
                        $this->patternMethods[$pattern] = (object)['method' => $method->name, 'partUrl'=>$pattern];
                    }

                }
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
    
    public function getMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }
    
    public function isPost()
    {
        return $this->getMethod() == Http::POST;
    }

    public function isGet()
    {
        return $this->getMethod() == Http::GET;
    }

    public function isPut()
    {
        return $this->getMethod() == Http::PUT;
    }

    public function isDelete()
    {
        return $this->getMethod() == Http::DELETE;
    }

}