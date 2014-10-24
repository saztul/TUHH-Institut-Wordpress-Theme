<?php
require_once get_template_directory() . '/classes/TUHH_UI.php';
$tuhh_ui = new TUHH_UI(TUHH_Teaser_Settings::get_instance());

?>
<div class="wrap tuhh-tabs">
    <?php screen_icon(); ?>
    <h2>TUHH Teaser Slides</h2>			
    <form method="post" action="options.php">
		<?php settings_fields( TUHH_Teaser_Settings::SETTINGS_NAME ); ?>
    	<?php do_settings_sections( TUHH_Teaser_Settings::SETTINGS_NAME ); ?>
     	<div class=tab-view data-remember-as=tuhh-teaser>
            <div class=tab-group>
                <div data-title="Slide 1" class="tab">
                    <h3>Slide 1:</h3>
			        <table class="form-table">
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_1_active">Slide anzeigen</label></th>
			            <td><?php $tuhh_ui->checkbox('teaser_slide_1_active'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_1_title">Titel</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_1_title'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_1_link">Link</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_1_link'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_1_text">Text</label></th>
			            <td><?php $tuhh_ui->text_area('teaser_slide_1_text'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label>Hintergrundbild</label></th>
			            <td><?php $tuhh_ui->upload("teaser_slide_1_image")?></td>
						</tr>
			       	</table>
				</div>
                <div data-title="Slide 2" class="tab">
                    <h3>Slide 2:</h3>
			        <table class="form-table">
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_2_active">Slide anzeigen</label></th>
			            <td><?php $tuhh_ui->checkbox('teaser_slide_2_active'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_2_title">Titel</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_2_title'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_2_link">Link</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_2_link'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_2_text">Text</label></th>
			            <td><?php $tuhh_ui->text_area('teaser_slide_2_text'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label>Hintergrundbild</label></th>
			            <td><?php $tuhh_ui->upload("teaser_slide_2_image")?></td>
						</tr>
			       	</table>
                </div>
                <div data-title="Slide 3" class="tab">
                    <h3>Slide 3:</h3>
			        <table class="form-table">
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_3_active">Slide anzeigen</label></th>
			            <td><?php $tuhh_ui->checkbox('teaser_slide_3_active'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_3_title">Titel</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_3_title'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_3_link">Link</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_3_link'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_3_text">Text</label></th>
			            <td><?php $tuhh_ui->text_area('teaser_slide_3_text'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label>Hintergrundbild</label></th>
			            <td><?php $tuhh_ui->upload("teaser_slide_3_image")?></td>
						</tr>
			       	</table>
				</div>
                <div data-title="Slide 4" class="tab">
                    <h3>Slide 4:</h3>
			        <table class="form-table">
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_4_active">Slide anzeigen</label></th>
			            <td><?php $tuhh_ui->checkbox('teaser_slide_4_active'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_4_title">Titel</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_4_title'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_4_link">Link</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_4_link'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_4_text">Text</label></th>
			            <td><?php $tuhh_ui->text_area('teaser_slide_4_text'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label>Hintergrundbild</label></th>
			            <td><?php $tuhh_ui->upload("teaser_slide_4_image")?></td>
						</tr>
			       	</table>
				</div>
                <div data-title="Slide 5" class="tab">
                    <h3>Slide 5:</h3>
			        <table class="form-table">
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_5_active">Slide anzeigen</label></th>
			            <td><?php $tuhh_ui->checkbox('teaser_slide_5_active'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_5_title">Titel</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_5_title'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_5_link">Link</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_5_link'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_5_text">Text</label></th>
			            <td><?php $tuhh_ui->text_area('teaser_slide_5_text'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label>Hintergrundbild</label></th>
			            <td><?php $tuhh_ui->upload("teaser_slide_5_image")?></td>
						</tr>
			       	</table>
				</div>
                <div data-title="Slide 6" class="tab">
                    <h3>Slide 6:</h3>
			        <table class="form-table">
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_6_active">Slide anzeigen</label></th>
			            <td><?php $tuhh_ui->checkbox('teaser_slide_6_active'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_6_title">Titel</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_6_title'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_6_link">Link</label></th>
			            <td><?php $tuhh_ui->text_field('teaser_slide_6_link'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label for="tuhh_teaser_slide_6_text">Text</label></th>
			            <td><?php $tuhh_ui->text_area('teaser_slide_6_text'); ?></td>
			        	</tr>
			        	<tr valign="top">
			            <th scope="row"><label>Hintergrundbild</label></th>
			            <td><?php $tuhh_ui->upload("teaser_slide_6_image")?></td>
						</tr>
			       	</table>
				</div>
			</div>
		</div>
		<?php submit_button(); ?>
	</form>
</div>   	
<?php
