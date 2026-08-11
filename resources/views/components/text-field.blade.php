@props(['label', 'type' => 'text', 'name' => null, 'id' => null])

@php
    $name = $name ?? Str::slug($label);
    $id = $id ?? $name;
    // Never echo a password back into the markup on a failed submit.
    $value = $type === 'password' ? '' : old($name);
    $invalid = $errors->has($name);
@endphp

<div>
    <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">{{ $label }}</label>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" {{ $attributes->class([
        'mt-1.5 w-full rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring',
        'border-slate-300 focus:border-indigo-400 focus:ring-indigo-100' => ! $invalid,
        'border-red-400 focus:border-red-400 focus:ring-red-100' => $invalid,
    ]) }} />

    @error($name)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
