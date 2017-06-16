<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
	<label class="screen-reader-text" for="s">『<?php bloginfo("name"); ?> のなかを検索』</label>
	<p>このサイト内を検索できます。気になるキーワードを選んでいただくか、文字を打ちこんで検索ください。</p>
	<div>
		<input type="text" value="" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="&#xf002;" />
    </div>
</form>