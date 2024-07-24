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
        .modal-dialog {
            max-width: 650px;
            margin: 30px auto;
        }
    </style>
</head>
<body>
    <div id="orders-container" class="container"></div>

    <!-- Modal -->
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

    <!-- Feedback Modal -->
    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="feedbackForm">
                        <input type="hidden" id="feedbackOrderItemId">
                        <input type="hidden" id="feedbackCustomerId">
                        <div class="form-group">
                            <label for="feedbackText">Feedback</label>
                            <textarea class="form-control" id="feedbackText" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="feedbackImages">Upload Images</label>
                            <input type="file" class="form-control-file" id="feedbackImages" name="images[]" multiple>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
$(document).ready(function() {
    const customerId = localStorage.getItem('customer_id');

    $.ajax({
        url: '/api/orders',
        type: 'GET',
        dataType: 'json',
        data: {
            customer_id: customerId
        },
        success: function(response) {
            if (!response || response.length === 0) {
                $('#orders-container').append('<p>No orders found.</p>');
                return;
            }

            response.forEach(function(order) {
                var orderHtml = `
                    <div class="order-container">
                        <div class="order-header">
                            <div>
                                <h5>Name: ${order.customer.first_name} ${order.customer.last_name}</h5>
                                <p>Address: ${order.customer.address}</p>
                            </div>
                            <div>
                                <p>Date: ${order.date}</p>
                                <p>Status: ${order.status}</p>
                                <div class="order-button">
                                    <button class="view-products btn btn-primary" data-order-id="${order.order_id}" data-order-status="${order.status}">View Products</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $('#orders-container').append(orderHtml);
            });

            $('.view-products').click(function() {
                var orderId = $(this).data('order-id');
                var status = $(this).data('order-status');

                $.ajax({
                    url: '/api/orders/' + orderId + '/products',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
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

                            let feedbackButtonHtml = status === 'cancelled' || status === 'delivered' ?
                                '<button class="feedback-btn btn btn-secondary" data-order-item-id="' + item.order_item_id + '">Feedback</button>' :
                                '';

                            $('#modal-body').append(
                                '<div class="product-item">' +
                                    '<div class="product-images">' + imageHtml + '</div>' +
                                    '<div class="product-details">' +
                                        '<h5>' + product.name + '</h5>' +
                                        '<p>Quantity: ' + quantity + '</p>' +
                                        '<p>Price: $' + price.toFixed(2) + '</p>' +
                                        feedbackButtonHtml +
                                    '</div>' +
                                '</div>'
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

            $(document).on('click', '.feedback-btn', function() {
                var orderItemId = $(this).data('order-item-id');

                $('#feedbackOrderItemId').val(orderItemId);

                $.ajax({
                    url: '/api/orders/items/' + orderItemId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(itemResponse) {
                        $('#feedbackProductName').text(itemResponse.product_name);
                        $('#feedbackCustomerId').val(itemResponse.customer_id);
                        $('#feedbackModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching product details:', xhr.responseText);
                        $('#feedbackProductName').text('Error fetching product details.');
                        $('#feedbackModal').modal('show');
                    }
                });
            });

            $('#feedbackForm').submit(function(e) {
                e.preventDefault();

                const feedbackText = $('#feedbackText').val();
                const orderItemId = $('#feedbackOrderItemId').val();
                const customerId = localStorage.getItem('customer_id');

                const formData = new FormData();
                formData.append('order_item_id', orderItemId);
                formData.append('customer_id', customerId);
                formData.append('description', feedbackText);
                const files = $('#feedbackImages')[0].files;
                for (let i = 0; i < files.length; i++) {
                    formData.append('images[]', files[i]);
                }

                $.ajax({
                    url: '/api/feedbacks',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Feedback submitted successfully!');
                        $('#feedbackModal').modal('hide');
                        $('#feedbackText').val('');
                        $('#feedbackImages').val('');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error submitting feedback:', error);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            $('#feedbackModal').on('hidden.bs.modal', function () {
                $('#feedbackText').val('');
                $('#feedbackImages').val('');
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching orders:', error);
            $('#orders-container').html('<p>Error fetching orders. Please try again.</p>');
        }
    });
});

    </script>
</body>
</html>
