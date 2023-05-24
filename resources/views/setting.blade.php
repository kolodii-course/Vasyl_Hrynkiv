@extends('same')

@section('title_name')
Setting
@endsection

@section('head_text')
Setting
@endsection

@section('first_content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
            <h5>Queue visibility</h5>
            @if($queues->isEmpty())
                <p>Nothing found :(</p>
            @else
            <form method="post" action="/setting/update">
                @csrf
                @foreach($queues as $item)
                    @if($settings->contains('queue_id', $item->id))
                        @foreach($settings as $sett)
                            @if($sett->queue_id == $item->id)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="{{$item->id}}" name="queues[]" 
                                    {{$sett->is_active == true ? 'checked' : ''}}>
                                    <label class="form-check-label" for="{{$item->id}}">
                                        {{$item->queue}}
                                    </label>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{$item->id}}" id="{{$item->id}}" name="queues[]" checked>
                            <label class="form-check-label" for="{{$item->id}}">
                                {{$item->queue}}
                            </label>
                        </div>
                    @endif
                @endforeach
                <button type="submit" class="btn btn-success">Save</button>
            </form>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection