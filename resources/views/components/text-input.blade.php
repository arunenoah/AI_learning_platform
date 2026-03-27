@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 focus:border-primary-500 focus:ring-primary-500 rounded-lg shadow-sm text-slate-900 placeholder-slate-400 text-sm px-4 py-2.5 transition']) }}>
