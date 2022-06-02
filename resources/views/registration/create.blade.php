@extends('layout')

@section('title', 'Register')

@section('header')
<script src="{{ asset('js/passwordUtils.js') }}"></script>
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
                <label class="form-label" for="password">Password:</label>
                <strong id="passwordWarning" style="color:red; visibility:hidden;">Careful! Caps Lock is enabled!</strong>
                <div class="d-flex align-items-center">
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                    <label for="togglePassword" class="col-1">
                        <input type="checkbox" id="togglePassword" class="form-check-input">
                        Show
                    </label>
                </div>
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
