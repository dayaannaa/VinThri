<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .order-container {
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
        }
        .order-content {
            margin-top: 10px;
        }
        .order-button {
            margin-top: 10px;
        }
        .product-item {
            display: flex;
            margin-top: 10px;
        }
        .product-details {
            flex: 1;
            margin-left: 10px;
        }
        .product-image {
            max-width: 180px;
            max-height: 180px;
            margin-right: 15px;
        }
        .product-images {
            display: flex;
        }
        .product-details {
            flex: 1;
        }
        .modal-dialog {
            max-width: 650px;
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <div id="orders-container" class="container"></div>
    <div class="modal fade" id="productsModal" tabindex="-1" role="dialog" aria-labelledby="productsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productsModalLabel">Order Products</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-body"></div>
                <div class="modal-footer">
                    <div class="text-right w-100">
                        <p><strong>Total Quantity:</strong> <span id="totalQuantity"></span></p>
                        <p><strong>Overall Total:</strong> <span id="overallTotal"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Change Order Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="statusForm">
                        <div class="form-group">
                            <label for="orderStatus">Status</label>
                            <select class="form-control" id="orderStatus">
                                <option value="pending">Pending</option>
                                <option value="shipping">Shipping</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <input type="hidden" id="currentOrderId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveStatusBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>$(document).ready(function() {
        $.ajax({
            url: '/api/orders',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Orders:', response);
                if (!response || response.length === 0) {
                    $('#orders-container').append('<p>No orders found.</p>');
                    return;
                }

                response.forEach(function(order) {
                    var orderHtml =
                        `<div class="order-container">
                            <div class="order-header">
                                <div>
                                    <h5>Name: ${order.customer.first_name} ${order.customer.last_name}</h5>
                                    <p>Address: ${order.customer.address}</p>
                                    <div class="order-button">
                                        <button class="view-products btn btn-primary" data-order-id="${order.order_id}">View Products</button>
                                        </div>
                                </div>
                                <div>
                                    <p>Date: ${order.date}</p>
                                    <p>Status: ${order.status}</p>
                                    <div class="order-button">

                                        <button class="change-status btn btn-secondary" data-order-id="${order.order_id}" data-current-status="${order.status}">Change Status</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    $('#orders-container').append(orderHtml);
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

                            $('#productsModal').modal('show');
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
                    $('#statusModal').modal('show');
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
                            $('#statusModal').modal('hide');
                            location.reload();
                            alert ('Order Status has been successfully updated')
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
                $('#orders-container').append('<p>Error fetching orders. Please try again.</p>');
            }
        });
    });
    </script>
</body>
</html>
