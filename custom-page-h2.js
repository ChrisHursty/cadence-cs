( function( blocks, element ) {
    var el = element.createElement;
    var registerBlockType = blocks.registerBlockType;

    registerBlockType( 'codewp/custom-page-h2', {
        title: 'Custom Page H2',
        icon: 'heading',
        category: 'common',
        attributes: {
            content: {
                type: 'string',
                default: '',
            },
        },
        edit: function( props ) {
            var content = props.attributes.content;

            function onChangeContent( newContent ) {
                props.setAttributes( { content: newContent } );
            }

            return el(
                'div',
                { className: 'custom-page-h2' },
                el(
                    'h2',
                    {},
                    el(
                        wp.editor.RichText,
                        {
                            tagName: 'span',
                            value: content,
                            onChange: onChangeContent,
                            placeholder: 'Enter your heading text...',
                        }
                    )
                )
            );
        },
        save: function( props ) {
            var content = props.attributes.content;

            return el(
                'div',
                { className: 'custom-page-h2' },
                el( 'h2', {}, content )
            );
        },
    } );
} )(
    window.wp.blocks,
    window.wp.element
);