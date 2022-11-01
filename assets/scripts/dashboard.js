/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scripts/dashboard/customizer-shortcuts/index.js":
/*!*************************************************************!*\
  !*** ./src/scripts/dashboard/customizer-shortcuts/index.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.scss */ "./src/scripts/dashboard/customizer-shortcuts/index.scss");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);






const SukiDashboardProTeaser = () => {
  const data = sukiDashboardData.customizerShortcuts;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-admin-dashboard__customizer-shortcuts suki-admin-dashboard__box"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
    className: "suki-admin-dashboard__heading"
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Start Customizing', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-admin-dashboard__customizer-links"
  }, data.links.map(link => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      key: link.label,
      className: "suki-admin-dashboard__customizer-link"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("a", {
      href: link.url
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Icon, {
      icon: link.icon
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, link.label)));
  })));
};

window.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('suki-admin-dashboard__customizer-shortcuts');

  if (root) {
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.render)((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SukiDashboardProTeaser, null), root);
  }
});

/***/ }),

/***/ "./src/scripts/dashboard/index.js":
/*!****************************************!*\
  !*** ./src/scripts/dashboard/index.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index.scss */ "./src/scripts/dashboard/index.scss");
/* harmony import */ var _customizer_shortcuts__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./customizer-shortcuts */ "./src/scripts/dashboard/customizer-shortcuts/index.js");
/* harmony import */ var _pro_teaser__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./pro-teaser */ "./src/scripts/dashboard/pro-teaser/index.js");
/* harmony import */ var _sites_import__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./sites-import */ "./src/scripts/dashboard/sites-import/index.js");





/***/ }),

/***/ "./src/scripts/dashboard/pro-teaser/index.js":
/*!***************************************************!*\
  !*** ./src/scripts/dashboard/pro-teaser/index.js ***!
  \***************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.scss */ "./src/scripts/dashboard/pro-teaser/index.scss");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);






const SukiDashboardProTeaser = () => {
  const data = sukiDashboardData.proTeaser;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-admin-dashboard__pro-teaser suki-admin-dashboard__box"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
    className: "suki-admin-dashboard__heading",
    style: {
      margin: 0
    }
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Suki Pro', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "suki-admin-dashboard__subheading",
    style: {
      marginTop: '5px'
    }
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Get more features, advanced demo templates, and premium support.', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("hr", {
    className: "suki-admin-dashboard__box-separator"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    className: "suki-admin-dashboard__pro-teaser-modules-grid"
  }, data.modules.map(module => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", {
      key: module.slug
    }, module.label);
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    className: "suki-admin-dashboard__pro-teaser-action"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__.__)('Upgrade to Suki Pro', 'suki'),
    variant: "primary",
    href: data.websiteURL
  })));
};

window.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('suki-admin-dashboard__pro-teaser');

  if (root) {
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.render)((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SukiDashboardProTeaser, null), root);
  }
});

/***/ }),

/***/ "./src/scripts/dashboard/sites-import/index.js":
/*!*****************************************************!*\
  !*** ./src/scripts/dashboard/sites-import/index.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.scss */ "./src/scripts/dashboard/sites-import/index.scss");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);







const SukiDashboardSitesImport = () => {
  const [isPluginInstalling, setPluginInstalling] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const [isPluginInstalled, setPluginInstalled] = (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.useState)(sukiDashboardData.sitesImport.isPluginInstalled);
  const pluginSlug = 'suki-sites-import';
  const pluginFilePath = pluginSlug + '/' + pluginSlug;

  const handleInstallPlugin = async () => {
    setPluginInstalling(true); // Install plugin.

    await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default()({
      method: 'POST',
      path: '/wp/v2/plugins/',
      data: {
        slug: pluginSlug
      }
    }).catch(() => {}); // Activate plugin.

    await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_2___default()({
      method: 'POST',
      path: '/wp/v2/plugins/' + pluginFilePath,
      data: {
        status: 'active'
      }
    }).catch(() => {});
    setPluginInstalling(false);
    setPluginInstalled(true);
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-admin-dashboard__sites-import suki-admin-dashboard__box"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
    src: sukiDashboardData.sitesImport.bannerImageURL,
    className: "suki-admin-dashboard__sites-import-banner",
    width: "400",
    height: "240",
    alt: ""
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-admin-dashboard__sites-import-text"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("h2", {
    className: "suki-admin-dashboard__heading",
    style: {
      margin: 0
    }
  }, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Demo Sites Import', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Kickstart your website with our pre-made demo websites: Import. Modify. Launch!', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", {
    style: {
      marginBottom: 0
    }
  }, isPluginInstalled && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Browse Demo Sites', 'suki'),
    variant: "primary",
    href: sukiDashboardData.sitesImport.pluginPageURL
  }), !isPluginInstalled && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
    text: isPluginInstalling ? (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Installing & Activating Plugin', 'suki') : (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__.__)('Install & Activate Plugin', 'suki'),
    variant: "primary",
    isBusy: isPluginInstalling,
    onClick: handleInstallPlugin
  }))));
};

window.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('suki-admin-dashboard__sites-import');

  if (root) {
    (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.render)((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SukiDashboardSitesImport, null), root);
  }
});

/***/ }),

/***/ "./src/scripts/dashboard/customizer-shortcuts/index.scss":
/*!***************************************************************!*\
  !*** ./src/scripts/dashboard/customizer-shortcuts/index.scss ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scripts/dashboard/index.scss":
/*!******************************************!*\
  !*** ./src/scripts/dashboard/index.scss ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scripts/dashboard/pro-teaser/index.scss":
/*!*****************************************************!*\
  !*** ./src/scripts/dashboard/pro-teaser/index.scss ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./src/scripts/dashboard/sites-import/index.scss":
/*!*******************************************************!*\
  !*** ./src/scripts/dashboard/sites-import/index.scss ***!
  \*******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/api-fetch":
/*!**********************************!*\
  !*** external ["wp","apiFetch"] ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["wp"]["apiFetch"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["i18n"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
!function() {
/*!**********************************!*\
  !*** ./src/scripts/dashboard.js ***!
  \**********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _dashboard_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./dashboard/index */ "./src/scripts/dashboard/index.js");

}();
/******/ })()
;
//# sourceMappingURL=dashboard.js.map