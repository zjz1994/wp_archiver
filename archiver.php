<?php
define( 'WP_USE_THEMES', false );
require( './wp-blog-header.php' );
remove_all_actions( 'wp_footer' );
remove_all_actions( 'loop_end' );
header( 'Content-Type: text/html;charset=utf-8' );
?>
<!doctype html>
<meta charset="utf-8">
<html>
<head>
<title><?php bloginfo_rss('name'); ?> Archiver</title>
<style type="text/css">
	body {font-family: Verdana;FONT-SIZE: 12px;MARGIN: 0;color: #000000;background: #ffffff;}
	img {border:0;}
	li {margin-top: 8px;}
	.page {padding: 4px; border-top: 1px #EEEEEE solid}
	.author {background-color:#EEEEFF; padding: 6px; border-top: 1px #ddddee solid}
	#nav, #content, #end {padding: 8px; border: 1px solid #EEEEEE; clear: both; width: 95%; margin: auto; margin-top: 10px;}
	#header, #footer { margin-top: 20px; }
	#loginform {text-align: center;}
</style>
</head>
<body vlink="#333333" link="#333333">

<center id="header">
<h2><?php bloginfo_rss('name'); ?> 's Archiver </h2>
</center>
	<div id="content">
		<?php if(empty($_GET['id']) && intval($_GET['id']) === 0): ?>
			<?php query_posts( array( 'posts_per_page' => 20 ) ); ?>
			<?php if(have_posts()): ?>
				<?php while (have_posts()): the_post(); ?>
					<p>
						<li><a href="<?php bloginfo('siteurl'); ?>/archiver.php?id=<?php the_id(); ?>"><?php the_title_rss(); ?>
						<br />
						<?php the_time(get_option('date_format').' ('.get_option('time_format').')'); ?></a></li>
					</p>
				<?php endwhile; ?>
			<?php endif; ?>
		<?php else : ?>
			<?php query_posts( array( 'p' => intval( $_GET['id'] ) ) ); ?>
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>
				<p> <a href="archiver.php"> <?php bloginfo_rss('name'); ?></a>&gt; <?php echo strip_tags(get_the_category_list(', ')); ?>&gt; <?php the_title_rss(); ?></p>
				<p class="author">
					<strong><?php the_author(); ?></strong>
				发表于 <?php the_time(get_option('date_format').' ('.get_option('time_format').')'); ?>	</p>
					<p><?php the_content_rss(); ?></p>
					<p><strong>评论</strong></br> <a href="archiver-comments.php?id=<?php the_ID(); ?>"><?php comments_number("没有评论！", "1 Comment", "% Comments"); ?></a></p>
				<?php endwhile; ?>
			<?php else : ?>
				<p>文章不存在！</p>
			<?php endif; ?>
			<br />
			<p><a href="archiver.php">&lt;&lt; <?php bloginfo_rss('name'); ?></a></p>
			<div id="end">
	            查看完整版本:
	            <a href="../archive-<?php the_ID(); ?>.html" target="_blank"><strong><?php the_title_rss(); ?></strong></a>
            </div>
		<?php endif; ?>
	</div>
<center>
	<div id="footer">
		Powered by <strong><a target="_blank" href="http://zjz1994.tk">ZJZ</a></strong> &nbsp; &copy 2015-2016 <a target="_blank" href="../"><?php bloginfo_rss('name'); ?></a>
		<br />
		<br />
	</div>
</center>

</body>
</html>
