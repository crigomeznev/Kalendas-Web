@extends('layout')

@section('title', 'Edit activity')

@section('head')
    <script src="{{ asset('js/activity.js') }}"></script>
@endsection

@section('header')
    @parent
@endsection

@section('content')
    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ route('calendars.index') }}" class="btn btn-info"><i class="fa-solid fa-arrow-left-long"></i> Back to calendar</a>
        </div>

        <h1>Edit activity</h1>
        <form action="{{ route('activities.destroy', $activity->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash-can"></i> Delete activity</button>
        </form>
    </div>
    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    <form action="{{ route('activities.update', $activity->id) }}" method="post" class="bg-dark-transp w-75">
        @csrf
        @method('PUT')
        <fieldset class="p-4">
            <label for="title" class="row m-2">
                <h6 class="col-3">Title</h6>
                <div class="col">
                    <input type="text" name="title" id="title" value="{{ $activity->title }}"
                        class="form-control">
                </div>
            </label>

            <label for="category_id" class="row m-2">
                <h6 class="col-3">Category</h6>
                <div class="col d-flex">
                    <input type="hidden" name="_category_id" value="{{ old('category_id') }}">
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="{{null}}"></option>
                        @foreach ($user->categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <button type="button" id="clear" class="btn btn-secondary"><i class="fa-solid fa-eraser"></i></button>
                </div>
            </label>

            <label for="begins_at" class="row m-2">
                <h6 class="col-3">Begins at</h6>
                <div class="col d-flex">
                    <input type="datetime-local" name="begins_at" id="begins_at" value="{{$begins_at}}" class="form-control">
                </div>
            </label>

            <label for="ends_at" class="row m-2">
                <h6 class="col-3">Ends at</h6>
                <div class="col d-flex">
                    <input type="datetime-local" name="ends_at" id="ends_at" value="{{$ends_at}}" class="form-control">
                </div>
            </label>

            <hr>

            <label for="description" class="w-100">
                <h6 class="text-center">Description</h6>
                <textarea name="description" id="description" class="form-control" rows="5">{{ $activity->description }}</textarea>
            </label>

            <hr>
            <legend>Location</legend>
            <div class="row">
                <label for="latitude" class="col">
                    <h6>Latitude</h6>
                    <input type="number" name="latitude" id="latitude" value="{{ $activity->latitude }}" step="0.00000001" class="form-control">
                </label>
                <label for="longitude" class="col">
                    <h6>Latitude</h6>
                    <input type="number" name="longitude" id="longitude" value="{{ $activity->longitude }}"
                        step="0.00000001" class="form-control">
                </label>
            </div>

        </fieldset>

        <div class="d-flex justify-content-center bg-secondary p-2 mt-2">
            <button type="submit" class="btn btn-warning fw-bold text-center" title="Update activity">
                <i class="fa-solid fa-file-pen"></i> Update activity
            </button>
        </div>
    </form>

    <div class="bg-secondary d-flex justify-content-evenly pb-2 w-75">
        <form action="{{ route('activities.publish', $activity->id) }}" method="post">
            @csrf
            <button type="submit" class="btn btn-success fw-bold">Publish in Google Calendar!</button>
        </form>
    </div>


@endsection

@section('footer')
@parent
@endsection