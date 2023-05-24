<?php

namespace App\Http\Controllers;

use App\Models\QueueModel;
use App\Models\BlackoutModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        public function queue_show(){
        $data = QueueModel::orderBy('queue')->get();
        return view('queue', compact('data'));
    }

    public function queue_add(Request $request){
        $valid = $request->validate([
            'queue' => 'required|unique:queue_models',
        ]);

        $my_model = QueueModel::create([
            "queue" => $request->input("queue")
        ]);

        return redirect()->route('queue');
    }

    public function queue_rename(Request $request){
        $queueItem = QueueModel::find($request->id);

        if ($queueItem) {
            $queueItem->queue = $request->input("queue");
            $queueItem->save();
        } else {
            abort(404);
        }

        return redirect()->route('queue');
    }

    public function queue_delete($id){
        $queueItem = QueueModel::find($id);

        if ($queueItem) {
            $queueItem->delete();
        } else {
            abort(404);
        }

        return redirect()->route('queue');
    }

    public function outagelist_find($date){
        $outages = BlackoutModel::with(['queueModel' => function ($query) {
            $query->orderBy('queue', 'asc');
        }])
        ->where('date', $date)
        ->get()
        ->sortBy([
            ['queueModel.queue', 'asc'],
            ['start_time', 'asc']
        ]);

        return view('outagelistshow', compact('outages', 'date'));
    }

    public function outagelist_add_show($date){
        $queues = QueueModel::orderBy('queue')->get();

        return view('outagelistadd', compact('date', 'queues'));
    }

    public function outagelist_add(Request $request){
        $valid = $request->validate([
            'date' => 'required',
            'queue' => 'required|exists:queue_models,id',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required'
        ]);

        if ($request->end_time <= $request->start_time) {
            return back()->with('error', "The selected end time ($request->end_time) should be greater than the start time ($request->start_time).");
        }

        $existingOutage = BlackoutModel::where('start_time', '<=', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->where('date', $request->date)
            ->where('queue_model_id', $request->queue)
            ->first();

        if ($existingOutage) {
            return back()->with('error', "The selected time range conflicts with an existing outage $existingOutage->start_time - $existingOutage->end_time.");
        }

        $my_model = BlackoutModel::create([
            "date" => $request->input("date"),
            "queue_model_id" => $request->input("queue"),
            "start_time" => $request->input("start_time"),
            "end_time" => $request->input("end_time"),
            "status" => $request->input("status")
        ]);

        $date = $request->input("date");
        return redirect()->route('outagelist.find', ['date' => $date]);
    }

    public function outagelist_delete($id){
        $blackoutItem = BlackoutModel::find($id);

        if ($blackoutItem) {
            $date = $blackoutItem->date;
            $blackoutItem->delete();
        } else {
            abort(404);
        }

        return redirect()->route('outagelist.find', ['date' => $date]);
    }

    public function outagelist_update_show($id){
        $outage = BlackoutModel::with('queueModel')->findOrFail($id);
        $queues = QueueModel::orderBy('queue')->get();

        $times = [];
        for ($hour = 0; $hour <= 24; $hour++) {
            $time = sprintf('%02d', $hour) . ':00';
            $times[$time] = $time;
        }

        return view('outagelistupdate', compact('outage', 'queues', 'times'));
    }

    public function outagelist_update(Request $request){
        $valid = $request->validate([
            'id' => 'required',
            'date' => 'required',
            'queue' => 'required|exists:queue_models,id',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required'
        ]);

        $data = [
            "date" => $request->input("date"),
            "queue_model_id" => $request->input("queue"),
            "start_time" => $request->input("start_time"),
            "end_time" => $request->input("end_time"),
            "status" => $request->input("status")
        ];

        if ($request->end_time < $request->start_time) {
            return back()->with('error', "The selected end time ($request->end_time) should be greater than the start time ($request->start_time).");
        }

        $existingOutage = BlackoutModel::where('start_time', '<=', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->where('date', $request->date)
            ->where('queue_model_id', $request->queue)
            ->where('id', '!=', $request->id)
            ->first();

        if ($existingOutage) {
            return back()->with('error', "The selected time range conflicts with an existing outage {$existingOutage->start_time} - {$existingOutage->end_time}.");
        }

        BlackoutModel::where('id', $request->input('id'))->update($data);

        $date = $request->input('date');
        return redirect()->route('outagelist.find', ['date' => $date]);
    }
}
