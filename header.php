<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package TUHH Institute
 */
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html <?php language_attributes(); ?> class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<meta name="viewport" content="initial-scale=1.0, width=device-width, maximum-scale=1.0" />

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <nav id="mobile-navigation" class="mobile">
    <div>
      
    </div>
  </nav>
  
  <div id="page">
    <div id="layout">
      
      <nav id="phantom">
        <ul>
          <li><a href="#top-navigation">Hauptnavigation</a></li>
          <li><a href="#sub-navigation">Unternavigation</a></li>
          <li><a href="#content">Inhalt</a></li>
          <li><a href="#search" id="phantom-search-link">Suche</a></li>
        </ul>
      </nav>
      
      <header id="page-header">
        <a href="http://www.tuhh.de" id="tuhh-logo" title="Zur TUHH Webseite">
          <div id="tuhh-logo-group">
            <img id="tuhh-logo-title"    src="<?php echo get_template_directory_uri(); ?>/static/assets/tuhh-logo.svg"          alt="TUHH" data-fallback="/assets/tuhh-logo.gif">
            <img id="tuhh-logo-subtitle" src="<?php echo get_template_directory_uri(); ?>/static/assets/tuhh-logo-subtitle.svg" alt="Technische Universität Hamburg-Harburg" data-fallback="<?php echo get_template_directory_uri(); ?>/static/assets/tuhh-logo-subtitle.gif">
          </div>
        </a>
        <a href="<?php echo get_option('home'); ?>" title="Zur Startseite">
          <h1>
            <img id="inst-logo" src="<?php echo TUHH_Institute::config()->institute_logo(); ?>">
            <span id="backflip">
              <span style="color: #<?php echo get_header_textcolor(); ?>;"><?php bloginfo('name'); ?></span>
            </span>
          </h1>
        </a>
        <a id="show-mobile-navigation" href="#" title="Mobile Navigation einblenden"><img src="<?php echo get_template_directory_uri(); ?>/static/assets/nav-icon.png" alt="Menu" /></a>
      </header>


    
    
      <section id="navigation-bar">
        <a id="search-link" href="/bitte-url-zur-suche-hier=eintragen" title="Suchformular anzeigen"><img src="<?php echo get_template_directory_uri(); ?>/static/assets/filter.png" alt="Suchformular anzeigen" /></a>
        <form method="get" action="?" id="search-panel">
          <a class=anchor name="search" title="Suche"></a>
          <label for="search-field">Webseite durchsuchen</label>
          <input type="text" id="search-field"><input type="submit" value="Suchen" id="search-submit">
        </form>
        <nav id="language-switch">
        	<?php echo TUHH_Institute::config()->language_switch(); ?>
        </nav>
        <a class=anchor name="top-navigation" title="Hauptnavigation"></a>
        <?php tuhh_top_menu(); ?>
      </section>
    
    
