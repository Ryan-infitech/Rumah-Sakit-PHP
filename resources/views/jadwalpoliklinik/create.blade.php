<!-- create.balde.php -->
@extends('layout.admin')

@section('title', 'Tambah Jadwal Poliklinik')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Tambah Jadwal Poliklinik</h1>

<div class="card shadow mb-4">
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('jadwalpoliklinik.add') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="dokter_id">Nama Dokter</label>
                <select name="dokter_id" id="dokter_id" class="form-control" required>
                    <option value="">Pilih Dokter</option>
                    @foreach ($dokter as $item)
                    <option value="{{ $item->id }}">{{ $item->nama_dokter }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_praktek">Tanggal Praktek</label>
                <input type="date" name="tanggal_praktek" id="tanggal_praktek" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Pasien</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('jadwalpoliklinik.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
