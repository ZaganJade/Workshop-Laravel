@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Kategori </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.kategori') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Informasi Kategori</h4>
                <p class="card-description"> Perbarui nama kategori buku. </p>
                <form class="forms-sample" action="{{ route('admin.kategori.update', $kategori->idkategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control @error('nama_kategori') is-invalid @enderror" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Novel, Biografi" value="{{ old('nama_kategori', $kategori->nama_kategori) }}">
                        @error('nama_kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Perbarui</button>
                    <a href="{{ route('admin.kategori') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
