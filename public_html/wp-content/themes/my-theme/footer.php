<?php
/*-------------------------------------
| Sitewide Object
-------------------------------------*/
$sw = new sitewide();
?>
            <footer id="closing">
				<div class="inset">
					<h1 class="company-name"><?php bloginfo('name'); ?></h1>

					<nav class="mainmenu">
						<?php
							wp_nav_menu(array(
								'theme_location' => 'main_menu', // menu slug from step 1
								'container' => false // 'div' container will not be added
							));
						?>
					</nav>

					<a class="phone" href="<?php echo $sw->tel_link_conv($sw->phone); ?>"><?php echo $sw->phone; ?></a>
					<a class="email visible-xs-block" href="mailto:<?php echo $sw->email; ?>"><?php echo $sw->email; ?></a>
					<div class="addy">
						<a href="<?php echo $sw->googleAddy; ?>" target="googleMaps">
							<?php echo $sw->addy; ?>
						</a>
					</div>
					<div class="copy">&copy; <?php echo date('Y '); echo bloginfo('name'); ?>. All rights reserved.</div>

					<?php get_template_part( 'shared', 'social' ); ?>
				</div>
			</footer>
        </div>


        <!-- Lightbox -->
        <div id="lbox">
            <div class="light">
                <div class="exit glyphicon glyphicon-remove-circle"></div>
                <div class="content">
                    <div class="placeholder">LIGHTBOX CONTENT</div>
                </div>
            </div>
        </div>

        <?php wp_footer(); ?>
		<!-- Google Analytics -->
    </body>
</html>
