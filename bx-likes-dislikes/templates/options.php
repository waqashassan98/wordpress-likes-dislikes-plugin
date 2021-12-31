<?php
/**
 * Plugin Options Page
 * 
 */
 ?>

<?php
 	$args = array(
       'public'   => true,
    );
    $output   = 'names'; // names or objects, note names is the default
    $operator = 'or'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator );
?>

<div class="wrap">
    
    <h2><?php _e('Like Dislike Plugin Options'); ?></h2>
    	    	
	<div>
	
		<div id="post-body" class="columns-3">
			
			<!-- main content -->
			<div id="post-body-content">
				
				<div class="meta-box">
					
					<!-- <form method="post" action=""> -->
						  <form method="post" action="options.php">
						    <?php settings_fields( 'bxlikes_dislikes_options' ); ?>
						    <?php do_settings_sections( 'bxlikes_dislikes_options' ); ?>

    					<?php //settings_fields('bxlikes_dislikes_options'); ?>
    					<?php //do_settings_sections('bxlikes_dislikes_options'); ?>

    					<h2><?php _e('Settings'); ?></h2>

    					<table class="form-table">
    						<tbody>
    							<tr valign="top">
    								<th scope="row"><label for="bxlikes_dislikes_post_type">Select Post Type</label></th>
    								<td>
    									<select name="bxlikes_dislikes_post_type" class="regular-text" id="bxlikes_dislikes_post_type">
    										<?php 
    										$selected = esc_attr( get_option('bxlikes_dislikes_post_type') );
    										foreach ( $post_types  as $post_type ) {
    											$isselected = "";
    											if ($post_type == $selected) {
    												$isselected = "selected";
    											}
										       echo '<option value="'. $post_type .'" '.$isselected.'>' . $post_type . '</option>';

										    }?>
										</select>
									</td>
    							</tr>
    							<tr valign="top">
    								<th scope="row"><label for="bxlikes_dislikes_test">Test</label></th>
    								<td>
										<input type="text" class="regular-text" id="bxlikes_dislikes_test" name="bxlikes_dislikes_test" value="<?php echo esc_attr( get_option('bxlikes_dislikes_test') ); ?>">
									</td>
    							</tr>
    							<tr valign="top">
    								<th scope="row"><label for="bxlikes_dislikes_test2">Test 2</label></th>
    								<td>
										<input type="text" class="regular-text" id="bxlikes_dislikes_test2" name="bxlikes_dislikes_test2" value="<?php echo esc_attr( get_option('bxlikes_dislikes_test2') ); ?>">
									</td>
    							</tr>
    						</tbody>
    					</table>

    					<?php submit_button(); ?>

					</form>
					
				</div><!-- .meta-box -->
				
			</div><!-- post-body-content -->
			
			
		</div><!-- #post-body .metabox-holder .columns-2 -->
		
		<br class="clear">
		
	</div><!-- #poststuff -->
			
</div> <!-- .wrap -->