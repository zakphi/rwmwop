<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package rwmwop
 */

  get_header();
?>

<div id="primary" class="content-area">
  <main id="main" class="site-main">

  <?php
    $args = array('post_type' => 'featured_artwork');
    $featured = new WP_Query($args);
    while($featured -> have_posts()) : $featured -> the_post();
  ?>
  <div class='featured-work'>
    <?php the_post_thumbnail(); ?>
    <div class='desc-plaque'>
      <span class='catgory'><?php the_category(' '); ?></span>
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </div>
  </div>

  <?php endwhile; ?>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>