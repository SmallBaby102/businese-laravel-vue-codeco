<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ial_upload extends Model
{
    use HasFactory;

    protected $fillable = ['container_no','size','type','import_do','vessel','shipper','voyage','port'];
}
