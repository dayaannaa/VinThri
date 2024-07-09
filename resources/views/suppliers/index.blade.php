@extends('layouts.master')

@section('title', 'Supplier Management')

@section('content')
    <h2>Supplier Management</h2>
    <button id="createSupplier" class="btn btn-success mb-3">Create Supplier</button>
    <table class="table table-bordered" id="suppliersTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
            <th>Images</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierModalLabel">Create Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Images</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                        </div>
                        <input type="hidden" id="supplier_id">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/supplier.js') }}"></script>
@endsection
