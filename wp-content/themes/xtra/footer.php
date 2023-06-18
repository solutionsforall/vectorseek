<?php 
     
	// Footer
	if ( is_404() ) {

		$_404 = get_page_by_title( '404' );
		if ( ! empty( $_404->ID ) ) {
			$footer = $_404;
		} else {
			$_404 = get_page_by_path( 'page-404' );
			if ( ! empty( $_404->ID ) ) {
				$footer = $_404;
			}
		}
		

		$footer = isset( $footer->ID ) ? !Codevz_Theme::meta( $footer->ID, 'hide_footer' ) : 1;

	} else if ( is_single() || is_page() ) {
		
		$footer = !Codevz_Theme::meta( false, 'hide_footer' );
		
	} else {
		$footer = 1;
	}

	// Footer content
	if ( $footer ) {
		echo '<footer class="page_footer' . esc_attr( Codevz_Theme::option( 'fixed_footer' ) ? ' cz_fixed_footer' : '' ) . '">';
		

		// Row before footer
		Codevz_Theme::row([
			'id'		=> 'footer_',
			'nums'		=> [ '1' ],
			'row'		=> 1,
			'left'		=> '_left',
			'right'		=> '_right',
			'center'	=> '_center'
		]);
        
		// Footer widgets
		$footer_layout = Codevz_Theme::option( 'footer_layout' );
		if ( $footer_layout ) {
			$layout = explode( ',', $footer_layout );
			$count = count( $layout );
			$is_widget = 0;
			foreach ( $layout as $num => $col ) {
				$num++;
				if ( is_active_sidebar( 'footer-' . $num ) ) {
					$is_widget = 1;
				}
			}
			 
			foreach ( $layout as $num => $col ) {
				$num++;
				if ( $is_widget && $num === 1 ) {
					echo '<div class="cz_middle_footer"><div class="row clr">';
				}
				if ( is_active_sidebar( 'footer-' . $num ) ) {
					echo '<div class="col ' . esc_attr( $col ) . ' sidebar_footer-' . esc_attr( $num ) . ' clr">';
					
					dynamic_sidebar( 'footer-' . $num );  
					echo '</div>';
				} else {
					$published_posts = wp_count_posts("vector_logo")->publish;		
                    $total_downloads = sum_download_logos();		
					echo '<div class="col ' . esc_attr( $col ) . ' sidebar_footer-' . esc_attr( $num ) . ' clr">&nbsp;
						
					    <div class="vectors-and-downloads">
						<h3 class="total-vectors">Total Logos: <span>'.$published_posts.'</span></h3>
						<h3 class="total-downloads">Total Downloads: <span>'. $total_downloads.'</span></h3>
						</div>
						
					
					</div>';
					
				}
				if ( $is_widget && $num === $count ) {
					echo '</div></div>';
				}
			}
		
		}

		// Row after footer
		Codevz_Theme::row([
			'id'		=> 'footer_',
			'nums'		=> [ '2' ],
			'row'		=> 1,
			'left'		=> '_left',
			'right'		=> '_right',
			'center'	=> '_center'
		]);
		
     
		echo '</footer>';
	}

	echo '</div></div>'; // layout

	// Back to top
	echo Codevz_Theme::option( 'backtotop' ) ? '<i class="' . esc_attr( Codevz_Theme::option( 'backtotop' ) ) . ' backtotop"></i>' : '';
	
	// Quick contact
	$cf7 = Codevz_Theme::option( 'cf7_beside_backtotop' );
	if ( $cf7 ) {
		$cf7 = Codevz_Theme::get_page_as_element( esc_html( $cf7 ) );
		if ( $cf7 ) {
			echo '<i class="' . esc_attr( Codevz_Theme::option( 'cf7_beside_backtotop_icon', 'fa fa-envelope-o' ) ) . ' fixed_contact"></i>';
			echo '<div class="fixed_contact">' . $cf7 . '</div>';
		}
	}

	// Popup
	$popup = Codevz_Theme::get_page_as_element( esc_html( Codevz_Theme::option( 'popup' ) ) );
	if ( $popup ) {
		echo '<div class="cz-pages-popup hidden">' . $popup . '</div>';
	}


?>
<div class="cz_fixed_top_border"></div>
<div class="cz_fixed_bottom_border"></div>

<?php wp_footer(); ?>
</body>
</html>
<script>
	jQuery(window).scroll(function(){
		var sticky = jQuery('.header_2'),
			scroll = jQuery(window).scrollTop();
		var searchBox = jQuery('.probox'); 	
	    var ajaxSearchResult = jQuery('#ajaxsearchprores1_1');
		if (scroll >= 100){
			sticky.addClass('fixedHeader');
		}
		else {
			sticky.removeClass('fixedHeader');
		}
		if (scroll >= 100){
			searchBox.addClass('fixedSearch');
			ajaxSearchResult.addClass("SearchResultClass");
		}else{ 
			searchBox.removeClass('fixedSearch');
			ajaxSearchResult.removeClass('SearchResultClass');
		}

	  });
</script>