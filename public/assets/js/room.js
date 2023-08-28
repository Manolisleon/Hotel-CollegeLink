$(document).ready(function () {
    $("form#favorite").on('submit', function(e) {
        //stop sybmit
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax(
            'http://hotel.collegelink.localhost/project/public/ajax/room_favorite.php',
            {
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function(result) {
                if (result.status) {
                    $('input[name=is_favorite]').val(result.is_favorite ? 1 : 0);
                    if (result.is_favorite) {
                        $("#heart").removeClass("white");
                        $("#heart").addClass("red");

                    }else {
                        $("#heart").removeClass("red");
                        $("#heart").addClass("white");
                    }
                } else {
                    $('#heart').toggleClass('red', !result.is_favorite);
                }
            }); 
    });

    $("form.formReview").on('submit', function(e) {
        //stop sybmit
        e.preventDefault();
        const formData = $(this).serialize();
        $.ajax(
            'http://hotel.collegelink.localhost/project/public/ajax/room_review.php',
            {
                type: "POST",
                dataType: "html",
                data: formData
            }).done(function(result) {
                //append new data 
                $('#listOfReview').append(result);

                //reset form
                $('form.formReview').trigger('reset');
            }); 
    });
});


