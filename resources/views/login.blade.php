<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kalendas - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
</head>

<body>
    <section class="row d-flex align-content-center justify-content-evenly bg-img bg-overlay full-screen">
        <img src="{{ asset('img/login_bg.jpg') }}">
        <div class="col-md d-flex justify-content-center align-items-center">
            <img src="{{ asset('img/logo.png') }}" width="600px">
        </div>

        <div class="col-md">
            <form action="{{ route('login') }}" method="post" class="card bg-dark text-white bg-transp m-5">
                @csrf

                @if ($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{!! Session::get('success') !!}</li>
                        </ul>
                    </div>
                @endif


                <div class="card-body p-5 text-center">

                    <div class="mb-md-5 mt-md-4 pb-5">

                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                        <p class="text-white-50 mb-5">Please enter your login and password!</p>

                        <div class="form-outline form-white mb-4">
                            <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" />
                            <label class="form-label" for="typeEmailX">Email</label>
                        </div>

                        <div class="form-outline form-white mb-4">
                            <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                            <label class="form-label" for="typePasswordX">Password</label>
                        </div>

                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                    </div>

                    <div>
                        <p class="mb-0">Don't have an account? <a href="{{route('register.create')}}" class="text-white-50 fw-bold">Sign
                                Up</a>
                        </p>
                    </div>

                </div>


            </form>
        </div>

        {{-- <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
              <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                </div>
              </div>
            </div>
          </section>
          
        <div class="col-md d-flex flex-column justify-content-center">
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control m-4"
                    placeholder="Type your email">

                <input type="password" name="password" id="password" class="col form-control"
                    placeholder="Type your password">

                    <input type="submit" value="Log in" class="btn btn-success">

                <a href="{{ route('register.create') }}" class="btn btn-success">Register</a>
            </form> --}}
        {{-- </div> --}}
    </section>


</body>
