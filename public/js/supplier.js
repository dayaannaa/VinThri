$(document).ready(function() {
    var table = $('#suppliersTable').DataTable({
        ajax: {
            url: '/api/suppliers',
            dataSrc: ''
        },
        columns: [
            { data: 'supplier_id' },
            {
                data: 'image',
                render: function(data) {
                    if (!data) return '';
                    return data.split(',').map(image =>
                        `<img src="/imgs/${image}" class="mask mask-squircle w-24" style="max-width: 100px; max-height: 100px; margin-right: 5px;">`
                    ).join('');
                }
            },
            { data: 'first_name' },
            { data: 'last_name' },
            { data: 'address' },
            
            {
                data: 'supplier_id',
                render: function(data) {
                    return `<button class="btn btn-accent btn-sm edit" data-id="${data}" onclick="supplierModal.showModal()">Edit</button>
                            <button class="btn btn-error btn-sm delete" data-id="${data}">Delete</button>`;
                }
            }
        ]
    });

    $('#createSupplier').click(function() {
        $('#supplierModalLabel').text('Create Supplier');
        $('#supplierForm')[0].reset();
        $('#supplier_id').val('');
        $('#supplierModal').modal('show');
    });


    $('#supplierForm').submit(function(e) {
        e.preventDefault();
        var id = $('#supplier_id').val();
        var url = id ? `/api/suppliers/${id}` : '/api/suppliers';
        var method = id ? 'POST' : 'POST';

        var formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            method: method,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            datatype: JSON,
            success: function(response) {
                $('#supplierModal').modal('hide');
                table.ajax.reload();
            },
            error: function(response) {
                alert('Error');
            }
        });
    });

    $('#suppliersTable tbody').on('click', '.edit', function() {
        var id = $(this).data('id');

        $.get(`/api/suppliers/${id}`, function(data) {
            $('#supplierModalLabel').text('Edit Supplier');
            $('#first_name').val(data.first_name);
            $('#last_name').val(data.last_name);
            $('#address').val(data.address);
            $('#supplier_id').val(data.supplier_id);
            $('#supplierModal').modal('show');
        }, 'json'); // Specify 'json' for JSON response handling
    });

    $('#suppliersTable tbody').on('click', '.delete', function() {
        var id = $(this).data('id');

        if (confirm('Are you sure you want to delete this supplier?')) {
            $.ajax({
                url: `/api/suppliers/${id}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    table.ajax.reload();
                },
                error: function(response) {
                    alert('Error');
                }
            });
        }
    });
});
