@extends('sameadmin')

@section('title_name')
Outage add
@endsection

@section('head_text')
Outage add
@endsection

@section('forma')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="post" action="/admin/outagelist/update">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="id" name="id" value="{{ $outage->id }}" readonly>
                    <div class="mb-3">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ $outage->date }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="queue">Queue:</label>
                        <select id="queue" name="queue" class="form-control">
                            @foreach($queues as $item)
                                <option value="{{ $item->id }}" {{ $item->queue == $outage->queueModel->queue ? 'selected' : '' }}>{{ $item->queue }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="start_time">Start time:</label>
                        <select id="start_time" name="start_time" class="form-control">
                            @for ($hour = 0; $hour <= 24; $hour++)
                                <option value="{{ sprintf('%02d', $hour) }}:00" {{ $outage->start_time == sprintf('%02d', $hour) . ':00:00' ? 'selected' : '' }}>
                                    {{ sprintf('%02d', $hour) }}:00
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="end_time">End time:</label>
                        <select id="end_time" name="end_time" class="form-control">
                            @for ($hour = 1; $hour <= 24; $hour++)
                                <option value="{{ sprintf('%02d', $hour) }}:00" {{ $outage->end_time == sprintf('%02d', $hour) . ':00:00' ? 'selected' : '' }}>
                                    {{ sprintf('%02d', $hour) }}:00
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status">Outage status:</label>
                        <select id="status" name="status" class="form-control">
                            <option value="-" {{ $outage->status == "-" ? 'selected' : '' }}>Power outage</option>
                            <option value="±" {{ $outage->status == "±" ? 'selected' : '' }}>Power outages are possible</option>
                        </select>
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <button type="submit" class="btn btn-warning">Update</button>
                        <a href="{{ url('admin/outagelist/'.$outage->date) }}" class="btn btn-primary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection