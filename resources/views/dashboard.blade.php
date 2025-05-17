@extends('layouts.app')

@section('content')
    <flux:main>
        <flux:heading size="xl" level="1">Bienvenido, {{ Auth::user()->nombre }}</flux:heading>
        <flux:text class="mb-6 mt-2 text-base">Aquí están tus herramientas</flux:text>
        <flux:separator variant="subtle" />
    </flux:main>
@endsection
