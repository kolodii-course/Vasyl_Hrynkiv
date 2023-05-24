<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingModel extends Model
{
    use HasFactory;

    protected $table = 'setting_models';

    protected $fillable = ['user_id', 'queue_id', 'is_active'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function queue()
    {
        return $this->belongsTo(QueueModel::class);
    }
}
