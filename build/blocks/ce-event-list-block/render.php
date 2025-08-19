<style>
	.ce-banner {
		display: block;
		background-color: #d85f27;
		color: white;
	}

	.eventCard .eventInformation, .eventCard .eventDateInformation {
		float: none;
		display: inline-block;
		vertical-align: top;
		box-sizing: border-box;
	}

	.eventCard .eventDateInformation {
		width: 20%;
		max-width: 200px;
		margin-top: 25px;
	}

	.eventCard .eventInformation{
		width: 75%;
		border-right: none;
		border-left: solid 1px black;
	}

	.eventCard .eventInformation .eventTitle {
		color: #d95e16;
		font-weight: bold;
	}

	.eventDay, .eventTime {
		margin-bottom: 5px;
	}

	.eventDayStatic {
		font-weight:bold;
		color: #d95e16;
		text-decoration: underline;
	}

    .eventDayDynamic {
        font-weight: normal;
    }

	.eventCard {
        text-decoration: none !important;
		padding: 10px 15px;
		border-top: none;
		margin-bottom: 5px;
		font-weight: normal;
		display: block;
		color: black;
	}

	.eventCard:nth-child(odd){
		background-color: #fafafa;
	}

	.eventCard:nth-child(even) {
		background-color: #eee;
	}

	.eventCard:hover {
		background-color: #cacaca;
        text-decoration: none;
	}

	.eventStartDate {
		font-weight: bold;
	}

</style>

<?php
$posts = get_posts(array(
    'post_type'         => 'ce-event',
    'posts_per_page'    => -1,
    'meta_query' => array(
	'relation' => 'AND',
    'date_clause' => array(
        'key' => 'date',
		'compare'	=> '=',
    ),
    'time_clause' => array(
        'key' => 'time',
		'compare'	=> '=',
    ),),
    'orderby' => array(
	'date_clause' => 'ASC',
	'time_clause' => 'ASC',
),
    'order'             => 'ASC'
));

if( $posts ):
    foreach( $posts as $post ): 
        $fields = get_fields($post->ID);
        $today = date("m/d/Y");
        if($fields['date'] < $today){
            wp_trash_post($post->ID);
            continue;
        }
        ?>
        <a href="<?=$post->guid;?>" class='eventCard'>
            <div class="eventDateInformation">
                <div class='eventStartDate'>
                    <div class='eventDay'><span class="eventDayStatic">Date:</span> <span class="eventDayDynamic"><?= $fields['date'];?></span></div>
                    <div class="eventDay"><span class="eventDayStatic">Time:</span> <span class="eventDayDynamic"><?= strtoupper($fields['time']);?> EST</span></div>
                </div>
            </div>
            <div class='eventInformation'>
                <p class='eventTitle'><span><?=$fields['event_nametitle'];?></span></p>
                <p>Presenter: <?=$fields['presenter'];?></p>
                <p>Event Sponsor: <?=$fields['event_sponsor'];?></p>
                <p>Cost of Training: <?=$fields['cost'];?></p>
                <p>CE Credits: <?=$fields['ce_credits'];?></p>
            </div>
        </a>

    <?php endforeach;
    
endif;