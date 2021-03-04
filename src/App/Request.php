<?php
declare(strict_types=1);

namespace QuickSoft;

use Exception;
use QuickSoft\File\Directory;
use QuickSoft\HttpMethod\{
    HttpGet,
    HttpDelete,
    HttpPost,
    HttpPut
};
use ReflectionAttribute;
use ReflectionClass;
use ErrorException;
use stdClass;

class Request
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    
    private Response $response;
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
        $this->response = new Response();
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
                    var_dump($this->patternMethods);
                }
            }
            else throw new ErrorException('Controller not found.');
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
            $this->patternClasses[] = (object)['class' => $reflectionClass, 'value'=>$pattern];
        }
    }
    
    private function matchClassPattern()
    {
        foreach ($this->patternClasses as $pattern) {
            if (mb_stripos($this->absoluteUri, $pattern->value) !== false) {
                if (substr($this->absoluteUri, 0, strlen($pattern->value)) == $pattern->value) {
                    $partUrl = substr($this->absoluteUri, strlen($pattern->value));
                    return (object)['class' => $pattern->class, 'partUrl' => $partUrl];
                }
            }
        }
        return false;
    }
    
    private function matchMethodPattern()
    {
        
    }

    private function analystMethods(stdClass $matchClass)
    {
        $reflectionClass = $matchClass->class;
        $this->has_method = false;
        foreach ($reflectionClass->getMethods() as $method) {
            $attributes = match ($this->getMethod()) {
                self::GET => $method->getAttributes(HttpGet::class, ReflectionAttribute::IS_INSTANCEOF),
                self::POST => $method->getAttributes(HttpPost::class, ReflectionAttribute::IS_INSTANCEOF),
                self::PUT => $method->getAttributes(HttpPut::class, ReflectionAttribute::IS_INSTANCEOF),
                self::DELETE => $method->getAttributes(HttpDelete::class, ReflectionAttribute::IS_INSTANCEOF),
            };
            if (count($attributes) > 0) {
                $this->has_method = true;
                foreach ($attributes as $attribute) {
                    $methodName = $attribute->newInstance();
                    $pattern = $methodName->getRoutePath();
                    
                    if (isset($this->patternMethods[$pattern])) {
                        
                    } else {
                        $this->patternMethods[$pattern] = (object)['class' => $reflectionClass, 'value'=>$pattern];
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
        return $this->getMethod() == self::POST;
    }

    public function isGet()
    {
        return $this->getMethod() == self::GET;
    }

    public function isPut()
    {
        return $this->getMethod() == self::PUT;
    }

    public function isDelete()
    {
        return $this->getMethod() == self::DELETE;
    }

}