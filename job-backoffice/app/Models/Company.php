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


#[Fillable(['name','address','industry','website','ownerId'])]

class Company extends Model
{
    use HasFactory, Notifiable, HasUuids, SoftDeletes;


    protected $table = "companies";

    protected $keyType = "string";

    public $incrementing = false;

    public static $industries = [
        'Technology',
        'Healthcare',
        'Finance',
        'Education',
        'Retail',
        'Manufacturing',
        'Hospitality',
        'Transportation',
        'Energy',
        'Telecommunications',
        'Other',
    ];

    protected $dates = [
         'deleted_at',
    ];

    protected function casts(): array
    {
        return [

            'deleted_at'=> 'datetime',
        ];
    }
    public function owner(){
        return $this->belongsTo(User::class,'ownerId','id');
    }
    public function JobVacancy(){
        return $this->hasMany(JobVacancy::class,'companyId','id');
    }
    public function jobApplication(){
        return $this->hasManyThrough(JobApplication::class, JobVacancy::class, 'companyId', 'jobVacancyId', 'id', 'id');
    }
}
