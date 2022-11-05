@inject('installer', 'Rwxrwx\Installer\Support\Installer')

@extends('installer::layout')

@section('content')
    <x-installer::card step="permissions">
        <x-slot name="title">
            {{ __('Permissions') }}
        </x-slot>

        <ul class="list-group list-group-flush px-4">
            @foreach($permissions->except('error')->toArray() as $folder => $pass)
                <li class="list-group-item p-1 d-flex justify-content-between">
                    <div class="small">
                        <div class="{{ ! $pass ? 'text-danger' : null}}">
                            <span class="badge bg-secondary">{{ config("installer.permissions")[$folder] }}</span>
                            <span class="mx-2">{{ $folder }}</span>
                        </div>
                    </div>

                    <span>
                        <i class="fa fa-{{ $pass === true ? 'check-square text-success' : 'xmark-square text-danger'}}"></i>
                    </span>
                </li>
            @endforeach
        </ul>
    </x-installer::card>
@endsection

@if($permissions->has('error'))
    @push('scripts')
        <script>
            nextBtn = document.getElementById('next-step-btn');
            nextBtn.className += ' disabled';
            nextBtn.setAttribute('disabled', 'disabled');
        </script>
    @endpush
@endif
