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
        <?php while($query -> have_posts()) : $query -> the_post(); ?>
          <h1><?php echo $currentCategory ?></h1>
          <h2><?php the_title(); ?></h2>
        <?php endwhile; ?>
      <?php else : ?>
        <h1>no posts found</h1>
      <?php endif; ?>
    </main><!-- #main -->
  </div><!-- #primary -->

<?php get_footer(); ?>