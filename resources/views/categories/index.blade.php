@extends('layouts.master')
@extends('layouts.datatables-style')
@extends('layouts.adminheader')
@section('title', 'Categories')

@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />

    <h2 class="display-3 fw-bolder my-5" style="text-align: center; font-family: 'Alfa Slab One', serif; color: #5F6F52;">
        Categories</h2>

    <div class="d-flex justify-content-center align-items-center mb-3">
        <button id="createCategory" class="btn" onclick="categoryModal.showModal()"
            style="background: #5F6F52; font-family: 'Poppins', sans-serif; color:#FEFAE0; text-align:center">
            Create Category
        </button>
    </div>

    <div class="overflow">
        <table class="table pt-3" id="categoriesTable">
            <thead style="background: #5F6F52; color:#FEFAE0">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <dialog id="categoryModal" class="modal">
            <div class="modal-box" style="background:#5F6F52;">
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" style="color: #FEFAE0">✕</button>
                </form>
                <div class="modal-body">
                    <p class="modal-title"
                        style="text-align:center; font-family: 'Alfa Slab One', serif; color:#FEFAE0; font-size:24px; margin-bottom:3%"
                        id="categoryModalLabel">Category</p>
                    <form id="categoryForm">
                        <div class="mb-3">
                            <label for="name" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <input type="hidden" id="categoryId">
                        <button type="submit" class="btn btn-block"
                            style="font-family: 'Poppins', serif; color:#FEFAE0; background:#B99470; margin-top:5%">Save</button>
                    </form>
                </div>
            </div>
        </dialog>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/categories.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection
