(function() {
	'use strict';

	/**
	 * matches() pollyfil
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/Element/closest#Polyfill
	 */
	if ( ! Element.prototype.matches ) {
		Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
	}

	/**
	 * closest() pollyfil
	 * @see https://developer.mozilla.org/en-US/docs/Web/API/Element/closest#Polyfill
	 */
	if ( ! Element.prototype.closest ) {
		Element.prototype.closest = function( s ) {
			var el = this;
			if ( ! document.documentElement.contains( el ) ) {
				return null;
			}
			do {
				if ( el.matches( s ) ) {
					return el;
				}
				el = el.parentElement || el.parentNode;
			} while ( el !== null && el.nodeType === 1 ); 
			return null;
		};
	}

	window.sukiHelper = {
		/**
		 * Helper function to get element's offset.
		 */
		getOffset: function( $el ) {
			if ( $el instanceof HTMLElement ) {
				var rect = $el.getBoundingClientRect();

				return {
					top: rect.top + window.pageYOffset,
					left: rect.left + window.pageXOffset,
				}
			}

			return {
				top: null,
				left: null,
			};
		},

		/**
		 * Helper function to check if element's visible or not.
		 */
		isVisible: function( $el ) {
			return $el.offsetWidth > 0 && $el.offsetHeight > 0;
		},

		/**
		 * Function to check RTL
		 */
		isRTL: function() {
			return document.body.classList.contains( 'rtl' );
		},

		/**
		 * Function to hide an element using slideUp animation.
		 *
		 * source: https://w3bits.com/javascript-slidetoggle/
		 */
		slideUp: function( target, duration = 250 ) {
			if ( ! target ) return;

			target.style.transitionProperty = 'height, margin, padding';
			target.style.transitionDuration = duration + 'ms';
			target.style.height = target.offsetHeight + 'px';
			target.offsetHeight;
			target.style.overflow = 'hidden';
			target.style.height = 0;
			target.style.paddingTop = 0;
			target.style.paddingBottom = 0;
			target.style.marginTop = 0;
			target.style.marginBottom = 0;

			window.setTimeout( function() {
				target.removeAttribute( 'style' );
			}, duration );
		},

		/**
		 * Function to show an element using slideDown animation.
		 *
		 * source: https://w3bits.com/javascript-slidetoggle/
		 */
		slideDown: function( target, duration = 250 ) {
			if ( ! target ) return;

			target.style.removeProperty( 'display' );

			var display = window.getComputedStyle( target ).display;
			if ( display === 'none' ) {
				display = 'block';
			}
			target.style.display = display;

			var height = target.offsetHeight;

			target.style.overflow = 'hidden';
			target.style.height = 0;
			target.style.paddingTop = 0;
			target.style.paddingBottom = 0;
			target.style.marginTop = 0;
			target.style.marginBottom = 0;
			target.offsetHeight;
			target.style.transitionProperty = 'height, margin, padding';
			target.style.transitionDuration = duration + 'ms';
			target.style.height = height + 'px';
			target.style.removeProperty( 'padding-top' );
			target.style.removeProperty( 'padding-bottom' );
			target.style.removeProperty( 'margin-top' );
			target.style.removeProperty( 'margin-bottom' );

			window.setTimeout( function() {
				target.style.removeProperty( 'height' );
				target.style.removeProperty( 'overflow' );
				target.style.removeProperty( 'transition-duration' );
				target.style.removeProperty( 'transition-property' );
			}, duration );
		},

		/**
		 * Function to toggle visibility of an element using slideUp or SlideDown animation.
		 *
		 * source: https://w3bits.com/javascript-slidetoggle/
		 */
		slideToggle: function( target, duration = 250 ) {
			if ( ! target ) return;

			if ( window.getComputedStyle( target ).display === 'none' ) {
				return slideDown( target, duration );
			} else {
				return slideUp( target, duration );
			}
		},
	}

	window.suki = {

		/**
		 * Function to init different style of focused element on keyboard users and mouse users.
		 */
		initKeyboardAndMouseFocus: function() {
			document.body.addEventListener( 'keydown', function( e ) {
				document.body.classList.add( 'using-keyboard' );
			}, false );

			document.body.addEventListener( 'mousedown', function( e ) {
				document.body.classList.remove( 'using-keyboard' );
			}, false );
		},

		/**
		 * Function to init edge sub menu detection script.
		 */
		initDropdownMenuReposition: function() {
			var prop = window.sukiHelper.isRTL() ? 'right' : 'left';

			var calculateSubMenuEdge = function() {

				var $submenus = Array.prototype.slice.call( document.querySelectorAll( '.suki-header-section .menu > * > .sub-menu' ) );
				$submenus.forEach(function( $submenu ) {
					var $section = $submenu.closest( '.suki-header-section' ),
					    $container = $section.classList.contains( 'suki-section-contained' ) ? $section.querySelector( '.suki-section-inner' ) : $submenu.closest( '.suki-wrapper' );

					// Reset inline styling.
					$submenu.classList.remove( 'suki-sub-menu-edge' );
					$submenu.style[ prop ] = '';

					$submenu.style.maxWidth = $container.offsetWidth + 'px';

					var containerEdge = $container.getBoundingClientRect().left + ( window.sukiHelper.isRTL() ? 0 : $container.getBoundingClientRect().width ),
						submenuEdge = $submenu.getBoundingClientRect().left + ( window.sukiHelper.isRTL() ? 0 : $submenu.getBoundingClientRect().width ),
						isSubmenuOverflow = window.sukiHelper.isRTL() ? submenuEdge < containerEdge : submenuEdge > containerEdge;

					// Apply class and left position.
					if ( isSubmenuOverflow ) {
						$submenu.classList.add( 'suki-sub-menu-edge' );
						$submenu.style[ prop ] = -1 * Math.abs( containerEdge - submenuEdge ).toString() + 'px';
					}

					// Apply vertical max-height.
					$submenu.style.maxHeight = ( window.innerHeight - $submenu.getBoundingClientRect().top ) + 'px';

					// Iterate to 2nd & higher level submenu.
					var $subsubmenus = Array.prototype.slice.call( $submenu.querySelectorAll( '.sub-menu' ) );
					$subsubmenus.forEach(function( $subsubmenu ) {
						var subsubmenuEdge = $subsubmenu.getBoundingClientRect().left + ( window.sukiHelper.isRTL() ? 0 : $subsubmenu.getBoundingClientRect().width ),
							isSubsubmenuOverflow = window.sukiHelper.isRTL() ? subsubmenuEdge < containerEdge : subsubmenuEdge > containerEdge;

						// Apply class and left position.
						if ( isSubsubmenuOverflow ) {
							$subsubmenu.classList.add( 'suki-sub-menu-right' );
						}

						// Apply vertical max-height.
						$subsubmenu.style.maxHeight = ( window.innerHeight - $subsubmenu.getBoundingClientRect().top ) + 'px';
					});
				});
			}

			var timeout;
			window.addEventListener( 'resize', function() {
				clearTimeout( timeout );
				timeout = setTimeout( calculateSubMenuEdge, 500 );
			}, false );
			calculateSubMenuEdge();
		},

		/**
		 * Function to init hover menu.
		 */
		initMenuAccessibility: function() {

			/**
			 * Accesibility using tab button
			 * ref: https://github.com/wpaccessibility/a11ythemepatterns/blob/master/dropdown-menus/vanilla-js/js/dropdown.js
			 */
			var handleMenuFocusUsingKeyboard = function( e ) {
				// Fix Firefox issue.
				if ( document === e.target ) return;

				// Check target element.
				var $this = e.target.closest( '.suki-hover-menu .menu-item > a' );
				if ( ! $this ) return;

				var $menu = $this.closest( '.suki-hover-menu' ),
				    $current = this;

				while ( $current !== $menu ) {
					if ( $current.classList.contains( 'menu-item' ) ) {
						if ( $current.classList.contains( 'focus' ) ) {
							$current.classList.remove( 'focus' );
						} else {
							$current.classList.add( 'focus' );
						}
					}
					$current = $current.parentElement;
				}
			}
			document.addEventListener( 'focus', handleMenuFocusUsingKeyboard, false );
			document.addEventListener( 'blur', handleMenuFocusUsingKeyboard, false );

			/**
			 * Accesibility using arrow nav buttons
			 * ref: https://github.com/wpaccessibility/a11ythemepatterns/blob/master/menu-keyboard-arrow-nav/vanilla-js/js/navigation.js
			 */
			var handleMenuNavigationUsingKeyboard = function( e ) {
				// Check target element.
				var $this = e.target.closest( '.suki-hover-menu .menu-item > a' );
				if ( ! $this ) return;

				var key = e.which || e.keyCode;

				// left key
				if ( 37 === key ) {
					e.preventDefault();

					if ( $this.parentElement.previousElementSibling ) {
						$this.parentElement.previousElementSibling.firstElementChild.focus();
					}
				}
				// right key
				else if ( 39 === key ) {
					e.preventDefault();

					if ( $this.parentElement.nextElementSibling ) {
						$this.parentElement.nextElementSibling.firstElementChild.focus();
					}
				}
				// down key
				else if ( 40 === key ) {
					e.preventDefault();

					if ( $this.nextElementSibling ) {
						$this.nextElementSibling.firstElementChild.firstElementChild.focus();
					}
					else if ( $this.parentElement.nextElementSibling ) {
						$this.parentElement.nextElementSibling.firstElementChild.focus();
					}
				}
				// up key
				else if ( 38 === key ) {
					e.preventDefault();

					if ( $this.parentElement.previousElementSibling ) {
						$this.parentElement.previousElementSibling.firstElementChild.focus();
					}
					else if ( $this.parentElement.parentElement.previousElementSibling ) {
						$this.parentElement.parentElement.previousElementSibling.focus();
					}
				}
			}
			document.addEventListener( 'keydown', handleMenuNavigationUsingKeyboard, false );
		},

		/**
		 * Function to init double tap menu on mobile devices.
		 */
		initDoubleTapMobileMenu: function() {
			/**
			 * Mobile Touch friendly
			 */
			var handleMenuOnMobile = function( e ) {
				// Check target element.
				var $this = e.target.closest( '.suki-header-menu .menu-item > a' );
				if ( ! $this ) return;

				// Only enable double tap on menu item that has sub menu.
				if ( $this.parentElement.classList.contains( 'menu-item-has-children' ) ) {
					if ( $this !== document.activeElement ) {
						$this.focus();

						e.preventDefault();
					}
				}
			}
			document.addEventListener( 'touchend', handleMenuOnMobile, false );
		},

		/**
		 * Function to init toggle menu.
		 */
		initClickToggleDropdownMenu: function() {
			/**
			 * Click Handler
			 */

			var handleSubMenuToggle = function( e ) {
				// Check target element.
				var $this = e.target.closest( '.suki-header-section .suki-toggle-menu .suki-sub-menu-toggle' );
				if ( ! $this ) return;
				
				e.preventDefault();

				var $header = document.getElementById( 'masthead' ),
				    $menuItem = $this.parentElement;

				// Menu item already has "focus" class, so collapses itself.
				if ( $menuItem.classList.contains( 'focus' ) ) {
					$menuItem.classList.remove( 'focus' );
				}
				// Menu item doesn't have "focus" class yet, so collapses other focused menu items found in the header and focuses this menu item.
				else {
					var $focusedMenuItems = Array.prototype.slice.call( $header.querySelectorAll( '.menu-item.focus' ) );
					$focusedMenuItems.forEach(function( $focusedMenuItem ) {
						$focusedMenuItem.classList.remove( 'focus' );
					});

					$menuItem.classList.add( 'focus' );

					// Move focus to search bar (if exists).
					var $searchBar = $menuItem.querySelector( '.search-field' );
					if ( $searchBar ) {
						setTimeout(function() {
							$searchBar.focus();
						}, 300 );
					}
				}
			}
			document.addEventListener( 'click', handleSubMenuToggle, false );

			/**
			 * Close Handler
			 */

			var handleSubMenuClose = function( e ) {
				// Make sure click event doesn't happen inside the menu item's scope.
				if ( ! e.target.closest( '.suki-header-section .suki-toggle-menu' ) ) {
					var $header = document.getElementById( 'masthead' ),
					    $focusedMenuItems;

					if ( $header ) {
						var $focusedMenuItems = Array.prototype.slice.call( $header.querySelectorAll( '.suki-toggle-menu .menu-item.focus' ) );
						$focusedMenuItems.forEach(function( $focusedMenuItem ) {
							$focusedMenuItem.classList.remove( 'focus' );
						});
					}
				}
			};
			document.addEventListener( 'click', handleSubMenuClose, false );
		},

		/**
		 * Function to init mobile menu.
		 */
		initAccordionMenu: function() {
			var handleAccordionMenuToggle = function( e ) {
				// Check target element.
				var $this = e.target.closest( '.suki-header-section-vertical .suki-toggle-menu .suki-sub-menu-toggle' );
				if ( ! $this ) return;
				
				e.preventDefault();

				var $menuItem = $this.parentElement,
				    $subMenu = $menuItem.querySelector( '.sub-menu' );

				// Menu item already has "focus" class, so collapses itself and all menu items inside.
				if ( $menuItem.classList.contains( 'focus' ) ) {
					window.sukiHelper.slideUp( $subMenu );
					$menuItem.classList.remove( 'focus' );

					var $insideMenuItems = Array.prototype.slice.call( $menuItem.querySelectorAll( '.menu-item.focus' ) );
					$insideMenuItems.forEach(function( $insideMenuItem ) {
						window.sukiHelper.slideUp( $insideMenuItem.querySelector( '.sub-menu' ) );
						$insideMenuItem.classList.remove( 'focus' );
					});
				}
				// Menu item doesn't have "focus" class yet, so collapses all focused siblings and focuses this menu item.
				else {
					var $siblingMenuItems = Array.prototype.slice.call( $menuItem.parentElement.querySelectorAll( '.menu-item.focus' ) );
					$siblingMenuItems.forEach(function( $siblingMenuItem ) {
						window.sukiHelper.slideUp( $siblingMenuItem.querySelector( '.sub-menu' ) );
						$siblingMenuItem.classList.remove( 'focus' );
					});

					window.sukiHelper.slideDown( $subMenu );
					$menuItem.classList.add( 'focus' );
				}
			}
			document.addEventListener( 'click', handleAccordionMenuToggle, false );
		},

		/**
		 * Function to init page popup toggle.
		 */
		initGlobalPopup: function() {
			var $clickedToggle = null;

			var deactivatePopup = function( device ) {
				var $activePopups = Array.prototype.slice.call( document.querySelectorAll( '.suki-popup-active' + ( undefined !== device ? '.suki-hide-on-' + device : '' ) ) );

				$activePopups.forEach(function( $activePopup ) {
					// Deactivate popup.
					$clickedToggle.classList.remove( 'suki-popup-toggle-active' );
					$activePopup.classList.remove( 'suki-popup-active' );
					document.body.classList.remove( 'suki-has-popup-active' );

					// Back current focus to the toggle.
					$activePopup.removeAttribute( 'tabindex' );
					$clickedToggle.focus();
				});
			}

			// Show / hide popup when the toggle is clicked.
			var handlePopupToggle = function( e ) {
				// Check target element.
				var $this = e.target.closest( '.suki-popup-toggle' );
				if ( ! $this ) return;

				e.preventDefault();
				
				var $target = document.querySelector( '#' + $this.getAttribute( 'data-target' ) );

				// Abort if no popup target found.
				if ( ! $target ) return;

				if ( $target.classList.contains( 'suki-popup-active' ) ) {
					deactivatePopup();
				} else {
					// Activate popup.
					$this.classList.add( 'suki-popup-toggle-active' );
					$target.classList.add( 'suki-popup-active' );
					document.body.classList.add( 'suki-has-popup-active' );

					// Put focus on popup.
					setTimeout(function() {
						$target.setAttribute( 'tabindex', 0 );
						$target.focus();
					}, 300 );

					// Save this toggle for putting back focus when popup is deactivated.
					$clickedToggle = $this;
				}
			}
			document.addEventListener( 'click', handlePopupToggle, false );

			// Close popup when any of ".suki-popup-close" element is clicked.
			var handlePopupClose = function( e ) {
				// Check target element.
				if ( ! e.target.closest( '.suki-popup-close' ) ) return;

				e.preventDefault();

				deactivatePopup();
			}
			document.addEventListener( 'click', handlePopupClose, false );

			// Close popup using "escape" keyboard button.
			var handlePopupEscape = function( e ) {
				var key = e.which || e.keyCode;

				if ( document.body.classList.contains( 'suki-has-popup-active' ) && 27 === key ) {
					deactivatePopup();
				}
			}
			document.addEventListener( 'keydown', handlePopupEscape, false );

			// When window resize, close Active Popups based on their responsive visibility classes.
			var handleResponsiveVisibility = function( e ) {
				if ( document.body.classList.contains( 'suki-has-popup-active' ) ) {
					var device = 'mobile';

					if ( sukiConfig.breakpoints.mobile <= window.innerWidth ) {
						device = 'tablet';
					}

					if ( sukiConfig.breakpoints.desktop <= window.innerWidth ) {
						device = 'desktop';
					}

					deactivatePopup( device );
				}
			}
			window.addEventListener( 'resize', handleResponsiveVisibility, false );

			// Close popup if any hash link is clicked.
			var handleHashLinkInsidePopup = function( e ) {
				// Check target element.
				if ( ! e.target.closest( '.suki-popup a' ) ) return;

				var $link = e.target.closest( 'a' );

				// Check if the link is a hash link.
				if ( '' !== $link.hash ) {
					var pageURL = ( window.location.hostname + '/' + window.location.pathname ).replace( '/\/$/', '' ),
					    linkURL = ( $link.hostname + '/' + $link.pathname ).replace( '/\/$/', '' );

					// Check if the hash target is on this page.
					if ( pageURL === linkURL ) {
						// Deactivate all popups.
						if ( document.body.classList.contains( 'suki-has-popup-active' ) ) {
							deactivatePopup();
						}
					}
				}
			}
			document.addEventListener( 'click', handleHashLinkInsidePopup, false );
		},

		/**
		 * Function to init scroll to top.
		 */
		initScrollToTop: function() {
			var $scrollToTop = document.querySelector( '.suki-scroll-to-top' );

			if ( $scrollToTop ) {
				var handleScrollToTop = function( e ) {
					// Check target element.
					if ( ! e.target.closest( '.suki-scroll-to-top' ) ) return;

					e.preventDefault();

					window.scrollTo({
						top: 0,
						behavior: 'smooth',
					});
				}
				document.addEventListener( 'click', handleScrollToTop, false );

				if ( $scrollToTop.classList.contains( 'suki-scroll-to-top-display-sticky' ) ) {
					var checkStickyOffset = function() {
						if ( window.pageYOffset > 0.5 * window.innerHeight ) {
							$scrollToTop.classList.add( 'sticky' );
						} else {
							$scrollToTop.classList.remove( 'sticky' );
						}
					}
					window.addEventListener( 'scroll', checkStickyOffset, false );
					checkStickyOffset();
				}
			}
		},

		/**
		 * Function that calls all init functions.
		 */
		initAll: function() {
			window.suki.initKeyboardAndMouseFocus();
			window.suki.initDropdownMenuReposition();
			window.suki.initMenuAccessibility();
			window.suki.initClickToggleDropdownMenu();
			window.suki.initDoubleTapMobileMenu();
			window.suki.initAccordionMenu();
			window.suki.initGlobalPopup();
			window.suki.initScrollToTop();
		},
	}

	document.addEventListener( 'DOMContentLoaded', window.suki.initAll, false );

})();