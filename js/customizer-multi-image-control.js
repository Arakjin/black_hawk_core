jQuery(document).ready(function ($) {
    $('.multi-image-add').on('click', function () {
        var frame = wp.media({
            title: 'Select Images',
            button: {
                text: 'Add to Carousel'
            },
            multiple: true
        });

        var $control = $(this).closest('.multi-image-wrapper');

        frame.on('select', function () {
            var attachments = frame.state().get('selection').toJSON();
            var imageIDs = [];
            var imageList = $control.find('.multi-image-list');

            imageList.empty();

            attachments.forEach(function (attachment) {
                imageIDs.push(attachment.id);
                imageList.append('<li><img src="' + attachment.url + '" alt="" /></li>');
            });

            $control.find('input').val(imageIDs.join(',')).trigger('change');
        });

        frame.open();
    });

    $('.multi-image-clear').on('click', function () {
        var $control = $(this).closest('.multi-image-wrapper');
        $control.find('input').val('').trigger('change');
        $control.find('.multi-image-list').empty();
    });
});
