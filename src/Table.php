<?php

namespace Cerwyn\Laraser;

use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Table
{
    protected $tables = [];

    /**
     * Table name
     */
    public $name;

    public function __construct(string $table)
    {
        if (Schema::hasTable($table)) {
            $this->name = $table;
        } else {
            $tableName = $this->getTableName($table);
            if ($tableName != null) $this->name = $tableName;
        }
    }

    public function hasColumn($column = 'deleted_at')
    {
        $schema = Schema::getColumnListing($this->name);
        return in_array($column, $schema);
    }

    public function delete(int $removesIn)
    {
        $date = now()->addDays($removesIn * -1);
        return DB::table($this->name)->where('deleted_at', '>=', $date)->delete();
    }

    public function logUnusedData($date)
    {
        /**
         * TODO: Log data (if needed).
         * Use repository & interface
         */
        return DB::table($this->name)->where('deleted_at', '!=', null)->get();
    }

    public function backupUnusedData()
    {
        /**
         * TODO: Backup data (if needed).
         * Use repository & interface
         */
    }

    /**
     * If the table name is exists
     * 
     * @return bool
     */
    public function isValid()
    {
        return $this->name != null;
    }

    protected function getTableName($modelPath): ?string
    {
        try {
            $model = new $modelPath();
            return $model->getTable();
        } catch (Throwable $e) {
            return null;
        }
    }
}
