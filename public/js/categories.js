$(document).ready(function() {
    var table = $('#categoriesTable').DataTable({
        ajax: {
            url: '/api/categories',
            dataSrc: ''
        },
        columns: [
            { data: 'category_id' },
            { data: 'name' },
            {
                data: 'category_id',
                render: function(data) {
                    return `<button class="btn btn-accent btn-sm edit" data-id="${data}">Edit</button>
                            <button class="btn btn-error btn-sm delete" data-id="${data}">Delete</button>`;
                }
            }
        ]
    });

    // Create Category Button Click Event
    $('#createCategory').click(function() {
        $('#categoryModalLabel').text('Create Category');
        $('#categoryForm')[0].reset();
        $('#categoryId').val('');
        $('#categoryModal').modal('show');
    });

    // Category Form Submit Event
    $('#categoryForm').submit(function(e) {
        e.preventDefault();
        var id = $('#categoryId').val();
        var url = id ? `/api/categories/${id}` : '/api/categories';
        var method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            dataType: 'json', // Expect JSON response
            success: function(response) {
                $('#categoryModal').modal('hide');
                table.ajax.reload(); // Reload DataTable on success
            },
            error: function(response) {
                alert('Error');
            }
        });
    });

    // Edit Category Button Click Event
    $('#categoriesTable tbody').on('click', '.edit', function() {
        var id = $(this).data('id');

        $.get(`/api/categories/${id}`, function(data) {
            $('#categoryModalLabel').text('Edit Category');
            $('#name').val(data.name);
            $('#categoryId').val(data.category_id);
            $('#categoryModal').modal('show');
        }, 'json'); // Specify 'json' for JSON response handling
    });

    // Delete Category Button Click Event
    $('#categoriesTable tbody').on('click', '.delete', function() {
        var id = $(this).data('id');

        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: `/api/categories/${id}`,
                method: 'DELETE',
                dataType: 'json', // Expect JSON response
                success: function(response) {
                    table.ajax.reload(); // Reload DataTable on success
                },
                error: function(response) {
                    alert('Error');
                }
            });
        }
    });
});
