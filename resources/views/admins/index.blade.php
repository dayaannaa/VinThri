@extends('layouts.master')
@extends('layouts.datatables-style')
@section('title', 'Admin Management')
@include('admins.home')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />

    <h2 class="display-3 fw-bolder mb-6" style="text-align: center; font-family: 'Alfa Slab One', serif; color: #5F6F52;">
        System Admins</h2>
    <button id="createAdmin" class="btn d-flex justify-content-center align-items-center" onclick="adminModal.showModal()"
        style="background: #5F6F52; font-family: 'Poppins', sans-serif; color:#FEFAE0; margin-bottom:2%; text-align:center">Create
        Admin</button>
    <div class="overflow">
        <table class="table pt-3" id="adminsTable">
            <thead style="background: #5F6F52; color:#FEFAE0">
                <tr>
                    <th>ID</th>
                    <th>Profile</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <dialog id="adminModal" class="modal">
            <div class="modal-box" style="background:#5F6F52;">
                <div class="modal-body">
                    <p class="modal-title"
                        style="text-align:center; font-family: 'Alfa Slab One', serif; color:#FEFAE0; font-size:24px; margin-bottom:3%"
                        id="adminModalLabel">Admin</p>
                    <form id="adminForm">
                        <div class="mb-3">
                            <label for="images" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Images:</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="first_name" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">First Name:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                <div class="col-6">
                                    <label for="last_name" class="form-label"
                                        style="font-family: 'Poppins', serif; color:#FEFAE0">Last Name:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"
                                style="font-family: 'Poppins', serif; color:#FEFAE0">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <input type="hidden" id="adminId">
                        <div class="row pt-2">
                            <div class="col-8">
                                <button type="submit" class="btn btn-block"
                                    style="font-family: 'Poppins', serif; color:#FEFAE0; background:#B99470;">Save</button>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-block"
                                    style="font-family: 'Poppins', serif; color:#B99470; background:#FEFAE0;"
                                    onclick="closeModal()">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </dialog>


        <div class ="card-body">
            <form action = "{{ url('admins') }}" method = "POST" enctype = "multipart/form-data">
                @csrf

                <div class = "input-group">
                    <input type = "file" name = "importFile" class = "form-control" />
                    <button type = "submit" class = "btn"
                        style="font-family: 'Poppins', serif; color:#FEFAE0; background:#5F6F52;"> Import </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/admins.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
@endsection
