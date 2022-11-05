@inject('installer', 'Rwxrwx\Installer\Support\Installer')
@extends('installer::layout')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-unstyled m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-installer::card step="database-setup">
        <x-slot name="title">
            {{ __('Database setup') }}
        </x-slot>

        <form action="{{ route(config('installer.steps.database-setup') )}}" method="POST" id="database-setup-form">
            @method('PATCH') @csrf
            <div class="mb-3">
                <label for="db_connection">
                    Database Software
                </label>

                <select class="form-control" name="db_connection" id="db_connection">
                    @foreach($supportedDatabases as $software => $driver)
                        <option value="{{ $driver }}" {{ old('db_connection', env('DB_CONNECTION')) === $driver ? 'selected' : null }}>
                            {{ $software }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 row">
                <div class="col-8">
                    <label for="db_host" class="form-label small">
                        {{ __('Database host') }}
                    </label>

                    <input type="text" class="form-control" name="db_host" id="db_host" value="{{ old('db_host', env('DB_HOST')) }}">
                </div>

                <div class="col-4">
                    <label for="db_port" class="form-label small">
                        {{ __('Port') }}
                    </label>

                    <input type="text" class="form-control" name="db_port" id="db_port" value="{{ old('db_port', env('DB_PORT')) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="db_database" class="form-label small">
                    {{ __('Database name') }}
                </label>
                <input type="text" class="form-control" name="db_database" id="db_database" value="{{ old('db_database', env('DB_DATABASE')) }}">
            </div>

            <div class="mb-3">
                <label for="db_username" class="form-label small">
                    {{ __('Username') }}
                </label>
                <input type="text" class="form-control" name="db_username" id="db_username" value="{{ old('db_username', env('DB_USERNAME')) }}">
            </div>

            <div class="mb-3">
                <label for="db_password" class="form-label small">
                    {{ __('Password') }}
                </label>

                <input type="text" class="form-control" name="db_password" id="db_password" value="{{ old('db_password', env('DB_PASSWORD')) }}">
            </div>
        </form>
    </x-installer::card>
@endsection

@push('scripts')
    <script>
        nextBtn = document.getElementById('next-step-btn');
        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('database-setup-form').submit();
            nextBtn.className += ' disabled';
            nextBtn.setAttribute('disabled', 'disabled');
        });
    </script>
@endpush
