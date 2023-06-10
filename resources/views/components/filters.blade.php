@props(['objects' => [], 'type'])

@foreach($objects as $obj => $count)
<button type="button" class="btn btn-default"
        wire:click.prevent="filter('{{$type}}', '{{$obj}}')">
    <span class="mr-1">{{$obj}}</span>
    <span class="badge badge-pill badge-primary">{{$count}}</span>
</button>
@endforeach
