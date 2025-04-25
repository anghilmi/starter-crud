<!-- show.stub -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h3>{{ ucfirst(${{modelVariable}}->{{displayColumn}}) }} Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        @foreach(${{modelVariable}}->getAttributes() as $key => $value)
                            <tr>
                                <th>{{ ucfirst($key) }}</th>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('{{modelVariablePlural}}.index') }}" class="btn btn-secondary">Back to List</a>
                <a href="{{ route('{{modelVariablePlural}}.edit', ${{modelVariable}}->id) }}" class="btn btn-primary">Edit</a>
                <!-- Button to trigger the delete modal -->
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteAction('{{ route('{{modelVariablePlural}}.destroy', ${{modelVariable}}->id) }}')">
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Include Delete Modal -->
    @include('partials.delete-modal')
@endsection
