<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package TUHH Institute
 */
$config = TUHH_Institute::config();
?>
    </div>
    <div class="footer-bumper"></div>
  </div>


  <footer id="page-footer">
    <p id="change-info">
        
      <?php tuhh_institute_posted_on(); ?>
    </p>
    
    <p id="social-links">
  	  <?php echo $config->facebook_link(); ?>
  	  <?php echo $config->twitter_link(); ?>
  	  <?php echo $config->google_plus_link(); ?>
  	  <?php echo $config->flickr_link(); ?>
  	  <?php echo $config->youtube_link(); ?>
  	  <?php echo $config->feed_link(); ?>
	</p>
    <p id="site-meta">
  		<?php echo $config->intranet_link(); ?>
	    <?php if($config->intranet_url() != '' && $config->imprint_url() != '') { echo '|'; }?>
	    <?php echo $config->imprint_link(); ?>
    </p>
    <div class=address>
      <p>
        <?php echo nl2br($config->address()); ?>
      </p>
      <p>
        <?php echo $config->contact(); ?>
      </p>
    </div>
  </footer>
<?php wp_footer(); ?>
</body>
</html>
