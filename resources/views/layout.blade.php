<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <title>Kalendas - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loader.css') }}">
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    
    <script src="{{ asset('js/formUtils.js') }}"></script>
    
    @section('head')
    @show
</head>

<body>
    <section class="row d-flex align-content-center justify-content-evenly bg-img bg-overlay full-screen">
    <img src="{{ asset('img/login_bg.jpg') }}">

    @section('header')
    <header class="d-flex justify-content-between bg-light bg-gradient">
        {{-- <h1 class="col title-font">Kalendas</h1> --}}
        <div>
            <img src="{{ asset('img/logo.png') }}" width="300px">
        </div>
    
        <form action="{{route('logout')}}" method="post" class="d-flex align-items-center">
            @csrf
            <a href="{{ route('settings') }}" class="btn btn-warning m-4">Settings</a>
            <button type="submit" class="btn btn-danger m-4">Log out</button>
        </form>
    </header>
    @show

    <main class="d-flex flex-column align-content-center justify-content-center center-content text-light">
        @yield('content')
    </main>

    @section('footer')
    <footer class="bg-dark text-light text-center">
        Copyright Kalendas 2021-22 All rights reserved
    </footer>
    @show

    <div class="loader">
        <div class="clock">
            <div class="minute-hand"></div>
            <div class="hour-hand"></div>
            <div class="round"></div>
        </div>
    </div>

</body>
