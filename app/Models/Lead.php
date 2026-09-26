<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lead extends Model {
protected $fillable=['name','email','service','urgency','budget','source','score','priority','followup'];
protected $casts=['budget'=>'float','score'=>'integer'];
}
