@extends('layout')

@section('title', 'Validate account')

@section('script')
@endsection

@section('header')
<script src="{{ asset('js/passwordUtils.js') }}"></script>
@endsection

@section('content')
    <h1 class="text-center">Validate your Kalendas account</h1>

    @if ($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    <form action="{{ route('register.confirm') }}" method="post" class="d-flex flex-column align-items-center justify-content-center">
        @csrf
        <input type="hidden" name="hash" value="{{$hash}}">

        <table>
            <tr>
                <td>
        <div class="form-group">
            <label for="email">
                Email:
                <input type="text" name="email" id="email" value="{{ $email }}" readonly class="form-control">
            </label>
        </div>
</td></tr>
<tr><td>

                        <label class="form-label" for="password">Enter your password:</label>
                        <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
                        <strong id="passwordWarning" style="color:red; visibility:hidden;">Careful! Caps Lock is enabled!</strong>
                        </label>
                </td>
                <td>
                <label for="togglePassword" class="col-1" class="m-2">
                                    <input type="checkbox" id="togglePassword" class="form-check-input">
                                    Show
                                </label>

            </td>

            </tr>
            <tr>
                <td>
                    <button type="submit" class="btn btn-success">Validate account</button>
                </td>
            </tr>
        </table>
    </form>
@endsection

@section('footer')
@endsection