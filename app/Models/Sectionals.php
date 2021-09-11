<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sectionals extends Model
{
  use HasFactory;

  public function sectionalUnits()
  {
    return $this->hasMany(SectionalUnit::class);
  }
  public function address()
  {
    return $this->hasOne(Address::class);
  }
}
