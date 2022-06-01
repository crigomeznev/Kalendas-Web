@extends('layout')

@section('title', 'Validate account')

@section('script')
@endsection

@section('header')
@endsection

@section('content')
    <h1>Validate your Kalendas account</h1>

    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    <form action="{{ route('register.confirm') }}" method="post">
        @csrf
        <input type="hidden" name="hash" value="{{$hash}}">
        <label for="email">
            Email:
            <input type="text" name="email" id="email" value="{{ $email }}" readonly>
        </label>

        <label for="password">
            Enter your password:
            <input type="password" name="password" id="password">
        </label>

        <button type="submit" class="btn btn-success">Validate account</button>
    </form>
@endsection

@section('footer')
@endsection