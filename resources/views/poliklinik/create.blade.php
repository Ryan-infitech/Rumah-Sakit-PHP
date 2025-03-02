<!-- create.blade.php -->
@extends('layout.admin')

@section('title', 'Tambah Poliklinik')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Tambah Poliklinik Baru</h6>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('poliklinik.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_poliklinik">Nama Poliklinik</label>
                <input type="text" name="nama_poliklinik" id="nama_poliklinik" class="form-control" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('poliklinik.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection