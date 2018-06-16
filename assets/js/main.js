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

	window.suki = {
		/**
		 * Function to check RTL
		 */
		isRTL: function() {
			return document.body.classList.contains( 'rtl' );
		},

		/**
		 * Function to init edge sub menu detection script.
		 */
		initSubMenuEdgeDetection: function() {
			var prop = window.suki.isRTL() ? 'right' : 'left';

			var calculateSubMenuEdge = function() {

				var $submenus = document.querySelectorAll( '.suki-header-section .menu > * > .sub-menu' );
				for ( var i = 0; i < $submenus.length; i++ ) {
					var $submenu = $submenus[i],
					    $wrapper = $submenu.closest( '.suki-wrapper' ),
						wrapperEdge = $wrapper.getBoundingClientRect().left + ( window.suki.isRTL() ? 0 : $wrapper.offsetWidth ),
						submenuEdge = $submenu.getBoundingClientRect().left + ( window.suki.isRTL() ? 0 : $submenu.offsetWidth ),
						isSubmenuOverflow = window.suki.isRTL() ? submenuEdge < wrapperEdge : submenuEdge > wrapperEdge;

					// Reset inline styling.
					$submenu.classList.remove( 'suki-sub-menu-edge' );
					$submenu.style[ prop ] = '';

					// Apply class and left position.
					if ( isSubmenuOverflow ) {
						$submenu.classList.add( 'suki-sub-menu-edge' );
						$submenu.style[ prop ] = -1 * Math.abs( wrapperEdge - submenuEdge ).toString() + 'px';
					}

					// Iterate to 2nd & higher level submenu.
					var $subsubmenus = $submenu.querySelectorAll( '.sub-menu' );
					for ( var j = 0; j < $subsubmenus.length; j++ ) {
						var $subsubmenu = $subsubmenus[j],
						    subsubmenuEdge = $subsubmenu.getBoundingClientRect().left + ( window.suki.isRTL() ? 0 : $subsubmenu.offsetWidth ),
							isSubsubmenuOverflow = window.suki.isRTL() ? subsubmenuEdge < wrapperEdge : subsubmenuEdge > wrapperEdge;

						// Apply class and left position.
						if ( isSubsubmenuOverflow ) {
							$subsubmenu.classList.add( 'suki-sub-menu-right' );
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
			} );
			calculateSubMenuEdge();
		},

		/**
		 * Function to init hover menu.
		 */
		initHoverMenu: function() {
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
				if ( key === 37 ) {
					e.preventDefault();

					if ( this.parentElement.previousElementSibling ) {
						this.parentElement.previousElementSibling.firstElementChild.focus();
					}
				}
				// right key
				else if ( key === 39 ) {
					e.preventDefault();

					if ( this.parentElement.nextElementSibling ) {
						this.parentElement.nextElementSibling.firstElementChild.focus();
					}
				}
				// down key
				else if ( key === 40 ) {
					e.preventDefault();

					if ( this.nextElementSibling ) {
						this.nextElementSibling.firstElementChild.firstElementChild.focus();
					}
					else if ( this.parentElement.nextElementSibling ) {
						this.parentElement.nextElementSibling.firstElementChild.focus();
					}
				}
				// up key
				else if ( key === 38 ) {
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
				$menuLinks[i].addEventListener( 'touchend', mobileTouch, false );

				// Accessibility
				$menuLinks[i].addEventListener( 'focus', toggleFocus, false );
				$menuLinks[i].addEventListener( 'blur', toggleFocus, false );
				$menuLinks[i].addEventListener( 'keydown', keyboardNav, false );
			}
		},

		/**
		 * Function to init toggle menu.
		 */
		initToggleMenu: function() {
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

			var closeToggle = function ( e ) {
				// Make sure click event doesn't happen inside the toggle.
				if ( ! e.target.closest( '.suki-toggle-menu' ) ) {
					var $header = document.getElementById( 'masthead' ),
					    $focusedMenuItems = $header.querySelectorAll( '.suki-toggle-menu .menu-item.focus' );

					for ( var i = 0; i < $focusedMenuItems.length; i++ ) {
						$focusedMenuItems[i].classList.remove( 'focus' );
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
		initVerticalToggleMenu: function() {
			var clickHandler = function( e ) {
				e.preventDefault();

				var $menuItem = this.parentElement;

				// Menu item already has "focus" class, so collapses itself and all menu items inside.
				if ( $menuItem.classList.contains( 'focus' ) ) {
					$menuItem.classList.remove( 'focus' );

					var $insideMenuItems = $menuItem.querySelectorAll( '.menu-item.focus' );
					for ( var i = 0; i < $insideMenuItems.length; i++ ) {
						$insideMenuItems[i].classList.remove( 'focus' );
					}
				}
				// Menu item doesn't have "focus" class yet, so collapsees all focused siblings and focuses this menu item.
				else {
					var $siblingMenuItems = $menuItem.parentElement.children;
					for ( var i = 0; i < $siblingMenuItems.length; i++ ) {
						$siblingMenuItems[i].classList.remove( 'focus' );
					}

					$menuItem.classList.add( 'focus' );
				}
			}

			var $menuToggles = document.querySelectorAll( '.suki-header-vertical .suki-toggle-menu .suki-sub-menu-toggle' );
			for ( var i = 0; i < $menuToggles.length; i++ ) {
				$menuToggles[i].addEventListener( 'click', clickHandler, false );
				$menuToggles[i].addEventListener( 'touchend', clickHandler, false );
			}
		},

		/**
		 * Function to init page popup toggle.
		 */
		initPopupToggle: function() {
			var removeActivePopups = function( device ) {
				var $activePopups = document.querySelectorAll( '.suki-popup-active' + ( undefined !== device ? '.suki-hide-on-' + device : '' ) );

				for ( var j = 0; j < $activePopups.length; j++ ) {
					$activePopups[j].classList.remove( 'suki-popup-active' );
					document.body.classList.remove( 'suki-has-popup-active' );
				}
			}

			var $toggles = document.querySelectorAll( '.suki-popup-toggle' );
			for ( var i = 0; i < $toggles.length; i++ ) {
				$toggles[i].addEventListener( 'click', function( e ) {
					e.preventDefault();
				    
				    var $target = document.querySelector( this.getAttribute( 'href' ) );

				    // Abort if no popup target found.
				    if ( ! $target ) return;

				    if ( $target.classList.contains( 'suki-popup-active' ) ) {
						removeActivePopups();
				    } else {
				    	$target.classList.add( 'suki-popup-active' );
				    	document.body.classList.add( 'suki-has-popup-active' );
				    }
				}, false );
			}

			var $closes = document.querySelectorAll( '.suki-popup-close' );
			for ( var i = 0; i < $closes.length; i++ ) {
				$closes[i].addEventListener( 'click', function( e ) {
					e.preventDefault();

					removeActivePopups();
				}, false );
			}

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

					removeActivePopups( device );
				}
			});
		},

		/**
		 * Function that calls all init functions.
		 */
		initAll: function() {
			window.suki.initSubMenuEdgeDetection();
			window.suki.initHoverMenu();
			window.suki.initToggleMenu();
			window.suki.initVerticalToggleMenu();
			window.suki.initPopupToggle();
		},
	}

	document.addEventListener( 'DOMContentLoaded', window.suki.initAll );

})();