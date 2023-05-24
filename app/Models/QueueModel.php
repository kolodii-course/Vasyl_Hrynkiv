<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QueueModel extends Model
{
    use HasFactory;

    protected $table = 'queue_models';

    protected $fillable = ['queue'];

    public $timestamps = false;

    public function blackoutModels()
    {
        return $this->hasMany(BlackoutModel::class);
    }

    public function settings()
    {
        return $this->hasMany(SettingModel::class);
    }

}
