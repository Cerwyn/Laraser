<?php

namespace Cerwyn\Laraser;

use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
    public function delete(int $removesIn, bool $log)
    {
        $date = now()->addDays($removesIn * -1);
        $data = DB::table($this->name)->whereDate('deleted_at', '<=', $date);

        if ($log) {
            $this->logData($data->get());
        }

        return $data->delete(); 
    }

    /**
     * Log the data
     */
    public function logData($data)
    {
        $fileName = $this->name . '_' . now()->format('Y-m-d');
        foreach($data as $item) {
            Storage::disk(config('laraser.storage'))->append($fileName, json_encode($item));
        }
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
