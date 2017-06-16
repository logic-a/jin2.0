<?php get_header(); ?>

<body>

	<?php include(STYLESHEETPATH.'/gtm.php'); ?>
		
	<?php include(STYLESHEETPATH.'/nav.php'); ?>
		
<div class="wrapper">
	
	<main class="single">
		
	<article class="content">
	
	<?php
	if( have_posts() ) : while( have_posts() ) : the_post();
	global $post_id;
	$post_id = get_the_ID();
	$author = $post->post_author;
	?>
	
	<div class="single_header">
		
		<ul class="bread">
			<li><i class="material-icons">home</i><a href="/">Home</a><span><i class="material-icons">keyboard_arrow_right</i></span></li>
			<li><i class="material-icons">apps</i><?php $cat = get_the_category(); echo get_category_parents($cat[0], true, '<span><i class="material-icons">keyboard_arrow_right</i></span>'); ?></li>
			<li><i class="material-icons">inbox</i><?php the_title(); ?></li>
		</ul>
	
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
		
	</div>
		
	<article>
	<?php the_content(); ?>
	</article>
		
	<?php
	endwhile;
	endif;
	?>
	</article>
	
	<div class="sns-area">
     
	<div class="sns-share">
	<a class="sns-link opensub" id="twitter" href="http://twitter.com/intent/tweet?text=<?php echo urlencode(the_title("","",0)); ?>&amp;<?php echo urlencode(get_permalink()); ?>&amp;url=<?php echo urlencode(get_permalink()); ?>" target="_blank" title="Twitterで共有">
	<i class="fa fa-twitter"></i><!--Twitter  --></a>
	</div>
	     
	<div class="sns-share">
	<a class="sns-link opensub" id="facebook" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>&amp;t=<?php echo urlencode(the_title("","",0)); ?>" target="_blank" title="Facebookで共有">
	<i class="fa fa-facebook"></i><!-- facebook --></a>
	</div>
	     
	<div class="sns-share visible-769">
	<a class="sns-link opensub" id="line" href="http://line.me/R/msg/text/?<?php the_title(); ?>%0D%0A<?php the_permalink(); ?>">
	<strong>LINE</strong><!-- LINE  Font Awesome　不使用--></a>
	</div>
	     
	<div class="sns-share">
	<a class="sns-link opensub" id="hatena" href="http://b.hatena.ne.jp/add?mode=confirm&amp;url=<?php echo urlencode(get_permalink()); ?>&amp;title=<?php echo urlencode(the_title("","",0)); ?>" target="_blank" data-hatena-bookmark-title="<?php the_permalink(); ?>" title="このエントリーをはてなブックマークに追加">
	<strong>B!</strong><!-- はてなブックマーク Font Awesome　不使用--></a>
	</div>
	     
	<div class="sns-share">
	<a class="sns-link opensub" id="pocket"  href="http://getpocket.com/edit?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" title="pocketで共有">
	<i class="fa fa-get-pocket"></i><!-- pocket --></a>
	</div>
	 
	</div>
	
	<?php //名言 ?>
	<article class="saying">
	<div class="inner">
	<?php
	    $wp_query = new WP_Query();
	    $param = array(
	        'posts_per_page' => '1', //表示件数。-1なら全件表示
	        'post_type' => 'saying', //カスタム投稿タイプの名称を入れる
	        'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
	        'orderby' => 'rand', //ID順に並び替え
	        'order' => 'DESC',
	        'author' => $author
	    );
	    $wp_query->query($param);
	    if($wp_query->have_posts()): 
	    while($wp_query->have_posts()) : $wp_query->the_post();
	    $link = get_author_posts_url(get_the_author_meta('ID'));
	    $name = get_the_author_meta('user_firstname');
		echo '<div class="author">';
		echo '<a href="'.$link.'">';
		echo get_avatar($author, 80);
		echo '</a>';
		echo "<h2 class='author_name'>本日はJINにお越しくださりありがとうございます。このお話しを書いた <span><a href='" .$link. "'>". $name ."</a></span> といいます。<br>もう一言だけ。　私の好きな言葉になります。</h2>";
		echo '</div>';
		echo "<blockquote class='message'><p>". get_field('message') ."</p></blockquote>";
		echo "<p class='great'>". get_field('great');
		echo '　<a href="'. get_field('sauce') .'" target="_blank">'. get_the_title() .'</a>　より .</p>';
		echo '<p>よろしければ、他にもいろいろなお話しをご用意しております。お時間ありましたらぜひご覧になってみてください。</p>';
	
		endwhile;
		endif;
	?>
	</div>
	</article>
			
	</main>

	
	<div class="sidebar">
	<article class="recommend">
		<!-- TAB CONTROLLERS -->
		<input id="tab-1-radio" class="panel-radios" type="radio" name="tab-radios" checked>
		<input id="tab-2-radio" class="panel-radios" type="radio" name="tab-radios">
		<input id="tab-3-radio" class="panel-radios" type="radio" name="tab-radios">
		<!-- TABS LIST -->
		<ul id="tabs">
		    <!-- MENU TOGGLE -->
		    <li id="tab-1">
		      <label class="tab-label" for="tab-1-radio">
		      	<i class="material-icons">fiber_new</i>
		      	新着
		      </label>
		    </li>
		    <li id="tab-2">
		      <label class="tab-label" for="tab-2-radio">
		      	<i class="material-icons">trending_up</i>
		      	人気
		      </label>
		    </li>
		    <li id="tab-3">
		      <label class="tab-label" for="tab-3-radio">
		      	<i class="material-icons">youtube_searched_for</i>
		      	目次
		      </label>
		    </li>
		</ul>
		<!-- THE PANELS -->
		<div id="panels">
			<section id="panel-1">
				<p>新着ホットな記事5選です。<br>冷めないうちにどうぞ。</p>
				<?php
				$array_views =array();
				$array_names =array();
				
			    $wp_query = new WP_Query();
			    $param = array(
			        'posts_per_page' => '-1', //表示件数。-1なら全件表示
			        'post_type' => 'post', //カスタム投稿タイプの名称を入れる
			        'post_status' => 'publish', //取得するステータス。publishなら一般公開のもののみ
			        'orderby' => 'DESC', //ID順に並び替え
			        'order' => 'DESC',
			        'author' => $author
			    );
			    $wp_query->query($param);
			    if($wp_query->have_posts()): 
			    while($wp_query->have_posts()) : $wp_query->the_post();
				//アクセス数
				$pv = get_post_meta($post->ID,'p_views',true);
				$array_views[] = $pv;
				$pv = $post->ID.'-'.$pv.',';
				$d_num = mb_strlen ( get_the_content($post->ID));
				//タイトル
				$array_names[] = get_the_title();
				//リンク
				$array_link[] = get_permalink();
				//kv
				if ( has_post_thumbnail()) : $kv = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium' ); $array_thumb[] = $kv[0]; else : $array_thumb[] = get_stylesheet_directory_uri()."/img/no-eyecatch.jpg"; endif;
				//更新日
				if (get_the_date() != get_the_modified_date()) {
					$array_date[] = get_the_modified_date('Y-m-d');
				}
				else {
					$array_date[] = get_the_date('Y-m-d');
				}
				//テキスト
				$array_textL[] = mb_substr(get_the_excerpt(), 0, 120);
				$array_textS[] = mb_substr(get_the_excerpt(), 0, 60);
				endwhile; endif;
				
				$num=0;
				foreach($array_views as $view) : $cnt=$num+1;
				if($cnt>=6){break;} ?>
				<section>
				<a href="<?php echo $array_link[$num];?>">
				<div class="kv">
					<img src="<?php echo $array_thumb[$num]; ?>">
				</div>
				<h2>
					<?php echo $array_names[$num]; ?>
					<span>
						<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
						<time datetime="<?php echo $array_date[$num]; ?>"><?php echo $array_date[$num]; ?></time>
					</span>
				</h2>
				
				<p><?php if ($cnt ==1) {echo $array_textL[$num]." ...";} else {/* echo $array_textS[$num]; */} ?></p>
				</a>
				</section>
				<?php $num++; endforeach; ?>
				
			</section>
			
			<section id="panel-2">
				<p>アクセスランキングBEST5です。<br>JINを知るにはまずここから。</p>
				<?php
				array_multisort($array_views,SORT_DESC,$array_names,$array_link,$array_thumb,$array_textL,$array_textS);
				$num=0;
				foreach($array_views as $view) : $cnt=$num+1;
				if($cnt>=6){break;} ?>
				<section>
				<a href="<?php echo $array_link[$num];?>">
				<div class="kv">
					<img src="<?php echo $array_thumb[$num]; ?>">
				</div>
				<h2>
					<?php echo $array_names[$num]; ?>
					<span>
						<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
						<time datetime="<?php echo $array_date[$num]; ?>"><?php echo $array_date[$num]; ?></time>
					</span>
				</h2>
				<p><?php if ($cnt ==1) {echo $array_textL[$num]." ...";} else {/* echo $array_textS[$num]; */} ?></p>
				</a>
				</section>
				<?php $num++; endforeach; ?>
			</section>
			
			<section id="panel-3">
				<p>JINの全てがここから探せます。<br>ご要望をなんなりと。</p>
				<?php get_search_form(); ?>
				
				<ul class="tags">
				<?php
				$tags = get_tags();
				if ($tags) :
					foreach($tags as $tag) :
						echo '<li><a href="'. get_tag_link($tag->term_id) .'">' . $tag->name . '</a></li>';
					endforeach;
				endif;
				?>
				</ul>
				
				<?php
					$taxonomies =  'category'; //カテゴリーの分類「category」を指定
					$args = array( 'fields' => 'ids', 'orderby' => 'id' );
					$category_ids = get_terms( $taxonomies, $args );
					$show = 0;
					$loop = 3;
					foreach ($category_ids as $cat_id) :
					$posts = get_posts('category='.$cat_id.'&showposts='.$show);
					global $post;
					
					echo '<section class="category"> <h1>『' .get_the_category_by_ID($cat_id). '』</h1>';
					
					if(category_description($cat_id)):
						echo category_description($cat_id);
					endif;
					
					if($posts): 
					$count = 0;
						foreach($posts as $post): 
							setup_postdata($post); ?>
							<section <?php $count++; if($count>$loop): ?>class="hide"<?php endif; ?> >
							<a href="<?php echo get_permalink(); ?>">
							<div class="kv">
								<?php if ( has_post_thumbnail()) :  $kv = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium' ); $kv = $kv[0]; ?>
								<?php else : $kv = get_stylesheet_directory_uri()."/img/no-eyecatch.jpg"; ?>
								<?php endif; ?>
								<img src="<?php echo $kv; ?>">
							</div>
							<h2>
								<?php
								if (get_the_date() != get_the_modified_date()) {
									$date = get_the_modified_date('Y-m-d');
								}
								else {
									$date = get_the_date('Y-m-d');
								}
								the_title();
								?>
								<span><time datetime="<?php echo $date; ?>"><?php echo $date; ?></time></span>
							</h2>
							</a>
							</section>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php if($count>$loop): echo '<div class="show_all">すべての記事を表示する ('.$count.')</div>'; endif; ?>
					</section>
				<?php endforeach;?>
			</section>
		</div>
	</article>
	
	<?php dynamic_sidebar( 'single_content' ); ?>
	
	</div>
	
</div>
	
	<?php get_footer(); ?>
	
</body>
</html>