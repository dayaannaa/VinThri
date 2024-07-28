
// $(document).ready(function() {
//     alert('Customer ID: ' + localStorage.getItem('customer_id'));
//     $.ajax({
//         url: '/api/carts',
//         method: 'GET',
//         dataType: 'json',
//         // headers: {
//         //     'Authorization': 'Bearer ' + localStorage.getItem('token'),
//         success: function(response) {
//             // Handle successful response
//             console.log(response);
//             // Example: Update HTML elements with cart data
//             if (response.length > 0) {
//                 response.forEach(function(cart) {
//                     $('#cartTable tbody').append(`
//                         <tr>
//                             <td>${cart.cart_id}</td>
//                             <td>${cart.quantity}</td>
//                             <td>${cart.product_id}</td>
//                             <td>${cart.customer_id}</td>
//                         </tr>
//                     `);
//                 });
//                 //   $('#customer_id').val(response.customer_id);
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     // }
//     });
// });

//WORKING
// $(document).ready(function() {
//     const customerId = localStorage.getItem('customer_id');
//     alert('Customer ID: ' + customerId);
//     $.ajax({
//         url: '/api/carts',
//         method: 'GET',
//         data: {
//             customer_id: customerId
//         },
//         dataType: 'json',
//         success: function(response) {
//             console.log(response);
//             if (response.length > 0) {
//                 response.forEach(function(cart) {
//                     $('#cartTable tbody').append(`
//                         <tr>
//                             <td>${cart.cart_id}</td>
//                             <td>${cart.quantity}</td>
//                             <td>${cart.product_id}</td>
//                             <td>${cart.customer_id}</td>
//                         </tr>
//                     `);
//                 });
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });


//WORKING
// $(document).ready(function() {
//     const customerId = localStorage.getItem('customer_id');
//     alert('Customer ID: ' + customerId);

//     $.ajax({
//         url: '/api/carts',
//         method: 'GET',
//         data: {
//             customer_id: customerId
//         },
//         dataType: 'json',
//         success: function(response) {
//             console.log(response);
//             if (response.length > 0) {
//                 response.forEach(function(cart) {
//                     $('#cartTable tbody').append(`
//                         <tr>
//                             <td>${cart.product_id}</td>
//                             <td>${cart.quantity}</td>
//                         </tr>
//                     `);
//                 });
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });

//FINAL WORKING
// $(document).ready(function() {
//     const customerId = localStorage.getItem('customer_id');
//     alert('Customer ID: ' + customerId);

//     $.ajax({
//         url: '/api/carts',
//         method: 'GET',
//         data: {
//             customer_id: customerId
//         },
//         dataType: 'json',
//         success: function(response) {
//             console.log(response);
//             if (response.length > 0) {
//                 response.forEach(function(cart) {
//                     let images = cart.product.images.split(',');
//                     let firstImage = images.length > 0 ? images[0] : '';

//                     $('#cartTable tbody').append(`
//                         <tr>
//                             <td>${cart.product.name}</td>
//                             <td><img src="/imgs/${firstImage.trim()}" class="img-thumbnail" style="max-width: 100px; max-height: 100px;"></td>
//                             <td>${cart.product.price}</td>
//                             <td>${cart.product.description}</td>
//                             <td>${cart.quantity}</td>
//                         </tr>
//                     `);
//                 });
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });

// $(document).ready(function() {
//     const customerId = localStorage.getItem('customer_id');
//     alert('Customer ID: ' + customerId);

//     $.ajax({
//         url: '/api/carts',
//         method: 'GET',
//         data: {
//             customer_id: customerId
//         },
//         dataType: 'json',
//         success: function(response) {
//             console.log(response);
//             if (response.length > 0) {
//                 response.forEach(function(cart) {
//                     let images = cart.product.images.split(',');
//                     let firstImage = images.length > 0 ? images[0].trim() : '';
//                     $('#cartItems').append(`
//                         <div class="card mb-3" style="max-width: 540px;">
//                             <div class="row g-0">
//                                 <div class="col-md-1">
//                                     <div class="form-check mt-2">
//                                         <input class="form-check-input" type="checkbox" value="${cart.product_id}" id="product${cart.product_id}">
//                                         <label class="form-check-label" for="product${cart.product_id}">
//                                         </label>
//                                     </div>
//                                 </div>
//                                 <div class="col-md-3">
//                                     <img src="/imgs/${firstImage}" class="img-thumbnail" alt="Product Image" style="max-width: 100px; max-height: 100px;">
//                                 </div>
//                                 <div class="col-md-8">
//                                     <div class="card-body">
//                                         <h5 class="card-title">${cart.product.name}</h5>
//                                         <p class="card-text">Price: ${cart.product.price}</p>
//                                         <p class="card-text">${cart.product.description}</p>
//                                         <p class="card-text">Quantity: ${cart.quantity}</p>
//                                     </div>
//                                 </div>
//                             </div>
//                         </div>
//                     `);
//                 });
//             }
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });


$(document).ready(function() {
    const customerId = localStorage.getItem('customer_id');

    function calculateTotal() {
        let overallTotal = 0;
        let totalQuantity = 0;

        $('.product-checkbox:checked').each(function() {
            let productPrice = parseFloat($(this).data('price'));
            let productQuantity = parseInt($(this).closest('.row').find('.quantity-input').val());
            overallTotal += productPrice * productQuantity;
            totalQuantity += productQuantity;
        });

        $('#overallTotal').text(overallTotal.toFixed(2));
        $('#totalQuantity').text(totalQuantity);
    }

    $.ajax({
        url: '/api/carts',
        method: 'GET',
        data: { customer_id: customerId },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (!response || response.length === 0) {
                $('#cartItems').append('<p style="text-align: center;">No items in cart.</p>');
                return;
            }
            if (response.length > 0) {
                response.forEach(function(cart) {
                    let images = cart.product.images.split(',');
                    let firstImage = images.length > 0 ? images[0].trim() : '';
                    $('#cartItems').append(`   
                        <section class="h-100">
                            <div class="container h-100 ">
                                <div class="row d-flex justify-content-center align-items-center h-100">
                                <div class="col-10">
                                    <div class="card rounded-3" style="border-right-color: transparent; border-left-color: transparent; border-top-color: #5F6F52; border-bottom-color: #5F6F52;">
                                    <div class="card-body p-4" style="background-color: #FEFAE0;">
                                        <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-md-1">
                                            <div class="form-check mt-2">
                                            <input class="form-check-input product-checkbox" type="checkbox" value="${cart.product_id}" data-price="${cart.product.price}" data-quantity="${cart.quantity}" id="product${cart.product_id}">
                                            <label class="form-check-label" for="product${cart.product_id}"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-lg-2 col-xl-2">
                                            <img src="/imgs/${firstImage}" class="img-fluid rounded-3" style="height: 80px; width: 80px;" alt="Product Image">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                            <p class="lead fw-normal" style="font-family: Alfa Slab One, sans-serif; color: #B99470;">${cart.product.name}</p>
                                            <p style="font-family: Poppins, serif; color: #5F6F52; font-size: 12px;" class="mb-3">${cart.product.description}</p>
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex input-group">
                                                <button class="btn btn-outline-secondary btn-minus" type="button">-</button>
                                                <input type="number" class="form-control quantity-input" style="max-width: 100px;" value="${cart.quantity}" min="1">
                                                <button class="btn btn-outline-secondary btn-plus" type="button">+</button>
                                            </div>
                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                            <h5 class="mb-0" style="font-family: Poppins, serif; color: #5F6F52; font-weight: 800; font-size: 20px;">₱ ${cart.product.price}</h5>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                            <i class="bi bi-trash delete-item text-danger" style="font-size: 25px;" data-cart-id="${cart.cart_id}" style="cursor: pointer;"></i>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </section>
                    `);
                });

                $('.product-checkbox').on('change', function() {
                    calculateTotal();
                });

                $('.quantity-input').on('change', function() {
                    let cartId = $(this).closest('.card-body').find('.delete-item').data('cart-id');
                    let newQuantity = $(this).val();

                    updateCartQuantity(cartId, newQuantity);
                });

                $('.btn-minus').on('click', function() {
                    let input = $(this).closest('.input-group').find('.quantity-input');
                    let currentValue = parseInt(input.val());
                    if (currentValue > 1) {
                        input.val(currentValue - 1);
                        input.trigger('change');
                    }
                });

                $('.btn-plus').on('click', function() {
                    let input = $(this).closest('.input-group').find('.quantity-input');
                    let currentValue = parseInt(input.val());
                    input.val(currentValue + 1);
                    input.trigger('change');
                });

                $('.delete-item').on('click', function() {
                    let cartId = $(this).data('cart-id');
                    $.ajax({
                        url: '/api/carts/' + cartId,
                        method: 'DELETE',
                        success: function(response) {
                            console.log(response);
                            alert('Item deleted successfully.');
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('Failed to delete item. Please try again.');
                        }
                    });
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

    $('#checkoutButton').on('click', function() {
        let selectedProducts = [];
        $('.product-checkbox:checked').each(function() {
            selectedProducts.push({
                product_id: $(this).val(),
                quantity: $(this).closest('.row').find('.quantity-input').val()
            });
        });

        if (selectedProducts.length === 0) {
            alert('Please select at least one product to checkout.');
            return;
        }

        $.ajax({
            url: '/api/carts/checkout',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                customer_id: customerId,
                products: selectedProducts
            }),
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('auth_token')
            },
            success: function(response) {
                alert('Checkout successful!');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Checkout failed. Please try again.');
            }
        });
    });

    function updateCartQuantity(cartId, newQuantity) {
        $.ajax({
            url: '/api/carts/' + cartId,
            method: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify({
                quantity: newQuantity,
                customer_id: customerId
            }),
            success: function(response) {
                console.log(response);
                calculateTotal();
                // alert('Quantity updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error(error);
                // alert('Failed to update quantity. Please try again.');
            }
        });
    }
});

