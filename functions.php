<?php



// JS・CSSファイルを読み込む
function add_files() {
	$date = new DateTime();
	$cacheData = $date->format('YmdHis');

// 	JS
	// WordPress提供のjquery.jsを読み込まない
	wp_deregister_script('jquery');
	// jQueryの読み込み
	wp_enqueue_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', "", "20170108", false );
	// プラグインJS
	wp_enqueue_script('modaal', get_stylesheet_directory_uri() . '/js/modaal.min.js"', array( 'jquery' ), $cacheData , false );
	//wp_enqueue_script('sharebox', get_stylesheet_directory_uri() . '/js/jquery.sharebox.min.js"', array( 'jquery' ), $cacheData , false );
	// サイト共通JS
	wp_enqueue_script('common_script', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), $cacheData , false );
	// singleページ専用JS
	//if ( is_single() ) wp_enqueue_script( 'mokuji', get_template_directory_uri() . '/script/mokuji.js', array( 'jquery' ), $cacheData , true );
// CSS
	//プラグインCSS
	wp_enqueue_style( 'modaal', '//cdn.jsdelivr.net/modaal/0.3.1/css/modaal.min.css', "", '20170108' );
	//wp_enqueue_style( 'sharebox', get_stylesheet_directory_uri() . '/css/jquery.sharebox.min.css', "", $cacheData );
	//WEB Font
	wp_enqueue_style( 'materialIcons', '//fonts.googleapis.com/icon?family=Material+Icons', "", '20170108' );
	wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', "", '20170108' );
	//wp_enqueue_style( 'google-fonts01', '//fonts.googleapis.com/css?family=Life+Savers|Mystery+Quest|Poiret+One|Megrim', "", '20170108' );
	wp_enqueue_style( 'google-fonts-julius', '//fonts.googleapis.com/css?family=Julius+Sans+One', "", '20170108' );	
	// サイト共通のCSSの読み込み
	wp_enqueue_style( 'style', get_stylesheet_directory_uri() . '/style.css', "", $cacheData );
}
add_action('wp_enqueue_scripts', 'add_files');







//アイキャッチ設定
add_theme_support('post-thumbnails');



//説明文でhtml使用OKへ
remove_filter( 'pre_term_description', 'wp_filter_kses' );



// get meta description from the content
function strip_html($num1) {
	$num2 = mb_substr(str_replace(array("\r\n", "\r", "\n"), '', strip_tags($num1)), 0, 100);
	return $num2;
}
function get_meta_description() {
  global $post;
  $description = "";
  if ( is_home() ) {
    // ホームでは、ブログの説明文を取得
    $ds = get_bloginfo( 'description' );
    $description = strip_html($ds);
  }
  elseif ( is_category() ) {
    // カテゴリーページでは、カテゴリーの説明文を取得
    $ds = category_description();
    $description = strip_html($ds);
  }
  elseif ( is_single() ) {
    if ($post->post_excerpt) {
      // 記事ページでは、記事本文から抜粋を取得
		$ds = $post->post_excerpt;
		$description = strip_html($ds);
    } else {
		// post_excerpt で取れない時は、自力で記事の冒頭100文字を抜粋して取得
		$description = strip_tags($post->post_content);
		$description = str_replace("\n", "", $description);
		$description = str_replace("\r", "", $description);
		$description = mb_substr($description, 0, 100) . "...";
		$description = strip_html($description);
    }
  } else {
    ;
  }
 
  echo $description;
}





//ウィジェット設定
if (function_exists('register_sidebar')) {
	register_sidebar(array(
		'name' => 'index_content',
		'id' => 'content',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h1>',
		'after_title' => '</h1>'
	));
	register_sidebar(array(
	'name' => 'single_content',
	'id' => 'single',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '',
	'after_title' => ''
));

}

//オリジナル ウィジェット 1
class content_Widget extends WP_Widget{
	public function __construct() {
		// 情報用の設定値
		$widget_options = array(
			'classname'                     => 'content',
			'description'                   => 'サイト紹介の文章を入力します',
			'customize_selective_refresh'   => true,
		);
		// 操作用の設定値
		$control_options = array( 'width' => "auto", 'height' => 350 );
		// 親クラスのコンストラクタに値を設定
		parent::__construct( 'anc-', 'コンテンツ（HTML）', $widget_options, $control_options );
	}
 
    public function widget($args, $instance) {
		// ウィジェットのオプション「タイトル(title)」を取得
		$title = empty( $instance['title'] ) ? '' : $instance['title'];
		// ウィジェットのオプション「テキスト(text)」を取得
		$widget_text = ! empty( $instance['text'] ) ? $instance['text'] : '';
		$checkbox = apply_filters('widget_checkbox', $instance['checkbox']);
		$anc_id = empty( $instance['id'] ) ? '' : $instance['id'];
		//入力されたテキストを出力
		if ($checkbox != "sidebar") {$checkbox = "content";}
		if ($anc_id){$anc_id = "anc-".$anc_id;}
		?>
		<article id="<?php echo $anc_id; ?>" class="<?php echo $checkbox; ?>">
		<?php
		// タイトルの値をタイトル開始/終了タグで囲んで出力
		if ( ! empty( $title ) ) : echo $args['before_title'] . $title . $args['after_title']; endif; ?>
			<section>
				<?php echo $widget_text; ?>
			</section>
		</article>
		<?php
    }
 
    public function form($instance) {
		// デフォルトのオプション値
		$defaults = array(
			'title' => '',
			'text'  => '',
			'checkbox' => '',
			'id' => ''
		);
		
		// デフォルトのオプション値と現在のオプション値を結合
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		// タイトル値の無害化（サニタイズ）
		$title = sanitize_text_field( $instance['title'] );
		// サイドバー フラグ
		$checkbox = esc_attr($instance['checkbox']);
		// ID
		$id = sanitize_text_field( $instance['id'] );
		?>
		<!-- 設定フォーム: タイトル -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">タイトル</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<!-- 設定フォーム: テキスト -->
		<p>
			<label for="<?php echo $this->get_field_id( 'text' ); ?>">内容</label>
			<textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_textarea( $instance['text'] ); ?></textarea>
		</p>
		<!-- 設定フォーム: チェックボックス -->
		<p>
			<label for="<?php echo $this->get_field_id('checkbox'); ?> "><?php _e('sidebar?'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('checkbox'); ?>" name="<?php echo $this->get_field_name('checkbox'); ?>" type="checkbox"<?php checked('sidebar', $checkbox); ?> value="sidebar" />
		</p>
		<!-- 設定フォーム: アンカー用ID -->
		<p>
			<label for="<?php echo $this->get_field_id( 'id' ); ?>">アンカー用ID</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'id' ); ?>" name="<?php echo $this->get_field_name( 'id' ); ?>" type="text" value="<?php echo esc_attr( $id ); ?>" />
		</p>

		<?php
	}

	/**
	 * ウィジェットオプションのデータ検証/無害化
	 *
	 * @param array $new_instance   新しいオプション値
	 * @param array $old_instance   以前のオプション値
	 *
	 * @return array データ検証/無害化した値を返す
	 */
	public function update( $new_instance, $old_instance ) {
	 
	 // 一時的に以前のオプションを別変数に退避
	 $instance = $old_instance;
	 
	 // タイトル値を無害化（サニタイズ）
	 $instance['title']  = sanitize_text_field( $new_instance['title'] );
	 
	 // ユーザがHTMLマークアップ権限を持っている場合（ユーザ権限の確認）
	 if ( current_user_can( 'unfiltered_html' ) ) {
	 
	     // 全てのHTMLタグをそのまま保存
	 $instance['text']   = $new_instance['text'];
	 } else {
	 
	     // 許可されたHTMLタグはそのままで、それ以外は無害化されて保存（サニタイズ）
	 $instance['text']   = wp_kses_post( $new_instance['text'] );
	 }
	 
	 $instance['checkbox'] = strip_tags($new_instance['checkbox']);
 	 // ID値を無害化（サニタイズ）
	 $instance['id']  = sanitize_text_field( $new_instance['id'] );

	 
	 return $instance;
	}
}
add_action('widgets_init', function() {return register_widget("content_Widget");});







//デフォルトウィジェット非表示
function unregister_default_widget() {
	unregister_widget('WP_Widget_Pages');            // 固定ページ
	unregister_widget('WP_Widget_Calendar');         // カレンダー
	unregister_widget('WP_Widget_Archives');         // アーカイブ
	unregister_widget('WP_Widget_Meta');             // メタ情報
	unregister_widget('WP_Widget_Search');           // 検索
	unregister_widget('WP_Widget_Text');             // テキスト
	unregister_widget('WP_Widget_Categories');       // カテゴリー
	unregister_widget('WP_Widget_Recent_Posts');     // 最近の投稿
	unregister_widget('WP_Widget_Recent_Comments');  // 最近のコメント
	unregister_widget('WP_Widget_RSS');              // RSS
	unregister_widget('WP_Widget_Tag_Cloud');        // タグクラウド
	unregister_widget('WP_Nav_Menu_Widget');         // カスタムメニュー
	unregister_widget('Twenty_Fourteen_Ephemera_Widget');  // Twenty Fourteen 短冊
}
add_action( 'widgets_init', 'unregister_default_widget' );









?>