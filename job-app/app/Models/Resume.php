<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


#[Fillable([
'fileName',
'fileUrl',
'contactDetails',
'education',
'summary',
'skills',
 'experience',
'userId'
])]
class Resume extends Model
{
      use HasFactory, Notifiable, HasUuids, SoftDeletes;

      protected $table = 'resumes';

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
    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }
}
