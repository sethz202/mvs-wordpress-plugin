/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
import { InspectorControls} from '@wordpress/block-editor';
import {PanelBody, TextControl, ToggleControl} from '@wordpress/components';
import { useEffect, useState } from "@wordpress/element";


export default function Edit( { attributes, setAttributes } ) {
    let boxList = [];
    const { group } = attributes;

        if(group != '')   {
            boxList = ['Anesthesia',
                'Cages',
                'Dental',
                'Diagnostics',
                'Fluid Administration',
                'Grooming',
                'Hospital',
                'Imaging/X-Ray',
                'Laboratory',
                'Lighting',
                'Monitors',
                'Optic/Otic',
                'Scales',
                'Signage',
                'Sinks/Tables/Tubs',
                'Sterilization',
                'Stethoscopes',
                'Surgery',
                'Therapy'];
            console.log(boxList)
        } 


    return (
        <>
        <InspectorControls>
                <PanelBody title={ __( 'Settings', 'equipment-library-block' ) }>
                        <TextControl
                            label={ __(
                                'ACF Group',
                                'copyright-date-block'
                            ) }
                            value={ group || '' }
                            onChange={ ( value ) =>
                                setAttributes( { group: value } )
                            }
                        />
                </PanelBody>
            </InspectorControls>
		<div {...useBlockProps()}>
			{group ? (
				<>
                test
				<div id="events" className="background">
					{boxList.map((box) => {
                        return (
                            <>
                            <div id={box} class="equipment-box">
                                {box}
                            </div>
                            </>
                        );
                    })}
			    </div>
		        </>
		) : (<div>
            Go into settings to set a group
        </div>)
    }
		</div>
        </>
	);
}