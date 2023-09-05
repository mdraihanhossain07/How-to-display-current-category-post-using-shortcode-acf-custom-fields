<?php 

// Current category post

function shortcode_callback_func_watch_list_cat( $atts = array(), $s_content = '' ) {

	global $post;

	$args = array(
	    'post_type' => 'brands',
	    'posts_per_page' =>6 ,
	    'tax_query' => array(
	        array(
	            'taxonomy' => 'brand',
	            'field'    => 'term_id',
				// 	'terms'    => array( 40 ), If need individual category post, show this line  and hide this( terms' => get_queried_object_id() ) line
				'terms' => get_queried_object_id(),
	            'operator' => 'AND',
	        ),
	    ),
	);


    $loop = new WP_Query( $args );
    $s_content .= '<div class="watch-grid-row">';
    while ( $loop->have_posts() ) : $loop->the_post(); 
	
    	$terms = get_the_terms( $post->ID , 'brand' );
    	$watch_cat = '';
		
		if (is_array($terms) || is_object($terms)){
			foreach ( $terms as $term ) {
				
				$watch_cat_link = get_term_link($term->slug, 'brand');
			$watch_cat = '<a href="'.$watch_cat_link.'">'.$term->name.'</a>';
		}}

    	$s_content .= '<div class="single-watch-item-col">';
    		$s_content .= '<div class="single-watch-item">';
	    		$s_content .= '<div class="watch-front-area">';

	    			$s_content .= '<div class="watch-image">';
	    				$s_content .='<img src="'.get_the_post_thumbnail_url().'"/>';
					$s_content .= "</div>";

	    			$s_content .= '<div class="watch-title">';
						$s_content .='<h3>'.get_the_title().'</h3>';
						$s_content .='<span class="watch-category">'. $watch_cat.'</span>';
					$s_content .='</div>';
					
				$s_content .='</div>';

				$s_content .= '<div class="watch-hover-area">';
					$s_content .= '<div class="watch-hover-area-content">';
						$s_content .='<h3><a href="'.get_the_permalink().'">'.get_the_title().'</a></h3>';
						$s_content .='<span class="watch-category">'. $watch_cat.'</span>';

						$s_content .='<table>';
							$s_content .='<thead>';
								$s_content .='<tr>';
								if (get_field('condition')) {
									$s_content .='<th>Condition</th>';
								}

								if (get_field('box')) {
									$s_content .='<th>Box</th>';
								}

								if (get_field('papers')) {
									$s_content .='<th>Papers</th>';
								}
									
								$s_content .='</tr>';
							$s_content .='</thead>';

							$s_content .='<tbody>';
								$s_content .='<tr>';

									if (get_field('condition')) {
										$s_content .='<td>'.get_field('condition').'</td>';
									}

									if (get_field('box')) {
										$s_content .='<td>'.get_field('box').'</td>';
									}

									if (get_field('papers')) {
										$s_content .='<td>'.get_field('papers').'</td>';
									}
									
								$s_content .='</tr>';
							$s_content .='</tbody>';

						$s_content .='</table>';

						if (get_field('price')) {
							$s_content .='<span class="watch-price">$'.get_field('price').'</span>';
						}
						$s_content .='<a class="watch-btn"  href="'.get_the_permalink().'">Learn more</a>';

					$s_content .='</div>';
				$s_content .='</div>';

			$s_content .='</div>';
		$s_content .='</div>';


	endwhile; 

	wp_reset_query(); 
	$s_content .= '</div>'; 


	return $s_content;
}
add_shortcode( 'watch_list_cat', 'shortcode_callback_func_watch_list_cat' );
