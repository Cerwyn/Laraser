<?php

namespace Cerwyn\Laraser;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Throwable;

class Laraser
{
    protected $config;
    protected $tables;
    public function __construct()
    {
        $this->config = new Configuration();
    }

    // Build your next great package.
    public function handle()
    {
        // Initiate the tables that take effect
        if ($this->config->allModels) {
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        } else {
            $tables = $this->config->models;
        }

        // Push Table object to an array
        foreach ($tables as $table) {
            $table = new Table($table);
            if ($table->hasColumn('deleted_at') && $table->isValid()) array_push($this->tables, $table);
        }

        // TODO: Log/Backup if needed


        // Remove Unused Data
        foreach($tables as $table) {
            if ($table->isValid()) $table->delete($this->config->removesIn);
        }
    }
}
