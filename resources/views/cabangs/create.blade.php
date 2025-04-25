@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>Tambah {{ ucfirst('Cabang') }}</h2>
            <form action="{{ route('cabangs.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label for="nama_cabang">Nama cabang</label>
                    <input type="text" name="nama_cabang" class="form-control" >
                    @error('nama_cabang')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="alamat_cabang">Alamat cabang</label>
                    <input type="text" name="alamat_cabang" class="form-control" >
                    @error('alamat_cabang')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="logo">Logo</label>
                    <input type="text" name="logo" class="form-control" >
                    @error('logo')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="kota_cabang">Kota cabang</label>
                    <input type="text" name="kota_cabang" class="form-control" >
                    @error('kota_cabang')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="no_kontak">No kontak</label>
                    <input type="text" name="no_kontak" class="form-control" >
                    @error('no_kontak')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" >
                    @error('deskripsi')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <input type="text" name="status" class="form-control" >
                    @error('status')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                <a href="{{ route('cabangs.index') }}" class="btn btn-secondary mt-3">Kembali</a>
            </form>
        </div>
    </div>
</div>
</div>
@endsection
