<?php
declare(strict_types=1);

namespace QuickSoft;


class Config implements \ArrayAccess, \Countable
{
    const DEFAULT_PATH_DELIMITER = '.';

    static protected $pathDelimiter;

    public function __construct(array $arrayConfig = []) {
        $this->assignMember($arrayConfig);
    }

    private function assignMember(array $config)
    {
        array_walk($config, function($element, $key){
            if (!is_array($element) || is_object($element)) {
                $this->$key = $element;
            } else $this->$key = new $this($element);
        });
    }

    private function findMember($memberName){
        if (isset($this->$memberName)) return $this->$memberName;
        return null;
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->findMember($name);
    }

    public function offsetExists($offset) {
        return isset($this->$offset);
    }

    public function get($offset, $defaultValue = null) {
        return $this->findMember($offset) ?: $defaultValue;
    }

    public function offsetGet($offset) {
        return $this->findMember($offset);
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) throw new \Exception("Can't Assign member as null to class QuickSoft\Config.", 1);
        $this->$offset = $value;
    }

    public function offsetUnset($index) {
        unset($this->$index);
    }

    public function toArray() {
        return json_decode(json_encode($this), true);
    }

    public function count() {
        return count($this->toArray());
    }

    public static function __set_state(array $data) {
        return new Config($data);
    }

    /**
     * Sets the default path delimiter
     *
     * @param string $delimiter
     */
    public static function setPathDelimiter($delimiter = null) {
        self::$pathDelimiter = $delimiter;
    }

    /**
     * Gets the default path delimiter
     *
     * @return string
     */
    public static function getPathDelimiter() {
        return self::$pathDelimiter;
    }

}