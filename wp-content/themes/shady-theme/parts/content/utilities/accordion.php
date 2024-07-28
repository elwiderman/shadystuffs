<?php    

$check = get_post_meta($post->ID, 'lf_radio', true);	
$group_values = rwmb_meta( 'accordion' );

if ( ! empty( $group_values ) ) :

	if($check == '' || $check == 'accordion'):
		echo '<ul class="accordion" data-accordion data-allow-all-closed="true">';
		
	    foreach ( $group_values as $group_value ) :
	    	
	    	$content = apply_filters('the_content', $group_value['lf_description']);
	    	
	    	echo <<<HTML
			<li class="accordion-item" data-accordion-item>
				<a href="#" class="accordion-title size-18 bold">{$group_value['lf_title']}</a>
				<div class="accordion-content" data-tab-content>
					{$content}
				</div>
			</li>
HTML;
	    endforeach;
	    
	    echo '</ul>';
	
	else:
		echo '<ul class="tabs" data-tabs id="tabs">';
			$i = 1;
			foreach ( $group_values as $group_value ) :
				$active = ($i == 1) ? 'is-active' : '';
				echo <<<TITLE
				<li class="tabs-title {$active}">
					<a href="#panel{$i}" aria-selected="true">
						{$group_value['lf_title']}
					</a>
				</li>		
TITLE;
				$i++;
			endforeach;
		echo '</ul>';
		
		echo '<div class="tabs-content" data-tabs-content="tabs">';
			$i = 1;
			foreach ( $group_values as $group_value ) :
				$active = ($i == 1) ? 'is-active' : '';
				$content = apply_filters('the_content', $group_value['lf_description']);
				
				echo <<<PANEL
				<div class="tabs-panel {$active}" id="panel{$i}">
					{$content}
				</div>
PANEL;
				$i++;
			endforeach;
		echo '</div>';
		
	endif;
	
endif;	
?>