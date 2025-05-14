<button {{ $attributes->merge(['type' => 'submit', 'class' => 'p-3 rounded-xl w-full text-black bg-sidebar']) }}>
    {{ $slot }}
</button>
