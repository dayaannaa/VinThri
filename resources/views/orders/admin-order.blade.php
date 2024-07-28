@extends('layouts.master')
@extends('layouts.datatables-style')
@section('title', 'Orders Management')
@include('admins.home')
@section('content')
<title>Orders Management</title>
<link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
<h2 class="display-3 fw-bolder my-5 text-center" style="font-family: 'Alfa Slab One', serif; color: #5F6F52;">
    Orders Management</h2>

<div class="overflow-auto">
    <table class="table pt-3" id="ordersTable">
        <thead class="bg-[#5F6F52] text-[#FEFAE0]">
            <tr>
                <th style="color: #FEFAE0;">ID</th>
                <th style="color: #FEFAE0;">Name</th>
                <th style="color: #FEFAE0;">Address</th>
                <th style="color: #FEFAE0;">Date</th>
                <th style="color: #FEFAE0;">Status</th>
                <th style="color: #FEFAE0;">Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Products Modal -->
<input type="checkbox" id="productsModal" class="modal-toggle" />
<label for="productsModal" class="modal cursor-pointer">
    <label class="modal-box relative" style="background-color: #5F6F52; color: #FEFAE0;" for="">
        <h2 class="text-center text-2xl font-bold mb-4" style="font-family: 'Alfa Slab One', serif; color: #FEFAE0;">Order Products</h2>
        <div id="modal-body" style="font-family: 'Poppins', sans-serif;"></div>
        <div class="modal-action">
            <label for="productsModal" class="btn btn-secondary">Close</label>
            <div class="text-right">
                <p><strong>Total Quantity:</strong> <span id="totalQuantity"></span></p>
                <p><strong>Overall Total:</strong> <span id="overallTotal"></span></p>
            </div>
        </div>
    </label>
</label>

<!-- Status Modal -->
<input type="checkbox" id="statusModal" class="modal-toggle" />
<label for="statusModal" class="modal cursor-pointer">
    <label class="modal-box relative" style="background-color: #5F6F52; color: #FEFAE0;" for="">
        <h2 class="text-center text-2xl mb-4" style="font-family: 'Alfa Slab One', serif; ">Change Order Status</h2>
        <form id="statusForm">
            <div class="mb-3">
                <label for="orderStatus" class="label">
                    <span class="label-text" style="font-family: 'Poppins', sans-serif; color: #FEFAE0;">Status</span>
                </label>
                <select class="select select-bordered w-full max-w-xs bg-[#FEFAE0] text-[#5F6F52]" style="color: #FEFAE0;" id="orderStatus">
                    <option value="pending">Pending</option>
                    <option value="shipping">Shipping</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <input type="hidden" id="currentOrderId">
        </form>
        <div class="modal-action">
            <label for="statusModal" class="btn btn-secondary">Close</label>
            <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
        </div>
    </label>
</label>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '/api/orders',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Orders:', response);
                    if (!response || response.length === 0) {
                        $('#ordersTable tbody').append('<tr><td colspan="6">No orders found.</td></tr>');
                        return;
                    }

                    response.forEach(function(order) {
                        var orderHtml =
                            `<tr>
                                <td>${order.order_id}</td>
                                <td>${order.customer.first_name} ${order.customer.last_name}</td>
                                <td>${order.customer.address}</td>
                                <td>${order.date}</td>
                                <td>${order.status}</td>
                                <td>
                                    <label for="productsModal" class="btn btn-primary view-products" data-order-id="${order.order_id}">View Products</label>
                                    <label for="statusModal" class="btn btn-secondary change-status" data-order-id="${order.order_id}" data-current-status="${order.status}">Change Status</label>
                                </td>
                            </tr>`;
                        $('#ordersTable tbody').append(orderHtml);
                    });

                    $('.view-products').click(function() {
                        var orderId = $(this).data('order-id');

                        $.ajax({
                            url: '/api/orders/' + orderId + '/products',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                console.log('Products:', response);
                                $('#modal-body').empty();
                                if (!response || response.length === 0) {
                                    $('#modal-body').append('<p>No products found.</p>');
                                    return;
                                }

                                let overallTotal = 0;
                                let totalQuantity = 0;

                                response.forEach(function(item) {
                                    let product = item.product;
                                    let quantity = parseInt(item.quantity);
                                    let price = parseFloat(product.price);
                                    let images = product.images.split(',');
                                    let firstImage = images[0].trim();
                                    let imageHtml = `<div class="product-image">
                                        <img src="/imgs/${firstImage}" class="img-fluid" alt="${product.name}">
                                    </div>`;
                                    $('#modal-body').append(
                                        `<div class="product-item">
                                            <div class="product-images">${imageHtml}</div>
                                            <div class="product-details">
                                                <h5>${product.name}</h5>
                                                <p>Quantity: ${quantity}</p>
                                                <p>Price: $${price.toFixed(2)}</p>
                                            </div>
                                        </div>`
                                    );

                                    overallTotal += price * quantity;
                                    totalQuantity += quantity;
                                });

                                $('#overallTotal').text('$' + overallTotal.toFixed(2));
                                $('#totalQuantity').text(totalQuantity);

                                $('#productsModal').checked = true;
                            },
                            error: function(xhr, status, error) {
                                console.error('Error fetching products:', error);
                                $('#modal-body').html('<p>Error fetching products. Please try again.</p>');
                            }
                        });
                    });

                    $('.change-status').click(function() {
                        var orderId = $(this).data('order-id');
                        var currentStatus = $(this).data('current-status');

                        $('#currentOrderId').val(orderId);
                        $('#orderStatus').val(currentStatus);
                        $('#statusModal').checked = true;
                    });

                    $('#saveStatusBtn').click(function() {
                        var orderId = $('#currentOrderId').val();
                        var newStatus = $('#orderStatus').val();

                        $.ajax({
                            url: '/api/orders/' + orderId + '/status',
                            type: 'PUT',
                            dataType: 'json',
                            contentType: 'application/json',
                            data: JSON.stringify({ status: newStatus }),
                            success: function(response) {
                                console.log('Status updated:', response);
                                $('#statusModal').checked = false;
                                location.reload();
                                alert('Order Status has been successfully updated');
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating status:', error);
                                alert('Error updating status. Please try again.');
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching orders:', error);
                    $('#ordersTable tbody').append('<tr><td colspan="6">Error fetching orders. Please try again.</td></tr>');
                }
            });
        });
    </script>
@endsection
