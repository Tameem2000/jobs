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

#[Fillable(columns: ['status','aiGeneratedScore','aiGeneratedFeedback','userId','resumeId','job_vacancyId'])]

class JobApplication extends Model
{
      use HasFactory, Notifiable, HasUuids, SoftDeletes;

      protected $table = 'job_applications';

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
        return $this->belongsTo(JobVacancy::class,'job_vacancyId','id');
    }
    public function resume(){
        return $this->belongsTo(Resume::class,'resumeId','id');
}
public function user(){
    return $this->belongsTo(User::class,'userId','id');
}
}
