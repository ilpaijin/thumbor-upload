(function () {

    var thumbor_server = 'http://localhost:8888/unsafe';

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

                    $('li.id').find('.value').html(response.data.id);
                    $('li.fileLabel').find('.value').html(response.data.label);
                    $('li.filename').find('.value').html(response.data.filename);
                    $('li.width').find('.value').html(response.data.width);
                    $('li.height').find('.value').html(response.data.height);
                    $('li.url').find('.value').html(response.data.url);
                    $('li.created_at').find('.value').html(response.data.timestamp);

                    $('.crop').find('img').attr('src', thumbor_server+'/100x75'+response.data.url).fadeIn();
                }
            }
        });
    });
})();
