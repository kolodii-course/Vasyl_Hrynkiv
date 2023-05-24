@extends('sameadmin')

@section('title_name')
Queue rename
@endsection

@section('head_text')
Queue rename
@endsection

@section('forma')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form method="post" action="/admin/queue/rename">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <input type="text" name="queue" class="form-control" value="{{ $data->queue }}">
                    </div>
                    <div class="flex justify-between items-center mb-3">
                        <button type="submit" class="btn btn-warning">Rename</button>
                        <a href="/admin/queue" class="btn btn-primary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection