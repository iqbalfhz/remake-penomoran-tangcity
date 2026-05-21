@extends('errors.layout')

@section('code', '404')
@section('title', 'Halaman Tidak Ditemukan')
@section('message', 'Halaman yang Anda cari tidak ditemukan, mungkin telah dipindahkan atau dihapus. Periksa kembali URL
    yang Anda masukkan.')

@section('icon')
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="#3b82f6" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
    </svg>
@endsection
