<?php get_header(); ?>

<body>

	<?php include(STYLESHEETPATH.'/gtm.php'); ?>
		
	<?php include(STYLESHEETPATH.'/nav.php'); ?>
		
	
	<main class="category">

	<h1 class="category-name"><?php echo get_the_author_meta('user_firstname'); ?><br><?php echo get_avatar($author, 80); ?><br><span>が書いた記事一覧</span></h1>

	<?php
	if( have_posts() ) : while( have_posts() ) : the_post();
	global $post_id;
	$post_id = get_the_ID();
	$author = $post->post_author;
	?>
		<article>
		<a href="<?php the_permalink(); ?>">
		
		<h1><?php the_title(); ?></h1>
				
		<span class="time">
		<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
		<time>
		<?php
			if (get_the_date() != get_the_modified_date()) {
				echo get_the_modified_date('Y-m-d');
			}
			else {
				echo get_the_date('Y-m-d');
			}
		?>
		</time>
		</span>

		<div class="kv">
		<?php if ( has_post_thumbnail()) : the_post_thumbnail(); else : ?>
		<img src="<?php bloginfo('template_url'); ?>/img/no-eyecatch.jpg" alt="アイキャッチはありません"  />
		<?php endif; ?>
		</div>
		
		<?php the_excerpt(); ?>
		
		<span class="next-button">続きを見る<i class="material-icons">keyboard_arrow_right</i></span>
		
		</a>
		</article>
		
	<?php
	endwhile;
	endif;
	?>
	
	</main>
	
	<?php dynamic_sidebar( 'single_content' ); ?>
	
	<?php get_footer(); ?>
	
</body>
</html>