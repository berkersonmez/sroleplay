<?php

abstract class M_Model
{
    protected function initSelf($data) {
        foreach ($data as $propName => $propValue)
        {
            $this->{$propName} = $propValue;
        }
    }
}