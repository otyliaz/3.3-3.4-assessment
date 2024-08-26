$(document).ready(function() {
    //increase quantity of item on click
    $('.btn-increase').on('click', function(event) {
        event.preventDefault(); //prevents the form from submitting
        let $input = $(this).siblings('.quantity-input');
        let currentValue = parseInt($input.val());
        $input.val(currentValue + 1);
    });

    $('.btn-decrease').on('click', function(event) {
        event.preventDefault();
        let $input = $(this).siblings('.quantity-input');
        let currentValue = parseInt($input.val());
        if (currentValue > 1) {
            $input.val(currentValue - 1);
        }
    });

});