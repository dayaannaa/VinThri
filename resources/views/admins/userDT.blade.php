<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container">
    <h2>User Management</h2>
    <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Status</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

{{-- MODEL TO AH YUNG NAG PA-POP UP PARA SA ANO TO CHANGE STATUS--}}
<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeStatusModalLabel">Change Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select id="newStatus" class="form-select">
          <option value="active">Active</option>
          <option value="deactivate">Deactivate</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

{{-- ETO NAMAN PARA SA ROLE--}}
<div class="modal fade" id="changeTypeModal" tabindex="-1" aria-labelledby="changeTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeTypeModalLabel">Change Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <select id="newType" class="form-select">
          <option value="0">Admin</option>
          <option value="1">Customer</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveTypeBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var userId;

    var table = $('#users-table').DataTable({
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
                    return '<button data-id="' + data + '" class="btn btn-primary btn-sm change-status">Change Status</button>'
                        + '<button data-id="' + data + '" class="btn btn-secondary btn-sm change-type">Change Type</button>';
                }
            },
        ]
    });

    $(document).on('click', '.change-status', function() {
        userId = $(this).data('id');
        $('#changeStatusModal').modal('show');
    });

    $('#saveStatusBtn').click(function() {
        var newStatus = $('#newStatus').val();
        $.ajax({
            url: '/api/users/change-status',
            method: 'POST',
            data: {
                user_id: userId,
                status: newStatus
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                $('#changeStatusModal').modal('hide');
                table.ajax.reload();
                alert(data.success);
            }
        });
    });

    $(document).on('click', '.change-type', function() {
        userId = $(this).data('id');
        $('#changeTypeModal').modal('show');
    });

    $('#saveTypeBtn').click(function() {
        var newType = $('#newType').val();
        $.ajax({
            url: '/api/users/change-type',
            method: 'POST',
            data: {
                user_id: userId,
                type: newType
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            dataType: 'json',
            success: function(data) {
                $('#changeTypeModal').modal('hide');
                table.ajax.reload();
                alert(data.success);
            }
        });
    });
});
</script>
</body>
</html>
