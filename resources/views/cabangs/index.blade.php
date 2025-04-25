@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h2>{{ ucfirst('cabangs') }}</h2>
            <a href="{{ route('cabangs.create') }}" class="btn btn-primary mb-3">Tambah {{ ucfirst('Cabang') }}</a>
            <form action="{{ route('cabangs.index') }}" method="GET" class="form-inline mb-3">
                <input type="text" name="search" class="form-control mr-2" placeholder="Cari..." value="{{ request()->get('search') }}">
                <a class="btn btn-outline-secondary mr-1" href="{{ route('cabangs.index') }}">X</a>
                <button type="submit" class="btn btn-outline-secondary">Cari</button>
                {{-- <a href="{{ route('cabangs.export') }}" class="btn btn-success ml-2">Export ke Excel</a> --}}
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ str_replace('_', ' ', ucfirst('nama_cabang')) }}</th><th>{{ str_replace('_', ' ', ucfirst('alamat_cabang')) }}</th><th>{{ str_replace('_', ' ', ucfirst('logo')) }}</th><th>{{ str_replace('_', ' ', ucfirst('kota_cabang')) }}</th><th>{{ str_replace('_', ' ', ucfirst('no_kontak')) }}</th><th>{{ str_replace('_', ' ', ucfirst('deskripsi')) }}</th><th>{{ str_replace('_', ' ', ucfirst('status')) }}</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cabangs as $Cabang)
                    <tr>
                        <td>{{ $Cabang->nama_cabang }}</td><td>{{ $Cabang->alamat_cabang }}</td><td>{{ $Cabang->logo }}</td><td>{{ $Cabang->kota_cabang }}</td><td>{{ $Cabang->no_kontak }}</td><td>{{ $Cabang->deskripsi }}</td><td>{{ $Cabang->status }}</td><td>
            <a href="{{ route('cabangs.edit', $Cabang->id) }}" class="btn btn-warning">Edit</a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal{{ $Cabang->id }}" >Delete</button>

            <!-- resources/views/partials/delete-modal.blade.php -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal{{$Cabang->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item: <strong>{{$Cabang->id}}</strong> ?
            </div>
            <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <form id="deleteForm" method="POST" action="{{ route('cabangs.destroy', $Cabang->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Script to set the action of the delete form dynamically
    function setDeleteAction(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
    }
</script>

            
        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Display pagination links -->
            Jumlah Data : {{ $cabangs->total() }} <br/>
        <div class="d-flex justify-content-center">
            {{ $cabangs->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
        </div>
    </div>
</div>

@endsection
