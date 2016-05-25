<?php
define( 'WP_USE_THEMES', false );
require( './wp-blog-header.php' );
remove_all_actions( 'wp_footer' );
remove_all_actions( 'loop_end' );
header( 'Content-Type: text/html;charset=utf-8' );
$id = intval($_GET['id']);
if ($id > 0) {
	$comments = $wpdb->get_results("SELECT comment_ID, comment_author, comment_author_email, comment_author_url, comment_date,	comment_content, comment_post_ID, $wpdb->posts.ID, $wpdb->posts.post_password FROM $wpdb->comments LEFT JOIN $wpdb->posts ON comment_post_ID = ID WHERE comment_post_ID = '$id' AND $wpdb->comments.comment_approved = '1' AND $wpdb->posts.post_status = 'publish' AND post_date < '".current_time('mysql')."' ORDER BY comment_date");
	$post = $wpdb->get_row("SELECT post_title, comment_status FROM $wpdb->posts WHERE ID = '$id' AND post_date < post_date < '".current_time('mysql')."' AND post_status = 'publish'");
### Else Display Last 10 Comments
} else {
	$comments = $wpdb->get_results("SELECT comment_ID, comment_author, comment_author_email, comment_author_url, comment_date, comment_content, comment_post_ID, $wpdb->posts.ID, $wpdb->posts.post_password FROM $wpdb->comments LEFT JOIN $wpdb->posts ON comment_post_id = id WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->comments.comment_approved = '1' AND post_date < '".current_time('mysql')."' ORDER BY comment_date DESC LIMIT 10");
	$post = $wpdb->get_row("SELECT post_title, comment_status FROM $wpdb->posts WHERE post_date < '".current_time('mysql')."' AND post_status = 'publish' ORDER BY post_date DESC");
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
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
<h2><?php bloginfo_rss('name'); ?>'s Archiver </h2>
</center>
<div id="content">
<p><strong><?php the_title_rss(); ?> 的评论</strong></p>
<br />
<?php if ($comments) : ?>
	<?php foreach ($comments as $comment) : ?>
			<p>&gt; <?php comment_author_rss() ?></p>
			<p>&gt; <?php comment_time(get_option('date_format').' ('.get_option('time_format').')'); ?></p>
			<p><?php comment_text_rss() ?></p>
			<br />
	<?php endforeach; ?>
<?php else : ?>
	<?php if ('open' === $post->comment_status) : ?> 
		<p>现在还没有评论呢！</p>
	<?php else : ?>
		<p>本文章禁止评论！</p>
	<?php endif; ?>
<?php endif; ?>
<br />
<p><a href="archiver.php?id=<?php echo $_GET['id']; ?>">&lt; <?php the_title_rss(); ?></a></p>
<p><a href="archiver.php">&lt;&lt; <?php bloginfo_rss('name'); ?></a></p>
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
