@inject('installer', 'Rwxrwx\Installer\Support\Installer')

@extends('installer::layout')

@section('content')
    <x-installer::card step="server-requirements">
        <x-slot name="title">
            {{ __('Server requirements') }}
        </x-slot>

        <ul class="list-group list-group-flush px-5">
            @foreach($requirements->except('error')->toArray() as $check => $pass)
                <li class="list-group-item p-1 d-flex justify-content-between">
                    <div class="small">
                        @if($check === 'phpversion')
                            <span class="{{ ! $pass ? 'text-danger' : null}}">
                                {{ __('PHP (Version :version or up is required)', ['version' => config('installer.php-version')]) }}
                            </span>
                        @else
                            <span class="{{ ! $pass ? 'text-danger' : null}}">
                                {{ $check }}
                            </span>
                        @endif
                    </div>

                    <span>
                        <i class="fa fa-{{ $pass === true ? 'check-square text-success' : 'xmark-square text-danger'}}"></i>
                    </span>
                </li>
            @endforeach
        </ul>
    </x-installer::card>
@endsection

@if($requirements->has('error'))
    @push('scripts')
        <script>
            nextBtn = document.getElementById('next-step-btn');
            nextBtn.className += ' disabled';
            nextBtn.setAttribute('disabled', 'disabled');
        </script>
    @endpush
@endif
