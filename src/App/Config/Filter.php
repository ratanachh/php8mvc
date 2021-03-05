<?php
declare(strict_types=1);

namespace QuickSoft\Config;


use QuickSoft\Application;

class Filter
{
    /**
     * @var Application
     */
    private Application $application;

    public function __construct(Application &$application)
    {
        $this->application = &$application;
    }
}