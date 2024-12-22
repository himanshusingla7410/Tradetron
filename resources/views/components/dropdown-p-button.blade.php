<button {{ $attributes->merge([
        'type'=>'button', 
        'class'=>'inline-flex justify-center gap-x-1.5 text-m font-semibold text-gray-900 hover:bg-gray-50',
        'aria-expanded'=> 'false',
        'aria-haspopup'=> 'true'
    ]) }}>
        {{ $slot }}
</button>