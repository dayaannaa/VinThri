@extends('layouts.master')
@extends('layouts.datatables-style')
@section('title', 'Product Management')
@include('admins.home')
@section('content')
<title>Product Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />

    <h2 class="display-3 fw-bolder my-5" style="text-align: center; font-family: 'Alfa Slab One', serif; color: #5F6F52;">
        Product Management</h2>

    <div class="d-flex justify-content-center align-items-center">
        <button id="createProduct" class="btn" onclick="productModal.showModal()"
            style="background: #5F6F52; font-family: 'Poppins', sans-serif; color:#FEFAE0; margin-right:1%; text-align:center">
            Create Product
        </button>
        <button id="importAdmin" class="btn" onclick="importProduct.showModal()"
            style="background: #5F6F52; font-family: 'Poppins', sans-serif; color:#FEFAE0; text-align:center">
            Import Product
        </button>
    </div>

    {{-- <button id="createProduct" class="btn btn-primary mb-3">Create Product</button> --}}
    <div class="overflow">
        <table class="table pt-3" id="productsTable">
            <thead style="background: #5F6F52; color:#FEFAE0">
                <tr>
                    <th>ID</th>
                    <th>Images</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Supplier Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Supplier</th>
                    <th>Stock</th>
                    <th>Date Supplied</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <dialog id="productModal" class="modal">
            <div class="modal-box" style="background:#5F6F52;">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" style="color: #FEFAE0">✕</button>
                </form>
                <div class="modal-body">
                    <p class="modal-title pb-4"
                        style="text-align:center; font-family: 'Alfa Slab One', serif; color:#FEFAE0; font-size:24px; margin-bottom:3%"
                        id="productModalLabel">Product</p>
                    <form id="productForm">
                        <div class="mb-3">
                            <label for="images" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Images:</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="price" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Selling Price:</label>
                                    <input type="text" class="form-control" id="price" name="price" required>
                                </div>
                                <div class="col-6">
                                    <label for="supplier_price" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Supplier Price:</label>
                                    <input type="text" class="form-control" id="supplier_price" name="supplier_price"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Description:</label>
                            <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="date_supplied" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Date Supplied:</label>
                                    <input type="date" class="form-control" id="date_supplied" name="date_supplied"
                                        required>
                                </div>
                                <div class="col-6">
                                    <label for="category_id" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Category:</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-9">
                                    <label for="supplier_id" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Supplier:</label>
                                    <select class="form-select" id="supplier_id" name="supplier_id" required>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="stock" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Stock:</label>
                                    <input type="text" class="form-control" id="stock" name="stock" required>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="productId">
                        <button type="submit" class="btn btn-block"
                            style="font-family: 'Poppins', serif; color:#FEFAE0; background:#B99470; margin-top:5%">Save</button>
                    </form>
                </div>
            </div>
        </dialog>

        <dialog id="importProduct" class="modal">
            <div class="modal-box" style="background:#5F6F52;">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                        style="color: #FEFAE0">✕</button>
                </form>
                <div class="modal-body">
                    <p class="modal-title pb-4"
                        style="text-align:center; font-family: 'Alfa Slab One', serif; color:#FEFAE0; font-size:24px; margin-bottom:3%"
                        id="adminModalLabel">Import Product</p>
                    <form action = "{{ url('products') }}" method = "POST" enctype = "multipart/form-data">
                        @csrf
                        <div class="d-flex justify-content-center align-items-center">
                            <input type="file" class="file-input w-full max-w-xs" name = "importFile"
                                style="color:#5F6F52; background:#FEFAE0; font-family: 'Poppins', serif" />
                            <button type = "submit" class = "btn ml-3"
                                style="font-family: 'Poppins', serif; color:#FEFAE0; background:#B99470;">Import </button>
                        </div>
                    </form>
                </div>
            </div>
        </dialog>

        <!-- <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="productForm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Selling Price</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label for="supplier_price" class="form-label">Supplier Price</label>
                                <input type="text" class="form-control" id="supplier_price" name="supplier_price"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="date_supplied" class="form-label">Date Supplied</label>
                                <input type="date" class="form-control" id="date_supplied" name="date_supplied"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select class="form-select" id="supplier_id" name="supplier_id" required>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="text" class="form-control" id="stock" name="stock" required>
                            </div>

                            <div class="mb-3">
                                <label for="images" class="form-label">Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                            </div>

                            <input type="hidden" id="productId">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>  -->

        <!-- View Supplies Modal -->
        <div class="modal fade" id="suppliesModal" tabindex="-1" aria-labelledby="suppliesModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="suppliesModalLabel">Product Supplies</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered" id="suppliesTable">
                            <thead>
                                <tr>
                                    <th>Date Supplied</th> <!-- Updated column header -->
                                    <th>Supplier Price</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

         <!-- <form action = "{{ url('products') }}" method = "POST" enctype = "multipart/form-data">
            @csrf

            <div class = "input-group">
                <input type = "file" name = "importFile" class = "form-control" />
                <button type = "submit" class = "btn btn-primary"> Import </button>
            </div>
        </form>  -->

    @endsection

    @section('scripts')
        <script src="{{ asset('js/products.js') }}"></script>
    @endsection
