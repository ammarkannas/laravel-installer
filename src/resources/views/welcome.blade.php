@inject('installer', 'Rwxrwx\Installer\Support\Installer')

@extends('installer::layout')

@section('content')
    <x-installer::card step="welcome">
        <x-slot name="title" >
            {{ __('Welcome to :app_name installation', ['app_name' => config('app.name')]) }}
        </x-slot>
        <p class="card-text">
            {{ __('Welcome to :app_name installation', ['app_name' => config('app.name')]) }}
        </p>
        <p class="card-text">
            {{ __('This will install :app_name :app_version on your server', ['app_name' => config('app.name'), 'app_version' => app()->version()]) }}
        </p>
        <p class="card-text">
            {{ __("it is recommended that to create a fresh database don't use already created database") }}
        </p>
        <p class="card-text">
            {{ __('Click Next to continue') }}
        </p>
    </x-installer::card>
@endsection
