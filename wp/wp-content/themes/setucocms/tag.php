<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
	<?php include("entry_parts.php"); ?>
<?php endwhile; ?>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
