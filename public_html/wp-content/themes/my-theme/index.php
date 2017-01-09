<?php
get_header();
/*-------------------------------------
| Sitewide Object
-------------------------------------*/
$sw = new sitewide();
?>
<main>
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div class="post">
    		<h2 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="date"><?php echo get_the_date(); ?> @ <?php the_time(); ?></div>
    		<?php if (has_post_thumbnail()) : ?>
						<a href="<?php the_permalink() ?>">
							<?php the_post_thumbnail(); ?>
						</a>
    					<?php the_excerpt(); ?>
    			</div>
    		<?php else : ?>
    			<?php the_excerpt(); ?>
    		<?php endif ?>
        </div>
	<?php endwhile; endif; ?>
</main>
<?php get_footer(); ?>
