<?php
	if(is_front_page()):
	$header_class = "top";
	elseif(is_single()) :
	$header_class = "single";
	else :
	$header_class = "other";
	endif;
?>

<header class="<?php echo $header_class; ?>">
	<?php if(is_front_page()): ?>
	<div class="option1 inner hero">
		<h1><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo_white.png" alt="JIN"></h1>
		<p>JIN</p>
	</div>
	<a href="#anc-otayori" class="cv hide upper"><i class="material-icons">send</i><em>お問い合わせはこちら</em></a>
	<?php else : ?>
	<div class="option3 inner">
		<h1><a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo_color.png" alt="JIN"></a></h1>
		<p>JIN</p>
	</div>
	<?php endif; ?>
	
	<input id="menu" type="checkbox" name="menu"/>
	<label for="menu" class="menu-icon">
		<i class="material-icons">add</i>
	</label>
	
	
	<nav class="slide">
		<div class="option2 inner">
			<h1><a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo_color.png" alt="JIN"></a></h1>
			<p>JIN</p>
			
		<ul>
			<li><a href="#anc-new"><i class="material-icons">featured_play_list</i>お話し一覧</a></li>
			<li><a href="#anc-whatis"><i class="fa fa-question" aria-hidden="true"></i>JIN-2115- とは？</a></li>
			<li><a href="#anc-creator"><i class="material-icons">people</i>JIN-2115- を創る人</a></li>
			<li><a href="#anc-social"><i class="fa fa-retweet" aria-hidden="true"></i>JIN-2115- と繋がる</a></li>
			<li class="long"><a href="#anc-otayori"><i class="material-icons">mail_outline</i>お便りを送る</a></li>
		</ul>
		</div>
	</nav>
</header>
