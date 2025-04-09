<div class="{{ $icon->classes }}">
    @php
        $name = $icon->icon(get_defined_vars());
    @endphp
    @pixelicon($name)
</div>
