<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlackoutModel extends Model
{
    use HasFactory;

    protected $table = 'blackout_models';

    protected $fillable = ['date', 'queue_model_id', 'start_time', 'end_time', 'status'];

    public $timestamps = false;

    public function queueModel()
    {
        return $this->belongsTo(QueueModel::class);
    }
}
