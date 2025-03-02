@extends('layout.admin')

@section('title', 'Edit Poliklinik')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Edit Poliklinik</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('poliklinik.update', $poliklinik->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="nama_poliklinik">Nama Poliklinik</label>
                <input type="text" name="nama_poliklinik" id="nama_poliklinik" class="form-control" required value="{{ $poliklinik->nama_poliklinik }}">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('poliklinik.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection