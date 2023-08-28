$(document).ready(function () {
    $("form.searchform").on('submit', function(e) {
        //stop sybmit
        e.preventDefault();

        const formData = $(this).serialize();
        $.ajax(
            'http://hotel.collegelink.localhost/project/public/ajax/search_results.php',
            {
                type: "GET",
                dataType: "html",
                data: formData
            }).done(function(result) {
                //clear html
                $('#result-hotel').html('');

                //append new data 
                $('#result-hotel').append(result);

                //change url 
                history.pushState({}, '', 'http://hotel.collegelink.localhost/project/public/list-hotel.php?' + formData);
            }); 
    });
});
