
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