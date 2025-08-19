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

import ServerSideRender from "@wordpress/server-side-render";

export default function Edit( { attributes, setAttributes } ) {
    const [eventData, setEventData] = useState(null);
    console.log(attributes.events);
    useEffect(() => {
		fetch("http://mvswpdev.midwestvet.local//wp-json/wp/v2/ce-event")
		.then((resp) => resp.json())
		.then((resp) => {
            setEventData(resp);
            attributes.events = resp;
			setAttributes({events:resp});
            console.log(resp);
		})
		.catch((err)=>console.log(err));
	}, [])
    

	return (
		<p {...useBlockProps()}>
			{eventData && (
				<>
				<div id="events" className="background">
					{eventData.map((event) => {
                        return (
                            <>
                            <a href={event.link+ "?id=" + event.id} class='eventCard'>
                                <div class='eventDateInformation'>
                                    <div class='eventStartDate'>
                                        <div class='eventDay'><span>Date:</span> Open Date</div>
                                    </div>
                                </div>
                                <div class='eventInformation'>
                                    <p class='eventTitle'><span>{event.acf.event_nametitle}</span></p>
                                    <p>Presenter: {event.acf.presenter}</p>
                                    <p>Event Sponsor: {event.acf.event_sponsor}</p>
                                    <p>Cost of Training: {event.acf.cost}</p>
                                    <p>CE Credits: {event.acf.ce_credits}</p>
                                </div>
                            </a>
                            </>
                        );
                    })}
			    </div>
                
		        </>
                
		)}
        
		</p>
	);

    return (
        <>
            <InspectorControls>
                <PanelBody title={ __( 'Settings', 'copyright-date-block' ) }>
                    <ToggleControl
                        checked={ !! showStartingYear }
                        label={ __(
                            'Show starting year',
                            'copyright-date-block'
                        ) }
                        onChange={ () =>
                            setAttributes( {
                                showStartingYear: ! showStartingYear,
                            } )
                        }
                    />
                    { showStartingYear && (
                        <TextControl
                            label={ __(
                                'Starting year',
                                'copyright-date-block'
                            ) }
                            value={ startingYear || '' }
                            onChange={ ( value ) =>
                                setAttributes( { startingYear: value } )
                            }
                        />
                    ) }
                </PanelBody>
            </InspectorControls>
            <p { ...useBlockProps() }>© { displayDate }</p>
        </>
    );
}