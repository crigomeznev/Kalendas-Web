@extends('layout')

@section('title', 'Global settings')

@section('header')
    @parent
@endsection

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif

    <section class="row">
        <h2 class="text-center">Global settings</h2>

        <div class="col">
            <h2>Your calendars</h2>
            <ul class="list-group">
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

        <div class="col">
            <h2>Subscribed calendars</h2>
            <ul class="list-group">
                @foreach ($user->helps as $help)
                    <li><a class="list-group-item list-group-item-action"
                        href="{{ route('calendars.show', $help->calendar->id) }}">{{ $help->user->name }}'s {{ $help->calendar->title }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col">
            <h2>Categories</h2>
            <ul class="list-group">
                @foreach ($categories as $category)
                    <li class="list-group-item list-group-action d-flex justify-content-between">
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

    </section>

@endsection


@section('footer')
    @parent
@endsection
