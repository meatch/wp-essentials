<?php
/*-------------------------------------
||
|| Functions
|| 2016.06.04
||
-------------------------------------*/

/*-------------------------------------
||
|| Theme Sitewide Object
|| These are not actually global variables - as they do not use global scope - the preferred way to do it
||
-------------------------------------*/
class sitewide {
	/*-------------------------------------
	| Domain
	-------------------------------------*/
	var $domain = 'domain.com';

	/*-------------------------------------
	| Phone
	-------------------------------------*/

	var $phone = '626.123.4567';

	public function tel_link_conv($str) {
		$str = str_replace(' ', '', $str); //get rid of spaces
		$str = str_replace('.', '', $str); //get rid of periods
		$str = str_replace('-', '', $str); //get rid of hyphens
		$str = str_replace('(', '', $str); //get rid of left paren
		$str = str_replace(')', '', $str); //get rid of right paren
		$str = 'tel:+1' . $str; //add tel prefix

		return $str;
	}

	/*-------------------------------------
	| Email
	-------------------------------------*/
	var $email = 'user@domain.com';

	/*-------------------------------------
	| Addy
	-------------------------------------*/
	var $addy = '123 Anywhere Street, <br> Monrovia, CA 91016';

	/*-------------------------------------
	| Google Map Anchor Not Embed :: Used a custom image instead of Google Maps Embed
	-------------------------------------*/
	var $googleAddy = 'https://maps.google.com/';
}


/*-------------------------------------
||
|| Body Class Slug
||
-------------------------------------*/
function add_slug_body_class( $classes ) {
	global $post;
	if ( isset( $post ) ) {
		$classes[] = $post->post_type . '-' . $post->post_name;
	}
	return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );

/*-------------------------------------
||
|| Menus
||
-------------------------------------*/
add_theme_support( 'menus' ); //this enables DB > Appearance > Menus (menus does not show otherwise)
function register_my_menus() {
  register_nav_menus(
	array(
	  'main_menu' => __( 'Main Menu' ),
	  'social_links' => __( 'Social Links' ),
	)
  );
}
add_action( 'init', 'register_my_menus' );

/*-------------------------------------
||
|| Loading Scripts and Styles
||
-------------------------------------*/
// Register some javascript files, because we love javascript files. Enqueue a couple as well
function my_loading_assets() {
	/* Bootstrap -------------------------------*/
	wp_register_style( 'css-bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), '1.2', 'screen' );
	wp_enqueue_style( 'css-bootstrap' );

	/* Author Styles -------------------------------*/
	wp_register_style( 'css-author', get_template_directory_uri() . '/assets/css/styles.min.css', array('css-bootstrap'), time(), 'screen' );
	wp_enqueue_style( 'css-author' ); //our own custom css file

    /* Use my own Jquery -------------------------------*/
    wp_deregister_script('jquery');
    wp_register_script( 'jquery', 'https://code.jquery.com/jquery-1.12.4.min.js', array(), '1.12.4', false); //load default jquery as dependency
    wp_enqueue_script( 'jquery' );

    /* Use jQuery UI -------------------------------*/
    wp_register_script( 'jquery-ui', 'https://code.jquery.com/ui/1.12.0/jquery-ui.min.js', array('jquery'), '1.12.0', false); //load default jquery as dependency
    wp_enqueue_script( 'jquery-ui' );

    /* Bootstrap -------------------------------*/
	wp_register_script( 'js-bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.min.js', array('jquery'), '3.0', true); //load default jquery as dependency
    wp_enqueue_script( 'js-bootstrap' );

    /* Viewport -------------------------------*/
	wp_register_script( 'js-viewport', get_template_directory_uri() . '/assets/vendor/jquery/jquery.viewport.mini.js', array('jquery'), '1.0', true); //load default jquery as dependency
    wp_enqueue_script( 'js-viewport' );

    /* Font-Awesome -------------------------------*/
    wp_register_script( 'font-awesome', 'https://use.fontawesome.com/135186ee27.js', array(), '2', false); //load default jquery as dependency
    wp_enqueue_script( 'font-awesome' );

    /* Author -------------------------------*/
    wp_register_script( 'js-author', get_template_directory_uri() . '/assets/js/scripts.js', array('js-bootstrap'), '1.0', true);
	wp_enqueue_script( 'js-author' );
}

add_action( 'wp_enqueue_scripts', 'my_loading_assets' );

/*-------------------------------------
||
|| Post Thumbnail
||
-------------------------------------*/
/*-------------------------------------
|  Post Thumbnail:: Enable
-------------------------------------*/
add_theme_support( 'post-thumbnails' ); //enables feature img
set_post_thumbnail_size( 300, 200, true); //sets default size of uploaded img

/*-------------------------------------
| Post Thumbnail :: Add more
-------------------------------------*/
// adding more :: http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/
add_image_size( 'staff-headshot', 81, 81, true ); // Hard Crop Mode :: resamples down to fit within the w/h - no cropping
add_image_size( 'training-options', 500, 500, true ); // Hard Crop Mode :: resamples down to fit within the w/h - no cropping
add_image_size( 'training-options-large', 1000, 1000 ); // Soft Crop Mode :: resamples down to fit within the w/h - no cropping
add_image_size( 'full-width', 1200, 400, true ); // Hard Crop Mode :: resamples down to fit within the w/h - no cropping

/*-------------------------------------
| Post Thumbnail :: Printing In Pages/Posts
-------------------------------------*/
/* Can be changed in Dashboard / settings / media -------------------------------*/
// the_post_thumbnail(); //default featured image
// the_post_thumbnail( 'thumbnail' );       // Thumbnail (default 150px x 150px max)
// the_post_thumbnail( 'medium' );          // Medium resolution (default 300px x 400px max)
// the_post_thumbnail( 'large' );           // Large resolution (default 1024x x 600px max)
// the_post_thumbnail( 'full' );            // Full resolution (original size uploaded)

// the_post_thumbnail( 'your-specified-image-size' ); //additional sizes as specified above
// the_post_thumbnail( 'training-options' ); //for example
// the_post_thumbnail( 'training-options-large' ); //for example

/*-------------------------------------
| Read more Link
-------------------------------------*/
function new_excerpt_more($more) {
       global $post;
    return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more...</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


/*-------------------------------------
| Widgets
-------------------------------------*/

if (function_exists('register_sidebar')) {

	register_sidebar(array(
		'name' => 'Contact Form',
		'id'   => 'contact-form',
		'description'   => 'Footer Contact Us Form.',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>'
	));


}

/*-------------------------------------
| Conditional Featured Image from Post
-------------------------------------*/
function featured_image_fallback($anchor = true) {
	global $post, $posts;
	$theImage = '<img src="/path/to/default.png" />'; //default
	$theImage = ''; //default
	$result = '';

	if ($anchor)
	{
		$result .= '<a href="';
		$result .= get_the_permalink($post->id);
		$result .= '" class="thumbnail-wrapper">';
	}

	if (get_the_post_thumbnail($post->id) != '')
	{
		$theImage = get_the_post_thumbnail($post->id,  'large' , array('class' => 'opener'));
	}
	else
	{
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if (!empty($matches[1][0])) {
			$theImage = '<img src="' . $matches[1][0] . '" />';
		}
	}
	$result .= $theImage;

	if ($anchor)
	{
		$result .= '</a>';
	}
	return $result;
}


/*-------------------------------------
| Child Page Templates
| https://wordpress.stackexchange.com/questions/55301/is-there-a-default-template-file-for-child-pages-subpages
| Then you can prepare templates with following patterns:
|	[parent-page-slug]/page.php
|	[parent-page-slug]/page-[child-page-slug].php
|	[parent-page-slug]/page-[child-post-id].php
-------------------------------------*/
add_filter(
    'page_template',
    function ($template) {
        global $post;

        if ($post->post_parent) {

            // get top level parent page
            $parent = get_post(
               reset(array_reverse(get_post_ancestors($post->ID)))
            );

            // or ...
            // when you need closest parent post instead
            // $parent = get_post($post->post_parent);

            $child_template = locate_template(
                [
                    $parent->post_name . '/page-' . $post->post_name . '.php',
                    $parent->post_name . '/page-' . $post->ID . '.php',
                    $parent->post_name . '/page.php',
                ]
            );

            if ($child_template) return $child_template;
        }
        return $template;
    }
);


/* Don't leave any whitespace below -------------------------------*/
?>