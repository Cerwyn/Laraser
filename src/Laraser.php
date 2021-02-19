<?php

namespace Cerwyn\Laraser;

use Illuminate\Support\Facades\DB;

class Laraser
{
    protected $tables = [];

    public function handle()
    {
        // Initiate the tables that take effect
        if (config('laraser.only') == ['*']) {
            $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        } else {
            $tables = config('laraser.only');
        }

        // Push Table object to an array
        foreach ($tables as $table) {
            $table = new Table($table);
            if ($table->hasColumn('deleted_at') && $table->isValid()) array_push($this->tables, $table);
        }

        // Remove Unused Data
        foreach ($this->tables as $table) {
            $table->delete(config('laraser.remove_in'), config('laraser.log'));
        }
    }
}
