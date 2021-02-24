<?php

namespace Cerwyn\Laraser\Tests;

use Cerwyn\Laraser\Book;
use Cerwyn\Laraser\Laraser;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\DB;
use Cerwyn\Laraser\LaraserServiceProvider;
use Cerwyn\Laraser\User;
use Illuminate\Support\Facades\Config;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaraserServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan(
            'migrate',
            ['--database' => 'testbench']
        )->run();
    }

    /** @test */
    public function delete_users_table_only()
    {
        // Set the config
        $this->setConfig(10, [
            'Cerwyn\Laraser\User',
        ]);

        // Create 10 dummy data for users and books
        User::factory(10)->create();
        Book::factory(10)->create();

        // Delete Half of Them
        User::limit(5)->delete();
        Book::limit(5)->delete();

        // User and Book should be Soft Deleted
        $this->assertNull(User::find(5));
        $this->assertNotNull(User::withTrashed()->find(5));
        $this->assertNull(Book::find(5));
        $this->assertNotNull(Book::withTrashed()->find(5));

        // Removed 2 days ago
        User::onlyTrashed()->update([
            'deleted_at' => now()->addDays(-2)
        ]);

        $l = new Laraser();
        $l->handle();

        // User and Book should not be Hard Deleted
        $this->assertNotEmpty(User::onlyTrashed()->get()->toArray());
        $this->assertNotEmpty(Book::onlyTrashed()->get()->toArray());

        // Removed 100 days ago
        User::onlyTrashed()->update([
            'deleted_at' => now()->addDays(-100)
        ]);

        $l = new Laraser();
        $l->handle();

        // User and Book should be Hard Deleted
        $this->assertEmpty(User::onlyTrashed()->get()->toArray());
        $this->assertNotEmpty(Book::onlyTrashed()->get()->toArray());
    }

    /** @test */
    public function delete_all_tables()
    {
        // Set the config
        $this->setConfig(10, [
            'Cerwyn\Laraser\User',
            'Cerwyn\Laraser\Book',
        ]);

        // Create 10 dummy data for users and books
        User::factory(10)->create();
        Book::factory(10)->create();

        // Delete Half of Them
        User::limit(5)->delete();
        Book::limit(5)->delete();

        // User and Book should be Soft Deleted
        $this->assertNull(User::find(5));
        $this->assertNotNull(User::withTrashed()->find(5));
        $this->assertNull(Book::find(5));
        $this->assertNotNull(Book::withTrashed()->find(5));

        // Removed 2 days ago
        User::onlyTrashed()->update([
            'deleted_at' => now()->addDays(-2)
        ]);

        $l = new Laraser();
        $l->handle();

        // User and Book should not be Hard Deleted
        $this->assertNotEmpty(User::onlyTrashed()->get()->toArray());
        $this->assertNotEmpty(Book::onlyTrashed()->get()->toArray());

        // Removed 100 days ago
        User::onlyTrashed()->update([
            'deleted_at' => now()->addDays(-100)
        ]);
        Book::onlyTrashed()->update([
            'deleted_at' => now()->addDays(-100)
        ]);

        $l = new Laraser();
        $l->handle();

        // User and Book should be Hard Deleted
        $this->assertEmpty(User::onlyTrashed()->get()->toArray());
        $this->assertEmpty(Book::onlyTrashed()->get()->toArray());
    }

    private function setConfig(int $removeIn, array $models)
    {
        Config::set('laraser.remove_in', $removeIn);
        Config::set('laraser.only', $models);
    }
}
