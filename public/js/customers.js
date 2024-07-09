$(document).ready(function() {
    var table = $('#customersTable').DataTable({
        ajax: {
            url: '/api/customers',
            dataSrc: ''
        },
        columns: [
            { data: 'customer_id' },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'address' },
            { data: 'email' },
            {
                data: 'image',
                render: function(data) {
                    if (!data) return '';
                    var images = data.split(',');
                    return images.map(function(img) {
                        return `<img src="/imgs/${img}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">`;
                    }).join(' ');
                },
                defaultContent: ''
            },
            {
                // Render edit and delete buttons
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-primary editCustomer" data-id="${row.customer_id}">Edit</button>
                        <button class="btn btn-sm btn-danger deleteCustomer" data-id="${row.customer_id}">Delete</button>
                    `;
                }
            }
        ],
        // Specify datatype as 'json'
        dataType: 'json'
    });

    $('#createCustomer').on('click', function() {
        $('#customerModalLabel').text('Create Customer');
        $('#customerForm')[0].reset();
        $('#customerId').val(''); // Corrected the ID here
        $('#customerModal').modal('show');
    });

    $('#customerForm').on('submit', function(event) {
        event.preventDefault();
        var id = $('#customerId').val();
        var url = id ? `/api/customers/${id}` : '/api/customers';
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
            success: function(response) {
                $('#customerModal').modal('hide');
                table.ajax.reload();
                alert(id ? 'Customer updated successfully!' : 'Customer created successfully!');
            },
            error: function(xhr, status, error) {
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

    $('#customersTable').on('click', '.editCustomer', function() {
        var customerId = $(this).data('id');
        $.get(`/api/customers/${customerId}`, function(customer) {
            $('#customerModalLabel').text('Edit Customer');
            $('#first_name').val(customer.first_name);
            $('#last_name').val(customer.last_name);
            $('#address').val(customer.address);
            $('#email').val(customer.email);
            $('#customerId').val(customer.customer_id);
            // Display password length (hashed password length)
            var passwordLength = customer.password.length;
            $('#password').val('*'.repeat(passwordLength)); // Mask the password

            $('#customerModal').modal('show');
        });
    });

    $('#customersTable').on('click', '.deleteCustomer', function() {
        if (confirm('Are you sure you want to delete this customer?')) {
            var customerId = $(this).data('id');
            $.ajax({
                url: `/api/customers/${customerId}`,
                type: 'DELETE',
                dataType: 'json', // Ensure dataType is 'json'
                success: function(response) {
                    table.ajax.reload();
                    alert('Customer deleted successfully!');
                },
                error: function(response) {
                    alert('Error deleting customer!');
                }
            });
        }
    });
});
