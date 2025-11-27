<?php
namespace App\Modelos;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model {
    protected $table = 'flights';
    protected $fillable = ['nave_id','origin','destination','departure','arrival','price'];
    public $timestamps = true;
}
