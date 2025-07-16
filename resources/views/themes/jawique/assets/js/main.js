/* UI Slider Range JS */
$(function () {
    
    $("#slider-range").slider({
        range: true,
        min: 0,
        max: 1000000,
        values: [$("#min_price").val(), $("#max_price").val()],
        slide: function (event, ui) {
            $("#amount").val(ui.values[0] + " - " + ui.values[1]);
        }
    });
    $("#amount").val($("#slider-range").slider("values", 0) +
        " - " + $("#slider-range").slider("values", 1));

    $('.delivery-address').change(function(){
        $('.courier_code').prop('checked', false);
        $('.available-wrapper').hide();
        $('.available-services').html('');
    });

    $('.courier_code').click(function(){
        let courier = $(this).val();
        let addressID = $('.delivery-address:checked').val();

        $.ajax({
            url: "/orders/shipping-fee",
            method: "POST",
            data: {
                address_id: addressID,
                courier: courier,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(result) {
                $('.available-wrapper').show();
                $('.available-services').html(result);
            },
            error: function(e) {
                console.log(e);
            }
        });
    });    
});

window.showLoginAlert = function() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Anda Belum Login',
            text: "Silakan login terlebih dahulu untuk melanjutkan.",
            icon: 'info',
            showCancelButton: true,

            confirmButtonColor: '#28a745', 
            cancelButtonColor: '#dc3545',  
            
            confirmButtonText: 'Login Sekarang!',
            cancelButtonText: 'Batal'
            
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/login';
            }
        });
    } else {
        if (confirm("Anda belum login. Silakan login terlebih dahulu untuk melanjutkan.")) {
            window.location.href = '/login';
        }
    }
}

