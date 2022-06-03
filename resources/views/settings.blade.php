@extends('layout')

@section('title', 'Global settings')

@section('header')
    @parent
@endsection

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! Session::get('success') !!}</li>
            </ul>
        </div>
    @endif
    
    <section class="row d-flex justify-content-center">
        <h2 class="text-center m-3">Global settings</h2>

        <div class="col-md w-75 m-3">
            <h2 class="text-center">Your calendars</h2>
            <ul class="list-group text-center mt-4">
                @foreach ($user->calendars as $calendar)
                    <li><a class="list-group-item list-group-item-action"
                            href="{{ route('calendars.show', $calendar->id) }}">{{ $calendar->title }}</a></li>
                @endforeach
            </ul>
            <form action="{{ route('calendars.store') }}" method="post" class="bg-secondary p-2">
                @csrf
                <label for="title">
                    New calendar
                    <input type="text" name="title" id="title" placeholder="New calendar title..." class="form-control">
                </label>
                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i></button>
            </form>
        </div>

        <div class="col-md w-75 m-3">
            <h2 class="text-center">Subscribed calendars</h2>
            <ul class="list-group text-center mt-4">
                @foreach ($user->helps as $help)
                    <li><a class="list-group-item list-group-item-action text-center"
                        href="{{ route('calendars.show', $help->calendar->id) }}">{{ $help->user->name }}'s {{ $help->calendar->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md w-75 m-3">
            <h2 class="text-center">Categories</h2>
            <ul class="list-group text-center mt-4">
                @foreach ($categories as $category)
                    <li class="list-group-item list-group-action d-flex justify-content-between text-center">
                            <p>{{ $category->name }}</p>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit"><i class="fas fa-times"></i></button>
                            </form>
                    </li>
                @endforeach
                <form action="{{ route('categories.store') }}" method="post" class="bg-secondary p-2">
                    @csrf
                    <label for="cat_name" class="col">Name<br>
                        <input type="text" name="cat_name" id="cat_name" value="{{ old('cat_name') }}" placeholder="New category name..."
                            class="form-control">
                    </label>
                    <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i></button>
                </form>
                </table>
        </div>

        <div class="row d-flex justify-content-between">
            <fieldset class="col-md w-75 m-3">
                <legend>Google Calendar</legend>
                <a href="{{route('google.redirect')}}" class="btn btn-info bg-gradient">Connect your kalendas account with Google Calendar!</a>
            </fieldset>
            <div class="col"></div>
            <form method="post" action="{{route('activities.report')}}" class="col-md w-75 m-3">
                @csrf
                <legend>Jasper Report</legend>
                <button type="submit" class="btn btn-info bg-gradient">View your activities report!</button>
            </form>
        </div>
    </section>

@endsection


@section('footer')
    @parent
@endsection
