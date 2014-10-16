<div class="wrap">
    <?php screen_icon(); ?>
    <h2>TUHH Institut Theme Options</h2>			
    <form method="post" action="options.php">
		<?php settings_fields( TUHH_Settings::SETTINGS_NAME ); ?>
    	<?php do_settings_sections( TUHH_Settings::SETTINGS_NAME ); ?>
    	
    	
    	
    	
    	
    	
    	
    	
        <?php submit_button(); ?>
    </form>
</div>
