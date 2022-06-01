@extends('layout')

@section('title', 'Calendars')

@section('head')

    <link rel="stylesheet" href="{{ asset('css/powerful-calendar/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/powerful-calendar/theme.css') }}">

    {{-- JQuery powerful-calendar --}}
    <script src="{{ asset('js/powerful-calendar/calendar.min.js') }}"></script>

    <script src="{{ asset('js/calendar.js') }}"></script>
@endsection

@section('header')
    @parent
@endsection

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif

    <section class="row">
        <div class="row d-flex">
            <h2 class="display-4 col">{{ $calendar->title }}</h2>

            <div class="d-flex col">
                <label for="switchCalendar">
                    <p class="text-center">Switch calendar</p>
                    <input type="hidden" name="_curcalendar" value="{{ $calendar->id }}">
                    <select id="switchCalendar" class="form-select">
                        @if ($calendars->count() > 0)
                            <optgroup label="Your own calendars">
                                @foreach ($calendars as $cal)
                                    <option value="{{ $cal->id }}">{{ $cal->title }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                        @if ($user->helps->count() > 0)
                            <optgroup label="Subscribed calendars">
                                @foreach ($user->helps as $help)
                                    <option value="{{ $help->calendar->id }}">{{ $help->calendar->title }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                </label>
                <div class="m-2">
                    <a href="{{ route('calendars.edit', $calendar->id) }}" class="btn btn-warning text-center">
                        <i class="bi bi-gear-fill"></i><br>Calendar settings
                    </a>
                </div>
            </div>

        </div>

        </div>

        <div class="col m-4 d-flex flex-column align-items-center">
            <div id="calendar-wrapper" class="calendar-wrapper text-dark w-100"></div>
            @if (isset($selectedDate))
                <button type="button" id="unselectDate" class="btn btn-primary btn-gradient m-2">Clear date filter</button>
            @endif
        </div>

        <div class="col m-4">
            <input type="hidden" name="_selectedDate" value="{{ isset($selectedDate) ? $selectedDate : null }}">

            <h2>
                @if (isset($selectedDate))
                    Activities on {{ $selectedDate }}
                @else
                    All activities
                @endif
            </h2>

            <ul class="list-group">
                @foreach ($activities as $activity)
                    <li class="m-2">
                        <a href="{{ route('activities.edit', $activity->id) }}"
                            class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">{{ $activity->title }}</div>
                                {{ $activity->description }}
                            </div>
                            @if (!is_null($activity->category_id))
                                <span class="badge bg-primary rounded-pill me-2">{{ $activity->category->name }}</span>
                            @endif
                            <form action="{{ route('activities.destroy', $activity->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-rounded btn-icon bg-gradient">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </a>
                    </li>
                @endforeach
                <li class="m-2">
                    <a href="{{ route('activities.create') }}" class="btn btn-success list-group-item bg-gradient">New
                        activity</a>
                </li>


            </ul>
        </div>
    </section>
@endsection

@section('footer')
    @parent
@endsection
