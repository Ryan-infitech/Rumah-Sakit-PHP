<!-- update.blade.php -->
@extends('layout.admin')

@section('title', 'Edit Dokter')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Dokter</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('dokter.update', $dokter->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_dokter">Nama Dokter</label>
                <input type="text" name="nama_dokter" id="nama_dokter" class="form-control" required value="{{ $dokter->nama_dokter }}">
            </div>
            <div class="form-group">
                <label for="poliklinik_id">Nama Poliklinik</label>
                <select name="poliklinik_id" id="poliklinik_id" class="form-control" required>
                    @foreach($poliklinik as $item)
                        <option value="{{ $item->id }}" {{ $dokter->poliklinik_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_poliklinik }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="foto_dokter" class="form-label">Foto Profil</label>
                <input class="form-control" type="file" name="foto_dokter" id="foto_dokter">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('dokter.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection