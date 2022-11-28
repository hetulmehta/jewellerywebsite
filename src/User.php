<?php

namespace Hetul\Miniproject;

use InvalidArgumentException;

class User
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function isadmin(): string
    {
        if ($this->name == 'admin') {
            return 'admin';
        } else {
            return 'user';
        }
    }
}