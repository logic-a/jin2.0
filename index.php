<?php get_header(); ?>

<body>

	<?php include(STYLESHEETPATH.'/gtm.php'); ?>
		
	<?php include(STYLESHEETPATH.'/nav.php'); ?>
		
	
	<main class="top">
		
	<?php dynamic_sidebar( 'index_content' ); ?>

		<article id="anc-new" class="sidebar">
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
					
					if (have_posts()) : while (have_posts()) : the_post();
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
									<span><i class="fa fa-calendar-check-o" aria-hidden="true"></i><time datetime="<?php echo $date; ?>"><?php echo $date; ?></time></span>
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
		</article>
		
		<article id="anc-whatis" class="content">
			<h1>JIN-2115- とは？</h1>
			<section>
				<p>JINとは、「何かを作れる」「何かを伝えられる」人たちを集めて繋ぐ場所です。その人たちの「できること」を集めて、一人ではできないことや、本来繋がらなかったご縁を繋ぐお仕事をしています。僕らJINの「できること」は“WEBでのお手伝い”。あなたの「できること」を僕らに預けてもらえますか？<br>
					お仕事は従来の“依頼主×受託”の形態ではなく、“ギブ&ギブ”、“相互サポーター”の形を取っています。こちらは“WEB制作と運用、他サポーターとのマッチング”を提供しますので、あなたからは“サポーター料”のお支払いか“同等のギブ”をください！いわゆる物々交換の考え方で結構です。魚を捕る人がいて、作物を作る人がいて、家を作る人がいて、いろんな人たちの“ギブ”を混ぜてくっつけて新しいなにかを生みます。</p>
			</section>
		</article>
		
		<article id="anc-creator" class="content">
			<h1>JIN-2115- を創る人</h1>
			<section class="members">
				<h2>その1　山﨑 良</h2>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/ryo_icon.png" alt="山﨑 良">
				<p>はじめまして。<br>
				私は「JIN」を通して「日本の粋」が感じられる世界を創りたいのです。なにより人のお役に立ちたいのです。<br>
				そんな私は、一児の父。<br>
				ちょっと先の日本について、最近気になりはじめる。<br>
				今までなんとなく生きてきたから、<br>
				見えるものばかり追いかけてきたから。<br>
				着物と日本文化に囲まれながら<br>
				生活することを夢見る今日この頃。<br>
				JIN。日本の粋を未来の子どもたちへつなげたい。</p>
<!-- 				<h3>スキル</h3> -->
				<ul>
					<li>休みの日には…泳いでみたり、こいでみたり、走ってみたり、トライアスロンのまねごとしている（おかげさまで、年中日焼けがとれない）</li>
					<li>たまに、集中する時間がほしくなって、兵庫の山まで陶芸に行っちゃう</li>
					<li>Instagram担当です</li>
				</ul>
			</section>
			<section class="members">
				<h2>その2　岩館 聡</h2>
				<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/dutch_icon.png" alt="岩館 聡">
				<p>JINの技術担当をしています。<br>
				僕の役目は創る人の想いを伝える「道具」をつくること。<br>
				道具は想いを込めないと、ただのガラクタになってしまいます。強くて大っきな想いを持ってませんか？<br>
				もし伝えたい想いをお持ちでしたら、僕らと一緒に伝えて広げていきませんか？<br>
				JINは、想いを届けたい方、一緒に想いを伝えていける仲間を大募集しております！</p>
<!-- 				<h3>スキル</h3> -->
				<ul>
					<li>サイトの構築と運用</li>
					<li>分析マーケティング</li>
					<li>お話し</li>
				</ul>

			</section>
		</article>
		
		<article id="anc-social" class="sidebar">
			<h1>JIN-2115- と繋がる</h1>
			<section class="instagram">
				<h2><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</h2>
				<p>100年先に遺したい情景を切り取っています。<br>もし気に入った写真があれば遠慮なく使ってください。<br>もし共感いただけたら一緒に撮りに行きませんか？</p>
				<section>
				<?php if (is_mobile()) : ?>
				<ul class="three">
				<?php else : ?>
				<ul class="four">
				<?php endif; ?>

				<?php
				$user_id = 2936247101;
				define("INSTAGRAM_ACCESS_TOKEN", "2936247101.0fd37fa.eef99c0068d845c592406c327b6604b9");
				$photos_api_url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent?access_token=' . INSTAGRAM_ACCESS_TOKEN . "&count=12";
				$photos_data = json_decode(@file_get_contents($photos_api_url));
				foreach ($photos_data->data as $photo) : ?>
				<li>
					<?php
						$photo_link = $photo->link;
						$instaIDs = explode("/", $photo_link);
						$instaID = $instaIDs[count($instaIDs)-2];
					?>
					<a href="#ig" class="modaal" data-modaal-type="instagram" data-modaal-instagram-id="<?php echo $instaID; ?>"><span class="image"><img src="<?php echo $photo->images->standard_resolution->url; ?>"></span></a>
				</li>
				<?php endforeach; ?>
				</ul>
				</section>
			</section>
			
			<section class="twitter">
				<h2><i class="fa fa-twitter" aria-hidden="true"></i> Twitter</h2>
				<p>私たちの理念や、共感したサイトの紹介をさせていただいてます。<br>サイトの更新情報やイベント情報もしております。ぜひフォローください！</p>
				<section>
					<a class="twitter-timeline" data-width="100%" data-height="450" data-dnt="true" data-theme="light" href="https://twitter.com/JIN_2115_">Tweets by JIN_2115_</a> <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
				</section>
			</section>
			
			<section class="facebook">
				<h2><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</h2>
				<p>イベントの告知や参加受付はこちらで主に行なっております。<br>他にもJIN-2115- に参加いただいている方々のセミナーやイベントも掲載していますのでぜひ友達申請ください！</p>
				<section>
					<div class="fb-page" data-href="https://www.facebook.com/%E3%81%98%E3%82%932115-1798737260449544/" data-tabs="&#x30a4;&#x30d9;&#x30f3;&#x30c8;" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/%E3%81%98%E3%82%932115-1798737260449544/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/%E3%81%98%E3%82%932115-1798737260449544/">じん2115</a></blockquote></div>
				</section>
			</section>
		</article>
		
		<article id="anc-otayori" class="content">
			<h1>お便りを送る</h1>
			<p>本日はこんな隅々までJINを見ていただき、本当にありがとうございます。<br>
				もし、私たちの想いが少しでもあなたに届いたなら、このJINを創った甲斐がありました。<br>
				些細なことでもけっこうです。なにか、あなたの想いを聞かせていただけると嬉しいです。</p>
			
			<p>また、JINでは一緒に想いを伝えたい方を大募集しています！<br>
				私たちの取材や対談に応じていただけたり、一緒に何か創っていきたい、成したいことがある、世の中になかなか想いが届かないと困っている、そんな思いを聞かせてください！</p>
			
			<p>まずは私たちと何が始められるか、お話しいたしましょう。お待ちしております。</p>
			<div class="otayori"><?php echo do_shortcode('[contact-form-7 id="99" title="コンタクトフォーム 1"]'); ?></div>
		</article>
		
	</main>
		
	<?php get_footer(); ?>
	
</body>
</html>