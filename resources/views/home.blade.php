@extends('same')

@section('title_name')
{{ __('Home') }}
@endsection

@section('head_text')
@auth
Timetable
@endauth
@guest
Welcome
@endguest
@endsection

@section('first_content')
@guest
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                Register and log in to see the schedule
            </div>
        </div>
    </div>
</div>
@endguest
@auth
<div class="py-12">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="post" action="/find">
                    @csrf
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                    <button type="submit" class="btn btn-primary" style="display: none;">Submit</button>
                </form>
                @if($outages->isEmpty())
                    <p>There will be no power outages.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@if($outages->isEmpty() == false)
    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p>{{ "Current time " . $currentTime }}</p>
                    @foreach($queues as $item)
                        @if($settings->contains('queue_id', $item->id))
                            @foreach($settings as $sett)
                            @if($sett->queue_id == $item->id && $sett->is_active == true)
                            <div class="overflow-x-auto">
                                <h4>Queue {{$item->queue}}</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            @for ($hour = 0; $hour <= 24; $hour++)
                                                <th scope="col">{{ sprintf('%02d', $hour) }}:00</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @for ($hour = 0; $hour <= 24; $hour++)
                                            @php
                                                $matchedOutage = null;
                                                foreach($outages as $outage) {
                                                    if ($outage->queueModel->queue == $item->queue &&
                                                        sprintf('%02d', $hour) . ':00:00' >= $outage->start_time &&
                                                        sprintf('%02d', $hour) . ':00:00' < $outage->end_time) {
                                                        $matchedOutage = $outage;
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            @if ($matchedOutage)
                                                <td class="text-center" style="background-color: {{ $matchedOutage->status == '-' ? '#dc3545' : '#ffc107' }};">
                                                    {{ $matchedOutage->status }}
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            @endif
                            @endforeach
                        @else
                            <div class="overflow-x-auto">
                                <h4>Queue {{$item->queue}}</h4>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            @for ($hour = 0; $hour <= 24; $hour++)
                                                <th scope="col">{{ sprintf('%02d', $hour) }}:00</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        @for ($hour = 0; $hour <= 24; $hour++)
                                            @php
                                                $matchedOutage = null;
                                                foreach($outages as $outage) {
                                                    if ($outage->queueModel->queue == $item->queue &&
                                                        sprintf('%02d', $hour) . ':00:00' >= $outage->start_time &&
                                                        sprintf('%02d', $hour) . ':00:00' < $outage->end_time) {
                                                        $matchedOutage = $outage;
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            @if ($matchedOutage)
                                                <td class="text-center" style="background-color: {{ $matchedOutage->status == '-' ? '#dc3545' : '#ffc107' }};">
                                                    {{ $matchedOutage->status }}
                                                </td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endfor
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif
@endauth
@endsection