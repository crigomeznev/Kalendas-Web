@extends('layout')

@section('title', 'Register')

@section('header')
@endsection

@section('content')
    <section class="d-flex flex-column align-content-center justify-content-center">
        <h1 class="text-center display-1">Kalendas</h1>
        <h6 class="text-center display-6">Your calendar app</h6>
        <form action="{{ is_null($email)? route('register.store') : route('register.update', $email) }}" method="post">
            @csrf

            @if ($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
            @endif
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="name">Lastname:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ old('lastname') }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ is_null($email) ? old('email') : $email }}"
                    {{!is_null($email)? "readonly" : ""}}>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
            </div>
            <div class="form-group">
                <label for="repassword">Password again:</label>
                <input type="password" class="form-control" id="repassword" name="repassword"
                    value="{{ old('repassword') }}">
            </div>
            <div class="form-group">
                <label for="birthdate">Birthdate:</label>
                <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select name="gender" id="gender">
                    @foreach ($genders as $gender)
                        <option value="{{$gender}}">{{$gender}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <select name="country" id="country">
                    @foreach ($countries as $country)
                        <option value="{{$country->code}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </div>

            <hr>
            <input type="submit" value="Register now!" class="btn btn-success">
        </form>
    </section>
@endsection

@section('footer')
@endsection
