@extends('errors.layout')

@section('code', '429')
@section('title', 'Terlalu Banyak Permintaan')
@section('message', 'Anda telah mengirimkan terlalu banyak permintaan dalam waktu singkat. Silakan tunggu beberapa saat
    sebelum mencoba kembali.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
    </svg>
@endsection
