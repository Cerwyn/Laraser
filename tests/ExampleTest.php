<?php

namespace Cerwyn\Laraser\Tests;

use Orchestra\Testbench\TestCase;
use Cerwyn\Laraser\LaraserServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaraserServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
