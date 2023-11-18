<?php

namespace Tests;

use App\Models\Account;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function createAccount(array $options = [])
    {
        return Account::factory()->create($options);
    }
}
