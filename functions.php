<?php
  /**
   * rwmwop functions and definitions
   *
   * @link https://developer.wordpress.org/themes/basics/theme-functions/
   *
   * @package rwmwop
   */

  if ( ! function_exists( 'rwmwop_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function rwmwop_setup() {
      /*
      * Make theme available for translation.
      * Translations can be filed in the /languages/ directory.
      * If you're building a theme based on rwmwop, use a find and replace
      * to change 'rwmwop' to the name of your theme in all the template files.
      */
      load_theme_textdomain( 'rwmwop', get_template_directory() . '/languages' );

      // Add default posts and comments RSS feed links to head.
      add_theme_support( 'automatic-feed-links' );

      /*
      * Let WordPress manage the document title.
      * By adding theme support, we declare that this theme does not use a
      * hard-coded <title> tag in the document head, and expect WordPress to
      * provide it for us.
      */
      add_theme_support( 'title-tag' );

      /*
      * Enable support for Post Thumbnails on posts and pages.
      *
      * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
      */
      add_theme_support( 'post-thumbnails' );

      // This theme uses wp_nav_menu() in one location.
      register_nav_menus( array(
        'menu-1' => esc_html__( 'Primary', 'rwmwop' ),
      ) );

      /*
      * Switch default core markup for search form, comment form, and comments
      * to output valid HTML5.
      */
      add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
      ) );

      // Set up the WordPress core custom background feature.
      add_theme_support( 'custom-background', apply_filters( 'rwmwop_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
      ) ) );

      // Add theme support for selective refresh for widgets.
      add_theme_support( 'customize-selective-refresh-widgets' );

      /**
       * Add support for core custom logo.
       *
       * @link https://codex.wordpress.org/Theme_Logo
       */
      add_theme_support( 'custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
      ) );
    }
  endif;
  add_action( 'after_setup_theme', 'rwmwop_setup' );

  /**
   * Set the content width in pixels, based on the theme's design and stylesheet.
   *
   * Priority 0 to make it available to lower priority callbacks.
   *
   * @global int $content_width
   */
  function rwmwop_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters( 'rwmwop_content_width', 640 );
  }
  add_action( 'after_setup_theme', 'rwmwop_content_width', 0 );

  /**
   * Register widget area.
   *
   * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
   */
  function rwmwop_widgets_init() {
    register_sidebar( array(
      'name' => esc_html__( 'Sidebar', 'rwmwop' ),
      'id' => 'sidebar-1',
      'description' => esc_html__( 'Add widgets here.', 'rwmwop' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>',
    ) );
  }
  add_action( 'widgets_init', 'rwmwop_widgets_init' );

  /**
   * Enqueue scripts and styles.
   */
  function rwmwop_scripts() {
    wp_enqueue_style( 'rwmwop-style', get_stylesheet_uri() );

    wp_enqueue_script( 'rwmwop-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
  add_action( 'wp_enqueue_scripts', 'rwmwop_scripts' );

  function create_featured_artwork_post_type() {
    $labels = array(
      'name' => __( 'Featured Works' ),
      'singular_name' => __( 'Featured Work' ),
      'add_new' => __( 'Add New' ),
      'add_new_item' => __( 'Add New Featured Work' ),
      'edit_item' => __( 'Edit Featured Work' ),
      'new_item' => __( 'New Featured Work' ),
      'all_items' => __( 'All Featured Work' ),
      'view_item' => __( 'View Featured Work' ),
      'search_items' => __( 'Search Featured Work' ),
      'not_found' => __( 'No Featured Work found' ),
      'not_found_in_trash' => __( 'No Featured Work found in the Trash' ),
    );
    $args = array(
      'labels' => $labels,
      'public' => true,
      'has_archive' => true,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-admin-appearance',
      'supports' => array('title', 'editor', 'thumbnail'),
      'taxonomies' => array('category'),
    );
    register_post_type( 'featured_artwork', $args);
  }
  add_action( 'init', 'create_featured_artwork_post_type' );

  function namespace_add_custom_types( $query ) {
    if( (is_category() || is_tag()) && $query->is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {
      $query->set( 'post_type', array('post', 'featured_artwork') );
      }
      return $query;
  }
  add_filter( 'pre_get_posts', 'namespace_add_custom_types' );

  if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
  } elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/CMB2/init.php';
  }

  function cmb2_render_dimensions_callback( $field, $value, $object_id, $object_type, $field_type ) {
    $value = wp_parse_args( $value, array(
      'width' => '',
      'height' => '',
    ) );
?>
    <div class='image-width'>
      <p>
        <label for="<?php echo $field_type->_id( '_width' ); ?>">Width</label>
      </p>
      <?php
        echo $field_type->input( array(
          'name' => $field_type->_name( '[width]' ),
          'id' => $field_type->_id( '_width' ),
          'value' => $value['width'],
          'desc' => '',
        ) );
      ?>
    </div>

    <div class='image-height'>
      <p>
        <label for="<?php echo $field_type->_id( '_height' ); ?>'">Height</label>
      </p>
      <?php
        echo $field_type->input( array(
          'name' => $field_type->_name( '[height]' ),
          'id' => $field_type->_id( '_height' ),
          'value' => $value['height'],
          'desc' => '',
        ) );
      ?>
    </div>

    <?php echo $field_type->_desc( true ); ?>
<?php
  }

  add_filter( 'cmb2_render_dimensions', 'cmb2_render_dimensions_callback', 10, 5 );

  function art_desc_metabox() {

    $prefix = '_rwmwop_';

    $cmb = new_cmb2_box( array(
      'id' => 'art_desc',
      'title' => __( 'Artwork Description', 'cmb2' ),
      'object_types' => array( 'featured_artwork' ),
      'context' => 'normal',
      'priority' => 'high',
      'show_names' => true
    ) );

    $cmb->add_field( array(
      'name' => __( 'Type', 'cmb2' ),
      'desc' => __( 'Artwork Type', 'cmb2' ),
      'id' => $prefix . 'type',
      'type' => 'text'
    ) );

    $cmb -> add_field( array(
      'name' => 'Image Size',
      'desc' => 'Image Size',
      'id' => $prefix . 'image_size',
      'type' => 'dimensions',
      )
    );

    $cmb->add_field( array(
      'name' => 'Paper Size',
      'desc' => 'Paper Size',
      'id' => $prefix . 'paper_size',
      'type' => 'dimensions'
    ) );

    $cmb->add_field( array(
      'name' => 'Physical Size',
      'desc' => 'Physical size',
      'id' => $prefix . 'physical_size',
      'type' => 'dimensions'
    ) );

    $cmb->add_field( array(
      'name'    => 'Background Color',
      'id'      => $prefix . 'bg_color',
      'type'    => 'colorpicker',
      'default' => '#ffffff',
    ) );

  }
  add_action( 'cmb2_admin_init', 'art_desc_metabox' );

?>