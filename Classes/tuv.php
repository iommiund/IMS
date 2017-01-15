<?php

/**
 * Created by PhpStorm.
 * User: Iommi
 * Date: 15/01/2017
 * Time: 16:29
 */
class tuv extends resourceItem
{

    private $value;

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

}