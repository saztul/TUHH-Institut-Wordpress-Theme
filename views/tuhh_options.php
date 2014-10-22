<?php
$TUHH_Settings = TUHH_Settings::get_instance();
$option_name = $TUHH_Settings->option_name();

function tuhh_color_field($name){
	$TUHH_Settings = TUHH_Settings::get_instance();
	$option_name = $TUHH_Settings->option_name();
	echo '<input type="text" '.
            'class="tuhh-color-field" '. 
            'id="tuhh_'.$name.'" '.
            'name="'.$option_name.'['.$name.']" '. 
            'value="'.esc_attr( $TUHH_Settings->option($name) ).'" />';
}

function tuhh_text_field($name){
	$TUHH_Settings = TUHH_Settings::get_instance();
	$option_name = $TUHH_Settings->option_name();
	echo '<input type="text" '.
            'name="'.$option_name.'['.$name.']" '. 
            'id="tuhh_'.$name.'" '.
            'value="'.esc_attr( $TUHH_Settings->option($name) ).'" />';
}

function tuhh_text_area($name){
	$TUHH_Settings = TUHH_Settings::get_instance();
	$option_name = $TUHH_Settings->option_name();
	echo '<textarea class="wp-editor-area" rows="14" '.
            'name="'.$option_name.'['.$name.']" '. 
            'id="tuhh_'.$name.'" '.
            '>'.esc_attr( $TUHH_Settings->option($name) ).'</textarea>';
}

function tuhh_checkbox($name){
	$TUHH_Settings = TUHH_Settings::get_instance();
	$option_name = $TUHH_Settings->option_name();
	$fname = $option_name.'['.$name.']';
	echo '<input type="hidden" name="'.$fname.'" value="0">';
	echo '<input type="checkbox" '.
            'name="'.$fname.'" '.
            'id="tuhh_'.$name.'" '.
            ($TUHH_Settings->option($name) == '1' ? 'checked="checked" ' : ''). 
            'value="1" />';
}

function tuhh_upload($name){
	$TUHH_Settings = TUHH_Settings::get_instance();
	$option_name = $TUHH_Settings->option_name();
	$fname = $option_name.'['.$name.']';
	
	echo '<label for="upload_image">'.
			'<input class="tuhh_upload" type="text" size="36" name="'.$fname.'" value="'.esc_attr( $TUHH_Settings->option($name) ).'" />'.
			'<input class="tuhh_upload_button button" type="button" value="Upload Image" />'.
			'<br />Geben Sie eine URL ein oder laden Sie ein Bild hoch'.
			'</label>';

}

?>
<div class="wrap tuhh-tabs">
    <?php screen_icon(); ?>
    <h2>TUHH Institut Theme Options</h2>			
    <form method="post" action="options.php">
		<?php settings_fields( TUHH_Settings::SETTINGS_NAME ); ?>
    	<?php do_settings_sections( TUHH_Settings::SETTINGS_NAME ); ?>
    	
    	<div class=tab-view>
            <div class=tab-group>
                <div data-title="Kopfzeile" class="tab">
                    <h3>Kopfzeile:</h3>
			        <table class="form-table">
			        <tr valign="top">
			            <th scope="row"><label>Institutslogo</label></th>
			            <td><?php tuhh_upload("header_institute_logo")?></td>
						</tr>
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_header_collapse_on_front_page">Auf der Startseite einklappen</label></th>
			            <td><?php tuhh_checkbox('header_collapse_on_front_page'); ?></td>
			            </tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_header_collapse_on_other_pages">Auf anderen Seiten einklappen</label></th>
			            <td><?php tuhh_checkbox('header_collapse_on_other_pages'); ?></td>
			            </tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_header_background_color">Hintergrundfarbe</label></th>
			            <td><?php tuhh_color_field('header_background_color'); ?></td>
			            </tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_header_text_color">Textfarbe</label></th>
			            <td><?php tuhh_color_field('header_text_color'); ?></td>
			            </tr>
			            </table>
                    </div>
            	<div data-title="Navigation" class="tab">
                    <h3>Brotkrumennavigation:</h3>
			        <table class="form-table">
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_breadcrumb_root_element_title">Titel für das Wurzelelement</label></th>
			            <td><?php tuhh_text_field('breadcrumb_root_element_title'); ?></td>
			            </tr>
						<tr valign="top">
			            <th scope="row"><label for="tuhh_breadcrumb_separator_color">Farbe des Pfadtrenners</label></th>
			            <td><?php tuhh_color_field('breadcrumb_separator_color'); ?></td>
			            </tr>
		            </table>
                    <h3>Sprachen:</h3>
		            <table class="form-table">
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_header_url_of_german_website">Adresse der deutschen Webseite</label></th>
			            <td><?php tuhh_text_field('header_url_of_german_website'); ?></td>
			            </tr>
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_header_url_of_english_website">Adresse der englischen Webseite</label></th>
			            <td><?php tuhh_text_field('header_url_of_english_website'); ?></td>
			            </tr>
		            </table>
                </div>
            	<div data-title="Inhalt" class="tab">
                    <h3>Inhalt:</h3>
			        <table class="form-table">
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_body_link_color">Link-Farbe</label></th>
			            <td><?php tuhh_color_field('body_link_color'); ?></td>
			            </tr>
						<tr valign="top">
			            <th scope="row"><label for="tuhh_body_link_hover_color">Link-Hover-Farbe</label></th>
			            <td><?php tuhh_color_field('body_link_hover_color'); ?></td>
			            </tr>
			        </table>
                    </div>
            	<div data-title="Fußzeile" class="tab">
					<h3>Fußzeile:</h3>
					<table class="form-table">
						<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_address">Adresse</label></th>
			            <td><?php tuhh_text_area('footer_address'); ?></td>
			            </tr>
						<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_contact">Kontakt</label></th>
			            <td><?php tuhh_text_field('footer_contact'); ?></td>
			            </tr>
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_footer_imprint_url">Impressum</label></th>
			            <td><?php tuhh_text_field('footer_imprint_url'); ?></td>
			            </tr>
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_footer_intranet_url">Intranet</label></th>
			            <td><?php tuhh_text_field('footer_intranet_url'); ?></td>
		            	</tr>
                    	<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_feed_url">RSS Feed</label></th>
			            <td><?php tuhh_text_field('footer_feed_url'); ?></td>
			            </tr>
			        </table>
                </div>
            	<div data-title="Soziale Netzwerke" class="tab">
					<h3>Links zu sozialen Netzwerken:</h3>
					<table class="form-table">
			            <tr valign="top">
			            <th scope="row"><label for="tuhh_footer_social_facebook_url">Facebook Seite</label></th>
			            <td><?php tuhh_text_field('footer_social_facebook_url'); ?></td>
			            </tr>
                    	<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_social_twitter_url">Twitter</label></th>
			            <td><?php tuhh_text_field('footer_social_twitter_url'); ?></td>
			            </tr>
                    	<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_social_google_plus_url">Google+ Seite</label></th>
			            <td><?php tuhh_text_field('footer_social_google_plus_url'); ?></td>
			            </tr>
                    	<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_social_flickr_url">Flickr</label></th>
			            <td><?php tuhh_text_field('footer_social_flickr_url'); ?></td>
			            </tr>
                    	<tr valign="top">
			            <th scope="row"><label for="tuhh_footer_social_youtube_url">Youtube Kanal</label></th>
			            <td><?php tuhh_text_field('footer_social_youtube_url'); ?></td>
			            </tr>
		        	</table>
				</div>
			</div>
		</div>    	
    	
    	
    	
        <?php submit_button(); ?>
    </form>
</div>
<script type='text/javascript'>  
    jQuery(document).ready(function() {  
        jQuery('.tuhh-color-field').wpColorPicker();  
    });  
</script>