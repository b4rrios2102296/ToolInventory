<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
    use HasFactory;

    protected $fillable = ['resguardo_id', 'firmado_por', 'firma_base64'];

    public function resguardo()
    {
        return $this->belongsTo(Resguardo::class);
    }
}
