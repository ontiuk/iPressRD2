<?php 

/**
 * iPress - WordPress Theme Framework                       
 * ==========================================================
 *
 * Template for displaying the generic site header
 * 
 * @package     iPress\Templates
 * @link        http://ipress.uk
 * @license     GPL-2.0+
 */
?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_attr_e( 'Skip to content', 'ipress' ); ?></a>

<header id="masthead" class="site-header" role="banner" <?php ipress_header_style(); ?>>
    <div class="wrap">
        <div class="site-branding">
        <?php
            if ( has_custom_logo() ) :
	    		$logo = get_custom_logo();
		    	$html = is_home() ? sprintf( '<h1 class="logo">%s</h1>', $logo ) : $logo;
            elseif ( function_exists( 'jetpack_has_site_logo' ) && jetpack_has_site_logo() ) :
	    		$logo    = site_logo()->logo;
		    	$logo_id = get_theme_mod( 'custom_logo' ); 
    			$logo_id = $logo_id ? $logo_id : $logo['id']; 
	    		$size    = site_logo()->theme_size();
		    	$html    = sprintf( '<a href="%1$s" class="site-logo-link" rel="home" itemprop="url">%2$s</a>',
			    	esc_url( home_url( '/' ) ),
				    wp_get_attachment_image(
					    $logo_id,
    					$size,
	    				false,
		    			[
			    			'class'     => 'site-logo attachment-' . $size,
				    		'data-size' => $size,
					    	'itemprop'  => 'logo'
                        ]
				    )
			    );

    			$html = apply_filters( 'jetpack_the_site_logo', $html, $logo, $size );
            else :
                $tag = ( ipress_is_home_page() ) ? 'h1' : 'p';
                $html = sprintf( '<%s class="site-title"><a href="%s" rel="home">%s</a></%s>', esc_attr( $tag ), esc_url( home_url('/') ), esc_html( get_bloginfo( 'name' ) ), esc_attr( $tag ) );
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ) :
                    $html .= sprintf( '<p class="site-description">%s</p>', esc_html( $description ) );
                endif; 
            endif;
            echo $html;
        ?>
        </div><!-- .site-branding -->
<?php if ( has_nav_menu( 'primary' ) ) : ?>
    <?php get_template_part( 'templates/site-navigation' ); ?>
<?php endif; ?>
    </div><!-- .wrap -->
</header><!-- header -->
