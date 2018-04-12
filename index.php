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
    $query = new WP_Query( array('post_type' => 'featured_artwork') );
    while($query -> have_posts()) : $query -> the_post();

    $type = get_post_meta( get_the_ID(), '_rwmwop_type', true);

    $image_size = get_post_meta( get_the_ID(), '_rwmwop_image_size', true );
    $image_size_width = !empty($image_size['width']) ? $image_size['width'] : null;
    $image_size_height = !empty($image_size['height']) ? $image_size['height'] : null;
    $image_size_dimensions = "{$image_size_width}\" x {$image_size_height}\"";

    $paper_size = get_post_meta( get_the_ID(), '_rwmwop_paper_size', true );
    $paper_size_width = !empty($paper_size['width']) ? $paper_size['width'] : null;
    $paper_size_height = !empty($paper_size['height']) ? $paper_size['height'] : null;
    $paper_size_dimensions = "{$paper_size_width}\" x {$paper_size_height}\"";

    $physical_size = get_post_meta( get_the_ID(), '_rwmwop_physical_size', true );
    $physical_size_width = !empty($physical_size['width']) ? $physical_size['width'] : null;
    $physical_size_height = !empty($physical_size['height']) ? $physical_size['height'] : null;
    $physical_size_dimensions = "{$physical_size_width}\" x {$physical_size_height}\"";
  ?>

  <div class='featured-work'>
    <?php the_post_thumbnail(); ?>
    <div class='plaque'>
      <span class='catgory'><?php the_category(' '); ?></span>
      <h1><?php the_title(); ?></h1>
      <?php if($type) echo $type; ?>
      <?php if($image_size_width && $image_size_height) echo $image_size_dimensions; ?>
      <?php if($paper_size_width && $paper_size_height) echo $paper_size_dimensions; ?>
      <?php if($physical_size_width && $physical_size_height) echo $physical_size_dimensions; ?>
    </div>
  </div>

  <?php endwhile; ?>

  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>