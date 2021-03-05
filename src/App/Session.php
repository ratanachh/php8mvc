<?php
declare(strict_types=1);

namespace QuickSoft;


class Session
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    // The state of the session
    private bool $sessionState = self::SESSION_NOT_STARTED;
    private string $applicationId;

    // THE only instance of the class
    private static Session $instance;

    private function __construct() {
        $this->applicationId = (string)getenv('APP_GUID');
    }


    /**
     *    Returns THE instance of 'Session'.
     *    The session is automatically initialized if it wasn't.
     *
     *    @return    Session
     **/

    public static function getInstance(): Session
    {
        if ( !isset(self::$instance))
        {
            self::$instance = new self;
        }

        if (!self::$instance->isStarted())
            self::$instance->startSession();

        return self::$instance;
    }

    private function isStarted()
    {
        return session_status() === PHP_SESSION_ACTIVE || session_status() === PHP_SESSION_NONE;
    }


    /**
     *    (Re)starts the session.
     *
     *    @return    bool    TRUE if the session has been initialized, else FALSE.
     **/

    public function startSession(): bool
    {
        if ( $this->sessionState == self::SESSION_NOT_STARTED )
        {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }


    /**
     *    Stores datas in the session.
     *    Example: $instance->foo = 'bar';
     *
     *    @param    name    Name of the datas.
     *    @param    value    Your datas.
     *    @return    void
     **/

    public function __set( $name , $value )
    {
        $_SESSION[$this->applicationId][$name] = $value;
    }


    /**
     *    Gets datas from the session.
     *    Example: echo $instance->foo;
     *
     * @param string $name Name of the datas to get.
     * @return    mixed    Datas stored in session.
     */

    public function __get(string $name)
    {
        if ( isset($_SESSION[$this->applicationId][$name]))
        {
            return $_SESSION[$this->applicationId][$name];
        }
    }


    public function __isset( $name ): bool
    {
        return isset($_SESSION[$this->applicationId][$name]);
    }


    public function __unset( $name )
    {
        unset( $_SESSION[$this->applicationId][$name] );
    }


    /**
     *    Destroys the current session.
     *
     *    @return    bool    TRUE is session has been deleted, else FALSE.
     **/

    public function destroy(): bool
    {
        if ( $this->sessionState == self::SESSION_STARTED )
        {
            $this->sessionState = !session_destroy();
            unset( $_SESSION[$this->applicationId] );

            return !$this->sessionState;
        }

        return false;
    }
}
