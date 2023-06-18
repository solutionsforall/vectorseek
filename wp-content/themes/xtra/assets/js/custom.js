/* Custom codevz menu - 1.7.6 */
!function(e,s){"use strict";var o=function(){var o={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",menuArrowClass:"sf-arrows"},n=function(){var s=/^(?![\w\W]*Windows Phone)[\w\W]*(iPhone|iPad|iPod)/i.test(navigator.userAgent);return s&&e("html").css("cursor","pointer").on("click",e.noop),s}(),t=function(){var e=document.documentElement.style;return"behavior"in e&&"fill"in e&&/iemobile/i.test(navigator.userAgent)}(),i=function(){return!!s.PointerEvent}(),r=function(e,s){var n=o.menuClass;s.cssArrows&&(n+=" "+o.menuArrowClass),e.toggleClass(n)},a=function(s,n){return s.find("li."+n.pathClass).slice(0,n.pathLevels).addClass(n.hoverClass+" "+o.bcClass).filter(function(){return e(this).children(n.popUpSelector).hide().show().length}).removeClass(n.pathClass)},l=function(e){e.children("a").toggleClass(o.anchorClass)},h=function(e){var s=e.css("ms-touch-action"),o=e.css("touch-action");o=o||s,o="pan-y"===o?"auto":"pan-y",e.css({"ms-touch-action":o,"touch-action":o})},u=function(e){return e.closest("."+o.menuClass)},p=function(e){return u(e).data("sf-options")},c=function(){var s=e(this),o=p(s);clearTimeout(o.sfTimer),s.siblings().codevzMenu("hide").end().codevzMenu("show")},f=function(s){s.retainPath=e.inArray(this[0],s.$path)>-1,this.codevzMenu("hide"),this.parents("."+s.hoverClass).length||(s.onIdle.call(u(this)),s.$path.length&&e.proxy(c,s.$path)())},d=function(){var s=e(this),o=p(s);n?e.proxy(f,s,o)():(clearTimeout(o.sfTimer),o.sfTimer=setTimeout(e.proxy(f,s,o),o.delay))},v=function(s){var o=e(this),n=p(o),t=o.siblings(s.data.popUpSelector);return n.onHandleTouch.call(t)===!1?this:void(t.length>0&&t.is(":hidden")&&(o.one("click.codevzMenu",!1),"MSPointerDown"===s.type||"pointerdown"===s.type?o.trigger("focus"):e.proxy(c,o.parent("li"))()))},m=function(s,o){var r="li:has("+o.popUpSelector+")";e.fn.hoverIntent&&!o.disableHI?s.hoverIntent(c,d,r):s.on("mouseenter.codevzMenu",r,c).on("mouseleave.codevzMenu",r,d);var a="MSPointerDown.codevzMenu";i&&(a="pointerdown.codevzMenu"),n||(a+=" touchend.codevzMenu"),t&&(a+=" mousedown.codevzMenu"),s.on("focusin.codevzMenu","li",c).on("focusout.codevzMenu","li",d).on(a,"a",o,v)};return{hide:function(s){if(this.length){var o=this,n=p(o);if(!n)return this;var t=n.retainPath===!0?n.$path:"",i=o.find("li."+n.hoverClass).add(this).not(t).removeClass(n.hoverClass).children(n.popUpSelector),r=n.speedOut;if(s&&(i.show(),r=0),n.retainPath=!1,n.onBeforeHide.call(i)===!1)return this;i.hide()}return this},show:function(){var e=p(this);if(!e)return this;var s=this.addClass(e.hoverClass),o=s.children(e.popUpSelector);return e.onBeforeShow.call(o)===!1?this:(o.show(),this)},destroy:function(){return this.each(function(){var s,n=e(this),t=n.data("sf-options");return t?(s=n.find(t.popUpSelector).parent("li"),clearTimeout(t.sfTimer),r(n,t),l(s),h(n),n.off(".codevzMenu").off(".hoverIntent"),s.children(t.popUpSelector).attr("style",function(e,s){return s.replace(/display[^;]+;?/g,"")}),t.$path.removeClass(t.hoverClass+" "+o.bcClass).addClass(t.pathClass),n.find("."+t.hoverClass).removeClass(t.hoverClass),t.onDestroy.call(n),void n.removeData("sf-options")):!1})},init:function(s){return this.each(function(){var n=e(this);if(n.data("sf-options"))return!1;var t=e.extend({},e.fn.codevzMenu.defaults,s),i=n.find(t.popUpSelector).parent("li");t.$path=a(n,t),n.data("sf-options",t),r(n,t),l(i),h(n),m(n,t),i.not("."+o.bcClass).codevzMenu("hide",!0),t.onInit.call(this)})}}}();e.fn.codevzMenu=function(s,n){return o[s]?o[s].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof s&&s?e.error("Method "+s+" does not exist on jQuery.fn.codevzMenu"):o.init.apply(this,arguments)},e.fn.codevzMenu.defaults={popUpSelector:"ul,.sf-mega",hoverClass:"sfHover",pathClass:"overrideThisToUse",pathLevels:1,delay:300,easing:'linear',animation:{opacity:"show"},animationOut:{opacity:"hide"},speed:100,speedOut:100,cssArrows:!0,disableHI:!1,onInit:e.noop,onBeforeShow:e.noop,onShow:e.noop,onBeforeHide:e.noop,onHide:e.noop,onIdle:e.noop,onDestroy:e.noop,onHandleTouch:e.noop}}(jQuery,window);

/* Custom theme scripts */
var Codevz = (function($) {
	"use strict";

	var body = $( 'body' ),
		wind = $( window ),
		inla = $( '.inner_layout' ),
		abar = ( $( '.admin-bar' ).length ? 32 : 0 );

	$.fn.codevz = function( n, i ) {

		$( this ).each(function( a ) {
			var e = $( this );

			if ( e.data( 'codevz' ) !== n || $( '.vc_editor' ).length ) {
				i.apply( e.data( 'codevz', n ), [ a ] );
			}
		});

	}

	return {

		init: function() {

			this.search();
			this.loading();

			// Functions on window resize.
			wind.on( 'resize', function() {
				var wind_width = wind.width();
				
				// WP 5.0 gutenberg
				$( '.alignfull' ).each(function() {
					var inla_width = $( this ).parent().width(),
						from_left  = ( ( wind_width - inla_width ) / 2 );

					$( this ).css({
						width: wind_width,
						left: -from_left
					});
				});

				// Line element auto height.
				setTimeout(function() {
					$( '.header_line_1' ).css( 'height', '' ).each(function() {
						$( this ).height( $( this ).closest( '.row' ).height() );
					});
				}, 500 );

			});

			// Posts equality.
			$( '.cz_default_loop_grid' ).closest( '.cz_posts_container' ).each(function() {
				$( this ).addClass( 'cz_posts_equal' );
			});

			// RTL mode.
			if ( window.location.search.indexOf( 'rtl' ) >= 1 ) {
				$( "a[target!='_blank']" ).each(function() {
					if ( ! (/rtl/.test( this.href ) ) ) {
						this.href += (/\?/.test( this.href ) ? '&' : '?') + 'rtl';
					}
				});
			}

			// Fixed footer.
			$( '.cz_fixed_footer' ).codevz( 'fixed_footer', function() {
				
				wind.on( 'resize', function() {
					body.css( 'margin-bottom', $( '.cz_fixed_footer' ).height() );
				});

				// Temp fix
				setTimeout(function() {
					body.css( 'margin-bottom', $( '.cz_fixed_footer' ).height() );
				}, 1000 );

			});

			// Header custom shape size.
			$( 'div[class*="cz_row_shape_"]' ).codevz( 'row_shape', function() {

				var en = $( this ), 
					cls, css, hei;

				Codevz.heightChanged( en, function() {
					cls = en.attr( 'class' ) || 'cz_no_class',
					cls = '.' + cls.replace(/  /g, '.').replace(/ /g, '.'),
					hei = en.height() + 37;

					if ( ! $( '> style', en ).length ) {
						en.append('<style></style>');
					}
					$( '> style', en ).html( cls + ' .row:before,' + cls + ' .row:after{width:' + hei + 'px}.elms_row ' + cls + ':before, .elms_row ' + cls + ':after{width:' + hei + 'px}' );
				});

			});

			// Print icon.
			body.on( 'click', '.cz-print', function() {

				if ( ! $( '#print-me' ).length ) {
					body.append( "<div id='xtraPrint'></div>" );
				}

				var print = $( "#xtraPrint" );

				$( ".xtra-post-title, .page_title .section_title, .cz_single_fi, .cz_post_content, .xtra-single-product" ).clone().appendTo( print );
				print.find( ".cz_single_fi" ).after( '<br />' );
				print.find( ".xtra-post-title" ).css( 'font-size', '28px' );

				body.addClass( "xtra-printing" );

				setTimeout( function() {
					window.print();
				}, 250 );

				setTimeout( function() {
					body.removeClass( "xtra-printing" );
					print.empty();
				}, 1000 );
			});

			// Widget nav menu dropdown.
			$( '.widget_nav_menu .menu-item-has-children > a' ).each( function() {

				var en = $( this );

				if ( ! en.find( '.fa-pulse' ).length ) {
					en.append( '<i class="fa fa-angle-down"></i>' );
				}

			});

			// Widget nav menu dropdown arrow.
			body.on( 'click', '.widget_nav_menu .menu-item-has-children > a > i', function( e ) {

				$( this ).toggleClass( 'fa-angle-down fa-angle-up' ).closest( 'li' ).find( '> ul' ).slideToggle();

				e.preventDefault();

			});

			// Dropdown menu off screen.
			body.on( 'mouseenter', '.sf-menu .menu-item-has-children', function() {

				var dropdown = $( this ).find( '> ul' ).removeClass( 'cz_open_menu_reverse' ),
					isVisible = dropdown.offset().left + dropdown.width() <= inla.width();

				dropdown[ isVisible ? 'removeClass' : 'addClass' ]( 'cz_open_menu_reverse' );

			});

			// Menus
			$( '.sf-menu' ).codevz( 'sf_menu', function() {
				var disMenu 	= $( this ),
					indicator 	= disMenu.data( 'indicator' ),
					default_ind = disMenu.hasClass( 'offcanvas_menu' ) ? 'fa fa-angle-down' : '',
					indicator 	= indicator ? indicator : default_ind,
					indicator2 	= disMenu.data( 'indicator2' ),
					indicator2 	= indicator2 ? indicator2 : default_ind,
					opa = $( '.page_content, .page_cover, footer' );

				// Fullscreen menu move
				$( '.fixed_side_1.have_center .fullscreen_menu' ).codevz( 'move_fm', function() {
					$( this ).appendTo( '.fixed_side_1.have_center' );
				});

				// Superfish.
				disMenu.codevzMenu({
					
					onInit: function() {

						// Menu indicators.
						$( '.sf-with-ul, h6', this ).each( function() {

							var en = $( this );

							if ( ! $( '.cz_indicator', en ).length ) {

								if ( $( '.cz_menu_subtitle', en ).length ) {
									$( '.cz_menu_subtitle', en ).before( '<i class="cz_indicator"></i>' );
								} else {
									en.append( '<i class="cz_indicator"></i>' );
								}

							}

							if ( ( indicator && indicator.length ) || ( indicator2 && indicator2.length ) ) {
								$( '.cz_indicator', en ).addClass( ( en.parent().parent().hasClass( 'sf-menu' ) ? indicator : indicator2 ) );
							}

							if ( ! en.parent().find( 'li, div' ).length ) {
								en.find( '.cz_indicator' ).remove();
								en.next( 'ul' ).remove();
							}

							// Empty href.
							if ( ! en.attr( 'href' ) ) {
								en.parent().removeClass( 'current_menu' );
							}

							// If there is no active menu.
							if ( ! disMenu.find( '> .current_menu' ).length ) {

								// Fix: Current active menu in dropdown.
								if ( en.parent().find( '.current_menu' ).length ) {

									setTimeout(function() {
										en.parent().addClass( 'current_menu' );
									}, 1000 );

								}

							}

							// Fix: Keep original current menu in dropdown menu.
							if ( disMenu.find( '.current_menu ul > .current-menu-item' ).length ) {

								disMenu.find( '.current_menu ul > .current-menu-item' ).siblings().removeClass( 'current_menu' );

							}

						});

						// Auto responsive menu items according to window width.
						wind.off( 'resize.cz_fix_menu_width' ).on( 'resize.cz_fix_menu_width', function() {

							$( 'header .cz_menu_default' ).not( '#menu_header_4, .cz-not-three-dots' ).each(function() {

								var en = $( this ),
									parent = en.parent(),
									menu_margin = parseFloat( parent.css( 'margin-left' ) ) + parseFloat( parent.css( 'margin-right' ) ),
									elements = 0;

								setTimeout(function() {

									if ( parent.parent().find( '.cz_menu_default' ).length >= 2 ) {
										return;
									}

									// Reset
									en.append( en.find( '.cz-extra-menus > .sub-menu > li' ) ).find( '.cz-extra-menus' ).remove();

									// Add icon dots
									if ( ! en.find( '.cz-extra-menus' ).length ) {
										var submenu_title = $( '.cz_menu_subtitle' ).text() ? '<span class="cz_menu_subtitle">&nbsp;</span>' : '';
										en.append( '<li class="cz-extra-menus cz"><a href="#" class="sf-with-ul"><span>&nbsp;<i class="fa czico-055-three cz-extra-menus" style="margin:0"></i>&nbsp;</span>' + submenu_title + '</a><ul class="sub-menu"></ul></li>');
									}

									var nw = en.find( '.cz-extra-menus' ), 
										nw_ul = nw.find( '> ul' );

									nw.hide().prev().addClass( 'cz-last-child' );

									// Get elements width
									en.parent().parent().find( '.cz_elm' ).not( parent ).each(function() {

										elements += $( this ).outerWidth() + parseFloat( $( this ).css( 'margin-left' ) ) + parseFloat( $( this ).css( 'margin-right' ) );

									});

									// Move back to parent
									nw_ul.find( '> li' ).appendTo( en );

									// Move to hidden menu
									$( en.find( '> li' ).not( '.cz-extra-menus' ).get().reverse() ).each(function() {

										var container = en.closest( '.have_center' ).length ? parent.parent().parent().outerWidth() : parent.parent().outerWidth();

										if ( ( parent.outerWidth() + menu_margin ) + elements + 25 >= container ) {
											$( this ).prependTo( nw_ul );
											nw.show();
										}

									});

								}, 250 );

							});

						});

					},
					onBeforeShow: function() {
						var dis = $( this );

						// Fix Lazyload for dropdown megamenu.
						$( 'img[data-src]', dis ).each(function(i) {
							var en = $( this );
							if ( en.data( 'src' ) ) {
								setTimeout(function () {
									en.attr( 'src', en.data( 'src' ) ).attr( 'srcset', en.data( 'srcset' ) ).attr( 'sizes', en.data( 'sizes' ) ).removeAttr( 'data-sizes data-srcset' ).addClass( 'lazyDone' );
								}, i *  50 );
							}
						});

						if ( dis.hasClass('sub-menu') ) {

							// Check if mega menu is fullwide
							if ( dis.parent().hasClass( 'cz_megamenu_width_fullwide' ) ) {

								var megamenu_row = body,
									megamenu_row_offset = megamenu_row.offset().left,
									megamenu_row_width = megamenu_row.width();

								dis.attr( 'style', dis.attr( 'style' ) + 'width: ' + wind.width() + 'px;left:' + ( megamenu_row_offset - dis.parent().offset().left ) + 'px;margin-right:0;margin-left:0;' );
							
							}

							// Sub-menu styling
							if ( dis.parent().data( 'sub-menu' ) ) {
								setTimeout(function() {
									dis.attr( 'style', dis.attr( 'style' ) + dis.parent().data( 'sub-menu' ) );
								}, 50 );
							}

							// Megamenu
							if ( dis.parent().hasClass( 'cz_parent_megamenu' ) ) {
								dis.addClass( 'cz_megamenu_' + $( '> .cz', dis ).length ).find( 'ul' ).addClass( 'cz_megamenu_inner_ul clr' );
							}

							// Megamenu full row
							if ( dis.parent().hasClass( 'cz_megamenu_width_full_row' ) ) {

								var megamenu_row = $( '.row' ),
									megamenu_row_offset = megamenu_row.offset().left,
									megamenu_row_width = megamenu_row.width();

								if ( dis.closest( '.cz-extra-menus' ).length ) {

									megamenu_row_width = megamenu_row_width - ( megamenu_row.width() - dis.parent().offset().left + 10 );

								}

								dis.attr( 'style', dis.attr( 'style' ) + 'width: ' + megamenu_row_width + 'px;left:' + ( megamenu_row_offset - dis.parent().offset().left ) + 'px;' );

							}

						}

						if ( dis.closest('.fixed_side').length ) {
							var pwidth = dis.parent().closest( '.sub-menu' ).length ? '.sub-menu' : '.sf-menu',
								ff_pos = $( '.fixed_side' ).hasClass( 'fixed_side_left' ) ? 'left' : 'right';
							dis.css( ff_pos, dis.closest( pwidth ).width() );
						}
					}
				});

				// Fullscreen Menu
				$( '.icon_fullscreen_menu' ).codevz( 'fulls_menu', function() {
					$( this ).off( 'click' ).on( 'click', function() {
						var sf_f = $( '.fullscreen_menu' );
						body.addClass( 'cz_noStickySidebar' );
						sf_f.fadeIn( 'fast' ).on( 'click', function() {
							$( this ).delay( 500 ).fadeOut( 'fast', function() {
								body.removeClass( 'cz_noStickySidebar' );
								$( '.xtra-close-icon' ).addClass( 'hide' );
							});
						});
						if ( sf_f.is(':visible') ) {
							Codevz.showOneByOne( $( '> .cz', sf_f ), 150 );
						}

						var h = sf_f.find( '> li' ).height() * ( ( sf_f.find( '> li' ).length - 1 ) / 2 );
						sf_f.css( 'padding-top', ( ( wind.height() / 2 ) - h ) );

						$( this ).parent().find( '.xtra-close-icon' ).toggleClass( 'hide' ).off().on( 'click', function() {
							$( this ).addClass( 'hide' );
							sf_f.fadeOut( 'fast' );
						});

					});
				});

				// Fullscreen
				$( 'ul.fullscreen_menu' ).codevz( 'ul_fulls_menu', function() {
					$( '.cz', this ).on( 'hover', function(e) {
						e.stopPropagation();
					}).off( 'click' ).on( 'click', function(e) {
						if ( $( e.target ).hasClass( 'cz_indicator' ) ) {
							$( this ).closest( 'li' ).find( '> ul' ).fadeToggle( 'fast' );
							e.preventDefault();
							e.stopPropagation();
						}
					});
				});

				// Dropdown Menu
				$( '.icon_dropdown_menu' ).codevz( 'dropdown_menu', function() {
					$( this ).off( 'click' ).on( 'click', function(e) {
						var dis = $( this ),
							pos = dis.position(),
							nav = dis.parent().find('.sf-menu'),
							row = $( this ).closest('.row').height(),
							offset = ( ( inla.outerWidth() + inla.offset().left ) - dis.offset().left );

						if ( nav.is(':visible') ) {
							nav.fadeOut( 'fast' );
							return;
						}

						nav.fadeToggle( 'fast' );

						body.on( 'click.cz_idm', function(e) {
							nav.fadeOut( 'fast' );
							body.off( 'click.cz_idm' );
						});

						$( '.cz', nav ).on( 'hover', function(e) {
							e.stopPropagation();
						}).off( 'click' ).on( 'click', function(e) {
							if ( $( e.target ).hasClass( 'cz_indicator' ) ) {
								$( this ).closest( 'li' ).find('> ul').fadeToggle( 'fast' );
								e.preventDefault();
								e.stopPropagation();
							}
						});

						e.stopPropagation();
					});
				});

				// Open Menu Horizontal
				$( '.icon_open_horizontal' ).codevz( 'iohor', function() {
					$( this ).off( 'click' ).on( 'click', function(e) {
						var dis = $( this ),
							pos = dis.position(),
							nav = dis.parent().find('.sf-menu'),
							row = $( this ).closest('.row').height(),
							offset = ( ( inla.outerWidth() + inla.offset().left ) - dis.offset().left );

						if ( nav.is(':visible') ) {
							nav.fadeOut( 'fast' );
							return;
						}

						nav.fadeToggle( 'fast' );
						Codevz.showOneByOne( $( '> .cz', nav ), 100, ( nav.hasClass( 'inview_left' ) ? 'left' : 'right' ) );

						body.on( 'click.cz_ioh', function(e) {
							nav.fadeOut( 'fast' );
							body.off( 'click.cz_ioh' );
						});

						e.stopPropagation();
					});
				});

				// Mobile Menu
				disMenu.prev( 'i.icon_mobile_offcanvas_menu' ).codevz( 'imom', function() {
					var en = $( this );

					en.removeClass( 'hide' ).on( 'click', function() {
						if ( ! $( this ).hasClass( 'done' ) ) {
							$( this ).addClass( 'done' );
							Codevz.offCanvas( $( this ), 1 );
							
							// Add mobile menus indicator
							if ( indicator.length || indicator2.length ) {
								$( this ).next( '.sf-menu' ).find( '.sf-with-ul' ).each(function() {
									$( '.cz_indicator', this ).addClass( ( $( this ).parent().parent().hasClass( 'sf-menu' ) ? indicator : indicator2 ) );
								});
							}

							var ul_offcanvas = $( 'ul.offcanvas_area' );
							$( '.sf-with-ul, .cz > h6', ul_offcanvas ).on( 'click', function(e) {
								if ( $( e.target ).hasClass( 'cz_indicator' ) ) {
									$( this ).next().slideToggle( 'fast' );
									e.preventDefault();
								}
							});
						}
					});
				});
			});

			// Fix iPad touch issue on mobile links.
			body.on( 'touchstart', '.cz a', function( e ) {

				if ( wind.width() <= 1024 ) {

					var link = $( this ).attr( 'href' );

					if ( link.length > 3 && ! $( e.target ).hasClass( 'cz_indicator' ) ) {
						window.location = $( this ).attr( 'href' );
					}

				}

			});

			// OffCanvas
			$( '.offcanvas_container > i' ).codevz( 'offcanvas_i', function() {
				$( this ).on( 'click', function() {
					if ( ! $( this ).hasClass( 'done' ) ) {
						$( this ).addClass( 'done' );
						Codevz.offCanvas( $( this ), 1 );
					}
				});
			});

			// WPML
			$( '.cz_language_switcher' ).codevz( 'lang_switcher', function() {
				var dis = $( this );
				$( '.cz_current_language', dis ).prependTo( dis );
			});

			// Fix WPML widgets
			$( '.footer_widget, .widget' ).each(function() {
				if ( $( '> .clr', this ).html() === '' ) {
					$( this ).remove();
				}
			});

			// Hidden fullwidth content
			$( '.hf_elm_icon' ).codevz( 'hf_elm_icon', function() {
				$( this ).on( 'click', function( e ) {
					var dis = $( this );

					dis.next( '.hf_elm_area' ).slideToggle( 'fast' ).css({
						width: inla.outerWidth(),
						left: inla.offset().left,
						top: dis.offset().top + dis.outerHeight()
					});

					e.preventDefault();
					e.stopPropagation();
				});

				body.on( 'click', '.hf_elm_area', function( e ) {
					e.stopPropagation();
				});

				body.on( 'click', function() {
					$( '.hf_elm_area' ).slideUp( 'fast' );
				});
			});

			// Header on title
			if ( $( '.header_onthe_cover' ).length ) {
				Codevz.header_on_title();
				wind.on( 'resize', function() {
					Codevz.header_on_title();
				});

				if ( $.fn.imagesLoaded ) {
					$( '.page_header' ).imagesLoaded().progress(function( imgLoad, image ) {
						Codevz.header_on_title();
					});
				} else {
					$( '.page_header img' ).on( 'load', function() {
						setTimeout( function() {
							Codevz.header_on_title();
						}, 250 );
					});
				}

				Codevz.heightChanged( '.page_header', function() {
					Codevz.header_on_title();
				});
			}

			// iframes auto size
			$( '.cz_iframe, .single .cz_post_content iframe, .single_con iframe, object, embed' ).not('.wp-embedded-content').codevz( 'cz_iframe', function() {
				var en = $( this ), newWidth;
				wind.on( 'resize', function() {
					en.attr( 'data-aspectRatio', en.height() / en.width() ).removeAttr( 'height width' );
					newWidth = en.parent().width();
					en.width( newWidth ).height( newWidth * en.attr( 'data-aspectRatio' ) );
				});
			});

			// Extra
			$( '.tagcloud' ).length && $( '.tagcloud' ).addClass( 'clr' );

			// Input buttons to button tag
			$( '.form-submit .submit, input.search-submit, .wpcf7-submit' ).codevz( 'button', function() {
				var en = $( this );
				$('<button name="submit" type="submit" class="' + en.attr('class') + '">' + en.val() + '</button>').insertAfter( en );
				en.detach();
			});

			/* Sticky */
			setTimeout(function() {

				$( '.header_is_sticky' ).codevz( 'header_sticky', function(n) {
					var header_sticky = $( this ),
						header_5 = $( '.header_5' ),
						lastScrollTop = 0,
						st, stickyNav, sticky_func, 
						scrollTop = header_sticky.offset().top,
						h_offset = header_sticky.position(),
						db_height = body.hasClass( 'codevz-is-db' ) ? parseFloat( body.css( 'margin-top' ) ) : 0,
						smart_sticky = function( scroll ) {

							if ( header_sticky.hasClass( 'smart_sticky' ) || ( $( '.cz_fixed_footer' ).length && ( $( '.page_content' ).offset().top + $( '.page_content' ).height() <= wind.scrollTop() + header_sticky.height() ) ) ) {

								st = scroll.scrollTop();

								var oHeight = header_sticky.outerHeight();

								if ( st > ( h_offset.top + oHeight ) && st > lastScrollTop ) {

									header_sticky.css( 'transform', 'translateY(-' + ( oHeight + 20 ) + 'px)' );

								} else if ( st < lastScrollTop ) {

									header_sticky.css( 'transform', 'none' );

								}

								lastScrollTop = st;

							}
							
						};

					if ( header_sticky.hasClass( 'header_5' ) ) {
						
						header_5.addClass( 'onSticky' );
						wind.on( 'scroll', function(e){
							var ph = $( '.page_header' ).height();

							if ( wind.scrollTop() >= ph ) {
								header_5.css( 'transform', 'none' ).css( 'width', inla.width() + 'px' );
							} else {
								header_5.css( 'transform', 'translateY(-' + ( ph + 20 ) + 'px)' ).css( 'width', inla.width() + 'px' );
							}

							smart_sticky( $( this ) );
						});

					} else if ( header_sticky.length ) {

						/* Add corpse */
						if ( ! header_sticky.prev( '.Corpse_Sticky').length ) {
							header_sticky.before( '<div class="Corpse_Sticky' + ( header_sticky.hasClass( 'header_4' ) ? ' cz_sticky_corpse_for_header_4' : '' ) + '"></div>' );
						}

						var scroll_down,
							scroll_top,
							new_scrollTop,
							cz_sticky_h12 = $( '.cz_sticky_h12' ).length,
							cz_sticky_h13 = $( '.cz_sticky_h13' ).length,
							cz_sticky_h23 = $( '.cz_sticky_h23' ).length,
							cz_sticky_h123 = $( '.cz_sticky_h123' ).length;

						sticky_func = function(e) {

							if ( header_sticky.hasClass( 'header_4' ) && header_sticky.css( 'display' ) == 'none' ) {
								return;
							}

							new_scrollTop = scrollTop;

							if ( cz_sticky_h12 && header_sticky.hasClass( 'header_2' ) ) {
								new_scrollTop = scrollTop+1 - $( '.header_1' ).outerHeight();
							} else if ( cz_sticky_h13 && header_sticky.hasClass( 'header_3' ) ) {
								new_scrollTop = scrollTop+1 - $( '.header_1' ).outerHeight();
							} else if ( cz_sticky_h23 && header_sticky.hasClass( 'header_3' ) ) {
								new_scrollTop = scrollTop+1 - $( '.header_2' ).outerHeight();
							} else if ( cz_sticky_h123 ) {
								if ( header_sticky.hasClass( 'header_2' ) ) {
									new_scrollTop = scrollTop+1 - $( '.header_1' ).outerHeight();
								}
								if ( header_sticky.hasClass( 'header_3' ) ) {
									new_scrollTop = scrollTop+1 - ( $( '.header_1' ).outerHeight() + $( '.header_2' ).outerHeight() );
								}
							}

							scroll_top = wind.scrollTop() + ( abar + db_height );
							
							if ( body.hasClass( 'admin-bar' ) && scroll_top === abar ) {
								scroll_top = 0;
							}

							scroll_down = scroll_top > new_scrollTop;

							if ( scroll_down && cz_sticky_h12 && header_sticky.hasClass( 'header_2' ) ) {
								$( '.header_2' ).css( 'marginTop', $( '.header_1' ).outerHeight() );
							} else if ( scroll_down && cz_sticky_h13 && header_sticky.hasClass( 'header_3' ) ) {
								$( '.header_3' ).css( 'marginTop', $( '.header_1' ).outerHeight() );
							} else if ( scroll_down && cz_sticky_h23 && header_sticky.hasClass( 'header_3' ) ) {
								$( '.header_3' ).css( 'marginTop', $( '.header_2' ).outerHeight() );
							} else if ( cz_sticky_h123 ) {
								if ( scroll_down && header_sticky.hasClass( 'header_2' ) ) {
									$( '.header_2' ).css( 'marginTop', $( '.header_1' ).outerHeight() );
								}
								if ( scroll_down && header_sticky.hasClass( 'header_3' ) ) {
									$( '.header_3' ).css( 'marginTop', ( $( '.header_1' ).outerHeight() + $( '.header_2' ).outerHeight() ) );
								}
							}

							if ( scroll_down ) {
								header_sticky.addClass( 'onSticky' ).prev( '.Corpse_Sticky' ).css({
									'height': header_sticky.outerHeight() + 'px'
								});
							} else {
								header_sticky.css( 'marginTop', '' ).removeClass( 'onSticky' ).prev( '.Corpse_Sticky').css({
									'height': 'auto'
								});
							}

							smart_sticky( $( this ) );
							header_sticky.css( 'width', inla.width() + 'px' );
							setTimeout(function() {
								header_sticky.css( 'width', inla.width() + 'px' );
							}, 300 );
						};

						wind.off( 'scroll.cz_sticky_' + n ).on( 'scroll.cz_sticky_' + n, sticky_func );
						wind.off( 'resize.cz_sticky_' + n ).on( 'resize.cz_sticky_' + n, sticky_func );
					}
				});

			}, 1000 );

			this.menu_anchor();
		},

		// Header and title position fix.
		header_on_title: function() {
			var en 		= $( '.header_onthe_cover' ),
				margin  = $( '.header_after_cover' ).length ? 'margin-bottom' : 'margin-top';

			en.css( margin, - $( '.page_header' ).outerHeight() ).css( 'opacity', '1' );
		},

		// Menu Anchor.
		menu_anchor: function() {

			// Define.
			var easing = ( $.easing != 'undefined' ) ? 'easeInOutExpo' : null,
				mPage = $( '.sf-menu' ),
				mLink = $( "a[href*='#']" ).not( 'a[href*="#top"],.cz_no_anchor,.cz_no_anchor a, .vc_general, .cz_no_anchor a, .cz_lrpr a, .wc-tabs a, .cz_edit_popup_link, .page-numbers a, #cancel-comment-reply-link, .vc_carousel-control, [data-vc-container],.comment-form-rating a,.sm2-bar-ui a' ),
				sticky = $( '.header_is_sticky' ).not( '.smart_sticky' ), 
				t, offset,
				scrollToAnchor = function( target ) {
					target = target.replace( '%20', ' ' );
					target = ( target.indexOf( '#' ) >= 0 ) ? $( target ) : $( '#' + target );
					
					if ( target.length ) {
						offset = target.offset().top;
						$( 'html, body' ).animate({ scrollTop: ( offset - abar ) - sticky.outerHeight() }, 1200, easing, function() {
							var new_sticky = $( '.onSticky' ).not( '.smart_sticky' );
							$( 'html, body' ).animate({ scrollTop: ( offset - abar ) - new_sticky.outerHeight() }, 100 );
							body.trigger( 'click' );
						});
					}
				};

			// Prevent page scroll jumping.
			var target = window.location.hash;
			if ( target ) {
				target = target.replace( '#', '' ).replace( '%20', ' ' );
				if ( $( '#' + target ).length ) {

					// Stop scroll.
					//window.location.hash = '';
					$( 'html, body' ).animate({scrollTop: 0}, 1);

					// Scroll to anchor.
					setTimeout(function() {
						scrollToAnchor( target );
					}, 1500 );
				}
			}

			// Links.
			if ( mLink.length ) {
				mLink.off( 'click.cz_manchor' ).on( 'click.cz_manchor', function(e) {

					if ( $( this.hash ).length && location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname ) {
						scrollToAnchor( this.hash );
					} else if ( this.hash ) {
						location = $( this ).attr( 'href' );
					}

					e.preventDefault();
				});

				var mPageH = mPage.outerHeight() + 15,
					mItems = mPage.find( "a[href*='#']" ),
					sItems = mItems.map(function(){
						var item = $( $( this ).attr( "href" ).replace( /\s+|%20/g, "" ).replace( /^.*\#(.*)$/g, "#$1" ) );
						if ( item.length ) {
							return item;
						}
					});

				wind.on( 'scroll', function() {
					var ft = $( this ).scrollTop() + mPageH + sticky.outerHeight() + abar,
						cur = sItems.map(function() {
							if ( $(this).offset().top < ft )
								return this;
							});

					cur = cur[cur.length-1];
					var id = cur && cur.length ? cur[0].id : "";
					if ( id && ! $( '#' + id + '.cz_popup_modal' ).length && $( '#' + id ).length ) {
						body.trigger( 'click' );
						mItems.parent().removeClass( "current_menu" ).end().filter( "[href*='#" + id + "']" ).parent().addClass( "current_menu" );
					//} else if ( id ) {
					} else {
						mItems.parent().removeClass( "current_menu" );
					}
				});
			}
		},

		// Height changed = run callback.
		heightChanged: function( elm, callback ) {
			var elm = ( typeof elm == 'string' ) ? $( elm ) : elm,
				lastHeight = elm.outerHeight(), newHeight;

			// First.
			callback();

			// Height detection.
			(function run() {
				newHeight = elm.outerHeight();
				if ( lastHeight != newHeight ) {
					callback();
					lastHeight = newHeight;
				}

				if ( elm.onElementHeightChangeTimer ) {
					clearTimeout( elm.onElementHeightChangeTimer );
				}

				elm.onElementHeightChangeTimer = setTimeout( run, 100 );
			})();
		},

		// Check element in viewport.
		inview: function( e, i ) {
			var docViewTop = wind.scrollTop(),
				docViewBottom = docViewTop + wind.height(),
				elemTop = e.offset().top,
				elemBottom = elemTop + e.height();

			i = i ? 800 : 0;
			return ( ( elemTop <= docViewBottom + i ) && ( elemBottom >= docViewTop - i ) );
		},

		/*
		*   Ajax Search
		*/
		search: function() {
			var time = 0;

			// Input changes
			if ( $( '.cz_ajax_search' ).length ) {
				$( '.cz_ajax_search' ).on('keyup', '[name="s"]', function() {

					clearTimeout( time );

					var form    = $( this ).parent(),
						results = form.next( '.ajax_search_results' ),
						icon 	= $( 'button i', form ),
						org 	= 'fa ' + icon.data( 'icon' ),
						ajax 	= $( '#intro' ).data( 'ajax' ),
						iLoader = 'fa fa-superpowers fa-pulse';

					// Check input length.
					if ( $( this ).val().length < 3 ) {
						$( '.ajax_search_results' ).slideUp( 'fast' );
						icon.removeClass( iLoader ).addClass( org );
						return;
					} else {
						icon.removeClass( org ).addClass( iLoader );
					}

					// Send request
					time = setTimeout(
						function() {
							$.ajax({
								type: "GET",
								url: ajax,
								dataType: 'html',
								data: "action=codevz_ajax_search&" + form.serialize(),
								success: function( data ) {
									results.html( data ).slideDown( 'fast' );
									icon.removeClass( iLoader ).addClass( org );
								},
								error: function( xhr, status, error ) {
									results.html( '<b class="ajax_search_error">' + error + '</b>' ).slideDown( 'fast' );
									icon.removeClass( iLoader ).addClass( org );
									console.log( xhr, status, error );
								}
							});
						},
						500
					);
				});
			}

			// Search icon
			$( '.search_with_icon' ).codevz( 'search_wi', function() {
				$( this ).on( 'click', function(e) {
					e.stopPropagation();
				}).on( 'click', '[name="s"]', function() {
					if ( $( this ).val() ) {
						$( '.ajax_search_results' ).slideDown( 'fast' );
					}
				});
			});

			// Search dropdown and shop quick cart
			$( '.search_style_icon_dropdown, .elms_shop_cart' ).codevz( 'dr_search_cart', function() {
				var en = $( this );

				if ( ( wind.width() / 2 ) > ( en.offset().left + 300 ) ) {
					en.addClass( 'inview_right' );
				}
			});

			// Search dropdown
			$( '.search_style_icon_dropdown > i' ).codevz( 'sdr_fullwor', function() {
				$( this ).on( 'click', function(e) {
					var dis     = $( this ),
						outer   = dis.parent().find('.outer_search'),
						row_h   = dis.closest('.row').height(),
						clr     = dis.closest('.clr');

					if ( outer.is( ':visible' ) ) {
						outer.fadeOut( 'fast' );
					} else {
						outer.fadeIn( 'fast' ).find('input').focus();
					}
				});
			});

			// Search fullscreen
			$( '.search_style_icon_full > i' ).codevz( 'ssifi', function() {
				$( this ).on( 'click', function() {

					//$( this ).closest( '.header_1,.header_2,.header_3' ).css( 'z-index', '9999' );
					$( this ).parent().find( '.outer_search' ).fadeIn( 'fast' ).find('input').focus();

					wind.off( 'resize.cz_search_full' ).on( 'resize.cz_search_full', function() {
						var w = wind.width(),
							h = wind.height(),
							s = $( this ).find('.outer_search .search');
						s.css({
							'top': h / 4 - s.height() / 2,
							'left': w / 2 - s.width() / 2
						});
					});

					$( this ).parent().find( '.xtra-close-icon' ).toggleClass( 'hide' ).off().on( 'click', function() {
						$( this ).addClass( 'hide' ).parent().find('.outer_search').fadeOut( 'fast' );
					});

				});
			});

			$( 'body, .outer_search' ).on( 'click', function(e) {
				if ( $( e.target ).closest('.outer_search .search').length ) {
					return;
				}

				$('.ajax_search_results').fadeOut( 'fast' );
				$( '.search_style_icon_dropdown, .search_style_icon_full' ).find('.outer_search').fadeOut( 'fast' );
				$( '.search_style_icon_full .xtra-close-icon' ).addClass( 'hide' );
			});

		},

		/*
		*   Loading
		*/
		loading: function() {
			var p 		= $( '.pageloader' ),
				pp 		= p.find( '.pageloader_percentage' ),
				p_done 	= function() {

					if ( ! $( '.pageloader_click' ).length ) {

						p.addClass( 'pageloader_done' );
						setTimeout(function() {
							p.addClass( 'pageloader_done_all' );
						}, 1200 );

					}
					
				};

			if ( p.length ) {

				// Percentage type.
				if ( pp.length ) {
					var images = $( '.inner_layout img' ),
						imgCount = images.length,
						process_done = 0, done, num;

					images.imagesLoaded().progress(function( imgLoad, image ) {
						if ( imgLoad.progressedCount === imgCount && process_done ) {
							setTimeout(function() {
								pp.html( '100%' );
								p_done();
							}, 1000 );
						} else {
							num = ( ( imgLoad.progressedCount / imgCount ) * 100 ).toFixed();

							setTimeout(function() {
								pp.html( num + '%' );
							}, num * 15 );

							if ( ( imgLoad.progressedCount + 1 ) == imgCount ) {
								process_done = 1;
							}
						}
					});

				} else {

					wind.on( 'load.p_done', function() {
						p_done();
					});

				}

				// Custom time
				setTimeout( function(){
					p_done();
				}, 4000 );

				// Loading on click
				if ( ! pp.length ) {

					$( 'a[href*="//"]' ).not( 'a[href*="#"],a[href*="?"],.cz_lightbox,.cz_a_lightbox a,a[href*="youtube.com/watch?"],a[href*="youtu.be/watch?"],a[href*="vimeo.com/"],a[href*=".jpg"],.product a,.esgbox,.jg-entry,.prettyphoto,.cz_grid_title,.ngg-fancybox,.fancybox,.lightbox,a[href*=".jpeg"],a[href*=".png"],a[href*=".gif"],.cz_language_switcher,.add_to_cart_button,.cart_list .remove,a[target="_blank"],[href^="#"],[href*="wp-login"],[id^="wpadminb"] a,[href*="wp-admin"],[data-rel^="prettyPhoto"],a[href$=".jpg"],a[href$=".jpeg"],a[href$=".png"],a[href$=".gif"],a[href$=".mp3"],a[href$=".zip"],a[href$=".rar"],a[href$=".mov"],a[href$=".mp4"],a[href$=".pdf"],a[href$=".mpeg"],.comment-reply-link' ).on( 'click', function(e) {
						
						if ( ! $( this ).hasClass( 'sf-with-ul' ) && $( e.target ).prop( 'tagName' ) != 'I' ) {

							p.addClass( 'pageloader_click' ).removeClass( 'pageloader_done pageloader_done_all' );
						
						}

					});

				}
			}
		},

		/*
		*   offCanvas area
		*/
		offCanvas: function( selector, click ) {
			var parent  = selector.parent(),
				area    = selector.next(),
				layout  = $('#layout'),
				overlay = '.cz_overlay',
				isRight, i, 
				fixed_side = 0,
				close;

			if ( area.length ) {
				var area = area.clone(),
					isRight = area.hasClass( 'inview_right' ),
					new_class = area.hasClass('sf-menu') ? 'sf-menu offcanvas_area' : 'offcanvas_area offcanvas_original';

				body.prepend( area.removeClass().addClass( 'sidebar_offcanvas_area' ).addClass( new_class + ( isRight ? ' inview_right' : ' inview_left' ) ) );
				var area_w = area.width() + 80;

				$( '.sub-menu', area ).hide();
			} else {
				return;
			}

			// Open icon
			selector.on( 'click', function(e) {

				if ( area.hasClass( 'active_offcanvas' ) && ! body.hasClass( 'offcanvas_doing' ) ) {
					body.trigger( 'click' );
				} else {

					// Close icon
					area.before( '<i class="fa czico-198-cancel offcanvas-close"></i>' );
					close = area.prev( '.offcanvas-close' );
					close.on( 'click', function(e) {
						if ( click ) {
							body.removeClass( 'active_offcanvas' );
							area.removeClass( 'active_offcanvas' );
							
							$( overlay ).fadeOut();
							setTimeout(function() {
								$( '.offcanvas-close' ).detach();
								wind.trigger( 'resize' );
							}, 500 );
							
							click = 0;
						} else {
							body.trigger( 'click' );
						}
					});
					close.css( ( isRight ? 'right' : 'left' ), area.outerWidth() + fixed_side );

					body.addClass( 'offcanvas_doing active_offcanvas' + ( isRight ? ' cz_offcanvas_right' : ' cz_offcanvas_left' ) );
					area.addClass( 'active_offcanvas' );
					
					if ( wind.width() > 768 ) {

						if ( ( $( '.fixed_side_left' ).length && $( '.cz_offcanvas_left' ).length ) || $( '.fixed_side_right' ).length  && $( '.cz_offcanvas_right' ).length ) {
							if ( ! $( '#cz_ofs' ).length ) {
								$( 'head' ).append( '<style id="cz_ofs"></style>' );
							}
							fixed_side = $( '.fixed_side' ).width();
							$( '#cz_ofs' ).html( '.active_offcanvas .offcanvas_area.active_offcanvas{transform:translateX(' + ( isRight ? '-' : '' ) + fixed_side + 'px)}' );
						}
						
					}

					$( overlay ).fadeIn();

					setTimeout(function() {
						body.removeClass( 'offcanvas_doing' );
					}, 1500 );
				}

				e.stopPropagation();
			});

			// First time
			if ( click ) {
				selector.trigger( 'click' );
			}

			// Prevent close on open icon
			area.on( 'click', function(e) {
				e.stopPropagation();
			});

			// reCall anchors
			this.menu_anchor();

			// Click on body
			body.on( 'click.offcanvas', function(e) {

				if ( $( '.active_offcanvas' ).length && ! body.hasClass( 'offcanvas_doing' ) ) {
					body.removeClass( 'active_offcanvas' );
					area.removeClass( 'active_offcanvas' );

					$( overlay ).fadeOut();
					setTimeout(function() {
						$( '.offcanvas-close' ).detach();
						wind.trigger( 'resize' );
					}, 500 );
				}

				setTimeout(function() {
					if ( ! $( overlay ).is( ':visible' ) && $( '.active_offcanvas' ).length ) {
						$( '.offcanvas-close' ).trigger( 'click' );
					}
				}, 500 );

			});

			// Close mobile on window resize.
			wind.on( 'resize', function(e) {
				
				if( $( '#menu_header_4' ).hasClass( 'active_offcanvas' ) && wind.width() > 768 ) {
					$( '#menu_header_4' ).prev( 'i' ).trigger( 'click' );
				}

			});

			// Reload necessary scripts.
			if( ! area.hasClass( 'xtra-reload-js' ) ) {

				// reInit codevz plus.
				Codevz_Plus.init();

				// Fix Lazyload images.
				area.find( 'img[data-src]' ).each(function() {
					
					var en = $( this );

					if( en.data( 'src' ) ) {
						en.attr( 'src', en.data( 'src' ) ).attr( 'srcset', en.data( 'srcset' ) ).attr( 'sizes', en.data( 'sizes' ) ).removeAttr( 'data-sizes data-srcset' ).addClass( 'lazyDone' );
					}
					
				});

				// reInit contact form 7.
				if( typeof wpcf7 != 'undefined' && area.find( '.wpcf7' ).length ) {

					area.find( 'div.wpcf7 > form' ).each( function() {
						var $form = $( this );
						wpcf7.initForm( $form );

						if( wpcf7.cached ) {
							wpcf7.refill( $form );
						}
					} );

				}

				// reInit Facebook.
				setTimeout( function(){
					if ( window.FB ) {
						FB.XFBML.parse();
					}
				}, 2000 );

				area.addClass( 'xtra-reload-js' );

			}

		},

		/*
		*   Show one by one with delay
		*/
		showOneByOne: function( e, s, d ) {
			var e = ( d == 'left' ) ? $( e.get().reverse() ) : e,
				b = ( d == 'left' ) ? {opacity:0,left:10} : {opacity: 0,left:-10};

			e.css( b ).each(function( i ) {
				$( this ).delay( s * i ).animate({opacity:1,left:0});
			});
		},

	};
})(jQuery);

jQuery(document).ready(function($) {
	Codevz.init();
});