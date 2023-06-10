<p class="m-0 text-muted">{{ __('admin_layout.showing') }}
    <span>{{ $paginator->firstItem() }}</span> {{ __('admin_layout.to') }} <span>{{ $paginator->lastItem() }}</span>
    {{ __('admin_layout.of') }} <span>{{ $paginator->total() }}</span> {{ __('admin_layout.entries') }}</p>
<ul class="pagination m-0 ms-auto">
@if ($paginator->onFirstPage())
    <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                @if (app()->getlocale() == 'en')
                <polyline points="15 6 9 12 15 18"></polyline>
                @else
                <polyline points="9 6 15 12 9 18"></polyline>
                @endif
            </svg>
        </a>
    </li>
@else
    <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" aria-disabled="false">
            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                @if (app()->getlocale() == 'en')
                <polyline points="15 6 9 12 15 18"></polyline>
                @else
                <polyline points="9 6 15 12 9 18"></polyline>
                @endif
            </svg>
        </a>
    </li>
@endif
@foreach ($elements as $element)
@if (is_string($element))
    <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">{{ $element }}</a>
    </li>
@endif
@if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
    <li class="page-item active">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">{{ $page }}</a>
    </li>
@else
    <li class="page-item">
        <a class="page-link" href="{{ $url }}" tabindex="-1" aria-disabled="false">{{ $page }}</a>
    </li>
@endif
@endforeach
@endif
@endforeach
@if ($paginator->hasMorePages())
    <li class="page-item">
        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" tabindex="-1" aria-disabled="false">
            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                @if (app()->getlocale() == 'ar')
                <polyline points="15 6 9 12 15 18"></polyline>
                @else
                <polyline points="9 6 15 12 9 18"></polyline>
                @endif
            </svg>
        </a>
    </li>
@else
    <li class="page-item disabled">
        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                @if (app()->getlocale() == 'ar')
                <polyline points="15 6 9 12 15 18"></polyline>
                @else
                <polyline points="9 6 15 12 9 18"></polyline>
                @endif
            </svg>
        </a>
    </li>
@endif
</ul>
