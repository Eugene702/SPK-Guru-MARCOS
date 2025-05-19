<button {{ $attributes->merge(['type' => 'submit', 'class' => 'p-3 rounded-xl w-full text-black bg-sidebar hover:bg-opacity-50 hover:transition-all hover:duration-300']) }}>
    {{ $slot }}
</button>
