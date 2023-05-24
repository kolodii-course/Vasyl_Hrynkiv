@extends('sameadmin')

@section('title_name')
Queue
@endsection

@section('head_text')
Queue manager
@endsection

@section('first_content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                @if($data->isEmpty())
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Queue</th>
                                <th scope="col">Command</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Nothing found :(</td>
                                <td>Enter a number (1.1,1.2, etc.)</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Queue</th>
                                <th scope="col">Command</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $item->queue }}</td>
                                    <td>
                                        <a href="/admin/queue/{{ $item->id }}/delete" class="btn btn-danger">delete</a>
                                        <a href="/admin/queue/{{ $item->id }}/rename" class="btn btn-warning">rename</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <form method="post" action="/admin/queue/add">
                    @csrf
                    <div class="mb-3">
                        <input type="text" id="queue" name="queue" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection