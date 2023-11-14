@props([
    'columns'
])
<div class="flex flex-col gap-8 md:flex-row">
    @for ($i = 1; $i <= $columns; $i++)
    <div class="md:flex-1">
        @yield('column-' . $i)
    </div>
    @endfor
</div>