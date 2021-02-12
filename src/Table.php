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

    /**
     * Initiate with a model Class or table name
     * 
     * @param string $table
     */
    public function __construct(string $table)
    {
        if (Schema::hasTable($table)) {
            $this->name = $table;
        } else {
            $tableName = $this->getTableName($table);
            if ($tableName != null) $this->name = $tableName;
        }
    }

    /**
     * Check if the table has a column
     * 
     * @param string $column
     * @return bool $hasColumn
     */
    public function hasColumn($column = 'deleted_at'): bool
    {
        $schema = Schema::getColumnListing($this->name);
        return in_array($column, $schema);
    }

    /**
     * Remove the deleted data
     * that has been x days old
     * 
     * @param int $removesIn
     */
    public function delete(int $removesIn)
    {
        $date = now()->addDays($removesIn * -1);
        return DB::table($this->name)->where('deleted_at', '>=', $date)->delete();
    }

    /**
     * Log the data
     */
    public function logUnusedData($date)
    {
        /**
         * TODO: Log data (if needed).
         * Use repository & interface
         */
        return DB::table($this->name)->where('deleted_at', '!=', null)->get();
    }

    /**
     * Backup the data
     */
    public function backupUnusedData()
    {
        /**
         * TODO: Backup data (if needed).
         * Use repository & interface
         */
    }

    /**
     * Check if the object is valid,
     * identified whether the object
     * has a table or not
     * 
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->name != null;
    }

    /**
     * Get the table name
     * based on model class
     * 
     * @param string $modelPath
     * @return null|string $tableName
     */
    protected function getTableName(string $modelPath): ?string
    {
        try {
            $model = new $modelPath();
            return $model->getTable();
        } catch (Throwable $e) {
            return null;
        }
    }
}
