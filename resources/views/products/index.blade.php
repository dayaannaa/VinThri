@extends('layouts.master')

@section('title', 'Product Management')

@section('content')
    <h2>Products Management</h2>
    <button id="createProduct" class="btn btn-primary mb-3">Create Product</button>
    <table class="table table-bordered" id="productsTable" style="background-color: #FEFAE0;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Images</th>
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

    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" id="supplier_price" name="supplier_price" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_supplied" class="form-label">Date Supplied</label>
                            <input type="date" class="form-control" id="date_supplied" name="date_supplied" required>
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
    </div>

    <!-- View Supplies Modal -->
    <div class="modal fade" id="suppliesModal" tabindex="-1" aria-labelledby="suppliesModalLabel" aria-hidden="true">
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

    <div class ="card-body">
        <form action = "{{url('products')}}" method = "POST" enctype = "multipart/form-data">
            @csrf

            <div class = "input-group">
                <input type = "file" name = "importFile" class = "form-control"/>
                <button type = "submit" class = "btn btn-primary"> Import </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/products.js') }}"></script>
@endsection
