<?php

namespace App\Chess\Data;

abstract class AbstractDataObject
{

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Returns value for given attribute if it exists, returns default value otherwise
     *
     * @param mixed $attribute
     * @param mixed $default
     * @return null
     */
    public function get($attribute, $default = null)
    {
        if ( ! $this->has($attribute)) {
            return $default;
        }

        return $this->{$attribute};
    }

    /**
     * Checks whether given attribute is set
     *
     * @param $attribute
     * @return bool
     */
    public function has($attribute)
    {
        return property_exists($this, $attribute);
    }

}
