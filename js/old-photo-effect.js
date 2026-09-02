(function(blocks, blockEditor, element, components) {
    var el = element.createElement;
    var useBlockProps = blockEditor.useBlockProps;
    var MediaUpload = blockEditor.MediaUpload;
    var InspectorControls = blockEditor.InspectorControls;
    var PanelBody = components.PanelBody;
    var RangeControl = components.RangeControl;
    var TextControl = components.TextControl;
    var SelectControl = components.SelectControl;
    var BlockControls = blockEditor.BlockControls;
    var ToolbarGroup = components.ToolbarGroup || components.Toolbar; // Fallback for older versions
    var RichText = blockEditor.RichText;
    var AlignmentToolbar = blockEditor.AlignmentToolbar;
    const { ToolbarDropdownMenu } = wp.components;
    
    // Helper function to format width and height values properly
    function formatDimension(value) {
        return value && value !== "auto" ? `${value}px` : value;
    }

    function sanitizeContent(content) {
        // Remove opening and closing p tags
        let sanitized = content.replace(/<\/?p[^>]*>/g, "");
        // Further sanitization steps could be added here, like removing script tags or event handlers
        return sanitized;
    }

    function stopTextDeleteFromRemovingBlock(event) {
        var target = event.target;
        var isEditingText = target && (
            target.isContentEditable ||
            (target.closest && target.closest('[contenteditable="true"], textarea, input'))
        );

        if (isEditingText && (event.key === 'Backspace' || event.key === 'Delete')) {
            if (event.nativeEvent && event.nativeEvent.stopImmediatePropagation) {
                event.nativeEvent.stopImmediatePropagation();
            }
            event.stopPropagation();
        }
    }

    function createHiddenSvg() {
        return el('svg', {
            width: "0px",
            height: "0px",
            style: { position: "absolute" },
            xmlns: "http://www.w3.org/2000/svg"
        },
        el('defs', {},
            el('clipPath', { id: "oldPaperClipPath", clipPathUnits: "objectBoundingBox" },
                el('path', { d: "M 0 0.1 L 0.005 0.25 L 0.035 0.253 L 0.005 0.255 L 0 0.507 L 0 0.55 L 0.086 0.555 L 0 0.558 L 0.007 0.768 L 0 0.919 L 0 0.984 Q 0 1 0.019 1 L 0.321 0.996 L 0.492 1 L 0.653 0.995 L 0.972 1 Q 1 1 1 0.982 L 0.994 0.793 L 0.983 0.791 L 0.994 0.79 L 1 0.56 L 0.9 0.555 L 1 0.55 L 0.997 0.366 L 0.992 0.23 L 1 0.111 L 1 0.02 Q 1 0 0.976 0 L 0.819 0.003 L 0.566 0 L 0.361 0.007 L 0.03 0 Q 0 0 0 0.019 Z" })
            )
        ));
    }

    function getMediaOrderClass(layoutOrientation) {
        return layoutOrientation === 'image-right' ? 'order-md-2' : 'order-md-1';
    }

    function getTextOrderClass(layoutOrientation) {
        return layoutOrientation === 'image-right' ? 'order-md-1' : 'order-md-2';
    }

    function getVerticalAlignClass(verticalAlign) {
        switch (verticalAlign) {
            case 'top':
                return 'align-items-md-start';
            case 'bottom':
                return 'align-items-md-end';
            case 'center':
            default:
                return 'align-items-md-center';
        }
    }

    function getVerticalAlignStyle(verticalAlign) {
        switch (verticalAlign) {
            case 'top':
                return 'flex-start';
            case 'bottom':
                return 'flex-end';
            case 'center':
            default:
                return 'center';
        }
    }
    
    blocks.registerBlockType('my-plugin/wh-custom-image-block', {
        title: 'Old Photo Effect',
        icon: 'format-image',
        category: 'common',
        attributes: {
            imageURL: {
                type: 'string',
                default: '',
            },
            verticalAlign: {
                type: 'string',
                default: 'center', // Default to vertically centered
            },            
            layoutOrientation: {
                type: 'string',
                default: 'image-left', // Other value could be 'image-right'
            },            
            layout: {
                type: 'string',
                default: 'image', // Possible values: 'image', 'media-text'
            },
            textAlign: {
                type: 'string',
                default: 'left', // Default alignment
            },            
            alt: {
                type: 'string',
                default: '',
            },
            text: {
                type: 'string',
                source: 'html',
                selector: '.wp-block-my-plugin-media-text__text',
                default: '',
            },
            rotation: {
                type: 'number',
                default: 0,
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
            applyOldPhotoEffect: {
                type: 'boolean',
                default: true, // Enable the effect by default
            },
        },

        edit: function(props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var hiddenSvg = createHiddenSvg();

            function onSelectImage(media) {
                setAttributes({ imageURL: media.url});
            }
            
            // Common classes and styles for the image
            var imageClasses = `old-photo-shape ${attributes.size} ${attributes.applyOldPhotoEffect ? 'old-photo' : ''}`;
                var imageStyles = {
                transform: `rotate(${attributes.rotation}deg)`,
                width: formatDimension(attributes.width),
                height: formatDimension(attributes.height),
                objectFit: 'cover',
            };
        
            // Conditional rendering based on the selected layout
            var blockContent;
            if (attributes.layout === 'image') {
                blockContent = el('div', useBlockProps(),
                    attributes.imageURL ?
                        el('figure', { className: `wp-block-image old-photo-shadow photo-rotated ${attributes.size}`, style: imageStyles },
                            el('img', { src: attributes.imageURL, alt: attributes.alt, className: imageClasses, style: imageStyles })
                        ) :
                        el(MediaUpload, {
                            onSelect: onSelectImage,
                            allowedTypes: ['image'],
                            render: function(obj) {
                                return el('button', {
                                        className: 'components-button is-button is-default',
                                        onClick: obj.open
                                    },
                                    'Choose an image'
                                );
                            },
                        })
                );
            } else {
                var mediaOrderClass = getMediaOrderClass(attributes.layoutOrientation);
                var textOrderClass = getTextOrderClass(attributes.layoutOrientation);
                var alignmentClass = getVerticalAlignClass(attributes.verticalAlign);
                var mediaOrder = attributes.layoutOrientation === 'image-right' ? 2 : 1;
                var textOrder = attributes.layoutOrientation === 'image-right' ? 1 : 2;
                var editorColumnStyle = {
                    flex: '0 0 calc(50% - 0.75rem)',
                    width: 'calc(50% - 0.75rem)',
                    maxWidth: 'calc(50% - 0.75rem)',
                    minWidth: 0
                };

                blockContent = el('div', useBlockProps({ 
                    className: `wp-block-my-plugin-media-text ${attributes.layoutOrientation}`
                }),
                    el('div', { 
                        className: `wp-block-my-plugin-media-text__content row g-3 ${alignmentClass}`,
                        style: {
                            width: '100%',
                            display: 'flex',
                            flexDirection: 'row',
                            flexWrap: 'nowrap',
                            columnGap: '1.5rem',
                            alignItems: getVerticalAlignStyle(attributes.verticalAlign)
                        }
                    },
                        el('div', {
                            className: `wp-block-my-plugin-media-text__media old-photo-shadow col-12 col-md-6 order-1 ${mediaOrderClass}`,
                            style: Object.assign({}, editorColumnStyle, { order: mediaOrder })
                        },
                            el('img', { src: attributes.imageURL, alt: attributes.alt, className: imageClasses, style: imageStyles })
                        ),
                        el('div', {
                            className: `media-text-content col-12 col-md-6 order-2 ${textOrderClass}`,
                            onKeyDown: stopTextDeleteFromRemovingBlock,
                            style: Object.assign({}, editorColumnStyle, {
                                backgroundColor: '#fff',
                                height:'100%',
                                order: textOrder,
                                position: 'relative',
                                zIndex: 2
                            })
                        },
                            el(RichText, {
                                tagName: 'p',
                                className: 'wp-block-my-plugin-media-text__text',
                                value: attributes.text,
                                onChange: function(newText) {
                                    setAttributes({ text: newText });
                                },
                                onKeyDownCapture: stopTextDeleteFromRemovingBlock,
                                onKeyDown: stopTextDeleteFromRemovingBlock,
                                placeholder: 'Enter your text here...',
                                preservePlaceholderOnFocus: true,
                                style: { textAlign: attributes.textAlign } // Keep your existing textAlign style
                            })
                        )
                    )
                );
            }
        
            // Return the updated blockContent within the edit function
            return el(
                element.Fragment,
                {},
                el(BlockControls, {},
                    el(ToolbarGroup, {},                        
                        el(components.ToolbarButton, {
                            icon: 'format-image',
                            label: 'Image Block',
                            isActive: attributes.layout === 'image',
                            onClick: function() { setAttributes({ layout: 'image' }); }
                        }),
                        el(components.ToolbarButton, {
                            icon: 'text',
                            label: 'Media & Text Block',
                            isActive: attributes.layout === 'media-text',
                            onClick: function() { setAttributes({ layout: 'media-text' }); }
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
                        icon: 'sort', // or any appropriate icon
                        label: 'Select vertical alignment',
                        controls: [
                            {
                                title: 'Top',
                                icon: 'arrow-up-alt2', // You can choose an appropriate icon
                                onClick: () => setAttributes({ verticalAlign: 'top' }),
                                isActive: attributes.verticalAlign === 'top',
                            },
                            {
                                title: 'Middle',
                                icon: 'align-center', // You can choose an appropriate icon
                                onClick: () => setAttributes({ verticalAlign: 'center' }),
                                isActive: attributes.verticalAlign === 'center',
                            },
                            {
                                title: 'Bottom',
                                icon: 'arrow-down-alt2', // You can choose an appropriate icon
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
                        icon: attributes.applyOldPhotoEffect ? 'visibility' : 'hidden', // Icons are illustrative; choose appropriate ones
                        label: 'Toggle Old Photo Effect',
                        onClick: () => setAttributes({ applyOldPhotoEffect: !attributes.applyOldPhotoEffect }),
                        isActive: attributes.applyOldPhotoEffect,
                    }),
                ),
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Image Settings', initialOpen: true },
                        el(MediaUpload, {
                            onSelect: onSelectImage,
                            allowedTypes: ['image'],
                            value: attributes.imageURL, // Assuming this is the image ID
                            render: ({ open }) => el(components.Button, {
                                onClick: open,
                                className: 'components-button is-primary'
                            }, attributes.imageURL ? 'Change Image' : 'Select Image'),
                        }),
                        el(TextControl, {
                            label: 'Alt Text',
                            value: attributes.alt,
                            onChange: function(newAlt) {
                                setAttributes({ alt: newAlt });
                            },
                            placeholder: 'Describe the image',
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
                            onChange: function(size) {
                                setAttributes({ size: size });
                            },
                        }),
                        el('div', { style: { display: 'flex', justifyContent: 'space-between' } },
                            el(TextControl, {
                                label: 'Width',
                                value: attributes.width,
                                onChange: function(newWidth) {
                                    setAttributes({ width: newWidth });
                                },
                                placeholder: 'auto',
                                className: 'pe-2' // Add your custom class here
                            }),
                            el(TextControl, {
                                label: 'Height',
                                value: attributes.height,
                                onChange: function(newHeight) {
                                    setAttributes({ height: newHeight });
                                },
                                placeholder: 'auto',
                                className: 'ps-2' // Add your custom class here
                            })
                        ),                        
                        el(RangeControl, {
                            label: 'Rotate Image',
                            value: attributes.rotation,
                            onChange: function(angle) {
                                setAttributes({ rotation: angle });
                            },
                            min: -180,
                            max: 180,
                            step: 1,
                        }),                        
                    )
                ),
                hiddenSvg,
                blockContent
            );
        },

        save: function(props) {
            var attributes = props.attributes;
            // Define common classes and styles for the image
            var imageClasses = `old-photo-shape ${attributes.size} ${attributes.applyOldPhotoEffect ? 'old-photo' : ''}`;
            
            var imageStyles = {
                transform: `rotate(${attributes.rotation}deg)`,
                width: formatDimension(attributes.width),
                height: formatDimension(attributes.height),
                objectFit: 'cover',
            };
                    // Implement save logic for both layouts
            if (attributes.layout === 'image') {
                return el(element.Fragment, {},
                    createHiddenSvg(),
                    el('figure', useBlockProps.save({ className: `wp-block-image old-photo-shadow photo-rotated ${attributes.size}` }),
                        el('img', { src: attributes.imageURL, alt: attributes.alt, className: imageClasses, style: imageStyles }),
                    )
                );
            } else {
                var mediaOrderClass = getMediaOrderClass(attributes.layoutOrientation);
                var textOrderClass = getTextOrderClass(attributes.layoutOrientation);
                var alignmentClass = getVerticalAlignClass(attributes.verticalAlign);

                return el(element.Fragment, {},
                    createHiddenSvg(),
                    el('div', useBlockProps.save({ className: `wp-block-my-plugin-media-text ${attributes.layoutOrientation}` }),
                        el('div', {
                            className: `wp-block-my-plugin-media-text__content row g-3 ${alignmentClass}`,
                            style: { width: '100%' }
                        },
                            el('figure', { className: `wp-block-image old-photo-shadow photo-rotated ${attributes.size} col-12 col-md-6 order-1 ${mediaOrderClass}` },
                                el('img', { src: attributes.imageURL, alt: attributes.alt, className: imageClasses, style: imageStyles })
                            ),
                            el('div', { className: `media-text-content col-12 col-md-6 order-2 ${textOrderClass}`, style: { height:'100%' } },
                                el(RichText.Content, {
                                    tagName: 'p', // Specifies that the content should be wrapped with a <p> tag
                                    className: 'wp-block-my-plugin-media-text__text',
                                    value: sanitizeContent(attributes.text),
                                    style: { textAlign: attributes.textAlign }
                                })
                            )
                        )
                    )
                );
            }
        },
    });
})(window.wp.blocks, window.wp.blockEditor, window.wp.element, window.wp.components);
