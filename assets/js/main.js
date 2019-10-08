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
				// target.style.display = 'none';
				// target.style.removeProperty( 'height' );
				// target.style.removeProperty( 'padding-top' );
				// target.style.removeProperty( 'padding-bottom' );
				// target.style.removeProperty( 'margin-top' );
				// target.style.removeProperty( 'margin-bottom' );
				// target.style.removeProperty( 'overflow' );
				// target.style.removeProperty( 'transition-duration' );
				// target.style.removeProperty( 'transition-property' );
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
			});

			document.body.addEventListener( 'mousedown', function( e ) {
				document.body.classList.remove( 'using-keyboard' );
			});
		},

		/**
		 * Function to init edge sub menu detection script.
		 */
		initDropdownMenuReposition: function() {
			var prop = window.sukiHelper.isRTL() ? 'right' : 'left';

			var calculateSubMenuEdge = function() {

				var $submenus = document.querySelectorAll( '.suki-header-section .menu > * > .sub-menu' );
				for ( var i = 0; i < $submenus.length; i++ ) {
					var $submenu = $submenus[i],
					    $section = $submenu.closest( '.suki-header-section' ),
					    $container = $section.classList.contains( 'suki-section-contained' ) ? $section.querySelector( '.suki-section-inner' ) : $submenu.closest( '.suki-wrapper' );

					$submenu.style.maxWidth = $container.offsetWidth + 'px';

					var containerEdge = $container.getBoundingClientRect().left + ( window.sukiHelper.isRTL() ? 0 : $container.getBoundingClientRect().width ),
						submenuEdge = $submenu.getBoundingClientRect().left + ( window.sukiHelper.isRTL() ? 0 : $submenu.getBoundingClientRect().width ),
						isSubmenuOverflow = window.sukiHelper.isRTL() ? submenuEdge < containerEdge : submenuEdge > containerEdge;

					// Reset inline styling.
					$submenu.classList.remove( 'suki-sub-menu-edge' );
					$submenu.style[ prop ] = '';

					// Apply class and left position.
					if ( isSubmenuOverflow ) {
						$submenu.classList.add( 'suki-sub-menu-edge' );
						$submenu.style[ prop ] = -1 * Math.abs( containerEdge - submenuEdge ).toString() + 'px';
					}

					// Apply vertical max-height.
					$submenu.style.maxHeight = 'none';
					if ( window.innerHeight < $submenu.getBoundingClientRect().top + $submenu.getBoundingClientRect().height ) {
						$submenu.style.maxHeight = ( window.innerHeight - $submenu.getBoundingClientRect().top ) + 'px';
					}

					// Iterate to 2nd & higher level submenu.
					var $subsubmenus = $submenu.querySelectorAll( '.sub-menu' );
					for ( var j = 0; j < $subsubmenus.length; j++ ) {
						var $subsubmenu = $subsubmenus[j],
						    subsubmenuEdge = $subsubmenu.getBoundingClientRect().left + ( window.sukiHelper.isRTL() ? 0 : $subsubmenu.getBoundingClientRect().width ),
							isSubsubmenuOverflow = window.sukiHelper.isRTL() ? subsubmenuEdge < containerEdge : subsubmenuEdge > containerEdge;

						// Apply class and left position.
						if ( isSubsubmenuOverflow ) {
							$subsubmenu.classList.add( 'suki-sub-menu-right' );
						}

						// Apply vertical max-height.
						$subsubmenu.style.maxHeight = 'none';
						if ( window.innerHeight < $subsubmenu.getBoundingClientRect().top + $subsubmenu.getBoundingClientRect().height ) {
							$subsubmenu.style.maxHeight = ( window.innerHeight - $subsubmenu.getBoundingClientRect().top ) + 'px';
						}
					}
				}
			}

			var timeout;
			window.addEventListener( 'resize', function() {
				var $submenus = document.querySelectorAll( '.suki-header-section .menu > * > .sub-menu' );
				for ( var i = 0; i < $submenus.length; i++ ) {
					$submenus[i].style[ prop ] = '';
					$submenus[i].parentElement.classList.remove( 'focus' );
				}

				clearTimeout( timeout );
				timeout = setTimeout( calculateSubMenuEdge, 100 );
			});
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
			var toggleFocus = function( e ) {
				var $menu = this.closest( '.suki-hover-menu' ),
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

			/**
			 * Accesibility using arrow nav buttons
			 * ref: https://github.com/wpaccessibility/a11ythemepatterns/blob/master/menu-keyboard-arrow-nav/vanilla-js/js/navigation.js
			 */
			var keyboardNav = function( e ) {
				var key = e.which || e.keyCode;

				// left key
				if ( 37 === key ) {
					e.preventDefault();

					if ( this.parentElement.previousElementSibling ) {
						this.parentElement.previousElementSibling.firstElementChild.focus();
					}
				}
				// right key
				else if ( 39 === key ) {
					e.preventDefault();

					if ( this.parentElement.nextElementSibling ) {
						this.parentElement.nextElementSibling.firstElementChild.focus();
					}
				}
				// down key
				else if ( 40 === key ) {
					e.preventDefault();

					if ( this.nextElementSibling ) {
						this.nextElementSibling.firstElementChild.firstElementChild.focus();
					}
					else if ( this.parentElement.nextElementSibling ) {
						this.parentElement.nextElementSibling.firstElementChild.focus();
					}
				}
				// up key
				else if ( 38 === key ) {
					e.preventDefault();

					if ( this.parentElement.previousElementSibling ) {
						this.parentElement.previousElementSibling.firstElementChild.focus();
					}
					else if ( this.parentElement.parentElement.previousElementSibling ) {
						this.parentElement.parentElement.previousElementSibling.focus();
					}
				}
			}

			var $menuLinks = document.querySelectorAll( '.suki-hover-menu .menu-item > a' );
			for ( var i = 0; i < $menuLinks.length; i++ ) {
				$menuLinks[i].addEventListener( 'focus', toggleFocus, false );
				$menuLinks[i].addEventListener( 'blur', toggleFocus, false );
				$menuLinks[i].addEventListener( 'keydown', keyboardNav, false );
			}
		},

		/**
		 * Function to init double tap menu on mobile devices.
		 */
		initDoubleTapMobileMenu: function() {
			/**
			 * Mobile Touch friendly
			 */
			var mobileTouch = function( e ) {
				// Only enable double tap on menu item that has sub menu.
				if ( this.parentElement.classList.contains( 'menu-item-has-children' ) ) {
					if ( this !== document.activeElement ) {
						this.focus();

						e.preventDefault();
					}
				}
			}

			var $menuLinks = document.querySelectorAll( '.suki-header-menu .menu-item > a' );
			for ( var i = 0; i < $menuLinks.length; i++ ) {
				$menuLinks[i].addEventListener( 'touchend', mobileTouch, false );
			}
		},

		/**
		 * Function to init toggle menu.
		 */
		initClickToggleDropdownMenu: function() {
			/**
			 * Click Handler
			 */

			var clickHandler = function( e ) {
				e.preventDefault();

				var $header = document.getElementById( 'masthead' ),
				    $menuItem = this.parentElement;

				// Menu item already has "focus" class, so collapses itself.
				if ( $menuItem.classList.contains( 'focus' ) ) {
					$menuItem.classList.remove( 'focus' );
				}
				// Menu item doesn't have "focus" class yet, so collapses other focused menu items found in the header and focuses this menu item.
				else {
					var $focusedMenuItems = $header.querySelectorAll( '.menu-item.focus' );
					for ( var i = 0; i < $focusedMenuItems.length; i++ ) {
						$focusedMenuItems[i].classList.remove( 'focus' );
					}

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

			var $menuToggles = document.querySelectorAll( '.suki-header-section .suki-toggle-menu .suki-sub-menu-toggle' );
			for ( var i = 0; i < $menuToggles.length; i++ ) {
				$menuToggles[i].addEventListener( 'click', clickHandler, false );
				$menuToggles[i].addEventListener( 'touchend', clickHandler, false );
			}

			/**
			 * Close Handler
			 */

			var closeToggle = function( e ) {
				// Make sure click event doesn't happen inside the toggle.
				if ( ! e.target.closest( '.suki-toggle-menu' ) ) {
					var $header = document.getElementById( 'masthead' ),
					    $focusedMenuItems;

					if ( $header ) {
						$focusedMenuItems = $header.querySelectorAll( '.suki-toggle-menu .menu-item.focus' );

						for ( var i = 0; i < $focusedMenuItems.length; i++ ) {
							$focusedMenuItems[i].classList.remove( 'focus' );
						}
					}
				}
			};

			// Handle hover state when clicks happened outside menu items.
			document.addEventListener( 'click', closeToggle, false );
			document.addEventListener( 'touchend', closeToggle, false );
		},

		/**
		 * Function to init mobile menu.
		 */
		initAccordionMenu: function() {
			var clickHandler = function( e ) {
				e.preventDefault();

				var $menuItem = this.parentElement,
				    $subMenu = $menuItem.querySelector( '.sub-menu' );

				// Menu item already has "focus" class, so collapses itself and all menu items inside.
				if ( $menuItem.classList.contains( 'focus' ) ) {
					window.sukiHelper.slideUp( $subMenu );
					$menuItem.classList.remove( 'focus' );

					var $insideMenuItems = $menuItem.querySelectorAll( '.menu-item.focus' );
					for ( var i = 0; i < $insideMenuItems.length; i++ ) {
						window.sukiHelper.slideUp( $insideMenuItems[i].querySelector( '.sub-menu' ) );
						$insideMenuItems[i].classList.remove( 'focus' );
					}
				}
				// Menu item doesn't have "focus" class yet, so collapses all focused siblings and focuses this menu item.
				else {
					var $siblingMenuItems = $menuItem.parentElement.querySelectorAll( '.menu-item.focus' );
					for ( var i = 0; i < $siblingMenuItems.length; i++ ) {
						window.sukiHelper.slideUp( $siblingMenuItems[i].querySelector( '.sub-menu' ) );
						$siblingMenuItems[i].classList.remove( 'focus' );
					}

					window.sukiHelper.slideDown( $subMenu );
					$menuItem.classList.add( 'focus' );
				}
			}

			var $menuToggles = document.querySelectorAll( '.suki-header-section-vertical .suki-toggle-menu .suki-sub-menu-toggle' );
			for ( var i = 0; i < $menuToggles.length; i++ ) {
				$menuToggles[i].addEventListener( 'click', clickHandler, false );
				$menuToggles[i].addEventListener( 'touchend', clickHandler, false );
			}
		},

		/**
		 * Function to init page popup toggle.
		 */
		initGlobalPopup: function() {
			var $clickedToggle = null;

			var deactivatePopup = function( device ) {
				var $activePopups = document.querySelectorAll( '.suki-popup-active' + ( undefined !== device ? '.suki-hide-on-' + device : '' ) );

				for ( var j = 0; j < $activePopups.length; j++ ) {
					// Deactivate popup.
					$clickedToggle.classList.remove( 'suki-popup-toggle-active' );
					$activePopups[j].classList.remove( 'suki-popup-active' );
					document.body.classList.remove( 'suki-has-popup-active' );

					// Back current focus to the toggle.
					$activePopups[j].removeAttribute( 'tabindex' );
					$clickedToggle.focus();
				}
			}

			var $toggles = document.querySelectorAll( '.suki-popup-toggle' );
			for ( var i = 0; i < $toggles.length; i++ ) {
				$toggles[i].addEventListener( 'click', function( e ) {
					e.preventDefault();
				    
				    var $target = document.querySelector( '#' + this.getAttribute( 'data-target' ) );

				    // Abort if no popup target found.
				    if ( ! $target ) return;

				    if ( $target.classList.contains( 'suki-popup-active' ) ) {
						deactivatePopup();
				    } else {
				    	// Activate popup.
						this.classList.add( 'suki-popup-toggle-active' );
						$target.classList.add( 'suki-popup-active' );
						document.body.classList.add( 'suki-has-popup-active' );

						// Put focus on popup.
						setTimeout(function() {
							$target.setAttribute( 'tabindex', 0 );
							$target.focus();
						}, 300 );

				    	// Save this toggle for putting back focus when popup is deactivated.
						$clickedToggle = this;
				    }
				}, false );
			}

			var $closes = document.querySelectorAll( '.suki-popup-close' );
			for ( var i = 0; i < $closes.length; i++ ) {
				$closes[i].addEventListener( 'click', function( e ) {
					e.preventDefault();

					deactivatePopup();
				}, false );
			}

			document.body.addEventListener( 'keydown', function( e ) {
				var key = e.which || e.keyCode;

				if ( document.body.classList.contains( 'suki-has-popup-active' ) && 27 === key ) {
					deactivatePopup();
				}
			});

			// When window resize, close Active Popups based on their responsive visibility classes.
			window.addEventListener( 'resize', function( e ) {
				if ( document.body.classList.contains( 'suki-has-popup-active' ) ) {
					var device = 'mobile';

					if ( 500 <= window.innerWidth ) {
						device = 'tablet';
					}

					if ( 1024 <= window.innerWidth ) {
						device = 'desktop';
					}

					deactivatePopup( device );
				}
			});

			// Close popup if any hash link is clicked.
			var $menuLinks = document.querySelectorAll( '.suki-popup a' );
			for ( var i = 0; i < $menuLinks.length; i++ ) {
				$menuLinks[i].addEventListener( 'click', function( e ) {
					// Check if the link is a hash link.
					if ( '' !== this.hash ) {
						var pageURL = ( window.location.hostname + '/' + window.location.pathname ).replace( '/\/$/', '' ),
						    linkURL = ( this.hostname + '/' + this.pathname ).replace( '/\/$/', '' );

						// Check if the hash target is on this page.
						if ( pageURL === linkURL ) {
							// Deactivate all popups.
							if ( document.body.classList.contains( 'suki-has-popup-active' ) ) {
								deactivatePopup();
							}
						}
					}
				});
			}
		},

		/**
		 * Function to init scroll to top.
		 */
		initScrollToTop: function() {
			var $scrollToTop = document.querySelector( '.suki-scroll-to-top' );

			if ( $scrollToTop ) {
				$scrollToTop.addEventListener( 'click', function( e ) {
					e.preventDefault();

					window.scrollTo({
						top: 0,
						behavior: 'smooth',
					});
				});

				if ( $scrollToTop.classList.contains( 'suki-scroll-to-top-display-sticky' ) ) {
					var checkStickyOffset = function() {
						if ( window.pageYOffset > 0.5 * window.innerHeight ) {
							$scrollToTop.classList.add( 'sticky' );
						} else {
							$scrollToTop.classList.remove( 'sticky' );
						}
					}

					window.addEventListener( 'scroll', checkStickyOffset );
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

	document.addEventListener( 'DOMContentLoaded', window.suki.initAll );

})();