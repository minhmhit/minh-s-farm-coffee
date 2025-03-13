$(document).ready(function() {
    console.log("jQuery và main.js đã tải thành công!");

    // Đăng nhập
    $('#login-form').submit(function(e) {
        e.preventDefault();
        console.log("Gửi yêu cầu đăng nhập...");
        $.ajax({
            url: '../ajax/login.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log("Phản hồi đăng nhập:", response);
                if (response.status == 'success') {
                    window.location = '../pages/index.php';
                } else {
                    $('#login-error').text(response.message).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX đăng nhập:", error);
            }
        });
    });

    // Đăng ký
    $('#register-form').submit(function(e) {
        e.preventDefault();
        console.log("Gửi yêu cầu đăng ký...");
        $.ajax({
            url: '../ajax/register.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log("Phản hồi đăng ký:", response);
                if (response.status == 'success') {
                    window.location = '../pages/index.php';
                } else {
                    $('#register-error').text(response.message).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX đăng ký:", error);
            }
        });
    });

    // Thêm vào giỏ hàng
    
    $(document).on('click', '.add-to-cart', function() {
        var product_id = $(this).data('id');
        console.log("Thêm sản phẩm vào giỏ, ID:", product_id);
        $.ajax({
            url: '../ajax/add_to_cart.php',
            type: 'POST',
            data: { product_id: product_id },
            dataType: 'json',
            success: function(response) {
                console.log("Phản hồi thêm vào giỏ:", response);
                if (response.status == 'success') {
                    alert(response.message);
                    updateCartCount();
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX thêm vào giỏ:", error);
            }
        });
    });

    // Tải giỏ hàng
    function loadCart() {
        console.log("Tải giỏ hàng...");
        $.ajax({
            url: '../ajax/load_cart.php',
            type: 'GET',
            success: function(response) {
                $('#cart-items').html(response);
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX tải giỏ hàng:", error);
            }
        });
    }
    if ($('#cart-items').length) {
        loadCart();
    }

    // Cập nhật số lượng
    $(document).on('change', '.update-quantity', function() {
        var cart_id = $(this).data('id');
        var quantity = $(this).val();
        console.log("Cập nhật số lượng, ID:", cart_id, "Số lượng:", quantity);
        $.ajax({
            url: '../ajax/update_cart.php',
            type: 'POST',
            data: { cart_id: cart_id, quantity: quantity },
            dataType: 'json',
            success: function(response) {
                console.log("Phản hồi cập nhật số lượng:", response);
                if (response.status == 'success') {
                    loadCart();
                    updateCartCount();
                }
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX cập nhật số lượng:", error);
            }
        });
    });

    // Xóa khỏi giỏ hàng
    $(document).on('click', '.remove-from-cart', function() {
        var cart_id = $(this).data('id');
        console.log("Xóa khỏi giỏ, ID:", cart_id);
        $.ajax({
            url: '../ajax/remove_from_cart.php',
            type: 'POST',
            data: { cart_id: cart_id },
            dataType: 'json',
            success: function(response) {
                console.log("Phản hồi xóa khỏi giỏ:", response);
                if (response.status == 'success') {
                    loadCart();
                    updateCartCount();
                }
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX xóa khỏi giỏ:", error);
            }
        });
    });

    // Tìm kiếm và load sản phẩm
    function loadProducts() {
        var search = $('#search').val();
        var category = $('#category').val();
        var price = $('#price').val();
        console.log("Tải sản phẩm với bộ lọc:", { search, category, price });
        $.ajax({
            url: '../ajax/search_products.php',
            type: 'POST',
            data: { search: search, category: category, price: price },
            success: function(response) {
                $('#product-list').html(response);
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX tải sản phẩm:", error);
            }
        });
    }

    // Load sản phẩm khi trang được tải
    if ($('#product-list').length) {
        loadProducts();
    }

    // Tìm kiếm và lọc sản phẩm khi thay đổi input
    $('#search, #category, #price').on('input change', function() {
        loadProducts();
    });

    // Đặt hàng
    $('#checkout-form').submit(function(e) {
        e.preventDefault();
        console.log("Gửi yêu cầu đặt hàng...");
        $.ajax({
            url: '../ajax/place_order.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                console.log("Phản hồi đặt hàng:", response);
                if (response.status == 'success') {
                    window.location = '../pages/thank_you.php';
                } else {
                    $('#checkout-error').text(response.message).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX đặt hàng:", error);
            }
        });
    });

    // Cập nhật số lượng giỏ hàng
    function updateCartCount() {
        console.log("Cập nhật số lượng giỏ hàng...");
        $.ajax({
            url: '../ajax/load_cart.php',
            type: 'GET',
            success: function(response) {
                var count = $(response).find('.card').length;
                $('#cart-count').text(count);
            },
            error: function(xhr, status, error) {
                console.log("Lỗi AJAX cập nhật số lượng giỏ:", error);
            }
        });
    }
    updateCartCount();
});