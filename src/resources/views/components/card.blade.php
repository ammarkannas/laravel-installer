@inject('installer', 'Rwxrwx\Installer\Support\Installer')
@props(['title','route', 'step'])

<div class="card rounded-0 shadow-sm">
    <div class="card-header bg-transparent">
        <h4 class="m-0">
            {{ $title }}
        </h4>
    </div>

    <div class="card-body">
        {{ $slot }}
    </div>

    <div class="card-footer px-3 d-flex justify-content-between">
        @if($installer->hasBack($step))
            <a class="btn btn-secondary" href="{{ $installer->backRoute($step) }}">
                {{ __('Back') }}
            </a>
        @endif

        <span class="d-block"></span>

        <a class="btn btn-primary" href="{{ $installer->nextRoute($step) }}" id="next-step-btn">
            {{ __('Next') }}
        </a>
    </div>
</div>
