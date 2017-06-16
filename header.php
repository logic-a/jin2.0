<!DOCTYPE html>
<?php
$tw_id = "JIN_2115";
$fb_admins = "1798737843782819";	
?>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?php wp_title(' | ', true, 'right'); bloginfo('name'); ?></title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	
	<meta name="description" content="<?php get_meta_description(); ?>">
	<meta property="og:title" content="<?php wp_title(' | ', true, 'right'); bloginfo('name'); ?>"/>
	<meta property="og:description" content="<?php get_meta_description(); ?>"/>
	<?php if ( has_post_thumbnail() ) {
		$image_id = get_post_thumbnail_id ();
		$image_url = wp_get_attachment_image_src ($image_id, true);
		$image_url = $image_url[0];
	} else {
		$image_url = get_bloginfo( 'template_directory' ) . '/img/no-eyecatch.jpg';
	} ?>
	<meta property="og:image" content="<?php echo $image_url; ?>"/>
	<meta property="og:url" content="<?php echo("//" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>"/>
	<meta property="og:type" content="article"/>
	<meta name="twitter:site" content="@<?php echo $tw_id; ?>">
	<meta name="twitter:card" content="summary">
	<meta property="fb:admins" content="<?php echo $fb_admins; ?>" />
	<?php wp_head(); ?>
</head>