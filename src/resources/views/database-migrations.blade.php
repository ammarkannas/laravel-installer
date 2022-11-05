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

    <x-installer::card step="database-migrations">
        <x-slot name="title">
            {{ __('Database setup step 2') }}
        </x-slot>

        <form action="{{ route(config('installer.steps.database-migrations') )}}" method="POST" id="database-migrations-form">
            @method('POST') @csrf
            <div id="result">
                <h5 class="card-text text-danger">
                    Warning
                </h5>
                <p class="card-text">
                    {{ __("it is recommended that to create a fresh database don't use already created database.") }}
                </p>
                <p class="card-text">
                    {{ __("this action will drop all tables and data in database ") }}
                </p>
                <p class="card-text text-danger badge">
                    {{ __("it is may take a long time please be patient don't refresh the page.") }}
                </p>
                <p class="card-text">
                    {{ __('Click Next to continue') }}
                </p>
            </div>
        </form>
    </x-installer::card>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.1.3/axios.min.js"></script>

    <script>
        nextBtn = document.getElementById('next-step-btn');
        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('database-migrations-form');

            nextBtn.className += ' disabled';
            nextBtn.setAttribute('disabled', 'disabled');

            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
            axios.post('{{ route(config('installer.steps.database-migrations') )}}', new FormData(form))
                .then(function (response) {
                    if(response.data.message) {
                        document.getElementById('result').innerHTML = "<textarea style='height: 280px;' class='form-control w-100'>"+response.data.message+"</textarea>";
                        setTimeout(function () {
                            window.location.href = {{ \Rwxrwx\Installer\Facades\Installer::nextRoute('database-migrations') }}
                        }, 20000);
                    }
                })
                .catch(function (error) {
                    document.getElementById('result').innerHTML = error;
                });
        });
    </script>
@endpush
