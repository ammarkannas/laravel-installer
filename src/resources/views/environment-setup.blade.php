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

    <x-installer::card step="environment-setup">
        <x-slot name="title">
            {{ __('Environment setup') }}
        </x-slot>

        <form action="{{ route(config('installer.steps.environment-setup') )}}" method="POST" id="environment-setup-form">
            @method('PATCH') @csrf
            <div class="mb-3">
                <label for="app_name" class="form-label small">
                    {{ __('Application name') }}
                </label>
                <input type="text" class="form-control" name="app_name" id="app_name" value="{{ old('app_name') ?? config('app.name') }}">
            </div>

            <div class="mb-3">
                <label for="app_url" class="form-label small">
                    {{ __('Application url') }}
                </label>
                <input type="text" class="form-control" name="app_url" id="app_url" value="{{ old('app_url') ?? config('app.url') }}">
            </div>

            <div class="mb-3">
                <div>
                    App Debug
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                           type="radio"
                           name="app_debug"
                           id="app_debug_true"
                           value="true" {{ (old('app_debug') || env('app_debug')) === true ? 'checked' : null }}>
                    <label class="form-check-label" for="app_debug_true">True</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input"
                           type="radio"
                           name="app_debug"
                           id="app_debug_false"
                           value="false" {{ (old('app_debug') || env('app_debug')) === false ? 'checked' : null }}>
                    <label class="form-check-label" for="app_debug_false">False</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="log_level">
                   Log Level
                </label>

                <select class="form-control" name="log_level" id="log_level">
                    @foreach(['debug', 'info', 'notice', 'warning', 'error', 'critical', 'alert', 'emergency'] as $level)
                        <option value="{{ $level }}" {{ old('log_level', env('LOG_LEVEL')) === $level ? 'selected' : null }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>

        </form>
    </x-installer::card>
@endsection

@push('scripts')
    <script>
        nextBtn = document.getElementById('next-step-btn');
        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('environment-setup-form').submit();
            nextBtn.className += ' disabled';
            nextBtn.setAttribute('disabled', 'disabled');
        });
    </script>
@endpush
