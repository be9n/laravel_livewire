<div
    x-data
{{--    ="{value:  @entangle($attributes->wire('model')) }"--}}

    x-init="new Pikaday({ field: $refs.input, format: 'YYYY-MM-DD' })"

    class="input-group mb-3">
    <div class="input-group-prepend">
        <span x-on:click="$refs.input.click()" style="cursor: pointer" class="input-group-text"><i
                class="fas fa-calendar"></i></span>
    </div>

    <input @change.prevent="$dispatch('input', $event.target.value)"
           {{ $attributes }}
           x-ref="input"
{{--           x-bind:value="value"--}}
           readonly
           style="cursor: pointer"
    >
    @error('date')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endpush

@push('js')
    <script src="https://unpkg.com/moment"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush
