<div {{ $attributes->merge(['class'=>'w-full flex justify-center my-8 mt-4']) }}>
    <div {{ $attributes->merge(['class'=>'w-full max-w-7xl bg-white shadow-md rounded-md p-6']) }}>
        <table {{ $attributes->merge(['class'=>'w-full bg-white border border-gray-200']) }}>
            {{ $slot }}
        </table>
    </div>
</div>  