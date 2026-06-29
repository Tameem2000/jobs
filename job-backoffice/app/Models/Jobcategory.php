<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable(columns: ['name'])]

class Jobcategory extends Model
{
  use HasFactory, Notifiable, HasUuids, SoftDeletes;

  protected $table = 'job_categories';

  protected $keyType = "string";

    public $incrementing = false;

    protected $dates = [
         'deleted_at',
    ];

    protected function casts(): array
    {
        return [

            'deleted_at'=> 'datetime',
        ];
    }
    public function jobVacancy(){
        return $this->hasMany(JobVacancy::class,'category_id','id');
    }
}
