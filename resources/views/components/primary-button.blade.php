<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-submit inline-flex items-center']) }}>
    {{ $slot }}
</button>
