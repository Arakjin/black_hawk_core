(function (blocks, blockEditor, element, components) {
    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;
    var MediaUpload = blockEditor.MediaUpload;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var ToggleControl = components.ToggleControl;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var BlockControls = blockEditor.BlockControls;
    var ToolbarGroup = components.ToolbarGroup || components.Toolbar;
    var RichText = blockEditor.RichText;
    var AlignmentToolbar = blockEditor.AlignmentToolbar;
    const { ToolbarDropdownMenu } = wp.components;
    const { apiFetch } = wp;

    // Helper function to format width and height values properly
    function formatDimension(value) {
        return value && value !== "auto" ? `${value}px` : value;
    }

    // Helper function to sanitize content
    function sanitizeContent(content) {
        return content ? content.replace(/<\/?p[^>]*>/g, "") : "";
    }

    blocks.registerBlockType('black-hawk-solutions/custom-image-block', {
        title: 'Image Customizer',
        icon: 'format-image',
        category: 'black-hawk',
        attributes: {
            imageURL: {
                type: 'string',
                default: '',
            },
            imageID: {
                type: 'number',
                default: 0,
            },
            verticalAlign: {
                type: 'string',
                default: 'center',
            },
            layoutOrientation: {
                type: 'string',
                default: 'image-left',
            },
            layout: {
                type: 'string',
                default: 'image',
            },
            textAlign: {
                type: 'string',
                default: 'left',
            },
            alt: {
                type: 'string',
                default: '',
            },
            text: {
                type: 'string',
                source: 'html',
                selector: '.media-text-content p',
                default: '',
            },
            size: {
                type: 'string',
                default: 'full',
            },
            width: {
                type: 'string',
                default: '',
            },
            height: {
                type: 'string',
                default: '',
            },
            caption: {
                type: 'string',
                default: '',
            },
            showCaption: {
                type: 'boolean',
                default: true,
            },
            applyDarkeningGradientEffect: {
                type: 'boolean',
                default: true,
            },
        },

        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var flexDirection = attributes.layoutOrientation === 'image-right' ? 'row-reverse' : 'row';
        
            // Define alignment classes
            var textAlignClass = attributes.textAlign === 'center' ? 'text-center' : attributes.textAlign === 'right' ? 'text-end' : 'text-start';
            var verticalAlignClass = attributes.verticalAlign === 'top' ? 'align-items-start' : attributes.verticalAlign === 'bottom' ? 'align-items-end' : 'align-items-center';
        
            // Function to handle image selection and fetch caption from media library
            function onSelectImage(media) {
                setAttributes({
                    imageURL: media.url,
                    imageID: media.id,
                });

                const attachment = wp.media.attachment(media.id);
                attachment.fetch().then(() => {
                    const caption = attachment.get('caption');
                    setAttributes({
                        caption: caption ? caption : '',
                    });
                });
            }

            // Function to update media library caption
            function updateMediaCaption(newCaption) {
                if (attributes.imageID) {
                    apiFetch({
                        path: `/wp/v2/media/${attributes.imageID}`,
                        method: 'POST',
                        data: {
                            caption: newCaption,
                        },
                    }).then(() => {
                        console.log('Caption updated in media library.');
                    });
                }
            }

            var imageClasses = attributes.applyDarkeningGradientEffect ? 'darkening-gradient' : '';
            var imageStyles = {
                width: formatDimension(attributes.width),
                height: formatDimension(attributes.height),
                objectFit: 'cover',
            };

            var blockContent;

            if (!attributes.imageURL) {
                blockContent = el('div', useBlockProps(),
                    el('p', {}, 'Please select an image.')
                );
            } else if (attributes.layout === 'image') {
                blockContent = el('div', useBlockProps({ className: `row ${verticalAlignClass}` }),
                    el('div', { className: `col-12` },
                        el('figure', { className: `wp-block-image` },
                            el('div', { className: `image-wrapper ${imageClasses}` },
                                el('img', { src: attributes.imageURL, alt: attributes.alt, style: imageStyles })
                            ),
                            attributes.showCaption && el('figcaption', { className: 'wp-caption-text' }, attributes.caption)
                        )
                    )
                );
            } else {
                // Create image and text elements
                var imageElement = el('div', { className: `col-6` },
                    el('figure', { className: `wp-block-image` },
                        el('div', { className: `image-wrapper ${imageClasses}` },
                            el('img', { src: attributes.imageURL, alt: attributes.alt, style: imageStyles })
                        ),
                        attributes.showCaption && el('figcaption', { className: 'wp-caption-text' }, attributes.caption)
                    )
                );

                var textElement = el('div', {
                    className: `col-6 ${textAlignClass} media-text-content`,
                    // Remove style: { height: '100%' },
                },
                    el(RichText, {
                        tagName: 'p', // Specify the tag name
                        className: 'wp-block-my-plugin-media-text__text',
                        value: attributes.text,
                        onChange: function (newText) {
                            setAttributes({ text: newText });
                        },
                        placeholder: 'Enter your text here...',
                    })                
                );

                // Determine the order based on layoutOrientation
                var contentOrder = attributes.layoutOrientation === 'image-right' ? [textElement, imageElement] : [imageElement, textElement];

                // Apply vertical alignment to the row
                blockContent = el('div', useBlockProps({ className: `row ${verticalAlignClass}` }),
                    contentOrder
                );
            }

            return el(
                React.Fragment,
                {},
                // Toolbar and InspectorControls
                el(BlockControls, {},
                    el(ToolbarGroup, {},
                        el(components.ToolbarButton, {
                            icon: 'format-image',
                            label: 'Image Block',
                            isActive: attributes.layout === 'image',
                            onClick: function () { setAttributes({ layout: 'image' }); }
                        }),
                        el(components.ToolbarButton, {
                            icon: 'text',
                            label: 'Media & Text Block',
                            isActive: attributes.layout === 'media-text',
                            onClick: function () { setAttributes({ layout: 'media-text' }); }
                        }),
                        el(components.ToolbarButton, {
                            icon: 'align-pull-left',
                            label: 'Image Left',
                            isActive: attributes.layoutOrientation === 'image-left',
                            onClick: () => setAttributes({ layoutOrientation: 'image-left' }),
                        }),
                        el(components.ToolbarButton, {
                            icon: 'align-pull-right',
                            label: 'Image Right',
                            isActive: attributes.layoutOrientation === 'image-right',
                            onClick: () => setAttributes({ layoutOrientation: 'image-right' }),
                        })
                    ),
                    el(ToolbarDropdownMenu, {
                        icon: 'sort',
                        label: 'Select vertical alignment',
                        controls: [
                            {
                                title: 'Top',
                                icon: 'arrow-up-alt2',
                                onClick: () => setAttributes({ verticalAlign: 'top' }),
                                isActive: attributes.verticalAlign === 'top',
                            },
                            {
                                title: 'Middle',
                                icon: 'align-center',
                                onClick: () => setAttributes({ verticalAlign: 'center' }),
                                isActive: attributes.verticalAlign === 'center',
                            },
                            {
                                title: 'Bottom',
                                icon: 'arrow-down-alt2',
                                onClick: () => setAttributes({ verticalAlign: 'bottom' }),
                                isActive: attributes.verticalAlign === 'bottom',
                            },
                        ],
                    }),
                    el(AlignmentToolbar, {
                        value: attributes.textAlign,
                        onChange: (newAlign) => setAttributes({ textAlign: newAlign }),
                    }),
                    el(components.ToolbarButton, {
                        icon: attributes.applyDarkeningGradientEffect ? 'visibility' : 'hidden',
                        label: 'Toggle Darkening Gradient Effect',
                        onClick: () => setAttributes({ applyDarkeningGradientEffect: !attributes.applyDarkeningGradientEffect }),
                        isActive: attributes.applyDarkeningGradientEffect,
                    }),
                ),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Image Settings', initialOpen: true },
                        el(MediaUpload, {
                            onSelect: onSelectImage,
                            allowedTypes: ['image'],
                            value: attributes.imageURL,
                            render: ({ open }) => el(components.Button, {
                                onClick: open,
                                className: 'components-button is-primary'
                            }, attributes.imageURL ? 'Change Image' : 'Select Image'),
                        }),
                        el(TextControl, {
                            label: 'Alt Text',
                            value: attributes.alt,
                            onChange: function (newAlt) {
                                setAttributes({ alt: newAlt });
                            },
                            placeholder: 'Describe the image',
                        }),
                        el(TextControl, {
                            label: 'Image Caption',
                            value: attributes.caption,
                            onChange: function (newCaption) {
                                setAttributes({ caption: newCaption });
                                updateMediaCaption(newCaption); // Updates media library
                            },
                            placeholder: 'Enter image caption...',
                        }),
                        el(SelectControl, {
                            label: 'Size',
                            value: attributes.size,
                            options: [
                                { label: 'Thumbnail', value: 'thumbnail' },
                                { label: 'Medium', value: 'medium' },
                                { label: 'Large', value: 'large' },
                                { label: 'Full Size', value: 'full' },
                            ],
                            onChange: function (size) {
                                setAttributes({ size: size });
                            },
                        }),
                        el(ToggleControl, {
                            label: 'Show Caption',
                            checked: attributes.showCaption,
                            onChange: () => setAttributes({ showCaption: !attributes.showCaption })
                        }),
                        el('div', { style: { display: 'flex', justifyContent: 'space-between' } },
                            el(TextControl, {
                                label: 'Width',
                                value: attributes.width,
                                onChange: function (newWidth) {
                                    setAttributes({ width: newWidth });
                                },
                                placeholder: 'auto',
                                className: 'pe-2'
                            }),
                            el(TextControl, {
                                label: 'Height',
                                value: attributes.height,
                                onChange: function (newHeight) {
                                    setAttributes({ height: newHeight });
                                },
                                placeholder: 'auto',
                                className: 'ps-2'
                            })
                        )
                    )
                ),
                blockContent
            );
        },save: function (props) {
            var attributes = props.attributes;
        
            var imageClasses = attributes.applyDarkeningGradientEffect ? 'darkening-gradient' : '';
            var imageStyles = {
                width: formatDimension(attributes.width),
                height: formatDimension(attributes.height),
                objectFit: 'cover',
            };
        
            var colSizeImage = attributes.layout === 'image' ? 'col-12' : 'col-6';
            var colSizeText = 'col-6';
        
            // Horizontal text alignment
            var textAlignClass = attributes.textAlign === 'center' ? 'text-center' : attributes.textAlign === 'right' ? 'text-end' : 'text-start';
        
            // Vertical alignment class
            var verticalAlignClass = attributes.verticalAlign === 'top' ? 'align-items-start' : attributes.verticalAlign === 'bottom' ? 'align-items-end' : 'align-items-center';
        
            if (attributes.layout === 'image') {
                return el('div', { className: `row ${verticalAlignClass}` },
                    el('div', { className: `${colSizeImage}` },
                        el('figure', { className: `wp-block-image` },
                            el('div', { className: `image-wrapper ${imageClasses}` },
                                el('img', { src: attributes.imageURL, alt: attributes.alt, style: imageStyles })
                            ),
                            attributes.showCaption && el('figcaption', { className: 'wp-caption-text' }, attributes.caption)
                        )
                    )
                );
            } else {
                // Create image and text elements
                var imageElement = el('div', { className: `${colSizeImage}` },
                    el('figure', { className: `wp-block-image` },
                        el('div', { className: `image-wrapper ${imageClasses}` },
                            el('img', { src: attributes.imageURL, alt: attributes.alt, style: imageStyles })
                        ),
                        attributes.showCaption && el('figcaption', { className: 'wp-caption-text' }, attributes.caption)
                    )
                );
        
                var textElement = el('div', { className: `${colSizeText} ${textAlignClass} media-text-content` },
                    el(RichText.Content, { tagName: 'p', value: attributes.text })
                );
                
        
                // Determine the order based on layoutOrientation
                var contentOrder = attributes.layoutOrientation === 'image-right' ? [textElement, imageElement] : [imageElement, textElement];
        
                // Apply vertical alignment to the row
                return el('div', { className: `row ${verticalAlignClass}` },
                    contentOrder
                );
            }
        },
    });
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.components);
