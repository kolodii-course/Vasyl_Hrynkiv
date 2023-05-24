<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\QueueModel;
use App\Models\BlackoutModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class MainController extends Controller
{
    
    public function setting_update(Request $request){
        $user = Auth::user();
        $settings = SettingModel::where('user_id', $user->id)->get();
        $queues = QueueModel::all();

        foreach ($queues as $queue) {
            $exists = $settings->where('queue_id', $queue->id)->isNotEmpty();
            $isActive = in_array($queue->id, $request->input('queues', []));

            $data = [
                "user_id" => $user->id,
                "queue_id" => $queue->id,
                "is_active" => $isActive
            ];

            if ($exists) {
                $setting = $settings->where('user_id', $user->id)
                    ->where('queue_id', $queue->id)
                    ->first();

                $data['id'] = $setting->id;
                $setting->update($data);
            } else {
                SettingModel::create($data);
            }
        }

        return redirect()->route('setting');
    }

    public function home_find($date){
        $user = Auth::user();
        $settings = SettingModel::where('user_id', $user->id)->get();

        $outages = BlackoutModel::with(['queueModel' => function ($query) {
            $query->orderBy('queue', 'asc');
        }])
            ->where('date', $date)
            ->get()
            ->sortBy('queueModel.queue');

        $queues = QueueModel::whereHas('blackoutModels', function ($query) use ($date) {
            $query->where('date', $date);
        })->orderBy('queue')->get();

        $timezone = new DateTimeZone("Europe/Kiev");

        $currentDateTime = new DateTime("now", $timezone);
        $currentTime = $currentDateTime->format('H:i:s');

        return view("home", compact('outages', 'queues', 'date', 'currentTime', 'settings'));
    }
}
