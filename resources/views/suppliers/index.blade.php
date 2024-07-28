@extends('layouts.master')
@extends('layouts.datatables-style')
@section('title', 'Supplier Management')
@include('admins.home')
@section('content')
<title>Supplier Management</title>
<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />

    <h2 class="display-3 fw-bolder my-5" style="text-align: center; font-family: 'Alfa Slab One', serif; color: #5F6F52;">
        Supplier Management</h2>

    <div class="d-flex justify-content-center align-items-center">
        <button id="createSupplier" class="btn" onclick="supplierModal.showModal()"
            style="background: #5F6F52; font-family: 'Poppins', sans-serif; color:#FEFAE0; margin-right:1%; text-align:center">
            Add Supplier
        </button>
        <button id="importAdmin" class="btn" onclick="importSupplier.showModal()"
            style="background: #5F6F52; font-family: 'Poppins', sans-serif; color:#FEFAE0; text-align:center">
            Import Supplier
        </button>
    </div>

    <div class="overflow">
        <table class="table pt-3" id="suppliersTable">
            <thead style="background: #5F6F52; color:#FEFAE0">
                <tr>
                    <th>ID</th>
                    <th>Images</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <dialog id="supplierModal" class="modal">
            <div class="modal-box" style="background:#5F6F52;">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" style="color: #FEFAE0">✕</button>
                </form>
                <div class="modal-body">
                    <p class="modal-title pb-4"
                        style="text-align:center; font-family: 'Alfa Slab One', serif; color:#FEFAE0; font-size:24px; margin-bottom:3%"
                        id="supplierModalLabel">Supplier</p>
                    <form id="supplierForm" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="images" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Images:</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                        </div>
                        <div class="mb-3">
                            <label for="first_name" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        
                        <input type="hidden" id="supplier_id">
                        <button type="submit" class="btn btn-block"
                            style="font-family: 'Poppins', serif; color:#FEFAE0; background:#B99470; margin-top:5%">Save</button>
                    </form>
                </div>
            </div>
        </dialog>

        <dialog id="importSupplier" class="modal">
            <div class="modal-box" style="background:#5F6F52;">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        style="color: #FEFAE0">✕</button>
                </form>
                <div class="modal-body">
                    <p class="modal-title pb-4"
                        style="text-align:center; font-family: 'Alfa Slab One', serif; color:#FEFAE0; font-size:24px; margin-bottom:3%"
                        id="importSupplierLabel">Import Supplier</p>
                    <form action="{{ url('suppliers') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="file" class="file-input w-full max-w-xs" name="importFile"
                                style="color:#5F6F52; background:#FEFAE0; font-family: 'Poppins', serif" />
                            <button type="submit" class="btn ml-3"
                                style="font-family: 'Poppins', serif; color:#FEFAE0; background:#B99470;">Import</button>
                        </div>
                    </form>
                </div>
            </div>
        </dialog>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/supplier.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection