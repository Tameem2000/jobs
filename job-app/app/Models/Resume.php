<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Resume extends Model
{
    use HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $table = 'resumes';

    protected $keyType = 'string';

    protected $fillable = [
        'fileName',
        'fileUrl',
        'contactDetails',
        'education',
        'summary',
        'skills',
        'experience',
        'userId',
    ];

    public $incrementing = false;

    protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [

            'deleted_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
}
