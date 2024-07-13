
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

$(document).ready(function() {
    const customerId = localStorage.getItem('customer_id');
    alert('Customer ID: ' + customerId);

    $.ajax({
        url: '/api/carts',
        method: 'GET',
        data: {
            customer_id: customerId
        },
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.length > 0) {
                response.forEach(function(cart) {
                    let images = cart.product.images.split(',');
                    let firstImage = images.length > 0 ? images[0].trim() : '';
                    $('#cartItems').append(`
                        <div class="card mb-3" style="max-width: 700px; background-color: #FEFAE0; max-height: 120px; border-left: transparent; border-right: transparent;">
                            <div class="row g-0">
                                <div class="col-md-1">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" value="${cart.product_id}" id="product${cart.product_id}">
                                        <label class="form-check-label" for="product${cart.product_id}">
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <img src="/imgs/${firstImage}" class="img-thumbnail" alt="Product Image" style="max-width: 120px; max-height: 120px;">
                                </div>
                                <div class="col-md-8" style="align-items: center;">
                                    <p class="card-title" style="font-family: Poppins, sans-serif; font-weight: 700; color: #B99470; margin-top: 5px; font-size: 18px; margin-bottom: 2px;">${cart.product.name}</p>
                                    <p class="card-text" style="font-family: Poppins, sans-serif; color: #A9B388; margin-top: 5px; font-size: 12px; margin-bottom: 10px; margin-right: 10px;">${cart.product.description}</p>
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 5px;">
                                        <p class="card-text" style="font-family: Poppins, sans-serif; color: #5F6F52; font-weight: 700; font-size: 20px; margin-bottom: 0;"><strong>&#8369; </strong>${cart.product.price}</p>
                                        <p class="card-text" style="font-family: Poppins, sans-serif; color: #B99470; margin-right: 10px; margin-bottom: 0;">Quantity: ${cart.quantity}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
});
