<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaborador extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'colaborador';
    protected $primaryKey = 'claveColab';
    public $incrementing = false;
    protected $keyType = 'string';

    public function getAreaLimpiaAttribute()
    {
        return trim(substr($this->Area, strpos($this->Area, '-') + 1));
    }

    public function getSucursalLimpiaAttribute()
    {
        return trim(substr($this->Sucursal, strpos($this->Sucursal, '-') + 1));
    }
}