const { registerBlockType } = wp.blocks;
const { InspectorControls } = wp.blockEditor;
const { PanelBody, RangeControl, ToggleControl, SelectControl } = wp.components;
const { __ } = wp.i18n;
const { createElement, useEffect, useState } = wp.element;

registerBlockType('black-hawk-solutions/recent-posts', {
    title: __('Recent Posts or Galleries'),
    description: __('A block that displays recent posts or galleries in Bootstrap card format.'),
    icon: 'admin-post',
    category: 'black-hawk',
    attributes: {
        postCategory: {
            type: 'string',
            default: 'all',
        },
        postsToShow: {
            type: 'number',
            default: 4,
        },
        showExcerpt: {
            type: 'boolean',
            default: true,
        },
        selectExcerptWordCount: {
            type: 'number',
            default: 20,
        },
        enableGradient: {
            type: 'boolean',
            default: false, // Gradient disabled by default
        },
        enableRoundedBottom: {
            type: 'boolean',
            default: false, // disable rounded bottom by default
        },
        roundedBottomSize: {
            type: 'number',
            default: 4, // Default rounded size
        },
        enableBorders: {
            type: 'boolean',
            default: true, // enable borders by default
        },
        borderWidth: {
            type: 'number',
            default: 2, // Default border width
        }, 
        useButton: {
            type: 'boolean',
            default: true, // enable borders by default
        },          
    },
    edit: (props) => {
        const { attributes, setAttributes } = props;
        const { postCategory, 
            postsToShow, 
            showExcerpt, 
            selectExcerptWordCount, 
            enableGradient, 
            enableRoundedBottom,
            roundedBottomSize, 
            enableBorders,
            borderWidth,
            useButton } = attributes;

        const [categories, setCategories] = useState([]);

        // Fetch categories for post type
        useEffect(() => {
            wp.apiFetch({ path: '/wp/v2/categories' }).then((postCategories) => {
                // Add a "Galleries" option manually
                const galleryOption = { id: 'galleries', name: __('Galleries'), slug: 'galleries' };
                setCategories([{ id: 'all', name: __('All Categories'), slug: 'all' }, ...postCategories, galleryOption]);
            });
        }, []);

        return createElement(
            'div',
            null,
            createElement(InspectorControls, null,
                createElement(PanelBody, { title: __('Settings') },
                    createElement(SelectControl, {
                        label: __('Select Category'),
                        value: postCategory,
                        options: categories.map((category) => ({
                            label: category.name,
                            value: category.slug
                        })),
                        onChange: (value) => setAttributes({ postCategory: value }),
                    }),
                    createElement(RangeControl, {
                        label: __('Number of posts to show'),
                        value: postsToShow,
                        onChange: (value) => setAttributes({ postsToShow: value }),
                        min: 1,
                        max: 12,
                    }),
                    createElement(ToggleControl, {
                        label: __('Show post excerpt'),
                        checked: showExcerpt,
                        onChange: (value) => setAttributes({ showExcerpt: value })
                    }),
                    createElement(RangeControl, {
                        label: __('Excerpt Word Count'),
                        value: selectExcerptWordCount,
                        onChange: (value) => setAttributes({ selectExcerptWordCount: value }),
                        min: 1,
                        max: 100,
                    }),
                    createElement(ToggleControl, {
                        label: __('Enable Gradient Overlay'),
                        checked: enableGradient,
                        onChange: (value) => setAttributes({ enableGradient: value })
                    }),
                    createElement(ToggleControl, {
                        label: __('Enable rounded bottom on images'),
                        checked: enableRoundedBottom,
                        onChange: (value) => setAttributes({ enableRoundedBottom: value })
                    }),
                    createElement(RangeControl, {
                        label: __('Rounded Bottom Size'),
                        value: roundedBottomSize,
                        onChange: (value) => setAttributes({ roundedBottomSize: value }),
                        min: 0,
                        max: 5,
                    }),
                    createElement(ToggleControl, {
                        label: __('Enable borders'),
                        checked: enableBorders,
                        onChange: (value) => setAttributes({ enableBorders: value })
                    })    ,
                    createElement(RangeControl, {
                        label: __('Border Width'),
                        value: borderWidth,
                        onChange: (value) => setAttributes({ borderWidth: value }),
                        min: 0,
                        max: 5,
                    }),
                    createElement(ToggleControl, {
                        label: __('Use "Read More" Button'),
                        checked: useButton,
                        onChange: (value) => setAttributes({ useButton: value }),
                    }),
                                     
                )
            ),
            createElement('p', null, __('Recent posts or galleries will be displayed in Bootstrap card format.'))
        );
    },
    save: () => {
        return null; // Server-side rendering
    },
});
