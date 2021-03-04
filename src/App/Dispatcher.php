<?php
declare(strict_types=1);

namespace QuickSoft;

class Dispatcher
{
    private Application $application;

    public function __construct(Application &$application)
    {
        $this->application = &$application;
    }

        /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->application;
    }
}