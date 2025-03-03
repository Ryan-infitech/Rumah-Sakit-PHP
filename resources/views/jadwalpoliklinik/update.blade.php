<!-- update.blade.php -->

@extends('layout.admin')

@section('title', 'Update Jadwal Poliklinik')

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Update Jadwal Poliklinik</h1>

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

        <form action="{{ route('jadwalpoliklinik.update', $jadwalpoliklinik->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="dokter_id">Nama Dokter</label>
                <select name="dokter_id" id="dokter_id" class="form-control" required>
                    @foreach($dokter as $d)
                    <option value="{{ $d->id }}" {{ $d->id == $jadwalpoliklinik->dokter_id ? 'selected' : '' }}>
                        {{ $d->nama_dokter }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="tanggal_praktek">Tanggal Praktek</label>
                <input type="date" name="tanggal_praktek" id="tanggal_praktek" class="form-control" value="{{ $jadwalpoliklinik->tanggal_praktek }}" required>
            </div>

            <div class="form-group">
                <label for="jam_mulai">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="{{ $jadwalpoliklinik->jam_mulai }}" required>
            </div>

            <div class="form-group">
                <label for="jam_selesai">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="{{ $jadwalpoliklinik->jam_selesai }}" required>
            </div>

            <div class="form-group">
                <label for="jumlah">Jumlah Pasien</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" value="{{ $jadwalpoliklinik->jumlah }}" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('jadwalpoliklinik.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection