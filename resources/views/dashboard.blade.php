@extends('layouts.app')


@section('content')
    <flux:main>
        <flux:heading size="xl" level="1">Bienvenido, {{ Auth::user()->nombre }}</flux:heading>
        <flux:separator variant="subtle" />
    </flux:main>
@endsection
