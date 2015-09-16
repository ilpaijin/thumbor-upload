(function () {

    var spinner = 'spinner.gif';

    var previewImage = function (input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onloadend = function (e) {
                $('#preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#myImage").change(function(){
        $('.upload-outcome-mark > span').removeClass('success').fadeOut();
        previewImage(this);
    });

    $('#image_uploader_form').submit(function (evt) {
        evt.preventDefault();

        $('#preview').css({'opacity': 0.4}).siblings('.loading').html("<img src='"+spinner+"' />");

        var formData = new FormData();
        formData.append('file', $('#myImage')[0].files[0]);

        $.ajax({
            url: 'http://api.favoroute.local/images',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function (response, status, call) {

                if (call.status !== 200) {
                    return;
                }

                if (response.data.image) {
                    $('.upload-outcome-mark > span').addClass('success').fadeIn(1000).css("display","block");
                    $('#preview').css({'opacity': 1}).siblings('.loading').html("");
                }
            }
        });
    });
})();
