// ccs-customizer.js
jQuery(document).ready(function($) {
    var iconList = $('#ccs-icons-list'),
        addButton = $('.ccs-add-icon-button'),
        customizerInput = $('input', iconList.parent());

    addButton.on('click', function() {
        wp.media.editor.send.attachment = function(props, attachment) {
            var newItem = $(
                '<li>' +
                    '<img src="' + attachment.url + '" class="icon-image" />' +
                    '<input type="hidden" value="' + attachment.url + '" class="icon-image-url" />' +
                    '<input type="url" placeholder="URL" class="icon-url" />' +
                    '<button type="button" class="button ccs-remove-icon-button">Remove</button>' +
                '</li>'
            );
            newItem.appendTo(iconList);
            iconList.on('input', 'input', updateCustomizerValue);
        };
        wp.media.editor.open();
    });

    iconList.on('click', '.ccs-remove-icon-button', function() {
        $(this).closest('li').remove();
        updateCustomizerValue();
    });

    function updateCustomizerValue() {
        var value = [];

        iconList.children().each(function() {
            var item = $(this),
                iconData = {
                    imageUrl: $('.icon-image-url', item).val(),
                    url: $('.icon-url', item).val(),
                };

            value.push(iconData);
        });

        customizerInput.val(JSON.stringify(value)).trigger('change');
    }
});
