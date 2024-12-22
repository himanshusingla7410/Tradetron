<ul {{ $attributes->merge(['class'=>'py-1']) }}>
    <li>
        <button {{ $attributes->merge([
            'type'=>'button', 
            'class'=>'block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100'
        ]) }}>
            {{ $slot }}
        </button>
    </li>
</ul>
