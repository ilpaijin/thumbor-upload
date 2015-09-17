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
        $('h4.id').find('span').html('');

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

                if (response.data) {
                    console.info(response.data);
                    $('.upload-outcome-mark > span').addClass('success').fadeIn(1000).css("display","block");
                    $('#preview').css({'opacity': 1}).siblings('.loading').html("");

                    $('h4.id').find('span').html(response.data.id);
                    $('h4.fileLabel').find('span').html(response.data.label);
                    $('h4.finename').find('span').html(response.data.filename);
                    $('h4.width').find('span').html(response.data.width);
                    $('h4.height').find('span').html(response.data.height);
                    $('h4.url').find('span').html(response.data.url);
                    $('h4.created_at').find('span').html(response.data.timestamp);
                }
            }
        });
    });
})();
