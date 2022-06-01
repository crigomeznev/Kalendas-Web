@extends('layout')

@section('title', "{$calendar->title} settings")

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

    <section class="row">
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ route('calendars.index') }}" class="btn btn-info"><i class="fa-solid fa-arrow-left-long"></i> Back to calendar</a>
            </div>
    
            <h2>{{ $calendar->title }} settings</h2>
            <div></div>
        </div>


        <div class="col">
            <h2>Helpers</h2>
            <table class="table table-striped">
                <thead class="table table-dark">
                    <tr>
                        <th>User</th>
                        <th colspan="2">Email</th>
                    </tr>
                </thead>

                <tbody class="table table-light table-striped">
                    @foreach ($calendar->helpers as $helper)
                        <tr>
                            <td>{{ $helper->user->name }}</td>
                            <td>{{ $helper->user->email }}</td>
                            <td>
                                {{-- <a href="{{ route('helpers.delete', ['destroyId' => $helper->id ]) }}">X</a> --}}
                                <form action="{{ route('helpers.destroy', $helper->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach


                    <form action="{{ route('helpers.store') }}" method="post">
                        @csrf
                        <tr class="table table-dark">
                            <td colspan="2">
                                <input type="text" name="newHelper" id="newHelper" list="nonHelpers" autocomplete="off"
                                    class="form-control">
                                <datalist id="nonHelpers">
                                    @foreach ($nonHelpers as $user)
                                        <option value="{{ $user->email }}">{{ $user->name }} {{ $user->lastname }}
                                        </option>
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <button type="submit" name="action" value="createHelper" class="btn btn-success">
                                    Add helper
                                </button>
                            </td>
                        </tr>
                    </form>

                </tbody>
            </table>
        </div>

        <div class="col">
            <h2>Targets</h2>
            <table class="table">
                <thead class="table table-dark">
                    <tr>
                        <th>Name</th>
                        <th colspan="2">Email</th>
                    </tr>
                </thead>

                <tbody class="table table-light table-striped">
                    @foreach ($calendar->targets as $target)
                        <tr>
                            <td>{{ $target->name }}</td>
                            <td>{{ $target->email }}</td>
                            <td>
                                <form action="{{ route('targets.destroy', $target->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">X</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    <form action="{{ route('targets.store') }}" method="post">
                        @csrf
                        <tr class="table-dark">
                            <td>
                                <input type="text" name="target_name" id="target_name" value="{{ old('target_name') }}"
                                    placeholder="Target name" class="form-control">
                            </td>
                            <td>
                                <input type="email" name="target_email" id="target_email"
                                    value="{{ old('target_email') }}" placeholder="Target email" class="form-control">
                            </td>
                            <td>
                                <input type="submit" class="btn btn-success" value="Add targets">
                            </td>
                        </tr>
                    </form>


                </tbody>
            </table>

            <form action="{{ route('targets.upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3 d-flex">
                    <div>
                        <label for="target_file" class="form-label">Select .csv file</label>
                        <input class="form-control" type="file" id="target_file" name="target_file">
                    </div>
                    <button type="submit" class="btn btn-success">Upload targets from .csv</button>
                </div>
            </form>
        </div>
    </section>

    <a href="{{ route('calendars.index') }}" class="btn btn-warning">Back to calendar</a>
@endsection


@section('footer')
    @parent
@endsection
