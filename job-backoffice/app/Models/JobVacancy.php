<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(columns: ['title','description','location','salary','type','caregoryId','companyId'])]

class JobVacancy extends Model
{
      use HasFactory, Notifiable, HasUuids, SoftDeletes;

      protected $table = 'job_vacancies';

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
    public function jobCategory(){
        return $this->belongsTo(JobCategory::class,'categoryId','id');
    }
    public function company(){
        return $this->belongsTo(Company::class,'companyId','id');
    }
    public function jobApplication(){
        return $this->hasMany(JobApplication::class,'jobVacancyId','id');
    }
}
