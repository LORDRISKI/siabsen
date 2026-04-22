<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class LokasiKantor extends Model
{
    protected $fillable = ['nama','lat','lng','radius'];
}