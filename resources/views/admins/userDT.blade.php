@extends('layouts.master')
@extends('layouts.datatables-style')
@extends('layouts.adminheader')
@section('title', 'User Management')
@section('content')
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <h2 class="display-3 fw-bolder my-5 text-center" style="font-family: 'Alfa Slab One', serif; color: #5F6F52;">
        User Management
    </h2>

    <div class="d-flex justify-content-center align-items-center mb-4">
        <!-- Add any action buttons here if needed -->
    </div>

    <div class="overflow">
        <table class="table table-bordered pt-3" id="users-table" style="font-family: 'Poppins', sans-serif;">
            <thead style="background: #5F6F52; color:#FEFAE0;">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

<!-- Change Status Modal -->
<div id="changeStatusModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="rounded-lg w-full max-w-sm mx-4 p-4" style="background:#5F6F52;">
        <div class="flex items-center justify-between border-b pb-2">
            <h5 class="text-lg font-semibold" style="color: #FEFAE0;">Change Status</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="py-4">
            <select id="newStatus" class="form-select w-full">
                <option value="active">Active</option>
                <option value="deactivate">Deactivate</option>
            </select>
        </div>
        <div class="flex justify-end border-t pt-2">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ml-2" id="saveStatusBtn">Save changes</button>
        </div>
    </div>
</div>

<!-- Change Type Modal -->
<div id="changeTypeModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
    <div class="rounded-lg w-full max-w-sm mx-4 p-4" style="background:#5F6F52;">
        <div class="flex items-center justify-between border-b pb-2">
            <h5 class="text-lg font-semibold" style="color: #FEFAE0;">Change Type</h5>
            <button type="button" class="text-gray-400 hover:text-gray-600" data-dismiss="modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div class="py-4">
            <select id="newType" class="form-select w-full">
                <option value="0">Admin</option>
                <option value="1">Customer</option>
            </select>
        </div>
        <div class="flex justify-end border-t pt-2">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary ml-2" id="saveTypeBtn">Save changes</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.tailwindcss.com"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
    let userId;

    const table = $('#users-table').DataTable({
        ajax: {
            url: '/api/users',
            dataSrc: 'data'
        },
        columns: [
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'email' },
            { data: 'status' },
            { data: 'type', render: function(data, type, row) {
                return data == 0 ? 'Admin' : 'Customer';
            }},
            { data: 'user_id', orderable: false, searchable: false, render: function(data, type, row) {
                    return '<button data-id="' + data + '" class="btn btn-sm btn-accent change-status">Change Status</button>'
                        + '<button data-id="' + data + '" class="btn btn-sm btn-error change-type">Change Type</button>';
                }
            },
        ]
    });

    // Function to show a modal
    function showModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    // Function to hide a modal
    function hideModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    $(document).on('click', '.change-status', function() {
        userId = $(this).data('id');
        showModal('changeStatusModal');
    });

    $('#saveStatusBtn').click(function() {
        const newStatus = $('#newStatus').val();
        $.ajax({
            url: '/api/users/change-status',
            method: 'POST',
            data: {
                user_id: userId,
                status: newStatus
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                hideModal('changeStatusModal');
                table.ajax.reload();
                alert(data.success);
            }
        });
    });

    $(document).on('click', '.change-type', function() {
        userId = $(this).data('id');
        $.ajax({
            url: '/api/users/details',
            method: 'POST',
            data: {
                user_id: userId
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                const user = data.user;
                $('#userAddress').text(user.address || 'N/A');
                $('#userImage').attr('src', user.image ? '/imgs/' + user.image : 'https://via.placeholder.com/100');

                showModal('changeTypeModal');
            }
        });
    });

    $('#saveTypeBtn').click(function() {
        const newType = $('#newType').val();
        $.ajax({
            url: '/api/users/change-type',
            method: 'POST',
            data: {
                user_id: userId,
                type: newType
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
                hideModal('changeTypeModal');
                table.ajax.reload();
                alert(data.message);
            }
        });
    });

    // Close modals when clicking on the close button or background
    $(document).on('click', '[data-dismiss="modal"]', function() {
        hideModal('changeStatusModal');
        hideModal('changeTypeModal');
    });
});

</script>
@endsection

