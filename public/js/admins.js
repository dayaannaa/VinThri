$(document).ready(function () {
    var table = $('#adminsTable').DataTable({
        ajax: {
            url: '/api/admins',
            dataSrc: ''
        },
        columns: [
            {
                data: 'admin_id',
                className: 'td'
            },
            {
                data: 'image',
                render: function (data) {
                    if (!data) return '';
                    var images = data.split(',');
                    return images.map(function (img) {
                        return `<img src="/imgs/${img}" class="mask mask-squircle" style="max-width: 100px; max-height: 100px;">`;
                    }).join(' ');
                },
                defaultContent: '',
                className: 'td'
            },
            {
                data: 'first_name',
                className: 'td'
            },
            {
                data: 'last_name',
                className: 'td'
            },
            {
                data: 'address',
                className: 'td'
            },
            {
                data: 'email',
                className: 'td'
            },
            {
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-accent editAdmin" data-id="${row.admin_id}" onclick="adminModal.showModal()">Edit</button>
                        <button class="btn btn-sm btn-error deleteAdmin" data-id="${row.admin_id}">Delete</button>
                    `;
                },
                className: 'td'
            }
        ],
        // Specify datatype as 'json'
        dataType: 'json'
    });

    $('#createAdmin').on('click', function () {
        $('#adminModalLabel').text('Create Admin');
        $('#adminForm')[0].reset();
        $('#adminId').val(''); // Corrected the ID here
        $('#adminModal').modal('show');
    });

    $('#adminForm').on('submit', function (event) {
        event.preventDefault();
        var id = $('#adminId').val();
        var url = id ? `/api/admins/${id}` : '/api/admins';
        var formData = new FormData(this);

        if (id) {
            formData.append('_method', 'PUT'); // Use PUT for updating
        }

        $.ajax({
            url: url,
            method: 'POST', // Always use POST for the actual request
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#adminModal').modal('hide');
                table.ajax.reload();
                alert(adminId ? 'Admin updated successfully!' : 'Admin created successfully!');
            },
            error: function (xhr, status, error) {
                var errorMessage = 'Error: Failed to process the request.';
                if (xhr.status === 422) { // Handle validation errors
                    var errors = xhr.responseJSON.errors;
                    var errorMessages = Object.values(errors).flat(); // Flatten nested arrays of errors
                    errorMessage += '\nValidation Errors:\n' + errorMessages.join('\n');
                } else if (xhr.status === 500) { // Handle server errors
                    errorMessage += '\nServer Error: ' + xhr.responseText;
                } else { // Default error handling
                    errorMessage += '\nHTTP Status: ' + xhr.status + ' ' + xhr.statusText;
                }
                alert(errorMessage);
            }
        });
    });

    $('#adminsTable').on('click', '.editAdmin', function () {
        var adminId = $(this).data('id');
        $.get(`/api/admins/${adminId}`, function (admin) {
            $('#adminModalLabel').text('Edit Admin');
            $('#first_name').val(admin.first_name);
            $('#last_name').val(admin.last_name);
            $('#address').val(admin.address);
            $('#email').val(admin.email);
            $('#adminId').val(admin.admin_id);
            // Display password length (hashed password length)
            var passwordLength = admin.password.length;
            $('#password').val('*'.repeat(passwordLength)); // Mask the password

            $('#adminModal').modal('show');
        });
    });

    $('#adminsTable').on('click', '.deleteAdmin', function () {
        if (confirm('Are you sure you want to delete this admin?')) {
            var adminId = $(this).data('id');
            $.ajax({
                url: `/api/admins/${adminId}`,
                type: 'DELETE',
                dataType: 'json', // Ensure dataType is 'json'
                success: function (response) {
                    table.ajax.reload();
                    alert('Admin deleted successfully!');
                },
                error: function (response) {
                    alert('Error deleting admin!');
                }
            });
        }
    });
});

function closeModal() {
    document.getElementById('adminModal').close();
}
