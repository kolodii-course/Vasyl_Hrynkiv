@extends('sameadmin')

@section('title_name')
Outage list
@endsection

@section('head_text')
Outage list
@endsection

@section('first_content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="post" action="/admin/outagelist/find">
                    @csrf
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" id="date" name="date" class="form-control" value="{{ $date }}" onchange="this.form.submit()">
                    </div>
                    <button type="submit" class="btn btn-primary" style="display: none;">Submit</button>
                </form>
                <div class="flex justify-between items-center mb-3">
                    <div></div>
                    <a href="{{ url('admin/outagelist/'.$date.'/add') }}" class="btn btn-success">Add</a>
                </div>
                @if($outages->isEmpty())
                    <p>Nothing found :(</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Queue</th>
                                <th scope="col">Start Time</th>
                                <th scope="col">End Time</th>
                                <th scope="col">Status</th>
                                <th scope="col">Commands</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outages as $item)
                                <tr>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->queueModel->queue }}</td>
                                    <td>{{ substr($item->start_time, 0, -3) }}</td>
                                    <td>{{ substr($item->end_time, 0, -3) }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>
                                        <a href="/admin/outagelist/{{ $item->id }}/delete" class="btn btn-danger">Delete</a>
                                        <a href="/admin/outagelist/{{ $item->id }}/update" class="btn btn-warning">Update</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection