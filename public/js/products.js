$(document).ready(function() {
    var table = $('#productsTable').DataTable({
        ajax: {
            url: '/api/products',
            dataSrc: ''
        },
        columns: [
            { data: 'product_id' },
            {
                data: 'images',
                render: function(data) {
                    if (!data) return '';
                    return data.split(',').map(image =>
                        `<img src="/imgs/${image}" class="img-thumbnail mask mask-hexagon-2" style="max-width: 100px; max-height: 100px; margin-right: 5px;">`
                    ).join('');
                }
            },
            { data: 'name' },
            { data: 'price' },
            {
                data: 'productsupplies',
                render: function(data) {
                    if (!data || data.length === 0) return '-';
                    return data.map(supply => supply.price).join(', ');
                },
                defaultContent: '-'
            },
            { data: 'description' },
            {
                data: 'category.name',
                defaultContent: '-'
            },
            {
                data: 'productsupplies',
                render: function(data) {
                    if (!data || data.length === 0) return '-';
                    let suppliers = data.map(supply => {
                        return supply.supplier ? `${supply.supplier.first_name} ${supply.supplier.last_name}` : '-';
                    });
                    return suppliers.join(', ');
                },
                defaultContent: '-'
            },
            {
                data: 'inventory.stock',
                defaultContent: '-'
            },
            {
                data: 'productsupplies',
                render: function(data) {
                    if (!data || data.length === 0) return '-';
                    return data.map(supply => supply.date_supplied).join(', ');
                },
                defaultContent: '-'
            },
            {
                data: 'product_id',
                render: function(data) {
                    return `<button class="btn btn-accent btn-sm edit" data-id="${data}" onclick="productModal.showModal()">Edit</button>
                            <button class="btn btn-error btn-sm delete" data-id="${data}">Delete</button>`;
                }
            }
        ]
    });

    // Fetch and populate category select options
    function populateCategoriesSelect() {
        $.ajax({
            url: '/api/categories',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#category_id').empty();
                $('#category_id').append(`<option value="">Select Category</option>`);
                response.forEach(category => {
                    $('#category_id').append(`<option value="${category.category_id}">${category.name}</option>`);
                });
            },
            error: function(xhr) {
                alert('Error fetching categories: ' + xhr.responseText);
            }
        });
    }

    // Fetch and populate supplier select options
    function populateSuppliersSelect() {
        $.ajax({
            url: '/api/suppliers',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#supplier_id').empty();
                $('#supplier_id').append(`<option value="">Select Supplier</option>`);
                response.forEach(supplier => {
                    $('#supplier_id').append(`<option value="${supplier.supplier_id}">${supplier.first_name} ${supplier.last_name}</option>`);
                });
            },
            error: function(xhr) {
                alert('Error fetching suppliers: ' + xhr.responseText);
            }
        });
    }

    populateCategoriesSelect();
    populateSuppliersSelect();

    // Reset form and open modal for creating new product
    $('#createProduct').click(function() {
        $('#productModalLabel').text('Create Product');
        $('#productForm')[0].reset();
        $('#product_id').val('');
        $('#productModal').modal('show');
    });

    // Handle form submission for creating/updating product
    $('#productForm').submit(function(e) {
        e.preventDefault();
        var id = $('#productId').val();
        var url = id ? `/api/products/${id}` : '/api/products';
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
                $('#productModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });

    // Fetch product details and populate modal for editing
    $('#productsTable tbody').on('click', '.edit', function() {
        var id = $(this).data('id');

        $.ajax({
            url: `/api/products/${id}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#productModalLabel').text('Edit Product');
                $('#name').val(data.name);
                $('#price').val(data.price);

                // Get the first product supply for the edit form
                if (data.productsupplies && data.productsupplies.length > 0) {
                    var firstSupply = data.productsupplies[0];
                    $('#supplier_price').val(firstSupply.price);
                    $('#date_supplied').val(firstSupply.date_supplied);
                    $('#supplier_id').val(firstSupply.supplier_id);
                } else {
                    $('#supplier_price').val('');
                    $('#date_supplied').val('');
                    $('#supplier_id').val('');
                }

                $('#description').val(data.description);
                $('#category_id').val(data.category_id);
                $('#productId').val(data.product_id);

                // Populate inventory stock based on product ID
                if (data.inventory) {
                    $('#stock').val(data.inventory.stock);
                } else {
                    $('#stock').val('');
                }

                $('#productModal').modal('show');
            },
            error: function(xhr) {
                alert('Error fetching product details: ' + xhr.responseText);
            }
        });
    });

    // Confirm deletion and handle product deletion
    $('#productsTable tbody').on('click', '.delete', function() {
        var id = $(this).data('id');

        if (confirm('Are you sure you want to delete this product?')) {
            $.ajax({
                url: `/api/products/${id}`,
                method: 'DELETE',
                dataType: 'json',
                success: function(response) {
                    table.ajax.reload();
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        }
    });

    // View supplies for a product
    $('#productsTable tbody').on('click', '.view-supplies', function() {
        var productId = $(this).data('id');

        $.ajax({
            url: `/api/product_supplies/${productId}`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var suppliesTable = $('#suppliesTable tbody');
                suppliesTable.empty();

                data.forEach(supply => {
                    suppliesTable.append(`
                        <tr>
                            <td>${supply.date_supplied}</td>
                            <td>${supply.price}</td>
                        </tr>
                    `);
                });

                $('#suppliesModal').modal('show');
            },
            error: function(xhr) {
                alert('Error fetching supplies: ' + xhr.responseText);
            }
        });
    });
});
