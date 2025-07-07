<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class DBTableColumns extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function useTable(string $tableName): static
    {
        $this->setTable($tableName);
        return $this;
    }

    public function fetchAll(array $columns = ['*'])
    {
        return $this->newQuery()->select($columns)->get();
    }

    public static function exists(string $table): bool
    {
        return Schema::hasTable($table);
    }

    public static function columns(string $table): array
    {
        return self::exists($table) ? Schema::getColumnListing($table) : [];
    }
}

