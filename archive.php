<?php
  /**
   * The template for displaying archive pages
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
      $currentCategory = get_category($cat);
      $currentCategory = $currentCategory -> slug;
      $query = new WP_Query( array( 'category_name' => $currentCategory ) );
    ?>
    <?php if($query -> have_posts() ) : ?>
      <h1><?php echo $currentCategory ?></h1>
      <?php while($query -> have_posts()) : $query -> the_post();
        $type = get_post_meta( get_the_ID(), '_rwmwop_type', true);

        $image_size = get_post_meta( get_the_ID(), '_rwmwop_image_size', true );
        $image_size_width = !empty($image_size['width']) ? $image_size['width'] : null;
        $image_size_height = !empty($image_size['height']) ? $image_size['height'] : null;
        $image_size_dimensions = "{$image_size_width}\" x {$image_size_height}\" image size";

        $paper_size = get_post_meta( get_the_ID(), '_rwmwop_paper_size', true );
        $paper_size_width = !empty($paper_size['width']) ? $paper_size['width'] : null;
        $paper_size_height = !empty($paper_size['height']) ? $paper_size['height'] : null;
        $paper_size_dimensions = "{$paper_size_width}\" x {$paper_size_height}\" paper size";

        $physical_size = get_post_meta( get_the_ID(), '_rwmwop_physical_size', true );
        $physical_size_width = !empty($physical_size['width']) ? $physical_size['width'] : null;
        $physical_size_height = !empty($physical_size['height']) ? $physical_size['height'] : null;
        $physical_size_dimensions = "{$physical_size_width}\" x {$physical_size_height}\" physical size";
      ?>
        <div class='work'>
          <?php the_post_thumbnail(); ?>
          <div class='plaque'>
            <span class='catgory'><?php the_category(' '); ?></span>
            <h2><?php the_title(); ?></h2>
            <?php if($type) echo "<h3>{$type}</h3>"; ?>
            <ul>
              <?php if($image_size_width && $image_size_height) echo "<li>{$image_size_dimensions}</li>"; ?>
              <?php if($paper_size_width && $paper_size_height) echo "<li>{$paper_size_dimensions}</li>"; ?>
              <?php if($physical_size_width && $physical_size_height) echo "<li>{$physical_size_dimensions}</li>"; ?>
            </ul>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else : ?>
      <h1>no posts found</h1>
    <?php endif; ?>
  </main><!-- #main -->
</div><!-- #primary -->