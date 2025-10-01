@props(['active' => false])
<a class="{{ $active ? 'bg-teal-700 text-white' : 'text-white hover:bg-teal-600 hover:text-white' }} rounded-md px-3 py-2 text-sm font-medium"
    aria-current="{{ $active ? 'page' : 'false' }}" {{ $attributes }}>
    {{ $slot }}
</a>
