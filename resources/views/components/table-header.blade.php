<th {{ $attributes->merge([ 'class'=>'relative py-2 px-4 border-b text-left' ]) }}>
    <div {{ $attributes->only(['class'])->merge(['class'=>'relative']) }}>
        {{ $slot }}
    </div>

    <div {{ $attributes->merge(['class' => 'dropdown-menu hidden absolute z-10 mt-2 w-48 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5']) }}>
        {{ $slot }}
    </div>
</th>