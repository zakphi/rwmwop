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
    <div id="announcements">
      <?php
        $announcements_args = array(
          'post_type' => 'announcements',
          'meta_key' => '_rwmwop_end_date',
          'meta_query' => array(
            array(
              'key' => '_rwmwop_end_date',
              'value' => time(),
              'compare' => '>=',
              'type' => 'numeric'
            )
          )
        );
        $announcements_query = new WP_Query( $announcements_args );
      ?>
      <?php if($announcements_query -> have_posts() ) : ?>
        <?php while($announcements_query -> have_posts()) : $announcements_query -> the_post();
          $start_date = get_post_meta( get_the_ID(), '_rwmwop_start_date', true );
          $end_date = get_post_meta( get_the_ID(), '_rwmwop_end_date', true );
          $event_details = get_post_meta( get_the_ID(), '_rwmwop_specific_details', true);

          $event_date = $start_date === $end_date ? date('F j, Y', $start_date) : date('F j, Y', $start_date) . ' - ' . date('F j, Y', $end_date);
        ?>
          <div class="announcement">
            <h2><?php the_title(); ?></h2>
            <p><?php echo $event_date; ?></p>
            <?php echo wpautop( $event_details ); ?>
          </div>
          <!-- /#announcement -->
        <?php endwhile; ?>
      <?php else : ?>
        <h1>no posts found</h1>
      <?php endif; ?>
    </div><!-- /#announcements -->

    <div id="featured-works">
      <?php
        $featured_artwork_args = array(
          'post_type' => 'featured_artwork',
          'posts_per_page' => 5
        );
        $featured_artwork_query = new WP_Query( $featured_artwork_args );
      ?>
      <?php if($featured_artwork_query -> have_posts() ) : ?>
        <?php while($featured_artwork_query -> have_posts()) : $featured_artwork_query -> the_post();
          $type = get_post_meta( get_the_ID(), '_rwmwop_type', true);

          $image_size = get_post_meta( get_the_ID(), '_rwmwop_image_size', true );
          $image_size_width = !empty($image_size['width']) ? $image_size['width'] : null;
          $image_size_height = !empty($image_size['height']) ? $image_size['height'] : null;
          $has_image_size = $image_size_width && $image_size_height ? true : false;
          $image_size_dimensions = "{$image_size_width}\" x {$image_size_height}\" image size";

          $paper_size = get_post_meta( get_the_ID(), '_rwmwop_paper_size', true );
          $paper_size_width = !empty($paper_size['width']) ? $paper_size['width'] : null;
          $paper_size_height = !empty($paper_size['height']) ? $paper_size['height'] : null;
          $has_paper_size = $paper_size_width && $paper_size_height ? true : false;
          $paper_size_dimensions = "{$paper_size_width}\" x {$paper_size_height}\" paper size";

          $physical_size = get_post_meta( get_the_ID(), '_rwmwop_physical_size', true );
          $physical_size_width = !empty($physical_size['width']) ? $physical_size['width'] : null;
          $physical_size_height = !empty($physical_size['height']) ? $physical_size['height'] : null;
          $has_physical_size = $physical_size_width && $physical_size_height ? true : false;
          $physical_size_dimensions = "{$physical_size_width}\" x {$physical_size_height}\" physical size";

          $bg_color = get_post_meta( get_the_id(), '_rwmwop_bg_color', true);
        ?>
          <div class='featured-work' style="background-color: <?php echo $bg_color ?>;">
            <?php the_post_thumbnail(); ?>
            <div class='plaque'>
              <span class='catgory'><?php the_category(' '); ?></span>
              <h2><?php the_title(); ?></h2>
              <?php the_content(); ?>
              <?php if($type) echo "<h3>{$type}</h3>"; ?>
              <?php if($has_image_size || $has_paper_size || $has_physical_size) : ?>
                <ul>
                  <?php if($image_size_width && $image_size_height) echo "<li>{$image_size_dimensions}</li>"; ?>
                  <?php if($paper_size_width && $paper_size_height) echo "<li>{$paper_size_dimensions}</li>"; ?>
                  <?php if($physical_size_width && $physical_size_height) echo "<li>{$physical_size_dimensions}</li>"; ?>
                </ul>
              <?php endif; ?>
            </div><!-- /.plaque -->
          </div><!-- /#featured-work -->
        <?php endwhile; ?>
      <?php else : ?>
        <h1>no posts found</h1>
      <?php endif; ?>
    </div><!-- /#featured-works -->
  </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>