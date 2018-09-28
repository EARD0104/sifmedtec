<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use sifmedtec\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $defaultUser;

    public function defaultUser(array $attributes = [])
    {
        if ($this->defaultUser) {
            return $this->defaultUser;
        }
        return $this->defaultUser = factory(User::class)->create($attributes);
    }
}
