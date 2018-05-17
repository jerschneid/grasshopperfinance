<?php
/**
* @package SiteGround
* @subpackage Wallpapered_Theme
*/ 
?>

<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="s" class="assistive-text"><?php echo 'Search'; ?></label>
	<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr( 'Search' ); ?>" />
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr( 'Search' ); ?>" />
</form>
