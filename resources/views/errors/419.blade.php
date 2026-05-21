@extends('errors.layout')

@section('code', '419')
@section('title', 'Sesi Kedaluwarsa')
@section('message', 'Sesi Anda telah berakhir karena tidak aktif dalam waktu lama. Silakan muat ulang halaman dan coba
    lagi.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#f59e0b" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
@endsection
