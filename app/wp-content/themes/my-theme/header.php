<?php
/*-------------------------------------
| Sitewide Object
-------------------------------------*/
$sw = new sitewide();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<!-- Viewport Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="<?php echo bloginfo('name'); ?> <?php echo bloginfo('description'); ?>">
    <title>
        <?php
            wp_title( '|', true, 'right' );
            bloginfo('name');
            // Add the blog description for the home/front page.
            $site_description = get_bloginfo('description', 'display');
            echo " | $site_description";
        ?>
    </title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="wrapper">
		<header class="masthead">
			<div class="inset">
				<h1 class="company-name"><?php bloginfo('name'); ?></h1>
				<div class="fa fa-search"><span class="sr-only">Search</span></div>
				<a class="phone" href="<?php echo $sw->tel_link_conv($sw->phone); ?>"><?php echo $sw->phone; ?></a>
		        <?php get_template_part( 'shared', 'social' ); ?>
				<nav class="primary">
					<?php
						wp_nav_menu(array(
							'theme_location' => 'main_menu', // menu slug from step 1
							'container' => false // 'div' container will not be added
						));
					?>
				</nav>
			</div>
		</header>
