<?php

declare(strict_types=1);
class ConfigException extends RuntimeException
{
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}
