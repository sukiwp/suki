/******/ (function() { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scripts/page-settings/index.js":
/*!********************************************!*\
  !*** ./src/scripts/page-settings/index.js ***!
  \********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _index_scss__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./index.scss */ "./src/scripts/page-settings/index.scss");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/data */ "@wordpress/data");
/* harmony import */ var _wordpress_data__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_data__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/edit-post */ "@wordpress/edit-post");
/* harmony import */ var _wordpress_edit_post__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/plugins */ "@wordpress/plugins");
/* harmony import */ var _wordpress_plugins__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_plugins__WEBPACK_IMPORTED_MODULE_6__);








const runFieldOutputs = (key, rules, value, inheritValue) => {
  const actualValue = '' !== value ? value : inheritValue;
  rules.forEach(rule => {
    if (undefined === rule.element) {
      return;
    }

    rule.pattern = rule.pattern || '$';

    switch (rule.type) {
      case 'class':
      default:
        const regex = new RegExp(rule.pattern.replace('$', '[\\w\\-]+'), 'i');
        const formattedValue = rule.pattern.replace('$', actualValue);
        document.querySelectorAll(rule.element).forEach(element => {
          if (element.className.match(regex)) {
            element.className = element.className.replace(regex, formattedValue);
          } else {
            element.className += ' ' + formattedValue;
          }
        });
        break;
    }
  });
};

const SukiPageSettingsSidebarSlotFillFilterableComponent = (0,_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.withFilters)('suki.pageSettingsAdditionalContentsBottom')(() => (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null));

const SukiPageSettingsSidebar = () => {
  const metaValue = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useSelect)(select => {
    return select('core/editor').getEditedPostAttribute('meta')[sukiPageSettingsData.metaKey];
  }, []);
  const editPost = (0,_wordpress_data__WEBPACK_IMPORTED_MODULE_3__.useDispatch)('core/editor').editPost;

  const getFieldValue = function (key) {
    let defaultValue = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
    // If the specified key exists in the values array, return it. Otherwise, return the defaultValue.
    return undefined !== metaValue && undefined !== metaValue[key] ? metaValue[key] : defaultValue;
  };

  const setFieldValue = (key, value) => {
    // Combine the meta value.
    const newValue = { ...metaValue,
      [key]: value
    }; // Ignore '' value because it's "inherit".

    if ('' === value) {
      delete newValue[key];
    } // Update the changes in the data store.


    editPost({
      meta: {
        [sukiPageSettingsData.metaKey]: newValue
      }
    });
  };

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_4__.PluginSidebar, {
    name: sukiPageSettingsData.metaKey,
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Page Settings (Theme)', 'suki')
  }, sukiPageSettingsData.structures.map(panel => {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Panel, {
      key: panel.key
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
      title: panel.title,
      initialOpen: false
    }, panel.fields.map(field => {
      const value = getFieldValue(field.key);

      if (field.outputs) {
        runFieldOutputs(field.key, field.outputs, value, field.inherit_value);
      }

      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelRow, {
        key: field.key,
        className: "suki-page-settings__row"
      }, 'select' === field.type && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.SelectControl, {
        key: field.key,
        label: field.label,
        value: value,
        options: field.options,
        help: field.description,
        onChange: newValue => {
          setFieldValue(field.key, newValue);

          if (field.outputs) {
            runFieldOutputs(field.key, field.outputs, newValue, field.inherit_value);
          }
        },
        __nextHasNoMarginBottom: true
      }));
    })));
  }), sukiPageSettingsData.showProTeaser && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Panel, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.PanelBody, {
    title: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('More options in Suki Pro', 'suki'),
    initialOpen: false
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("ul", {
    style: {
      margin: '1em 0',
      listStyle: 'disc',
      paddingLeft: '1em'
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Transparent header', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Sticky header', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Alternate header colors', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Sticky sidebar', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Preloader screen', 'suki')), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("li", null, (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Insert custom content into any template hooks (header, footer, before content, etc.).', 'suki'))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("p", null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Button, {
    variant: "secondary",
    text: (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__.__)('Learn More', 'suki'),
    href: sukiPageSettingsData.proTeaserUrl,
    target: "_blank",
    rel: "noopener"
  })))), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_2__.Slot, {
    name: "SukiPageSettingsAdditionalContentsBottom"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(SukiPageSettingsSidebarSlotFillFilterableComponent, null)), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_edit_post__WEBPACK_IMPORTED_MODULE_4__.PluginSidebarMoreMenuItem, {
    target: sukiPageSettingsData.metaKey
  }, sukiPageSettingsData.title));
};

(0,_wordpress_plugins__WEBPACK_IMPORTED_MODULE_6__.registerPlugin)(sukiPageSettingsData.metaKey.replaceAll('_', '-'), {
  icon: 'admin-settings',
  render: SukiPageSettingsSidebar
});

/***/ }),

/***/ "./src/scripts/page-settings/index.scss":
/*!**********************************************!*\
  !*** ./src/scripts/page-settings/index.scss ***!
  \**********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/data":
/*!******************************!*\
  !*** external ["wp","data"] ***!
  \******************************/
/***/ (function(module) {

module.exports = window["wp"]["data"];

/***/ }),

/***/ "@wordpress/edit-post":
/*!**********************************!*\
  !*** external ["wp","editPost"] ***!
  \**********************************/
/***/ (function(module) {

module.exports = window["wp"]["editPost"];

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

/***/ }),

/***/ "@wordpress/plugins":
/*!*********************************!*\
  !*** external ["wp","plugins"] ***!
  \*********************************/
/***/ (function(module) {

module.exports = window["wp"]["plugins"];

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
/*!**************************************!*\
  !*** ./src/scripts/page-settings.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _page_settings_index__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./page-settings/index */ "./src/scripts/page-settings/index.js");

}();
/******/ })()
;
//# sourceMappingURL=page-settings.js.map