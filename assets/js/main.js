const suki = {
	/**
	 * Keyboard mode
	 *
	 * Add class to body indicating whether users are using keyboard or not.
	 * This is useful to allow different styles for keyboard interaction.
	 */
	initKeyboardFocus() {
		document.body.addEventListener( 'keydown', function() {
			document.body.classList.add( 'using-keyboard' );
		}, false );

		document.body.addEventListener( 'mousedown', function() {
			document.body.classList.remove( 'using-keyboard' );
		}, false );
	},

	/**
	 * Menu's dropdown (sub-menu) reposition
	 *
	 * Check the dropdown size and reposition the `left` offset if it exceeds the current section's container.
	 */
	initMenuDropdownPosition() {
		const calculateSubMenuEdge = function() {
			const isRTL = document.body.classList.contains( 'rtl' );
			const anchorSide = isRTL ? 'left' : 'right';
			const $submenus = [ ...document.querySelectorAll( '.suki-header-row .menu > * > .sub-menu' ) ];

			$submenus.forEach( function( $submenu ) {
				const $section = $submenu.closest( '.suki-header' );
				const $menuItem = $submenu.parentElement;
				const $wrapper = $menuItem.closest( '.suki-header-row' );

				let $container = $wrapper;

				if ( $menuItem.classList.contains( 'suki-mega-menu' ) && $menuItem.classList.contains( 'suki-mega-menu-full-width' ) ) {
					// Full width mega menu, use section as the container.

					$container = $section;
				} else if ( $section.classList.contains( 'suki-section-contained' ) ) {
					// Contained section, use section inner as the container.

					$container = $section.querySelector( '.suki-section-inner' );
				}

				// Reset inline styling.
				$submenu.classList.remove( 'suki-sub-menu-edge' );
				$submenu.style[ anchorSide ] = '';

				// Set "max-width" based on container's width.
				$submenu.style.maxWidth = $container.offsetWidth + 'px';

				const containerEdge = $container.getBoundingClientRect()[ anchorSide ];
				const submenuEdge = $submenu.getBoundingClientRect()[ anchorSide ];
				const isSubmenuOverflow = isRTL ? submenuEdge < containerEdge : submenuEdge > containerEdge;

				// Apply class and left position.
				if ( isSubmenuOverflow ) {
					$submenu.classList.add( 'suki-sub-menu-edge' );
					$submenu.style[ anchorSide ] = ( isRTL ? $container.getBoundingClientRect()[ anchorSide ] - $wrapper.getBoundingClientRect()[ anchorSide ] : $wrapper.getBoundingClientRect()[ anchorSide ] - $container.getBoundingClientRect()[ anchorSide ] ) + 'px';
				}

				if ( $menuItem.classList.contains( 'suki-mega-menu' ) && $menuItem.classList.contains( 'suki-mega-menu-full-width' ) ) {
					const maxContentWidth = $section.classList.contains( 'suki-section-contained' ) ? $menuItem.closest( '.suki-section-inner' ).offsetWidth : $menuItem.closest( '.suki-wrapper' ).offsetWidth;
					const sidePadding = ( $submenu.clientWidth - maxContentWidth ) / 2;

					$submenu.style.paddingLeft = ( sidePadding - parseFloat( window.getComputedStyle( $submenu.firstElementChild, null ).getPropertyValue( 'padding-left' ) ) ) + 'px';
					$submenu.style.paddingRight = ( sidePadding - parseFloat( window.getComputedStyle( $submenu.lastElementChild, null ).getPropertyValue( 'padding-left' ) ) ) + 'px';
				}

				// Apply vertical max-height.
				$submenu.style.maxHeight = ( window.innerHeight - $submenu.getBoundingClientRect().top ) + 'px';

				// If this is a mega menu, there is no need to reposition the subsubmenus.
				if ( $menuItem.classList.contains( 'suki-mega-menu' ) ) {
					return;
				}

				// Iterate to 2nd & higher level submenu.
				const $subsubmenus = [ ...$submenu.querySelectorAll( '.sub-menu' ) ];
				$subsubmenus.forEach( function( $subsubmenu ) {
					const subsubmenuEdge = $subsubmenu.getBoundingClientRect().left + ( isRTL ? 0 : $subsubmenu.getBoundingClientRect().width );
					const isSubsubmenuOverflow = isRTL ? subsubmenuEdge < containerEdge : subsubmenuEdge > containerEdge;

					// Reset inline styling.
					$subsubmenu.classList.remove( 'suki-sub-menu-right' );

					// Apply class and left position.
					if ( isSubsubmenuOverflow ) {
						$subsubmenu.classList.add( 'suki-sub-menu-right' );
					}

					// Apply vertical max-height.
					$subsubmenu.style.maxHeight = ( window.innerHeight - $subsubmenu.getBoundingClientRect().top ) + 'px';
				} );
			} );
		};

		window.addEventListener( 'resize', calculateSubMenuEdge, false );
		calculateSubMenuEdge();
	},

	/**
	 * Accessibility support for menu
	 *
	 * Allow navigating menu using keyboard.
	 */
	initMenuAccessibility() {
		/**
		 * Accesibility using tab button
		 * ref: https://github.com/wpaccessibility/a11ythemepatterns/blob/master/dropdown-menus/vanilla-js/js/dropdown.js
		 *
		 * @param {Event} e
		 */
		const handleMenuFocusUsingKeyboard = function( e ) {
			const $this = e.target;
			const $menu = $this.closest( '.suki-hover-menu' );
			let $current = this;

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
		};

		const $menuLinks = [ ...document.querySelectorAll( '.suki-hover-menu .menu-item > a' ) ];
		$menuLinks.forEach( function( $menuLink ) {
			$menuLink.addEventListener( 'focus', handleMenuFocusUsingKeyboard, true );
			$menuLink.addEventListener( 'blur', handleMenuFocusUsingKeyboard, true );
		} );

		/**
		 * Accesibility using arrow nav buttons
		 * ref: https://github.com/wpaccessibility/a11ythemepatterns/blob/master/menu-keyboard-arrow-nav/vanilla-js/js/navigation.js
		 *
		 * @param {Event} e
		 */
		const handleMenuNavigationUsingKeyboard = function( e ) {
			// Check target element.
			const $this = e.target.closest( '.suki-hover-menu .menu-item > a' );
			if ( ! $this ) {
				return;
			}

			const key = e.which || e.keyCode;

			if ( 37 === key ) {
				// left key

				e.preventDefault();

				if ( $this.parentElement.previousElementSibling ) {
					$this.parentElement.previousElementSibling.firstElementChild.focus();
				}
			} else if ( 39 === key ) {
				// right key

				e.preventDefault();

				if ( $this.parentElement.nextElementSibling ) {
					$this.parentElement.nextElementSibling.firstElementChild.focus();
				}
			} else if ( 40 === key ) {
				// down key

				e.preventDefault();

				if ( $this.nextElementSibling ) {
					$this.nextElementSibling.firstElementChild.firstElementChild.focus();
				} else if ( $this.parentElement.nextElementSibling ) {
					$this.parentElement.nextElementSibling.firstElementChild.focus();
				}
			} else if ( 38 === key ) {
				// up key

				e.preventDefault();

				if ( $this.parentElement.previousElementSibling ) {
					$this.parentElement.previousElementSibling.firstElementChild.focus();
				} else if ( $this.parentElement.parentElement.previousElementSibling ) {
					$this.parentElement.parentElement.previousElementSibling.focus();
				}
			}
		};

		document.addEventListener( 'keydown', handleMenuNavigationUsingKeyboard, false );
	},

	/**
	 * Double tap mode for menu on mobile devices
	 *
	 * First click works like hover mouse event.
	 * Second click works like the normal click mouse event (follow the link).
	 */
	initDoubleTapMobileMenu() {
		const handleMenuOnMobile = function( e ) {
			// Check target element.
			const $this = e.target.closest( '.suki-hover-menu .menu-item > a' );
			if ( ! $this ) {
				return;
			}

			const $menuItem = $this.parentElement;

			// Only enable double tap on menu item that has sub menu and it's not a empty hash link.
			if ( $menuItem.classList.contains( 'menu-item-has-children' ) ) {
				if ( $this !== this.ownerDocument.activeElement ) {
					e.preventDefault(); // Prevent touchend action here (before manually set the focus) to allow focus actions below.

					this.ownerDocument.activeElement.blur();
					$this.focus();
				}
			}
		};

		document.addEventListener( 'touchend', handleMenuOnMobile, false );
	},

	/**
	 * Toggle-triggered dropdown menu
	 */
	initToggleMenu() {
		let $clickedToggle = null;

		/**
		 * Toggle Handler
		 *
		 * @param {Event} e
		 */
		const handleSubMenuToggle = function( e ) {
			// Check target element.
			const $this = e.target.closest( '.suki-header-row .suki-toggle-menu .suki-sub-menu-toggle' );
			if ( ! $this ) {
				return;
			}

			e.preventDefault();

			const $header = document.getElementById( 'masthead' );
			const $menuItem = $this.parentElement;

			if ( $menuItem.classList.contains( 'focus' ) ) {
				// Menu item already has "focus" class, so collapses itself.

				$menuItem.classList.remove( 'focus' );
				$this.setAttribute( 'aria-expanded', false );
			} else {
				// Menu item doesn't have "focus" class yet, so collapses other focused menu items found in the header and focuses this menu item.

				const $focusedMenuItems = [ ...$header.querySelectorAll( '.menu-item.focus' ) ];
				$focusedMenuItems.forEach( function( $focusedMenuItem ) {
					$focusedMenuItem.classList.remove( 'focus' );
				} );

				$menuItem.classList.add( 'focus' );
				$this.setAttribute( 'aria-expanded', true );

				// Move focus to search bar (if exists).
				const $searchBar = $menuItem.querySelector( 'input[type="search"]' );
				if ( $searchBar ) {
					const $subMenu = $searchBar.closest( '.sub-menu' );

					const focusSearchBar = function() {
						$searchBar.click();

						$subMenu.removeEventListener( 'transitionend', focusSearchBar );
					};

					$subMenu.addEventListener( 'transitionend', focusSearchBar );
				}

				// Save this toggle for putting back focus when popup is deactivated.
				$clickedToggle = $this;
			}
		};

		document.addEventListener( 'click', handleSubMenuToggle, false );
		document.addEventListener( 'touchend', handleSubMenuToggle, false );

		/**
		 * Close Handler
		 *
		 * @param {Event} e
		 */
		const handleSubMenuClose = function( e ) {
			// Make sure click event doesn't happen inside the menu item's scope.
			if ( ! e.target.closest( '.suki-header .suki-toggle-menu' ) ) {
				const $header = document.getElementById( 'masthead' );

				if ( $header ) {
					const $focusedMenuItems = [ ...$header.querySelectorAll( '.suki-toggle-menu .menu-item.focus' ) ];
					$focusedMenuItems.forEach( function( $focusedMenuItem ) {
						$focusedMenuItem.classList.remove( 'focus' );
						$clickedToggle.setAttribute( 'aria-expanded', false );
					} );
				}
			}
		};

		document.addEventListener( 'click', handleSubMenuClose, false );
		document.addEventListener( 'touchend', handleSubMenuClose, false );
	},

	/**
	 * Accordion menu
	 */
	initAccordionMenu() {
		/**
		 * Function to hide an element using slideUp animation.
		 *
		 * source: https://w3bits.com/javascript-slidetoggle/
		 *
		 * @param {Element} target
		 * @param {number}  duration
		 */
		const slideUp = function( target, duration ) {
			if ( ! target ) {
				return;
			}

			duration = ( typeof duration !== 'undefined' ) ? duration : 250;

			target.style.transitionProperty = 'height, margin, padding';
			target.style.transitionDuration = duration + 'ms';
			target.style.height = target.offsetHeight + 'px';
			// target.offsetHeight;
			target.style.overflow = 'hidden';
			target.style.height = 0;
			target.style.paddingTop = 0;
			target.style.paddingBottom = 0;
			target.style.marginTop = 0;
			target.style.marginBottom = 0;

			window.setTimeout( function() {
				target.removeAttribute( 'style' );
			}, duration );
		};

		/**
		 * Function to show an element using slideDown animation.
		 *
		 * source: https://w3bits.com/javascript-slidetoggle/
		 *
		 * @param {Element} target
		 * @param {number}  duration
		 */
		const slideDown = function( target, duration ) {
			if ( ! target ) {
				return;
			}

			duration = ( typeof duration !== 'undefined' ) ? duration : 250;

			target.style.removeProperty( 'display' );

			let display = window.getComputedStyle( target ).display;
			if ( display === 'none' ) {
				display = 'block';
			}
			target.style.display = display;

			const height = target.offsetHeight;

			target.style.overflow = 'hidden';
			target.style.height = 0;
			target.style.paddingTop = 0;
			target.style.paddingBottom = 0;
			target.style.marginTop = 0;
			target.style.marginBottom = 0;
			// target.offsetHeight;
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
		};

		/**
		 * Toggle Handler
		 *
		 * @param {Event} e
		 */
		const handleAccordionMenuToggle = function( e ) {
			// Check target element.
			const $this = e.target.closest( '.suki-header-vertical-column .suki-toggle-menu .suki-sub-menu-toggle' );
			if ( ! $this ) {
				return;
			}

			e.preventDefault();

			const $menuItem = $this.parentElement;
			const $subMenu = $menuItem.querySelector( '.sub-menu' );

			if ( $menuItem.classList.contains( 'focus' ) ) {
				// Menu item already has "focus" class, so collapses itself and all menu items inside.

				slideUp( $subMenu );
				$menuItem.classList.remove( 'focus' );

				const $insideMenuItems = [ ...$menuItem.querySelectorAll( '.menu-item.focus' ) ];
				$insideMenuItems.forEach( function( $insideMenuItem ) {
					slideUp( $insideMenuItem.querySelector( '.sub-menu' ) );
					$insideMenuItem.classList.remove( 'focus' );
				} );
			} else {
				// Menu item doesn't have "focus" class yet, so collapses all focused siblings and focuses this menu item.

				const $siblingMenuItems = [ ...$menuItem.parentElement.querySelectorAll( '.menu-item.focus' ) ];
				$siblingMenuItems.forEach( function( $siblingMenuItem ) {
					slideUp( $siblingMenuItem.querySelector( '.sub-menu' ) );
					$siblingMenuItem.classList.remove( 'focus' );
				} );

				slideDown( $subMenu );
				$menuItem.classList.add( 'focus' );
			}
		};

		document.addEventListener( 'click', handleAccordionMenuToggle, false );
		document.addEventListener( 'touchend', handleAccordionMenuToggle, false );

		/**
		 * Empty Hash Link Handler
		 *
		 * @param {Event} e
		 */
		const handleAccordionMenuEmptyHashLink = function( e ) {
			// Check target element.
			const $this = e.target.closest( '.suki-header-section-vertical .suki-toggle-menu .menu-item-has-children > .suki-menu-item-link[href="#"]' );
			if ( ! $this ) {
				return;
			}

			e.preventDefault();

			const $menuItem = $this.parentElement;
			const $toggle = $menuItem.querySelector( '.suki-sub-menu-toggle' );

			// If an empty hash link is clicked, trigger the toggle click event.
			// ref: https://gomakethings.com/how-to-simulate-a-click-event-with-javascript/
			$toggle.click();
		};

		document.addEventListener( 'click', handleAccordionMenuEmptyHashLink, false );
		document.addEventListener( 'touched', handleAccordionMenuEmptyHashLink, false );
	},

	/**
	 * Popup
	 */
	initPopup() {
		let $clickedToggle = null;

		/**
		 * Deactivate popup.
		 *
		 * @param {string} device
		 */
		const deactivatePopup = function( device ) {
			const $activePopups = [ ...document.querySelectorAll( '.suki-popup--active' + ( undefined !== device ? '.suki-hide-on-' + device : '' ) ) ];

			$activePopups.forEach( function( $activePopup ) {
				// Deactivate popup.
				$clickedToggle.classList.remove( 'suki-popup-toggle-active' );
				$clickedToggle.setAttribute( 'aria-expanded', false );
				$activePopup.classList.remove( 'suki-popup--active' );
				document.body.classList.remove( 'suki-has-active-popup' );

				// Back current focus to the toggle.
				$activePopup.removeAttribute( 'tabindex' );
				if ( document.body.classList.contains( 'using-keyboard' ) ) {
					$clickedToggle.focus();
				}
			} );
		};

		/**
		 * Toggle popup visibility.
		 *
		 * @param {Event} e
		 */
		const handlePopupToggle = function( e ) {
			// Check target element.
			const $this = e.target.closest( '.suki-popup-toggle' );
			if ( ! $this ) {
				return;
			}

			e.preventDefault();

			const $target = document.querySelector( '#' + $this.dataset.target );

			// Abort if no popup target found.
			if ( ! $target ) {
				return;
			}

			if ( $target.classList.contains( 'suki-popup--active' ) ) {
				deactivatePopup();
			} else {
				// Activate popup.
				$this.classList.add( 'suki-popup-toggle-active' );
				$this.setAttribute( 'aria-expanded', true );
				$target.classList.add( 'suki-popup--active' );
				document.body.classList.add( 'suki-has-active-popup' );

				// Put focus on popup.
				setTimeout( function() {
					$target.setAttribute( 'tabindex', 0 );
					$target.focus();
				}, 300 );

				// Save this toggle for putting back focus when popup is deactivated.
				$clickedToggle = $this;
			}
		};

		document.addEventListener( 'click', handlePopupToggle, false );
		document.addEventListener( 'touchend', handlePopupToggle, false );

		/**
		 * Close popup using click or tap.
		 *
		 * @param {Event} e
		 */
		const handleClickPopupClose = function( e ) {
			// Check target element.
			if ( ! e.target.closest( '.suki-popup__close' ) ) {
				return;
			}

			e.preventDefault();

			deactivatePopup();
		};

		document.addEventListener( 'click', handleClickPopupClose, false );
		document.addEventListener( 'touchend', handleClickPopupClose, false );

		/**
		 * Close popup using escape key.
		 *
		 * @param {Event} e
		 */
		const handlePopupEscape = function( e ) {
			const key = e.which || e.keyCode;

			if ( document.body.classList.contains( 'suki-has-active-popup' ) && 27 === key ) {
				deactivatePopup();
			}
		};

		document.addEventListener( 'keydown', handlePopupEscape, false );

		/**
		 * Responsive visibility
		 */
		const handleResponsiveVisibility = function() {
			if ( document.body.classList.contains( 'suki-has-active-popup' ) ) {
				let device = 'mobile';

				if ( sukiConfig.breakpoints.mobile <= window.innerWidth ) {
					device = 'tablet';
				}

				if ( sukiConfig.breakpoints.desktop <= window.innerWidth ) {
					device = 'desktop';
				}

				deactivatePopup( device );
			}
		};

		window.addEventListener( 'resize', handleResponsiveVisibility, false );

		/**
		 * Automatic popup close when hash link is triggered.
		 *
		 * @param {Event} e
		 */
		const handleHashLinkInsidePopup = function( e ) {
			// Check target element.
			if ( ! e.target.closest( '.suki-popup a' ) ) {
				return;
			}

			const $link = e.target.closest( 'a' );

			// Check if the link is a hash link.
			if ( '' !== $link.hash ) {
				const pageURL = ( window.location.hostname + '/' + window.location.pathname ).replace( '/\/$/', '' );
				const linkURL = ( $link.hostname + '/' + $link.pathname ).replace( '/\/$/', '' );

				// Check if the hash target is on this page.
				if ( pageURL === linkURL ) {
					// Deactivate all popups.
					if ( document.body.classList.contains( 'suki-has-active-popup' ) ) {
						deactivatePopup();
					}
				}
			}
		};

		document.addEventListener( 'click', handleHashLinkInsidePopup, false );
		document.addEventListener( 'touchend', handleHashLinkInsidePopup, false );
	},

	/**
	 * Function to init scroll to top.
	 */
	initScrollToTop() {
		const $scrollToTop = document.querySelector( '.suki-scroll-to-top' );

		if ( $scrollToTop ) {
			/**
			 * Trigger scroll to top.
			 *
			 * @param {Event} e
			 */
			const handleScrollToTop = function( e ) {
				// Check target element.
				if ( ! e.target.closest( '.suki-scroll-to-top' ) ) {
					return;
				}

				e.preventDefault();

				const $link = e.target.closest( '.suki-scroll-to-top' );
				const $target = document.getElementById( $link.getAttribute( 'href' ).replace( '#', '' ) );

				if ( $target ) {
					window.scrollTo( {
						top: $target.getBoundingClientRect().top,
						behavior: 'smooth',
					} );
				}
			};

			document.addEventListener( 'click', handleScrollToTop, false );
			document.addEventListener( 'touchend', handleScrollToTop, false );

			if ( $scrollToTop.classList.contains( 'suki-scroll-to-top--display-sticky' ) ) {
				const checkStickyOffset = function() {
					if ( window.pageYOffset > 0.5 * window.innerHeight ) {
						$scrollToTop.classList.add( 'suki-sticky' );
					} else {
						$scrollToTop.classList.remove( 'suki-sticky' );
					}
				};

				window.addEventListener( 'scroll', checkStickyOffset, false );
				checkStickyOffset();
			}
		}
	},

	initAll() {
		suki.initKeyboardFocus();
		suki.initMenuDropdownPosition();
		suki.initMenuAccessibility();
		suki.initToggleMenu();
		suki.initDoubleTapMobileMenu();
		suki.initAccordionMenu();
		suki.initPopup();
		suki.initScrollToTop();
	},
};

document.addEventListener( 'DOMContentLoaded', suki.initAll, false );
