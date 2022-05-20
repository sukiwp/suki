/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/scripts/customizer/components/SukiColorSelectDropdown.js":
/*!**********************************************************************!*\
  !*** ./src/scripts/customizer/components/SukiColorSelectDropdown.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);




function SukiColorSelectDropdown(_ref) {
  var changeValue = _ref.changeValue,
      defaultPickerValue = _ref.defaultPickerValue,
      defaultValue = _ref.defaultValue,
      value = _ref.value;
  var palette = [];

  for (var i = 1; i <= 8; i++) {
    var color = wp.customize('color_palette_' + i).get();
    palette.push({
      name: wp.customize('color_palette_' + i + '_name').get() || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.sprintf)(SukiCustomizerData.l10n.themeColor$d, i),
      color: 'var(--color-palette-' + i + ')',
      actualValue: color
    });
  }

  var valueIsLink = value && 0 === value.indexOf('var(') ? true : false;
  var pickerIsOpened = value && !valueIsLink;
  var valueInfo = valueIsLink ? palette.find(function (item) {
    return value === item.color;
  }) : {
    name: SukiCustomizerData.l10n.custom,
    color: value,
    actualValue: value
  };
  console.log(valueInfo);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-color-dropdown"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SlotFillProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Dropdown, {
    position: "bottom left",
    focusOnMount: "container",
    renderToggle: function renderToggle(toggleParams) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
        isSmall: true,
        variant: "tertiary",
        label: '' !== value ? valueInfo.name : SukiCustomizerData.l10n.notSet,
        showTooltip: true,
        "aria-expanded": toggleParams.isOpen,
        className: "suki-color-dropdown__toggle",
        onClick: toggleParams.onToggle
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorIndicator, {
        colorValue: value,
        className: 'suki-color-indicator' + (valueIsLink ? ' suki-color-indicator--linked' : '')
      }));
    },
    renderContent: function renderContent(contentParams) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalVStack, {
        spacing: "3",
        style: {
          width: '275px'
        }
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHStack, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorPalette, {
        colors: palette,
        value: valueIsLink ? valueInfo.color : '',
        disableCustomColors: true,
        clearable: false,
        className: "suki-color-dropdown__palette",
        onChange: function onChange(color) {
          changeValue(color);
        }
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
        className: "suki-color-dropdown__custom"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
        isSmall: true,
        isPressed: pickerIsOpened,
        variant: "tertiary",
        icon: "color-picker",
        label: SukiCustomizerData.l10n.custom,
        showTooltip: true,
        "aria-expanded": pickerIsOpened,
        className: "suki-color-dropdown__custom__toggle",
        onClick: function onClick(e) {
          if (pickerIsOpened) {
            // isPresed: true
            changeValue('');
          } else {
            // isPressed: false
            if (valueInfo.actualValue) {
              changeValue(valueInfo.actualValue);
            } else {
              changeValue(defaultPickerValue || '#ffffff');
            }
          }
        }
      }))), pickerIsOpened && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorPicker, {
        color: value,
        enableAlpha: true,
        className: "suki-color-dropdown__picker",
        onChange: function onChange(value) {
          changeValue(value);
        }
      }), defaultValue && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHStack, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
        isSmall: true,
        variant: "secondary",
        onClick: function onClick(e) {
          changeValue(defaultValue);
        }
      }, SukiCustomizerData.l10n.reset)));
    }
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Popover.Slot, null))));
}

/* harmony default export */ __webpack_exports__["default"] = (SukiColorSelectDropdown);

/***/ }),

/***/ "./src/scripts/customizer/components/SukiControlDescription.js":
/*!*********************************************************************!*\
  !*** ./src/scripts/customizer/components/SukiControlDescription.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);



function SukiControlDescription(_ref) {
  var children = _ref.children,
      className = _ref.className,
      id = _ref.id;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()(className, 'description', 'customize-control-description'),
    id: id
  }, children));
}

/* harmony default export */ __webpack_exports__["default"] = (SukiControlDescription);

/***/ }),

/***/ "./src/scripts/customizer/components/SukiControlLabel.js":
/*!***************************************************************!*\
  !*** ./src/scripts/customizer/components/SukiControlLabel.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);



function SukiControlLabel(_ref) {
  var children = _ref.children,
      className = _ref.className,
      target = _ref.target;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()(className, 'customize-control-title'),
    htmlFor: target
  }, children));
}

/* harmony default export */ __webpack_exports__["default"] = (SukiControlLabel);

/***/ }),

/***/ "./src/scripts/customizer/components/SukiControlResponsiveContainer.js":
/*!*****************************************************************************!*\
  !*** ./src/scripts/customizer/components/SukiControlResponsiveContainer.js ***!
  \*****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_1__);



function SukiControlResponsiveContainer(_ref) {
  var children = _ref.children,
      className = _ref.className,
      device = _ref.device;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()(className, 'suki-responsive-container'),
    "data-device": device
  }, children));
}

/* harmony default export */ __webpack_exports__["default"] = (SukiControlResponsiveContainer);

/***/ }),

/***/ "./src/scripts/customizer/components/SukiControlResponsiveSwitcher.js":
/*!****************************************************************************!*\
  !*** ./src/scripts/customizer/components/SukiControlResponsiveSwitcher.js ***!
  \****************************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);



function SukiControlResponsiveSwitcher(_ref) {
  var devices = _ref.devices;
  var controlDevices = ['desktop', 'tablet', 'mobile'].filter(function (device) {
    return -1 !== devices.indexOf(device);
  });
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, 1 < controlDevices.length && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ButtonGroup, {
    className: "suki-responsive-switcher"
  }, controlDevices.map(function (device) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
      key: device,
      isSmall: true,
      variant: "tertiary",
      icon: 'mobile' === device ? 'smartphone' : device,
      "data-device": device,
      label: SukiCustomizerData.l10n.device,
      showTooltip: true,
      className: "suki-responsive-switcher__button",
      onClick: function onClick(e) {
        wp.customize.previewedDevice.set(device);
      }
    });
  })));
}

/* harmony default export */ __webpack_exports__["default"] = (SukiControlResponsiveSwitcher);

/***/ }),

/***/ "./src/scripts/customizer/controls.js":
/*!********************************************!*\
  !*** ./src/scripts/customizer/controls.js ***!
  \********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _controls_SukiControl__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./controls/SukiControl */ "./src/scripts/customizer/controls/SukiControl.js");
/* harmony import */ var _controls_SukiControl__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_controls_SukiControl__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _controls_SukiReactControl__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./controls/SukiReactControl */ "./src/scripts/customizer/controls/SukiReactControl.js");
/* harmony import */ var _controls_SukiReactControl__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_controls_SukiReactControl__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _controls_SukiBackgroundControl__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./controls/SukiBackgroundControl */ "./src/scripts/customizer/controls/SukiBackgroundControl.js");
/* harmony import */ var _controls_SukiBuilderControl__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./controls/SukiBuilderControl */ "./src/scripts/customizer/controls/SukiBuilderControl.js");
/* harmony import */ var _controls_SukiColorControl__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./controls/SukiColorControl */ "./src/scripts/customizer/controls/SukiColorControl.js");
/* harmony import */ var _controls_SukiColorSelectControl__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./controls/SukiColorSelectControl */ "./src/scripts/customizer/controls/SukiColorSelectControl.js");
/* harmony import */ var _controls_SukiDimensionControl__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./controls/SukiDimensionControl */ "./src/scripts/customizer/controls/SukiDimensionControl.js");
/* harmony import */ var _controls_SukiDimensionsControl__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./controls/SukiDimensionsControl */ "./src/scripts/customizer/controls/SukiDimensionsControl.js");
/* harmony import */ var _controls_SukiMultiCheckControl__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./controls/SukiMultiCheckControl */ "./src/scripts/customizer/controls/SukiMultiCheckControl.js");
/* harmony import */ var _controls_SukiMultiSelectControl__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./controls/SukiMultiSelectControl */ "./src/scripts/customizer/controls/SukiMultiSelectControl.js");
/* harmony import */ var _controls_SukiRadioImageControl__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./controls/SukiRadioImageControl */ "./src/scripts/customizer/controls/SukiRadioImageControl.js");
/* harmony import */ var _controls_SukiShadowControl__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./controls/SukiShadowControl */ "./src/scripts/customizer/controls/SukiShadowControl.js");
/* harmony import */ var _controls_SukiSliderControl__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./controls/SukiSliderControl */ "./src/scripts/customizer/controls/SukiSliderControl.js");
/* harmony import */ var _controls_SukiToggleControl__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./controls/SukiToggleControl */ "./src/scripts/customizer/controls/SukiToggleControl.js");
/* harmony import */ var _controls_SukiTypographyControl__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./controls/SukiTypographyControl */ "./src/scripts/customizer/controls/SukiTypographyControl.js");
// Base controls

 // Custom controls














wp.customize.bind('ready', function () {
  /**
   * Color Palette controls
   */
  function setColorPaletteValue(i, color) {
    var styleId = "suki-color-palette-".concat(i, "-output-css");
    var styleTag = document.getElementById(styleId);

    if (!styleTag) {
      styleTag = document.createElement('style');
      styleTag.id = styleId;
      document.head.appendChild(styleTag);
    }

    styleTag.textContent = ".wp-customizer{--color-palette-".concat(i, ":").concat(color, "}");
  }

  var _loop = function _loop(i) {
    wp.customize("color_palette_".concat(i)).bind(function (color) {
      setColorPaletteValue(i, color);
    });
    setColorPaletteValue(i, wp.customize("color_palette_".concat(i)).get());
  };

  for (var i = 1; i <= 8; i++) {
    _loop(i);
  }
});

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiBackgroundControl.js":
/*!******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiBackgroundControl.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);


/**
 * Background control (React)
 */



wp.customize.SukiBackgroundControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var _control$params$image, _control$params$image2;

    var control = this;
    var attachmentOptions = [{
      value: 'scroll',
      label: SukiCustomizerData.l10n.scroll
    }, {
      value: 'italic',
      label: SukiCustomizerData.l10n.italic
    }];
    var repeatOptions = [{
      value: 'repeat',
      label: SukiCustomizerData.l10n.repeatBoth
    }, {
      value: 'repeat-x',
      label: SukiCustomizerData.l10n.repeatX
    }, {
      value: 'repeat-y',
      label: SukiCustomizerData.l10n.repeatY
    }, {
      value: 'no-repeat',
      label: SukiCustomizerData.l10n.noRepeat
    }];
    var sizeOptions = [{
      value: 'auto',
      label: SukiCustomizerData.l10n.auto
    }, {
      value: 'contain',
      label: SukiCustomizerData.l10n.contain
    }, {
      value: 'cover',
      label: SukiCustomizerData.l10n.cover
    }];
    var positionOptions = [{
      value: 'left top',
      label: SukiCustomizerData.l10n.leftTop
    }, {
      value: 'left center',
      label: SukiCustomizerData.l10n.leftCenter
    }, {
      value: 'left bottom',
      label: SukiCustomizerData.l10n.leftBottom
    }, {
      value: 'center top',
      label: SukiCustomizerData.l10n.centerTop
    }, {
      value: 'center center',
      label: SukiCustomizerData.l10n.centerCenter
    }, {
      value: 'center bottom',
      label: SukiCustomizerData.l10n.centerBottom
    }, {
      value: 'right top',
      label: SukiCustomizerData.l10n.rightTop
    }, {
      value: 'right right',
      label: SukiCustomizerData.l10n.rightCenter
    }, {
      value: 'right bottom',
      label: SukiCustomizerData.l10n.rightBottom
    }];
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, {
      spacing: "2",
      className: "suki-control-content-box"
    }, control.settings.image && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "suki-media-upload"
    }, control.params.imageAttachment ? (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, {
      spacing: "2"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
      className: "suki-media-upload__image"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
      src: (_control$params$image = control.params.imageAttachment.sizes) === null || _control$params$image === void 0 ? void 0 : (_control$params$image2 = _control$params$image.medium) === null || _control$params$image2 === void 0 ? void 0 : _control$params$image2.url
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalGrid, {
      columns: "2",
      gap: "2"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      icon: "upload",
      text: SukiCustomizerData.l10n.changeImage,
      variant: "secondary",
      className: "suki-media-upload__actions__open",
      onClick: function onClick(e) {
        e.preventDefault();
        control.openMediaLibrary();
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      icon: "no-alt",
      text: SukiCustomizerData.l10n.removeImage,
      variant: "secondary",
      className: "suki-media-upload__actions__remove",
      onClick: function onClick(e) {
        e.preventDefault();
        control.removeImage();
      }
    }))) : (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalGrid, {
      columns: "1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
      icon: "upload",
      text: SukiCustomizerData.l10n.selectImage,
      variant: "secondary",
      className: "suki-media-upload-actions__open",
      onClick: function onClick(e) {
        e.preventDefault();
        control.openMediaLibrary();
      }
    }))), (control.settings.attachment || control.settings.repeat || control.settings.size || control.settings.position) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, {
      spacing: "2"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalGrid, {
      columns: "2",
      gap: "2"
    }, control.settings.attachment && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
      label: SukiCustomizerData.l10n.attachment,
      value: control.settings.attachment.get(),
      options: attachmentOptions,
      onChange: function onChange(attachment) {
        control.settings.attachment.set(attachment);
      }
    }), control.settings.repeat && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
      label: SukiCustomizerData.l10n.repeat,
      value: control.settings.repeat.get(),
      options: repeatOptions,
      onChange: function onChange(repeat) {
        control.settings.repeat.set(repeat);
      }
    }), control.settings.size && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
      label: SukiCustomizerData.l10n.size,
      value: control.settings.size.get(),
      options: sizeOptions,
      onChange: function onChange(size) {
        control.settings.size.set(size);
      }
    }), control.settings.position && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SelectControl, {
      label: SukiCustomizerData.l10n.position,
      value: control.settings.position.get(),
      options: positionOptions,
      onChange: function onChange(position) {
        control.settings.position.set(position);
      }
    }))))), control.container[0]);
  },
  openMediaLibrary: function openMediaLibrary() {
    var control = this;

    if (!control.mediaLibrary) {
      control.initMediaLibrary();
    }

    control.mediaLibrary.open();
  },
  initMediaLibrary: function initMediaLibrary() {
    var control = this;
    control.mediaLibrary = wp.media({
      states: [new wp.media.controller.Library({
        library: wp.media.query({
          type: 'image'
        }),
        multiple: false,
        date: false
      })]
    }); // When a file is selected, run a callback.

    control.mediaLibrary.on('select', function () {
      control.onSelectMediaLibrary();
    });
    control.mediaLibrary.on('open', function () {
      control.onOpenMediaLibrary();
    });
  },
  onOpenMediaLibrary: function onOpenMediaLibrary() {
    var control = this;

    if (control.params.imageAttachment) {
      var attachment = wp.media.attachment(control.params.imageAttachment.id);
      attachment.fetch();
      control.mediaLibrary.state().get('selection').add([attachment]);
    }
  },
  onSelectMediaLibrary: function onSelectMediaLibrary() {
    var control = this;
    var attachment = control.mediaLibrary.state().get('selection').first().toJSON();
    control.params.imageAttachment = attachment; // Set the Customizer setting; the callback takes care of rendering.

    control.settings.image.set(attachment.url);
  },
  removeImage: function removeImage() {
    var control = this;
    control.params.imageAttachment = undefined;
    control.settings.image.set('');
  }
});
wp.customize.controlConstructor['suki-background'] = wp.customize.SukiBackgroundControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiBuilderControl.js":
/*!***************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiBuilderControl.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! react-sortablejs */ "./node_modules/react-sortablejs/dist/index.js");
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(react_sortablejs__WEBPACK_IMPORTED_MODULE_7__);





function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); enumerableOnly && (symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; })), keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = null != arguments[i] ? arguments[i] : {}; i % 2 ? ownKeys(Object(source), !0).forEach(function (key) { (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(target, key, source[key]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)) : ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } return target; }

/**
 * Builder control (React)
 */





function SukiBuilder(_ref) {
  var control = _ref.control;

  // State for all settings values and inactive elements.
  var _useState = (0,react__WEBPACK_IMPORTED_MODULE_6__.useState)(getValues()),
      _useState2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_2__["default"])(_useState, 2),
      values = _useState2[0],
      setValues = _useState2[1]; // Get all settings values, and also define inactive elements.


  function getValues() {
    var values = {};
    var activeItemIds = [];
    var inactiveItemIds = [];
    Object.keys(control.settings).forEach(function (settingId) {
      var value = control.settings[settingId].get();
      values[settingId] = value;
      activeItemIds = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(activeItemIds), (0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(value));
    });
    control.params.choices.forEach(function (choice) {
      if (-1 === activeItemIds.indexOf(choice.value)) {
        inactiveItemIds.push(choice.value);
      }
    });
    values._inactive = inactiveItemIds;
    return values;
  } // Sortable areas and their info.


  var areas = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_1__["default"])(control.params.areas), [{
    id: '_inactive',
    label: SukiCustomizerData.l10n.inactiveElements,
    sortableInstance: null
  }]);
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)("div", {
    className: "suki-builder"
  }, areas.map(function (area) {
    // Array of item objects of current sortable area.
    var areaItems = values[area.id].map(function (itemId) {
      return control.params.choices.find(function (choice) {
        return itemId === choice.value;
      });
    });
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)("div", {
      key: area.id,
      "data-area": area.id,
      className: "suki-builder__area",
      style: {
        '--area': area.id
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)("label", {
      className: "suki-builder__area__label"
    }, area.label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(react_sortablejs__WEBPACK_IMPORTED_MODULE_7__.ReactSortable // Store the sortable instance to `areas` variable.
    , {
      ref: function ref(node) {
        if (node) {
          area.sortableInstance = node.sortable;
        }
      } // Connect with other sortable areas.
      ,
      group: control.id // Sortable values.
      ,
      list: areaItems // Handler to update sortable values.
      ,
      setList: function setList(updatedAreaItems) {
        // Parse array of IDs from the updated sortable items.
        var updatedAreaItemsIds = updatedAreaItems.map(function (item) {
          return item.value;
        }); // Update values state.

        setValues(function (prevValues) {
          return _objectSpread(_objectSpread({}, prevValues), {}, (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])({}, area.id, updatedAreaItemsIds));
        }); // Update setting values for areas, except the `_inactive` area.

        if ('_inactive' !== area.id) {
          if (updatedAreaItemsIds !== control.settings[area.id].get()) {
            control.settings[area.id].set(updatedAreaItemsIds);
          }
        }
      } // When start dragging a sortable item, disable the unsupported areas.
      ,
      onStart: function onStart(e) {
        //
        var itemId = e.item.getAttribute('data-value');
        var itemObj = control.params.choices.find(function (choice) {
          return itemId === choice.value;
        });
        itemObj.unsupported_areas.forEach(function (areaId) {
          var area = areas.find(function (area) {
            return areaId === area.id;
          });
          area.sortableInstance.option('disabled', true);
          area.sortableInstance.el.parentElement.classList.add('disabled');
        });
      } // When dropping a sortable item, restore all areas.
      ,
      onEnd: function onEnd(e) {
        areas.forEach(function (area) {
          area.sortableInstance.option('disabled', false);
          area.sortableInstance.el.parentElement.classList.remove('disabled');
        });
      },
      className: "suki-builder__area__sortable"
    }, areaItems.map(function (item) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)("span", {
        key: item.value,
        "data-value": item.value,
        className: "suki-builder__item button"
      }, item.icon && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)("span", {
        className: 'dashicons dashicons-' + item.icon
      }), item.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)("span", null, item.label));
    })));
  }));
}

wp.customize.SukiBuilderControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_4__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_5__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_3__.createElement)(SukiBuilder, {
      control: control
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-builder'] = wp.customize.SukiBuilderControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiColorControl.js":
/*!*************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiColorControl.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);


/**
 * Color control (React)
 */



wp.customize.SukiColorControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var value = control.setting.get();
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.SlotFillProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Dropdown, {
      position: "bottom left",
      className: "suki-color-dropdown",
      renderToggle: function renderToggle(toggleParams) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Tooltip, {
          text: value,
          position: "top center"
        }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
          isSmall: true,
          variant: "tertiary",
          "aria-expanded": toggleParams.isOpen,
          id: '_customize-input' + control.id,
          className: "suki-color-dropdown__toggle",
          onClick: toggleParams.onToggle
        }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.ColorIndicator, {
          colorValue: value,
          className: "suki-color-indicator"
        })));
      },
      renderContent: function renderContent(contentParams) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.ColorPicker, {
          color: value,
          onChange: function onChange(color) {
            control.setting.set(color);
          },
          defaultValue: "#ff0",
          enableAlpha: true,
          className: "suki-color-dropdown__picker"
        }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalHStack, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
          isSmall: true,
          variant: "secondary",
          onClick: function onClick(e) {
            control.setting.set(control.params.defaultValue);
          }
        }, SukiCustomizerData.l10n.reset)));
      }
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Popover.Slot, null))), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-color'] = wp.customize.SukiColorControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiColorSelectControl.js":
/*!*******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiColorSelectControl.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _components_SukiColorSelectDropdown__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiColorSelectDropdown */ "./src/scripts/customizer/components/SukiColorSelectDropdown.js");


/**
 * Color control (React)
 */



wp.customize.SukiColorSelectControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var value = control.setting.get();
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiColorSelectDropdown__WEBPACK_IMPORTED_MODULE_3__["default"], {
      value: value,
      changeValue: function changeValue(newColorValue) {
        control.setting.set(newColorValue);
      },
      defaultValue: control.params.defaultValue || null,
      defaultPickerValue: "#ffffff",
      id: '_customize-input' + control.id
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-color-select'] = wp.customize.SukiColorSelectControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiControl.js":
/*!********************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiControl.js ***!
  \********************************************************/
/***/ (function() {

/**
 * Base dynamic control.
 *
 * @ref https://github.com/xwp/wp-customize-posts/blob/develop/js/customize-dynamic-control.js
 */
wp.customize.SukiControl = wp.customize.Control.extend({
  initialize: function initialize(id, options) {
    var control = this,
        args;
    args = options || {};
    args.params = args.params || {};

    if (!args.params.type) {
      args.params.type = 'dynamic';
    }

    if (!args.params.content) {
      args.params.content = $('<li></li>');
      args.params.content.attr('id', 'customize-control-' + id.replace(/]/g, '').replace(/\[/g, '-'));
      args.params.content.attr('class', 'suki-customize-control customize-control customize-control-' + args.params.type);
    }

    control.propertyElements = [];
    wp.customize.Control.prototype.initialize.call(control, id, args);
  },

  /**
   * Add bidirectional data binding links between inputs and the setting(s).
   *
   * This is copied from wp.customize.Control.prototype.initialize(). It
   * should be changed in Core to be applied once the control is embedded.
   *
   * @private
   * @returns {void}
   */
  _setUpSettingRootLinks: function _setUpSettingRootLinks() {
    var control, nodes, radios;
    control = this;
    nodes = control.container.find('[data-customize-setting-link]');
    radios = {};
    nodes.each(function () {
      var node = $(this),
          name;

      if (node.is(':radio')) {
        name = node.prop('name');

        if (radios[name]) {
          return;
        }

        radios[name] = true;
        node = nodes.filter('[name="' + name + '"]');
      }

      wp.customize(node.data('customizeSettingLink'), function (setting) {
        var element = new wp.customize.Element(node);
        control.elements.push(element);
        element.sync(setting);
        element.set(setting());
      });
    });
  },

  /**
   * Add bidirectional data binding links between inputs and the setting properties.
   *
   * @private
   * @returns {void}
   */
  _setUpSettingPropertyLinks: function _setUpSettingPropertyLinks() {
    var control = this,
        nodes,
        radios;

    if (!control.setting) {
      return;
    }

    nodes = control.container.find('[data-customize-setting-property-link]');
    radios = {};
    nodes.each(function () {
      var node = $(this),
          name,
          element,
          propertyName = node.data('customizeSettingPropertyLink');

      if (node.is(':radio')) {
        name = node.prop('name');

        if (radios[name]) {
          return;
        }

        radios[name] = true;
        node = nodes.filter('[name="' + name + '"]');
      }

      element = new wp.customize.Element(node);
      control.propertyElements.push(element);
      element.set(control.setting()[propertyName]);
      element.bind(function (newPropertyValue) {
        var newSetting = control.setting();

        if (newPropertyValue === newSetting[propertyName]) {
          return;
        }

        newSetting = _.clone(newSetting);
        newSetting[propertyName] = newPropertyValue;
        control.setting.set(newSetting);
      });
      control.setting.bind(function (newValue) {
        if (newValue[propertyName] !== element.get()) {
          element.set(newValue[propertyName]);
        }
      });
    });
  },

  /**
   * @inheritdoc
   */
  ready: function ready() {
    var control = this;

    control._setUpSettingRootLinks();

    control._setUpSettingPropertyLinks();

    wp.customize.Control.prototype.ready.call(control); // @todo build out the controls for the post when Control is expanded.
    // @todo Let the Control title include the post title.

    control.deferred.embedded.done(function () {});
  },

  /**
   * Embed the control in the document.
   *
   * Override the embed() method to do nothing,
   * so that the control isn't embedded on load,
   * unless the containing section is already expanded.
   *
   * @returns {void}
   */
  embed: function embed() {
    var control = this,
        sectionId = control.section();

    if (!sectionId) {
      return;
    }

    wp.customize.section(sectionId, function (section) {
      if (section.expanded() || wp.customize.settings.autofocus.control === control.id) {
        control.actuallyEmbed();
      } else {
        section.expanded.bind(function (expanded) {
          if (expanded) {
            control.actuallyEmbed();
          }
        });
      }
    });
  },

  /**
   * Deferred embedding of control when actually
   *
   * This function is called in Section.onChangeExpanded() so the control
   * will only get embedded when the Section is first expanded.
   *
   * @returns {void}
   */
  actuallyEmbed: function actuallyEmbed() {
    var control = this;

    if ('resolved' === control.deferred.embedded.state()) {
      return;
    }

    control.renderContent();
    control.deferred.embedded.resolve(); // This triggers control.ready().
  },

  /**
   * This is not working with autofocus.
   *
   * @param {object} [args] Args.
   * @returns {void}
   */
  focus: function focus(args) {
    var control = this;
    control.actuallyEmbed();
    wp.customize.Control.prototype.focus.call(control, args);
  }
});

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiDimensionControl.js":
/*!*****************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiDimensionControl.js ***!
  \*****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiControlResponsiveSwitcher */ "./src/scripts/customizer/components/SukiControlResponsiveSwitcher.js");
/* harmony import */ var _components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/SukiControlResponsiveContainer */ "./src/scripts/customizer/components/SukiControlResponsiveContainer.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../utils */ "./src/scripts/customizer/utils/index.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__);



/**
 * Dimension control (React)
 */






wp.customize.SukiDimensionControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_4__["default"], {
      devices: Object.keys(control.params.responsiveStructures)
    })), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), Object.keys(control.params.responsiveStructures).map(function (device) {
      var _valueUnitObj$min, _valueUnitObj$max, _valueUnitObj$step;

      var settingId = control.params.responsiveStructures[device];
      var value = control.settings[settingId].get();
      /**
       * @todo Wait for `parseQuantityAndUnitFromRawValue` to be available on UnitControl. For the time being, we are using our own function `convertDimensionValueIntoNumberAndUnit`.
       */

      var _convertDimensionValu = (0,_utils__WEBPACK_IMPORTED_MODULE_6__.convertDimensionValueIntoNumberAndUnit)(value, control.params.units),
          _convertDimensionValu2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__["default"])(_convertDimensionValu, 2),
          valueNumber = _convertDimensionValu2[0],
          valueUnit = _convertDimensionValu2[1];

      var valueUnitObj = control.params.units.find(function (item) {
        return valueUnit === item.value;
      });
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_5__["default"], {
        key: device,
        device: device
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.__experimentalGrid, {
        columns: "4",
        gap: "1"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.__experimentalUnitControl, {
        value: value,
        isResetValueOnUnitChange: true,
        units: control.params.units,
        min: (_valueUnitObj$min = valueUnitObj === null || valueUnitObj === void 0 ? void 0 : valueUnitObj.min) !== null && _valueUnitObj$min !== void 0 ? _valueUnitObj$min : -Infinity,
        max: (_valueUnitObj$max = valueUnitObj === null || valueUnitObj === void 0 ? void 0 : valueUnitObj.max) !== null && _valueUnitObj$max !== void 0 ? _valueUnitObj$max : Infinity,
        step: (_valueUnitObj$step = valueUnitObj === null || valueUnitObj === void 0 ? void 0 : valueUnitObj.step) !== null && _valueUnitObj$step !== void 0 ? _valueUnitObj$step : 1,
        id: '_customize-input-' + control.id,
        className: "suki-dimension",
        onChange: function onChange(value) {
          // If value only contains unit (e.g. 'px'), set the value to empty string ('').
          value = isFinite(parseFloat(value)) ? value : '';
          control.settings[settingId].set(value);
        }
      })));
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-dimension'] = wp.customize.SukiDimensionControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiDimensionsControl.js":
/*!******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiDimensionsControl.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiControlResponsiveSwitcher */ "./src/scripts/customizer/components/SukiControlResponsiveSwitcher.js");
/* harmony import */ var _components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../components/SukiControlResponsiveContainer */ "./src/scripts/customizer/components/SukiControlResponsiveContainer.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ../utils */ "./src/scripts/customizer/utils/index.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__);



/**
 * Dimensions control (React)
 */






wp.customize.SukiDimensionsControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var directions = [SukiCustomizerData.l10n.top, SukiCustomizerData.l10n.right, SukiCustomizerData.l10n.bottom, SukiCustomizerData.l10n.left];
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_4__["default"], {
      devices: Object.keys(control.params.responsiveStructures)
    })), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), Object.keys(control.params.responsiveStructures).map(function (device) {
      var settingId = control.params.responsiveStructures[device];
      var valueString = control.settings[settingId].get(); // Split value into array.

      var valueSplit = valueString.split(' ', 4); // Set default value array to 4 items and blank values.

      var valueArray = ['', '', '', '']; // Iterate through the splitted values and set the value array.

      valueArray.forEach(function (subValue, i) {
        var _valueSplit$i;

        valueArray[i] = (_valueSplit$i = valueSplit[i]) !== null && _valueSplit$i !== void 0 ? _valueSplit$i : '';
      });
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_5__["default"], {
        key: device,
        device: device
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.__experimentalGrid, {
        columns: "4",
        gap: "1"
      }, valueArray.map(function (subValue, i) {
        var _subValueUnitObj$min, _subValueUnitObj$max, _subValueUnitObj$step;

        /**
         * @todo Wait for `parseQuantityAndUnitFromRawValue` to be available on UnitControl, and then we can replace our manual (non-safe) parsing with it instead.
         */
        var _convertDimensionValu = (0,_utils__WEBPACK_IMPORTED_MODULE_6__.convertDimensionValueIntoNumberAndUnit)(subValue, control.params.units),
            _convertDimensionValu2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__["default"])(_convertDimensionValu, 2),
            subValueNumber = _convertDimensionValu2[0],
            subValueUnit = _convertDimensionValu2[1];

        var subValueUnitObj = control.params.units.find(function (item) {
          return subValueUnit === item.value;
        });
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_7__.__experimentalUnitControl, {
          key: device + '-' + i,
          label: directions[i],
          labelPosition: "bottom",
          value: subValue,
          isResetValueOnUnitChange: true,
          units: control.params.units,
          min: (_subValueUnitObj$min = subValueUnitObj === null || subValueUnitObj === void 0 ? void 0 : subValueUnitObj.min) !== null && _subValueUnitObj$min !== void 0 ? _subValueUnitObj$min : -Infinity,
          max: (_subValueUnitObj$max = subValueUnitObj === null || subValueUnitObj === void 0 ? void 0 : subValueUnitObj.max) !== null && _subValueUnitObj$max !== void 0 ? _subValueUnitObj$max : Infinity,
          step: (_subValueUnitObj$step = subValueUnitObj === null || subValueUnitObj === void 0 ? void 0 : subValueUnitObj.step) !== null && _subValueUnitObj$step !== void 0 ? _subValueUnitObj$step : 1,
          className: "suki-dimension",
          onChange: function onChange(newSubValue) {
            newSubValue = isNaN(parseFloat(newSubValue)) ? '' : newSubValue;
            valueArray[i] = newSubValue;
            /**
             * If all subvalues are '', value will be '',
             * If at least one of the subvalues is a dimension value, convert the other '' subvalues into '0'.
             */

            var newValue = valueArray.join(' ').trim();

            if ('' !== newValue.trim()) {
              valueArray = valueArray.map(function (valueArrayItem) {
                if ('' === valueArrayItem) {
                  return '0';
                } else {
                  return valueArrayItem;
                }
              });
              newValue = valueArray.join(' ').trim();
            }

            control.settings[settingId].set(newValue);
          }
        });
      })));
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-dimensions'] = wp.customize.SukiDimensionsControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiMultiCheckControl.js":
/*!******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiMultiCheckControl.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);



/**
 * Multi-check control (React)
 */



wp.customize.SukiMultiCheckControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var valueArray = control.setting.get();
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.__experimentalVStack, {
      spacing: "1.5"
    }, control.params.choices.map(function (choice, i) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.CheckboxControl, {
        key: choice.value,
        label: choice.label,
        checked: -1 !== valueArray.indexOf(choice.value),
        onChange: function onChange(newValue) {
          if (newValue) {
            control.addNewValueItem(choice.value);
          } else {
            control.removeValueItem(choice.value);
          }
        }
      });
    }))), control.container[0]);
  },
  addNewValueItem: function addNewValueItem(value) {
    var control = this;
    var valueArray = control.setting.get() || []; // Add the selected item into the value array.

    if (-1 === valueArray.indexOf(value)) {
      valueArray = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(valueArray), [value]);
    }

    var choicesValues = control.params.choices.map(function (item) {
      return item.value;
    }); // Sort the combinedValue according to the original options order.

    valueArray = choicesValues.filter(function (choice) {
      return -1 !== valueArray.indexOf(choice);
    });
    control.setting.set(valueArray);
  },
  removeValueItem: function removeValueItem(removedValue) {
    var control = this;
    var valueArray = control.setting.get() || []; // Remove the clicked item from the value array.

    valueArray = valueArray.filter(function (value) {
      return value !== removedValue;
    });
    control.setting.set(valueArray);
  }
});
wp.customize.controlConstructor['suki-multicheck'] = wp.customize.SukiMultiCheckControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiMultiSelectControl.js":
/*!*******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiMultiSelectControl.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/toConsumableArray */ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react-sortablejs */ "./node_modules/react-sortablejs/dist/index.js");
/* harmony import */ var react_sortablejs__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_sortablejs__WEBPACK_IMPORTED_MODULE_5__);



/**
 * Multi Select control (React)
 */





function SukiMultiSelect(_ref) {
  var control = _ref.control;
  var values = control.setting.get();
  var valuesObj = values.map(function (value) {
    return control.params.choices.find(function (choice) {
      return value === choice.value;
    });
  }); // If limit is set to `0`, it means limit is same as the number of options.

  var limit = control.params.itemsLimit || control.params.choices.length;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(react_sortablejs__WEBPACK_IMPORTED_MODULE_5__.ReactSortable, {
    draggable: ".suki-multiselect__list__item",
    handle: ".suki-multiselect__list__item__move",
    list: valuesObj,
    setList: function setList(updatedValuesObj) {
      var updatedValues = updatedValuesObj.map(function (valueObj) {
        return valueObj.value;
      });
      control.setting.set(updatedValues);
    },
    className: "suki-multiselect__list"
  }, valuesObj.map(function (valueObj) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", {
      key: valueObj.value,
      className: "suki-multiselect__list__item"
    }, control.params.isSortable && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Icon, {
      icon: "move",
      className: "suki-multiselect__list__item__move"
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", {
      className: "suki-multiselect__list__item__label"
    }, valueObj.label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
      isSmall: true,
      icon: "no-alt",
      label: SukiCustomizerData.l10n.remove,
      showTooltip: true,
      className: "suki-multiselect__list__item__remove",
      onClick: function onClick() {
        var newValues = values || []; // Remove the clicked item from the value array.

        newValues = newValues.filter(function (value) {
          return value !== valueObj.value;
        });
        control.setting.set(newValues);
      }
    }));
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("select", {
    value: "",
    id: '_customize-input-' + control.id,
    hidden: limit <= values.length,
    onChange: function onChange(e) {
      if (limit <= values.length) {
        return;
      }

      var addedValue = e.target.value;
      var newValues = values || []; // Add the selected item into the value array.

      if (-1 === newValues.indexOf(addedValue)) {
        newValues = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(newValues), [addedValue]);
      } // If sortable mode is deisabled, sort the array according to the original options order.


      if (!control.params.isSortable) {
        var choicesValues = control.params.choices.map(function (item) {
          return item.value;
        });
        newValues = choicesValues.filter(function (choice) {
          return -1 !== newValues.indexOf(choice);
        });
      }

      control.setting.set(newValues);
    }
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
    value: "",
    disabled: true
  }, SukiCustomizerData.l10n.addNew), control.params.choices.map(function (choice, i) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
      key: choice.value,
      value: choice.value,
      disabled: -1 === values.indexOf(choice.value) ? false : true
    }, choice.label);
  })));
}

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(SukiMultiSelect, {
      control: control
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-multiselect'] = wp.customize.SukiMultiSelectControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiRadioImageControl.js":
/*!******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiRadioImageControl.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);


/**
 * Dimensions control (React)
 */



wp.customize.SukiDimensionsControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalGrid, {
      columns: control.params.columns || 3,
      gap: "1",
      className: "suki-radioimage"
    }, control.params.choices.map(function (choice) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Button, {
        key: choice.value,
        isPressed: choice.value === control.setting.get(),
        className: "suki-radioimage__option",
        onClick: function onClick() {
          control.setting.set(choice.value);
        }
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, {
        expanded: true,
        spacing: "0.5",
        justify: "center"
      }, choice.image && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("img", {
        src: choice.image,
        role: "img",
        "aria-hidden": "true"
      }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", null, choice.label)));
    }))), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-radioimage'] = wp.customize.SukiDimensionsControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiReactControl.js":
/*!*************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiReactControl.js ***!
  \*************************************************************/
/***/ (function() {

/**
 * Base react control.
 */
wp.customize.SukiReactControl = wp.customize.SukiControl.extend({
  /**
   * Initialize.
   *
   * @param {string} id - Control ID.
   * @param {Object} params - Control params.
   */
  initialize: function initialize(id, params) {
    var control = this; // Bind functions to this control context for passing as React props.

    control.setNotificationContainer = control.setNotificationContainer.bind(control);
    wp.customize.Control.prototype.initialize.call(control, id, params); // The following should be eliminated with <https://core.trac.wordpress.org/ticket/31334>.

    var onRemoved = function onRemoved(removedControl) {
      if (control === removedControl) {
        control.destroy();
        control.container.remove();
        wp.customize.control.unbind('removed', onRemoved);
      }
    };

    wp.customize.control.bind('removed', onRemoved);
  },

  /**
   * Set notification container and render.
   *
   * This is called when the React component is mounted.
   *
   * @param {Element} element - Notification container.
   * @return {void}
   */
  setNotificationContainer: function setNotificationContainer(element) {
    var control = this;
    control.notifications.container = jQuery(element);
    control.notifications.render();
  },

  /**
   * After control has been first rendered, start re-rendering when setting changes.
   *
   * React is able to be used here instead of the wp.customize.Element abstraction.
   *
   * @returns {void}
   */
  ready: function ready() {
    var control = this;
    /**
     * Update component value's state when customizer setting's value is changed.
     */

    Object.keys(control.settings).forEach(function (settingKey) {
      control.settings[settingKey].bind(function (val) {
        control.renderContent();
      });
    });
  },

  /**
   * Handle removal/de-registration of the control.
   *
   * This is essentially the inverse of the Control#embed() method.
   *
   * @link https://core.trac.wordpress.org/ticket/31334
   * @returns {void}
   */
  destroy: function destroy() {
    var control = this; // Garbage collection: undo mounting that was done in the embed/renderContent method.

    ReactDOM.unmountComponentAtNode(control.container[0]); // Call destroy method in parent if it exists (as of #31334).

    if (wp.customize.Control.prototype.destroy) {
      wp.customize.Control.prototype.destroy.call(control);
    }
  }
});

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiShadowControl.js":
/*!**************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiShadowControl.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/slicedToArray */ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _components_SukiColorSelectDropdown__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiColorSelectDropdown */ "./src/scripts/customizer/components/SukiColorSelectDropdown.js");
/* harmony import */ var _utils__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../utils */ "./src/scripts/customizer/utils/index.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__);



/**
 * Shadow control (React)
 */





wp.customize.SukiShadowControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var _valueSplit$, _valueSplit$2, _valueSplit$3, _valueSplit$4, _valueSplit$5, _valueSplit$6;

    var control = this;
    var units = [{
      value: 'px',
      label: 'px'
    }, {
      value: 'em',
      label: 'em'
    }, {
      value: 'rem',
      label: 'rem'
    }]; // Split value into array.

    var valueSplit = control.setting.get().split(' ', 6); // Define value array and the fallback value.

    var valueObj = {
      x: (_valueSplit$ = valueSplit[0]) !== null && _valueSplit$ !== void 0 ? _valueSplit$ : '',
      y: (_valueSplit$2 = valueSplit[1]) !== null && _valueSplit$2 !== void 0 ? _valueSplit$2 : '',
      blur: (_valueSplit$3 = valueSplit[2]) !== null && _valueSplit$3 !== void 0 ? _valueSplit$3 : '',
      spread: (_valueSplit$4 = valueSplit[3]) !== null && _valueSplit$4 !== void 0 ? _valueSplit$4 : '',
      color: (_valueSplit$5 = valueSplit[4]) !== null && _valueSplit$5 !== void 0 ? _valueSplit$5 : '',
      position: (_valueSplit$6 = valueSplit[5]) !== null && _valueSplit$6 !== void 0 ? _valueSplit$6 : ''
    };
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__.__experimentalHStack, {
      expanded: true,
      align: "top",
      spacing: "1",
      className: "suki-shadow"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__.Button, {
      icon: 'inset' === valueObj.position ? 'editor-contract' : 'editor-expand',
      label: 'inset' === valueObj.position ? SukiCustomizerData.l10n.innerShadow : SukiCustomizerData.l10n.outerShadow,
      showTooltip: true,
      className: "suki-shadow__position-toggle",
      onClick: function onClick(e) {
        valueObj.position = 'inset' === valueObj.position ? '' : 'inset';
        var newValue = Object.values(valueObj).join(' ').trim();
        control.setting.set(newValue);
      }
    }), ['x', 'y', 'blur', 'spread'].map(function (prop, i) {
      var _propValueUnitObj$min, _propValueUnitObj$max, _propValueUnitObj$ste;

      var _convertDimensionValu = (0,_utils__WEBPACK_IMPORTED_MODULE_5__.convertDimensionValueIntoNumberAndUnit)(valueObj[prop], units),
          _convertDimensionValu2 = (0,_babel_runtime_helpers_slicedToArray__WEBPACK_IMPORTED_MODULE_0__["default"])(_convertDimensionValu, 2),
          propValueNumber = _convertDimensionValu2[0],
          propValueUnit = _convertDimensionValu2[1];

      var propValueUnitObj = units.find(function (item) {
        return propValueUnit === item.value;
      });
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_6__.__experimentalUnitControl, {
        key: prop,
        label: SukiCustomizerData.l10n[prop],
        labelPosition: "bottom",
        value: valueObj[prop],
        isResetValueOnUnitChange: true,
        units: units,
        min: (_propValueUnitObj$min = propValueUnitObj === null || propValueUnitObj === void 0 ? void 0 : propValueUnitObj.min) !== null && _propValueUnitObj$min !== void 0 ? _propValueUnitObj$min : -Infinity,
        max: (_propValueUnitObj$max = propValueUnitObj === null || propValueUnitObj === void 0 ? void 0 : propValueUnitObj.max) !== null && _propValueUnitObj$max !== void 0 ? _propValueUnitObj$max : Infinity,
        step: (_propValueUnitObj$ste = propValueUnitObj === null || propValueUnitObj === void 0 ? void 0 : propValueUnitObj.step) !== null && _propValueUnitObj$ste !== void 0 ? _propValueUnitObj$ste : 1,
        className: "suki-dimension",
        onChange: function onChange(newPropValue) {
          newPropValue = isNaN(parseFloat(newPropValue)) ? '0' : newPropValue;
          valueObj[prop] = newPropValue;
          var newValue = Object.values(valueObj).join(' ').trim();
          control.setting.set(newValue);
        }
      });
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiColorSelectDropdown__WEBPACK_IMPORTED_MODULE_4__["default"], {
      value: valueObj.color,
      changeValue: function changeValue(newColorValue) {
        valueObj.color = newColorValue;
        var newValue = Object.values(valueObj).join(' ').trim();
        control.setting.set(newValue);
      },
      defaultValue: "#00000000",
      defaultPickerValue: "#000000"
    }))), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-shadow'] = wp.customize.SukiShadowControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiSliderControl.js":
/*!**************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiSliderControl.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlResponsiveSwitcher */ "./src/scripts/customizer/components/SukiControlResponsiveSwitcher.js");
/* harmony import */ var _components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiControlResponsiveContainer */ "./src/scripts/customizer/components/SukiControlResponsiveContainer.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);


/**
 * Slider control (React)
 */





wp.customize.SukiSliderControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var min = parseFloat(control.params.min) || 0;
    var max = parseFloat(control.params.max) || 100;
    var step = parseFloat(control.params.step) || 1;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_3__["default"], {
      devices: Object.keys(control.params.responsiveStructures)
    })), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), Object.keys(control.params.responsiveStructures).map(function (device) {
      var settingId = control.params.responsiveStructures[device];
      var value = control.settings[settingId].get();
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_4__["default"], {
        key: device,
        device: device
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.RangeControl, {
        value: value,
        min: min,
        max: max,
        step: step,
        id: '_customize-input-' + control.id,
        className: "suki-slider",
        onChange: function onChange(value) {
          value = value || control.params.min;
          control.settings[settingId].set(value);
        }
      }));
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-slider'] = wp.customize.SukiSliderControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiToggleControl.js":
/*!**************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiToggleControl.js ***!
  \**************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);


/**
 * Toggle control (React)
 */



wp.customize.SukiToggleControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.FormToggle, {
      checked: control.setting.get() ? true : false,
      id: '_customize-input-' + control.id,
      className: "suki-toggle",
      onChange: function onChange(e) {
        control.setting.set(e.target.checked);
      }
    })), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-toggle'] = wp.customize.SukiToggleControl;

/***/ }),

/***/ "./src/scripts/customizer/controls/SukiTypographyControl.js":
/*!******************************************************************!*\
  !*** ./src/scripts/customizer/controls/SukiTypographyControl.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlResponsiveSwitcher */ "./src/scripts/customizer/components/SukiControlResponsiveSwitcher.js");
/* harmony import */ var _components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiControlResponsiveContainer */ "./src/scripts/customizer/components/SukiControlResponsiveContainer.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);


/**
 * Typography control (React)
 */





wp.customize.SukiTypographyControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var fontWeightOptions = [{
      value: '',
      label: ''
    }, {
      value: 100,
      label: SukiCustomizerData.l10n.weight100
    }, {
      value: 200,
      label: SukiCustomizerData.l10n.weight200
    }, {
      value: 300,
      label: SukiCustomizerData.l10n.weight300
    }, {
      value: 400,
      label: SukiCustomizerData.l10n.weight400
    }, {
      value: 500,
      label: SukiCustomizerData.l10n.weight500
    }, {
      value: 600,
      label: SukiCustomizerData.l10n.weight600
    }, {
      value: 700,
      label: SukiCustomizerData.l10n.weight700
    }, {
      value: 800,
      label: SukiCustomizerData.l10n.weight800
    }, {
      value: 900,
      label: SukiCustomizerData.l10n.weight900
    }];
    var fontStyleOptions = [{
      value: '',
      label: ''
    }, {
      value: 'normal',
      label: SukiCustomizerData.l10n.normal
    }, {
      value: 'italic',
      label: SukiCustomizerData.l10n.italic
    }];
    var textTransformOptions = [{
      value: '',
      label: ''
    }, {
      value: 'none',
      label: SukiCustomizerData.l10n.none
    }, {
      value: 'uppercase',
      label: SukiCustomizerData.l10n.uppercase
    }, {
      value: 'lowercase',
      label: SukiCustomizerData.l10n.lowercase
    }, {
      value: 'capitalize',
      label: SukiCustomizerData.l10n.capitalize
    }];
    var fontSizeUnits = [{
      value: 'px',
      label: 'px'
    }, {
      value: 'em',
      label: 'em'
    }, {
      value: 'rem',
      label: 'rem'
    }, {
      value: '%',
      label: '%'
    }];
    var lineHeightUnits = [{
      value: 'px',
      label: 'px'
    }, {
      value: '',
      label: 'em'
    }, {
      value: 'rem',
      label: 'rem'
    }, {
      value: '%',
      label: '%'
    }];
    var letterSpacingUnits = [{
      value: 'px',
      label: 'px'
    }, {
      value: 'em',
      label: 'em'
    }, {
      value: 'rem',
      label: 'rem'
    }];
    var responsiveStructures = control.params.responsiveStructures;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_1__["default"], {
      target: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalVStack, {
      spacing: "2",
      className: "suki-control-content-box"
    }, control.settings.font_family && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: SukiCustomizerData.l10n.fontFamily,
      value: control.settings.font_family.get(),
      onChange: function onChange(fontFamily) {
        control.settings.font_family.set(fontFamily);
      }
    }, Object.keys(SukiCustomizerData.fonts).map(function (groupLabel) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("optgroup", {
        key: groupLabel,
        label: groupLabel
      }, Object.keys(SukiCustomizerData.fonts[groupLabel]).map(function (familyName) {
        return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("option", {
          key: familyName,
          value: familyName
        }, familyName);
      }));
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalGrid, {
      columns: "3",
      gap: "2"
    }, control.settings.font_weight && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: SukiCustomizerData.l10n.fontWeight,
      value: control.settings.font_weight.get(),
      options: fontWeightOptions,
      onChange: function onChange(fontWeight) {
        control.settings.font_weight.set(fontWeight);
      }
    }), control.settings.font_style && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: SukiCustomizerData.l10n.fontStyle,
      value: control.settings.font_style.get(),
      options: fontStyleOptions,
      onChange: function onChange(fontStyle) {
        control.settings.font_style.set(fontStyle);
      }
    }), control.settings.text_transform && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.SelectControl, {
      label: SukiCustomizerData.l10n.textTransform,
      value: control.settings.text_transform.get(),
      options: textTransformOptions,
      onChange: function onChange(textTransform) {
        control.settings.text_transform.set(textTransform);
      }
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlResponsiveSwitcher__WEBPACK_IMPORTED_MODULE_3__["default"], {
      devices: Object.keys(responsiveStructures)
    }), Object.keys(responsiveStructures).map(function (device) {
      if ('global' === device) {
        return;
      }

      var fontSizeSettingId = 'font_size' + ('desktop' !== device ? '__' + device : '');
      var lineHeightSettingId = 'line_height' + ('desktop' !== device ? '__' + device : '');
      var letterSpacingSettingId = 'letter_spacing' + ('desktop' !== device ? '__' + device : '');
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlResponsiveContainer__WEBPACK_IMPORTED_MODULE_4__["default"], {
        key: device,
        device: device
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalGrid, {
        columns: "3",
        gap: "2"
      }, control.settings[fontSizeSettingId] && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalUnitControl, {
        label: SukiCustomizerData.l10n.fontSize,
        value: control.settings[fontSizeSettingId].get(),
        isResetValueOnUnitChange: true,
        units: fontSizeUnits,
        min: "0",
        className: "suki-dimension",
        onChange: function onChange(fontSize) {
          fontSize = isNaN(parseFloat(fontSize)) ? '' : fontSize;
          control.settings[fontSizeSettingId].set(fontSize);
        }
      }), control.settings[lineHeightSettingId] && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalUnitControl, {
        label: SukiCustomizerData.l10n.lineHeight,
        value: control.settings[lineHeightSettingId].get(),
        isResetValueOnUnitChange: true,
        units: lineHeightUnits,
        min: "0",
        className: "suki-dimension",
        onChange: function onChange(lineHeight) {
          lineHeight = isNaN(parseFloat(lineHeight)) ? '' : lineHeight;
          control.settings[lineHeightSettingId].set(lineHeight);
        }
      }), control.settings[letterSpacingSettingId] && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalUnitControl, {
        label: SukiCustomizerData.l10n.letterSpacing,
        value: control.settings[letterSpacingSettingId].get(),
        isResetValueOnUnitChange: true,
        units: letterSpacingUnits,
        className: "suki-dimension",
        onChange: function onChange(letterSpacing) {
          letterSpacing = isNaN(parseFloat(letterSpacing)) ? '' : letterSpacing;
          control.settings[letterSpacingSettingId].set(letterSpacing);
        }
      })));
    }))), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-typography'] = wp.customize.SukiTypographyControl;

/***/ }),

/***/ "./src/scripts/customizer/interactions.js":
/*!************************************************!*\
  !*** ./src/scripts/customizer/interactions.js ***!
  \************************************************/
/***/ (function() {

wp.customize.bind('ready', function () {
  /**
   * Control dependencies
   */
  Object.keys(SukiCustomizerData.contexts).forEach(function (elementId) {
    var elementType = 0 === elementId.indexOf('suki_section') ? 'section' : 'control';
    wp.customize[elementType](elementId, function (elementObj) {
      SukiCustomizerData.contexts[elementId].forEach(function (rule, i) {
        var settingObj = '__device' === rule.setting ? wp.customize.previewedDevice : wp.customize(rule.setting);

        var setVisibility = function setVisibility(checkedValue) {
          var displayed = false;

          if (undefined == rule.operator || '=' == rule.operator) {
            rule.operator = '==';
          }

          switch (rule.operator) {
            case '>':
              displayed = checkedValue > rule.value;
              break;

            case '<':
              displayed = checkedValue < rule.value;
              break;

            case '>=':
              displayed = checkedValue >= rule.value;
              break;

            case '<=':
              displayed = checkedValue <= rule.value;
              break;

            case 'in':
              displayed = 0 <= rule.value.indexOf(checkedValue);
              break;

            case 'not_in':
              displayed = 0 > rule.value.indexOf(checkedValue);
              break;

            case 'contain':
              displayed = 0 <= checkedValue.indexOf(rule.value);
              break;

            case 'not_contain':
              displayed = 0 > checkedValue.indexOf(rule.value);
              break;

            case '!=':
              displayed = checkedValue != rule.value;
              break;

            case 'empty':
              displayed = 0 == checkedValue.length;
              break;

            case '!empty':
              displayed = 0 < checkedValue.length;
              break;

            default:
              displayed = checkedValue == rule.value;
              break;
          }

          var container = elementObj.container;

          if ('section' === elementType) {
            container = elementObj.headContainer;
          }

          if (displayed) {
            container.show();
            container.removeClass('suki-context-hidden');
          } else {
            container.hide();
            container.addClass('suki-context-hidden');

            if ('section' === elementType && elementObj.expanded()) {
              elementObj.collapse();
            }
          }
        };

        if (undefined !== settingObj) {
          if ('__device' !== rule.setting) {
            setVisibility(settingObj.get());
          } // Bind the setting for future use.


          settingObj.bind(setVisibility);
        }
      });
    });
  });
  /**
   * "Go to control / section" link
   */

  document.getElementById('customize-controls').addEventListener('click', function (e) {
    if (!e.target.matches('.suki-customize-autofocus-link')) {
      return;
    }

    e.preventDefault();
    var url = new URL(e.target);

    if (targetControl = url.searchParams.get('autofocus[control]')) {
      wp.customize.control(targetControl).focus();
    } else if (targetSection = url.searchParams.get('autofocus[section]')) {
      wp.customize.section(targetSection).focus();
    } else if (targetPanel = url.searchParams.get('autofocus[panel]')) {
      wp.customize.panel(targetPanel).focus();
    }
  });
});

/***/ }),

/***/ "./src/scripts/customizer/sections.js":
/*!********************************************!*\
  !*** ./src/scripts/customizer/sections.js ***!
  \********************************************/
/***/ (function() {

/**
 * Static sections
 */
wp.customize.sectionConstructor['suki-pro-link'] = wp.customize.sectionConstructor['suki-pro-teaser'] = wp.customize.sectionConstructor['suki-spacer'] = wp.customize.Section.extend({
  // No events for this type of section.
  attachEvents: function attachEvents() {},
  // Always make the section active.
  isContextuallyActive: function isContextuallyActive() {
    return true;
  }
});
/**
 * Builder section
 */

wp.customize.sectionConstructor['suki-builder'] = wp.customize.Section.extend({
  initAllControls: function initAllControls() {
    var section = this;
    section.controls().forEach(function (control) {
      if ('resolved' !== control.deferred.embedded.state()) {
        control.embed();

        if (control.actuallyEmbed) {
          control.actuallyEmbed();
        }
      }
    });
    section.initialized = true;
  },
  resizePreview: function resizePreview() {
    var section = this;

    if (!section.initialized) {
      return;
    }

    if (1324 <= window.innerWidth && section.contentContainer[0].classList.contains('active') && !section.contentContainer[0].classList.contains('hidden')) {
      switch (wp.customize.previewedDevice.get()) {
        case 'tablet':
          originalHeight = '1024px';
          break;

        case 'mobile':
          originalHeight = '812px';
          break;

        default:
          originalHeight = '100%';
          break;
      }

      wp.customize.previewer.container[0].style.height = 'min( calc(100% - ' + (section.contentContainer[0].getBoundingClientRect().height + 'px') + '), ' + originalHeight + ' )';
    } else {
      wp.customize.previewer.container[0].style.height = null;
    }
  },
  ready: function ready() {
    var section = this;
    section.initialized = false; // Bind this.

    this.resizePreview = this.resizePreview.bind(this);
    var panelId = section.panel.get(); // If section is inside a panel, bind panel expanded.

    if ('' !== panelId) {
      wp.customize.panel(panelId, function (panel) {
        panel.expanded.bind(function (isExpanded) {
          if (isExpanded) {
            section.initAllControls();
            section.contentContainer[0].classList.add('active');
            window.addEventListener('resize', section.resizePreview);
            section.resizePreview();
          } else {
            section.contentContainer[0].classList.remove('active');
            window.removeEventListener('resize', section.resizePreview);
            section.resizePreview();
          }
        });
      });
    } // Init section right away.
    else {
      section.initAllControls();
      section.contentContainer[0].classList.add('active');
      window.addEventListener('resize', section.resizePreview);
      section.resizePreview();
    } // Handler for hide builder button.


    section.contentContainer[0].querySelector('.suki-builder-section__toggle__hide').addEventListener('click', function (e) {
      e.preventDefault();
      section.contentContainer[0].classList.add('hidden');
      document.activeElement.blur();
      section.resizePreview();
    }); // Handler for show builder button.

    section.contentContainer[0].querySelector('.suki-builder-section__toggle__show').addEventListener('click', function (e) {
      e.preventDefault();
      section.contentContainer[0].classList.remove('hidden');
      document.activeElement.blur();
      section.resizePreview();
    });
    wp.customize.bind('ready', function () {
      wp.customize.previewedDevice.bind(function (device) {
        section.resizePreview();
      });
    });
  }
});

/***/ }),

/***/ "./src/scripts/customizer/utils/index.js":
/*!***********************************************!*\
  !*** ./src/scripts/customizer/utils/index.js ***!
  \***********************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "convertDimensionValueIntoNumberAndUnit": function() { return /* binding */ convertDimensionValueIntoNumberAndUnit; }
/* harmony export */ });
/**
 * Convert dimension value (e.g. 100px) into number (e.g. 100) and unit (e.g. px) values.
 * When allowed units array were specified, the value unit will be validated.
 *
 * @param {string} rawValue     The raw value as a string (may or may not contain the unit)
 * @param {array}  allowedUnits Array of allowed units
 * @returns {array} Array of 2 items, number and unit derived from the raw value.
 */
function convertDimensionValueIntoNumberAndUnit(rawValue) {
  var allowedUnits = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : [];
  var value = String(rawValue); // Fetch number from the rawValue.

  var number = parseFloat(value); // Check if number is valid (finite number).

  number = isFinite(number) ? number : undefined; // Fetch unit from the value.

  var unit = value.replace(number, ''); // Check if unit is valid (one of the allowedUnits).

  if (Array.isArray(allowedUnits) && 0 < allowedUnits.length) {
    var unitObj = allowedUnits.find(function (item) {
      return unit === item.value;
    }); // Use the matched unit. If not, use the first item of allowedUnits.

    unit = (unitObj === null || unitObj === void 0 ? void 0 : unitObj.value) || allowedUnits[0].value;
  }

  return [number, unit];
}

/***/ }),

/***/ "./node_modules/classnames/index.js":
/*!******************************************!*\
  !*** ./node_modules/classnames/index.js ***!
  \******************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2018 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames() {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg)) {
				if (arg.length) {
					var inner = classNames.apply(null, arg);
					if (inner) {
						classes.push(inner);
					}
				}
			} else if (argType === 'object') {
				if (arg.toString === Object.prototype.toString) {
					for (var key in arg) {
						if (hasOwn.call(arg, key) && arg[key]) {
							classes.push(key);
						}
					}
				} else {
					classes.push(arg.toString());
				}
			}
		}

		return classes.join(' ');
	}

	if ( true && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}());


/***/ }),

/***/ "./node_modules/react-sortablejs/dist/index.js":
/*!*****************************************************!*\
  !*** ./node_modules/react-sortablejs/dist/index.js ***!
  \*****************************************************/
/***/ (function(module, __unused_webpack_exports, __webpack_require__) {

var $8zHUo$sortablejs = __webpack_require__(/*! sortablejs */ "./node_modules/sortablejs/modular/sortable.esm.js");
var $8zHUo$classnames = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
var $8zHUo$react = __webpack_require__(/*! react */ "react");
var $8zHUo$tinyinvariant = __webpack_require__(/*! tiny-invariant */ "./node_modules/tiny-invariant/dist/tiny-invariant.esm.js");

function $parcel$interopDefault(a) {
  return a && a.__esModule ? a.default : a;
}
function $parcel$export(e, n, v, s) {
  Object.defineProperty(e, n, {get: v, set: s, enumerable: true, configurable: true});
}
function $parcel$exportWildcard(dest, source) {
  Object.keys(source).forEach(function(key) {
    if (key === 'default' || key === '__esModule' || dest.hasOwnProperty(key)) {
      return;
    }

    Object.defineProperty(dest, key, {
      enumerable: true,
      get: function get() {
        return source[key];
      }
    });
  });

  return dest;
}

$parcel$export(module.exports, "Sortable", () => $882b6d93070905b3$re_export$Sortable);
$parcel$export(module.exports, "Direction", () => $882b6d93070905b3$re_export$Direction);
$parcel$export(module.exports, "DOMRect", () => $882b6d93070905b3$re_export$DOMRect);
$parcel$export(module.exports, "GroupOptions", () => $882b6d93070905b3$re_export$GroupOptions);
$parcel$export(module.exports, "MoveEvent", () => $882b6d93070905b3$re_export$MoveEvent);
$parcel$export(module.exports, "Options", () => $882b6d93070905b3$re_export$Options);
$parcel$export(module.exports, "PullResult", () => $882b6d93070905b3$re_export$PullResult);
$parcel$export(module.exports, "PutResult", () => $882b6d93070905b3$re_export$PutResult);
$parcel$export(module.exports, "SortableEvent", () => $882b6d93070905b3$re_export$SortableEvent);
$parcel$export(module.exports, "SortableOptions", () => $882b6d93070905b3$re_export$SortableOptions);
$parcel$export(module.exports, "Utils", () => $882b6d93070905b3$re_export$Utils);
$parcel$export(module.exports, "ReactSortable", () => $7fe8e3ea572bda7a$export$11bbed9ee0012c13);





function $eb03e74f8f7db1f3$export$1d0aa160432dfea5(node) {
    if (node.parentElement !== null) node.parentElement.removeChild(node);
}
function $eb03e74f8f7db1f3$export$6d240faa51aa562f(parent, newChild, index) {
    const refChild = parent.children[index] || null;
    parent.insertBefore(newChild, refChild);
}
function $eb03e74f8f7db1f3$export$d7d742816c28cf91(customs) {
    $eb03e74f8f7db1f3$export$77f49a256021c8de(customs);
    $eb03e74f8f7db1f3$export$a6177d5829f70ebc(customs);
}
function $eb03e74f8f7db1f3$export$77f49a256021c8de(customs) {
    customs.forEach((curr)=>$eb03e74f8f7db1f3$export$1d0aa160432dfea5(curr.element)
    );
}
function $eb03e74f8f7db1f3$export$a6177d5829f70ebc(customs) {
    customs.forEach((curr)=>{
        $eb03e74f8f7db1f3$export$6d240faa51aa562f(curr.parentElement, curr.element, curr.oldIndex);
    });
}
function $eb03e74f8f7db1f3$export$4655efe700f887a(evt, list) {
    const mode = $eb03e74f8f7db1f3$export$1fc0f6205829e19c(evt);
    const parentElement = {
        parentElement: evt.from
    };
    let custom = [];
    switch(mode){
        case "normal":
            /* eslint-disable */ const item = {
                element: evt.item,
                newIndex: evt.newIndex,
                oldIndex: evt.oldIndex,
                parentElement: evt.from
            };
            custom = [
                item
            ];
            break;
        case "swap":
            const drag = {
                element: evt.item,
                oldIndex: evt.oldIndex,
                newIndex: evt.newIndex,
                ...parentElement
            };
            const swap = {
                element: evt.swapItem,
                oldIndex: evt.newIndex,
                newIndex: evt.oldIndex,
                ...parentElement
            };
            custom = [
                drag,
                swap
            ];
            break;
        case "multidrag":
            custom = evt.oldIndicies.map((curr, index)=>({
                    element: curr.multiDragElement,
                    oldIndex: curr.index,
                    newIndex: evt.newIndicies[index].index,
                    ...parentElement
                })
            );
            break;
    }
    /* eslint-enable */ const customs = $eb03e74f8f7db1f3$export$bc06a3af7dc65f53(custom, list);
    return customs;
}
function $eb03e74f8f7db1f3$export$c25cf8080bd305ec(normalized, list) {
    const a = $eb03e74f8f7db1f3$export$be2da95e6167b0bd(normalized, list);
    const b = $eb03e74f8f7db1f3$export$eca851ee65ae17e4(normalized, a);
    return b;
}
function $eb03e74f8f7db1f3$export$be2da95e6167b0bd(normalized, list) {
    const newList = [
        ...list
    ];
    normalized.concat().reverse().forEach((curr)=>newList.splice(curr.oldIndex, 1)
    );
    return newList;
}
function $eb03e74f8f7db1f3$export$eca851ee65ae17e4(normalized, list, evt, clone) {
    const newList = [
        ...list
    ];
    normalized.forEach((curr)=>{
        const newItem = clone && evt && clone(curr.item, evt);
        newList.splice(curr.newIndex, 0, newItem || curr.item);
    });
    return newList;
}
function $eb03e74f8f7db1f3$export$1fc0f6205829e19c(evt) {
    if (evt.oldIndicies && evt.oldIndicies.length > 0) return "multidrag";
    if (evt.swapItem) return "swap";
    return "normal";
}
function $eb03e74f8f7db1f3$export$bc06a3af7dc65f53(inputs, list) {
    const normalized = inputs.map((curr)=>({
            ...curr,
            item: list[curr.oldIndex]
        })
    ).sort((a, b)=>a.oldIndex - b.oldIndex
    );
    return normalized;
}
function $eb03e74f8f7db1f3$export$7553c81e62e31b7e(props) {
    /* eslint-disable */ const { list: // react sortable props
    list , setList: setList , children: children , tag: tag , style: style , className: className , clone: clone , onAdd: // sortable options that have methods we want to overwrite
    onAdd , onChange: onChange , onChoose: onChoose , onClone: onClone , onEnd: onEnd , onFilter: onFilter , onRemove: onRemove , onSort: onSort , onStart: onStart , onUnchoose: onUnchoose , onUpdate: onUpdate , onMove: onMove , onSpill: onSpill , onSelect: onSelect , onDeselect: onDeselect , ...options } = props;
    /* eslint-enable */ return options;
}


/** Holds a global reference for which react element is being dragged */ // @todo - use context to manage this. How does one use 2 different providers?
const $7fe8e3ea572bda7a$var$store = {
    dragging: null
};
class $7fe8e3ea572bda7a$export$11bbed9ee0012c13 extends $8zHUo$react.Component {
    constructor(props){
        super(props);
        // @todo forward ref this component
        this.ref = /*#__PURE__*/ $8zHUo$react.createRef();
        // make all state false because we can't change sortable unless a mouse gesture is made.
        const newList = [
            ...props.list
        ].map((item)=>Object.assign(item, {
                chosen: false,
                selected: false
            })
        );
        props.setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
        ($parcel$interopDefault($8zHUo$tinyinvariant))(//@ts-expect-error: Doesn't exist. Will deprecate soon.
        !props.plugins, `
Plugins prop is no longer supported.
Instead, mount it with "Sortable.mount(new MultiDrag())"
Please read the updated README.md at https://github.com/SortableJS/react-sortablejs.
      `);
    }
    componentDidMount() {
        if (this.ref.current === null) return;
        const newOptions = this.makeOptions();
        ($parcel$interopDefault($8zHUo$sortablejs)).create(this.ref.current, newOptions);
    }
    componentDidUpdate(prevProps) {
        if (prevProps.disabled !== this.props.disabled && this.sortable) this.sortable.option("disabled", this.props.disabled);
    }
    render() {
        const { tag: tag , style: style , className: className , id: id  } = this.props;
        const classicProps = {
            style: style,
            className: className,
            id: id
        };
        // if no tag, default to a `div` element.
        const newTag = !tag || tag === null ? "div" : tag;
        return(/*#__PURE__*/ $8zHUo$react.createElement(newTag, {
            // @todo - find a way (perhaps with the callback) to allow AntD components to work
            ref: this.ref,
            ...classicProps
        }, this.getChildren()));
    }
    getChildren() {
        const { children: children , dataIdAttr: dataIdAttr , selectedClass: selectedClass = "sortable-selected" , chosenClass: chosenClass = "sortable-chosen" , dragClass: /* eslint-disable */ dragClass = "sortable-drag" , fallbackClass: fallbackClass = "sortable-falback" , ghostClass: ghostClass = "sortable-ghost" , swapClass: swapClass = "sortable-swap-highlight" , filter: /* eslint-enable */ filter = "sortable-filter" , list: list ,  } = this.props;
        // if no children, don't do anything.
        if (!children || children == null) return null;
        const dataid = dataIdAttr || "data-id";
        /* eslint-disable-next-line */ return $8zHUo$react.Children.map(children, (child, index)=>{
            if (child === undefined) return undefined;
            const item = list[index] || {
            };
            const { className: prevClassName  } = child.props;
            // @todo - handle the function if avalable. I don't think anyone will be doing this soon.
            const filtered = typeof filter === "string" && {
                [filter.replace(".", "")]: !!item.filtered
            };
            const className = ($parcel$interopDefault($8zHUo$classnames))(prevClassName, {
                [selectedClass]: item.selected,
                [chosenClass]: item.chosen,
                ...filtered
            });
            return(/*#__PURE__*/ $8zHUo$react.cloneElement(child, {
                [dataid]: child.key,
                className: className
            }));
        });
    }
    /** Appends the `sortable` property to this component */ get sortable() {
        const el = this.ref.current;
        if (el === null) return null;
        const key = Object.keys(el).find((k)=>k.includes("Sortable")
        );
        if (!key) return null;
        //@ts-expect-error: fix me.
        return el[key];
    }
    /** Converts all the props from `ReactSortable` into the `options` object that `Sortable.create(el, [options])` can use. */ makeOptions() {
        const DOMHandlers = [
            "onAdd",
            "onChoose",
            "onDeselect",
            "onEnd",
            "onRemove",
            "onSelect",
            "onSpill",
            "onStart",
            "onUnchoose",
            "onUpdate", 
        ];
        const NonDOMHandlers = [
            "onChange",
            "onClone",
            "onFilter",
            "onSort", 
        ];
        const newOptions = $eb03e74f8f7db1f3$export$7553c81e62e31b7e(this.props);
        DOMHandlers.forEach((name)=>newOptions[name] = this.prepareOnHandlerPropAndDOM(name)
        );
        NonDOMHandlers.forEach((name)=>newOptions[name] = this.prepareOnHandlerProp(name)
        );
        /** onMove has 2 arguments and needs to be handled seperately. */ const onMove1 = (evt, originalEvt)=>{
            const { onMove: onMove  } = this.props;
            const defaultValue = evt.willInsertAfter || -1;
            if (!onMove) return defaultValue;
            const result = onMove(evt, originalEvt, this.sortable, $7fe8e3ea572bda7a$var$store);
            if (typeof result === "undefined") return false;
            return result;
        };
        return {
            ...newOptions,
            onMove: onMove1
        };
    }
    /** Prepares a method that will be used in the sortable options to call an `on[Handler]` prop & an `on[Handler]` ReactSortable method.  */ prepareOnHandlerPropAndDOM(evtName) {
        return (evt)=>{
            // call the component prop
            this.callOnHandlerProp(evt, evtName);
            // calls state change
            //@ts-expect-error: until @types multidrag item is in
            this[evtName](evt);
        };
    }
    /** Prepares a method that will be used in the sortable options to call an `on[Handler]` prop */ prepareOnHandlerProp(evtName) {
        return (evt)=>{
            // call the component prop
            this.callOnHandlerProp(evt, evtName);
        };
    }
    /** Calls the `props.on[Handler]` function */ callOnHandlerProp(evt, evtName) {
        const propEvent = this.props[evtName];
        if (propEvent) propEvent(evt, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    // SORTABLE DOM HANDLING
    onAdd(evt) {
        const { list: list , setList: setList , clone: clone  } = this.props;
        /* eslint-disable-next-line */ const otherList = [
            ...$7fe8e3ea572bda7a$var$store.dragging.props.list
        ];
        const customs = $eb03e74f8f7db1f3$export$4655efe700f887a(evt, otherList);
        $eb03e74f8f7db1f3$export$77f49a256021c8de(customs);
        const newList = $eb03e74f8f7db1f3$export$eca851ee65ae17e4(customs, list, evt, clone).map((item)=>Object.assign(item, {
                selected: false
            })
        );
        setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    onRemove(evt) {
        const { list: list , setList: setList  } = this.props;
        const mode = $eb03e74f8f7db1f3$export$1fc0f6205829e19c(evt);
        const customs = $eb03e74f8f7db1f3$export$4655efe700f887a(evt, list);
        $eb03e74f8f7db1f3$export$a6177d5829f70ebc(customs);
        let newList = [
            ...list
        ];
        // remove state if not in clone mode. otherwise, keep.
        if (evt.pullMode !== "clone") newList = $eb03e74f8f7db1f3$export$be2da95e6167b0bd(customs, newList);
        else {
            // switch used to get the clone
            let customClones = customs;
            switch(mode){
                case "multidrag":
                    customClones = customs.map((item, index)=>({
                            ...item,
                            element: evt.clones[index]
                        })
                    );
                    break;
                case "normal":
                    customClones = customs.map((item)=>({
                            ...item,
                            element: evt.clone
                        })
                    );
                    break;
                case "swap":
                default:
                    ($parcel$interopDefault($8zHUo$tinyinvariant))(true, `mode "${mode}" cannot clone. Please remove "props.clone" from <ReactSortable/> when using the "${mode}" plugin`);
            }
            $eb03e74f8f7db1f3$export$77f49a256021c8de(customClones);
            // replace selected items with cloned items
            customs.forEach((curr)=>{
                const index = curr.oldIndex;
                /* eslint-disable-next-line */ const newItem = this.props.clone(curr.item, evt);
                newList.splice(index, 1, newItem);
            });
        }
        // remove item.selected from list
        newList = newList.map((item)=>Object.assign(item, {
                selected: false
            })
        );
        setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    onUpdate(evt) {
        const { list: list , setList: setList  } = this.props;
        const customs = $eb03e74f8f7db1f3$export$4655efe700f887a(evt, list);
        $eb03e74f8f7db1f3$export$77f49a256021c8de(customs);
        $eb03e74f8f7db1f3$export$a6177d5829f70ebc(customs);
        const newList = $eb03e74f8f7db1f3$export$c25cf8080bd305ec(customs, list);
        return setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    onStart() {
        $7fe8e3ea572bda7a$var$store.dragging = this;
    }
    onEnd() {
        $7fe8e3ea572bda7a$var$store.dragging = null;
    }
    onChoose(evt) {
        const { list: list , setList: setList  } = this.props;
        const newList = list.map((item, index)=>{
            let newItem = item;
            if (index === evt.oldIndex) newItem = Object.assign(item, {
                chosen: true
            });
            return newItem;
        });
        setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    onUnchoose(evt) {
        const { list: list , setList: setList  } = this.props;
        const newList = list.map((item, index)=>{
            let newItem = item;
            if (index === evt.oldIndex) newItem = Object.assign(newItem, {
                chosen: false
            });
            return newItem;
        });
        setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    onSpill(evt) {
        const { removeOnSpill: removeOnSpill , revertOnSpill: revertOnSpill  } = this.props;
        if (removeOnSpill && !revertOnSpill) $eb03e74f8f7db1f3$export$1d0aa160432dfea5(evt.item);
    }
    onSelect(evt) {
        const { list: list , setList: setList  } = this.props;
        const newList = list.map((item)=>Object.assign(item, {
                selected: false
            })
        );
        evt.newIndicies.forEach((curr)=>{
            const index = curr.index;
            if (index === -1) {
                console.log(`"${evt.type}" had indice of "${curr.index}", which is probably -1 and doesn't usually happen here.`);
                console.log(evt);
                return;
            }
            newList[index].selected = true;
        });
        setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
    onDeselect(evt) {
        const { list: list , setList: setList  } = this.props;
        const newList = list.map((item)=>Object.assign(item, {
                selected: false
            })
        );
        evt.newIndicies.forEach((curr)=>{
            const index = curr.index;
            if (index === -1) return;
            newList[index].selected = true;
        });
        setList(newList, this.sortable, $7fe8e3ea572bda7a$var$store);
    }
}
$7fe8e3ea572bda7a$export$11bbed9ee0012c13.defaultProps = {
    clone: (item)=>item
};


var $faefaad95e5fcca0$exports = {};


$parcel$exportWildcard(module.exports, $faefaad95e5fcca0$exports);


//# sourceMappingURL=index.js.map


/***/ }),

/***/ "./node_modules/sortablejs/modular/sortable.esm.js":
/*!*********************************************************!*\
  !*** ./node_modules/sortablejs/modular/sortable.esm.js ***!
  \*********************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "MultiDrag": function() { return /* binding */ MultiDragPlugin; },
/* harmony export */   "Sortable": function() { return /* binding */ Sortable; },
/* harmony export */   "Swap": function() { return /* binding */ SwapPlugin; }
/* harmony export */ });
/**!
 * Sortable 1.15.0
 * @author	RubaXa   <trash@rubaxa.org>
 * @author	owenm    <owen23355@gmail.com>
 * @license MIT
 */
function ownKeys(object, enumerableOnly) {
  var keys = Object.keys(object);

  if (Object.getOwnPropertySymbols) {
    var symbols = Object.getOwnPropertySymbols(object);

    if (enumerableOnly) {
      symbols = symbols.filter(function (sym) {
        return Object.getOwnPropertyDescriptor(object, sym).enumerable;
      });
    }

    keys.push.apply(keys, symbols);
  }

  return keys;
}

function _objectSpread2(target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i] != null ? arguments[i] : {};

    if (i % 2) {
      ownKeys(Object(source), true).forEach(function (key) {
        _defineProperty(target, key, source[key]);
      });
    } else if (Object.getOwnPropertyDescriptors) {
      Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
    } else {
      ownKeys(Object(source)).forEach(function (key) {
        Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
      });
    }
  }

  return target;
}

function _typeof(obj) {
  "@babel/helpers - typeof";

  if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
    _typeof = function (obj) {
      return typeof obj;
    };
  } else {
    _typeof = function (obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };
  }

  return _typeof(obj);
}

function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

function _extends() {
  _extends = Object.assign || function (target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i];

      for (var key in source) {
        if (Object.prototype.hasOwnProperty.call(source, key)) {
          target[key] = source[key];
        }
      }
    }

    return target;
  };

  return _extends.apply(this, arguments);
}

function _objectWithoutPropertiesLoose(source, excluded) {
  if (source == null) return {};
  var target = {};
  var sourceKeys = Object.keys(source);
  var key, i;

  for (i = 0; i < sourceKeys.length; i++) {
    key = sourceKeys[i];
    if (excluded.indexOf(key) >= 0) continue;
    target[key] = source[key];
  }

  return target;
}

function _objectWithoutProperties(source, excluded) {
  if (source == null) return {};

  var target = _objectWithoutPropertiesLoose(source, excluded);

  var key, i;

  if (Object.getOwnPropertySymbols) {
    var sourceSymbolKeys = Object.getOwnPropertySymbols(source);

    for (i = 0; i < sourceSymbolKeys.length; i++) {
      key = sourceSymbolKeys[i];
      if (excluded.indexOf(key) >= 0) continue;
      if (!Object.prototype.propertyIsEnumerable.call(source, key)) continue;
      target[key] = source[key];
    }
  }

  return target;
}

function _toConsumableArray(arr) {
  return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread();
}

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}

function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return _arrayLikeToArray(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i];

  return arr2;
}

function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

var version = "1.15.0";

function userAgent(pattern) {
  if (typeof window !== 'undefined' && window.navigator) {
    return !! /*@__PURE__*/navigator.userAgent.match(pattern);
  }
}

var IE11OrLess = userAgent(/(?:Trident.*rv[ :]?11\.|msie|iemobile|Windows Phone)/i);
var Edge = userAgent(/Edge/i);
var FireFox = userAgent(/firefox/i);
var Safari = userAgent(/safari/i) && !userAgent(/chrome/i) && !userAgent(/android/i);
var IOS = userAgent(/iP(ad|od|hone)/i);
var ChromeForAndroid = userAgent(/chrome/i) && userAgent(/android/i);

var captureMode = {
  capture: false,
  passive: false
};

function on(el, event, fn) {
  el.addEventListener(event, fn, !IE11OrLess && captureMode);
}

function off(el, event, fn) {
  el.removeEventListener(event, fn, !IE11OrLess && captureMode);
}

function matches(
/**HTMLElement*/
el,
/**String*/
selector) {
  if (!selector) return;
  selector[0] === '>' && (selector = selector.substring(1));

  if (el) {
    try {
      if (el.matches) {
        return el.matches(selector);
      } else if (el.msMatchesSelector) {
        return el.msMatchesSelector(selector);
      } else if (el.webkitMatchesSelector) {
        return el.webkitMatchesSelector(selector);
      }
    } catch (_) {
      return false;
    }
  }

  return false;
}

function getParentOrHost(el) {
  return el.host && el !== document && el.host.nodeType ? el.host : el.parentNode;
}

function closest(
/**HTMLElement*/
el,
/**String*/
selector,
/**HTMLElement*/
ctx, includeCTX) {
  if (el) {
    ctx = ctx || document;

    do {
      if (selector != null && (selector[0] === '>' ? el.parentNode === ctx && matches(el, selector) : matches(el, selector)) || includeCTX && el === ctx) {
        return el;
      }

      if (el === ctx) break;
      /* jshint boss:true */
    } while (el = getParentOrHost(el));
  }

  return null;
}

var R_SPACE = /\s+/g;

function toggleClass(el, name, state) {
  if (el && name) {
    if (el.classList) {
      el.classList[state ? 'add' : 'remove'](name);
    } else {
      var className = (' ' + el.className + ' ').replace(R_SPACE, ' ').replace(' ' + name + ' ', ' ');
      el.className = (className + (state ? ' ' + name : '')).replace(R_SPACE, ' ');
    }
  }
}

function css(el, prop, val) {
  var style = el && el.style;

  if (style) {
    if (val === void 0) {
      if (document.defaultView && document.defaultView.getComputedStyle) {
        val = document.defaultView.getComputedStyle(el, '');
      } else if (el.currentStyle) {
        val = el.currentStyle;
      }

      return prop === void 0 ? val : val[prop];
    } else {
      if (!(prop in style) && prop.indexOf('webkit') === -1) {
        prop = '-webkit-' + prop;
      }

      style[prop] = val + (typeof val === 'string' ? '' : 'px');
    }
  }
}

function matrix(el, selfOnly) {
  var appliedTransforms = '';

  if (typeof el === 'string') {
    appliedTransforms = el;
  } else {
    do {
      var transform = css(el, 'transform');

      if (transform && transform !== 'none') {
        appliedTransforms = transform + ' ' + appliedTransforms;
      }
      /* jshint boss:true */

    } while (!selfOnly && (el = el.parentNode));
  }

  var matrixFn = window.DOMMatrix || window.WebKitCSSMatrix || window.CSSMatrix || window.MSCSSMatrix;
  /*jshint -W056 */

  return matrixFn && new matrixFn(appliedTransforms);
}

function find(ctx, tagName, iterator) {
  if (ctx) {
    var list = ctx.getElementsByTagName(tagName),
        i = 0,
        n = list.length;

    if (iterator) {
      for (; i < n; i++) {
        iterator(list[i], i);
      }
    }

    return list;
  }

  return [];
}

function getWindowScrollingElement() {
  var scrollingElement = document.scrollingElement;

  if (scrollingElement) {
    return scrollingElement;
  } else {
    return document.documentElement;
  }
}
/**
 * Returns the "bounding client rect" of given element
 * @param  {HTMLElement} el                       The element whose boundingClientRect is wanted
 * @param  {[Boolean]} relativeToContainingBlock  Whether the rect should be relative to the containing block of (including) the container
 * @param  {[Boolean]} relativeToNonStaticParent  Whether the rect should be relative to the relative parent of (including) the contaienr
 * @param  {[Boolean]} undoScale                  Whether the container's scale() should be undone
 * @param  {[HTMLElement]} container              The parent the element will be placed in
 * @return {Object}                               The boundingClientRect of el, with specified adjustments
 */


function getRect(el, relativeToContainingBlock, relativeToNonStaticParent, undoScale, container) {
  if (!el.getBoundingClientRect && el !== window) return;
  var elRect, top, left, bottom, right, height, width;

  if (el !== window && el.parentNode && el !== getWindowScrollingElement()) {
    elRect = el.getBoundingClientRect();
    top = elRect.top;
    left = elRect.left;
    bottom = elRect.bottom;
    right = elRect.right;
    height = elRect.height;
    width = elRect.width;
  } else {
    top = 0;
    left = 0;
    bottom = window.innerHeight;
    right = window.innerWidth;
    height = window.innerHeight;
    width = window.innerWidth;
  }

  if ((relativeToContainingBlock || relativeToNonStaticParent) && el !== window) {
    // Adjust for translate()
    container = container || el.parentNode; // solves #1123 (see: https://stackoverflow.com/a/37953806/6088312)
    // Not needed on <= IE11

    if (!IE11OrLess) {
      do {
        if (container && container.getBoundingClientRect && (css(container, 'transform') !== 'none' || relativeToNonStaticParent && css(container, 'position') !== 'static')) {
          var containerRect = container.getBoundingClientRect(); // Set relative to edges of padding box of container

          top -= containerRect.top + parseInt(css(container, 'border-top-width'));
          left -= containerRect.left + parseInt(css(container, 'border-left-width'));
          bottom = top + elRect.height;
          right = left + elRect.width;
          break;
        }
        /* jshint boss:true */

      } while (container = container.parentNode);
    }
  }

  if (undoScale && el !== window) {
    // Adjust for scale()
    var elMatrix = matrix(container || el),
        scaleX = elMatrix && elMatrix.a,
        scaleY = elMatrix && elMatrix.d;

    if (elMatrix) {
      top /= scaleY;
      left /= scaleX;
      width /= scaleX;
      height /= scaleY;
      bottom = top + height;
      right = left + width;
    }
  }

  return {
    top: top,
    left: left,
    bottom: bottom,
    right: right,
    width: width,
    height: height
  };
}
/**
 * Checks if a side of an element is scrolled past a side of its parents
 * @param  {HTMLElement}  el           The element who's side being scrolled out of view is in question
 * @param  {String}       elSide       Side of the element in question ('top', 'left', 'right', 'bottom')
 * @param  {String}       parentSide   Side of the parent in question ('top', 'left', 'right', 'bottom')
 * @return {HTMLElement}               The parent scroll element that the el's side is scrolled past, or null if there is no such element
 */


function isScrolledPast(el, elSide, parentSide) {
  var parent = getParentAutoScrollElement(el, true),
      elSideVal = getRect(el)[elSide];
  /* jshint boss:true */

  while (parent) {
    var parentSideVal = getRect(parent)[parentSide],
        visible = void 0;

    if (parentSide === 'top' || parentSide === 'left') {
      visible = elSideVal >= parentSideVal;
    } else {
      visible = elSideVal <= parentSideVal;
    }

    if (!visible) return parent;
    if (parent === getWindowScrollingElement()) break;
    parent = getParentAutoScrollElement(parent, false);
  }

  return false;
}
/**
 * Gets nth child of el, ignoring hidden children, sortable's elements (does not ignore clone if it's visible)
 * and non-draggable elements
 * @param  {HTMLElement} el       The parent element
 * @param  {Number} childNum      The index of the child
 * @param  {Object} options       Parent Sortable's options
 * @return {HTMLElement}          The child at index childNum, or null if not found
 */


function getChild(el, childNum, options, includeDragEl) {
  var currentChild = 0,
      i = 0,
      children = el.children;

  while (i < children.length) {
    if (children[i].style.display !== 'none' && children[i] !== Sortable.ghost && (includeDragEl || children[i] !== Sortable.dragged) && closest(children[i], options.draggable, el, false)) {
      if (currentChild === childNum) {
        return children[i];
      }

      currentChild++;
    }

    i++;
  }

  return null;
}
/**
 * Gets the last child in the el, ignoring ghostEl or invisible elements (clones)
 * @param  {HTMLElement} el       Parent element
 * @param  {selector} selector    Any other elements that should be ignored
 * @return {HTMLElement}          The last child, ignoring ghostEl
 */


function lastChild(el, selector) {
  var last = el.lastElementChild;

  while (last && (last === Sortable.ghost || css(last, 'display') === 'none' || selector && !matches(last, selector))) {
    last = last.previousElementSibling;
  }

  return last || null;
}
/**
 * Returns the index of an element within its parent for a selected set of
 * elements
 * @param  {HTMLElement} el
 * @param  {selector} selector
 * @return {number}
 */


function index(el, selector) {
  var index = 0;

  if (!el || !el.parentNode) {
    return -1;
  }
  /* jshint boss:true */


  while (el = el.previousElementSibling) {
    if (el.nodeName.toUpperCase() !== 'TEMPLATE' && el !== Sortable.clone && (!selector || matches(el, selector))) {
      index++;
    }
  }

  return index;
}
/**
 * Returns the scroll offset of the given element, added with all the scroll offsets of parent elements.
 * The value is returned in real pixels.
 * @param  {HTMLElement} el
 * @return {Array}             Offsets in the format of [left, top]
 */


function getRelativeScrollOffset(el) {
  var offsetLeft = 0,
      offsetTop = 0,
      winScroller = getWindowScrollingElement();

  if (el) {
    do {
      var elMatrix = matrix(el),
          scaleX = elMatrix.a,
          scaleY = elMatrix.d;
      offsetLeft += el.scrollLeft * scaleX;
      offsetTop += el.scrollTop * scaleY;
    } while (el !== winScroller && (el = el.parentNode));
  }

  return [offsetLeft, offsetTop];
}
/**
 * Returns the index of the object within the given array
 * @param  {Array} arr   Array that may or may not hold the object
 * @param  {Object} obj  An object that has a key-value pair unique to and identical to a key-value pair in the object you want to find
 * @return {Number}      The index of the object in the array, or -1
 */


function indexOfObject(arr, obj) {
  for (var i in arr) {
    if (!arr.hasOwnProperty(i)) continue;

    for (var key in obj) {
      if (obj.hasOwnProperty(key) && obj[key] === arr[i][key]) return Number(i);
    }
  }

  return -1;
}

function getParentAutoScrollElement(el, includeSelf) {
  // skip to window
  if (!el || !el.getBoundingClientRect) return getWindowScrollingElement();
  var elem = el;
  var gotSelf = false;

  do {
    // we don't need to get elem css if it isn't even overflowing in the first place (performance)
    if (elem.clientWidth < elem.scrollWidth || elem.clientHeight < elem.scrollHeight) {
      var elemCSS = css(elem);

      if (elem.clientWidth < elem.scrollWidth && (elemCSS.overflowX == 'auto' || elemCSS.overflowX == 'scroll') || elem.clientHeight < elem.scrollHeight && (elemCSS.overflowY == 'auto' || elemCSS.overflowY == 'scroll')) {
        if (!elem.getBoundingClientRect || elem === document.body) return getWindowScrollingElement();
        if (gotSelf || includeSelf) return elem;
        gotSelf = true;
      }
    }
    /* jshint boss:true */

  } while (elem = elem.parentNode);

  return getWindowScrollingElement();
}

function extend(dst, src) {
  if (dst && src) {
    for (var key in src) {
      if (src.hasOwnProperty(key)) {
        dst[key] = src[key];
      }
    }
  }

  return dst;
}

function isRectEqual(rect1, rect2) {
  return Math.round(rect1.top) === Math.round(rect2.top) && Math.round(rect1.left) === Math.round(rect2.left) && Math.round(rect1.height) === Math.round(rect2.height) && Math.round(rect1.width) === Math.round(rect2.width);
}

var _throttleTimeout;

function throttle(callback, ms) {
  return function () {
    if (!_throttleTimeout) {
      var args = arguments,
          _this = this;

      if (args.length === 1) {
        callback.call(_this, args[0]);
      } else {
        callback.apply(_this, args);
      }

      _throttleTimeout = setTimeout(function () {
        _throttleTimeout = void 0;
      }, ms);
    }
  };
}

function cancelThrottle() {
  clearTimeout(_throttleTimeout);
  _throttleTimeout = void 0;
}

function scrollBy(el, x, y) {
  el.scrollLeft += x;
  el.scrollTop += y;
}

function clone(el) {
  var Polymer = window.Polymer;
  var $ = window.jQuery || window.Zepto;

  if (Polymer && Polymer.dom) {
    return Polymer.dom(el).cloneNode(true);
  } else if ($) {
    return $(el).clone(true)[0];
  } else {
    return el.cloneNode(true);
  }
}

function setRect(el, rect) {
  css(el, 'position', 'absolute');
  css(el, 'top', rect.top);
  css(el, 'left', rect.left);
  css(el, 'width', rect.width);
  css(el, 'height', rect.height);
}

function unsetRect(el) {
  css(el, 'position', '');
  css(el, 'top', '');
  css(el, 'left', '');
  css(el, 'width', '');
  css(el, 'height', '');
}

var expando = 'Sortable' + new Date().getTime();

function AnimationStateManager() {
  var animationStates = [],
      animationCallbackId;
  return {
    captureAnimationState: function captureAnimationState() {
      animationStates = [];
      if (!this.options.animation) return;
      var children = [].slice.call(this.el.children);
      children.forEach(function (child) {
        if (css(child, 'display') === 'none' || child === Sortable.ghost) return;
        animationStates.push({
          target: child,
          rect: getRect(child)
        });

        var fromRect = _objectSpread2({}, animationStates[animationStates.length - 1].rect); // If animating: compensate for current animation


        if (child.thisAnimationDuration) {
          var childMatrix = matrix(child, true);

          if (childMatrix) {
            fromRect.top -= childMatrix.f;
            fromRect.left -= childMatrix.e;
          }
        }

        child.fromRect = fromRect;
      });
    },
    addAnimationState: function addAnimationState(state) {
      animationStates.push(state);
    },
    removeAnimationState: function removeAnimationState(target) {
      animationStates.splice(indexOfObject(animationStates, {
        target: target
      }), 1);
    },
    animateAll: function animateAll(callback) {
      var _this = this;

      if (!this.options.animation) {
        clearTimeout(animationCallbackId);
        if (typeof callback === 'function') callback();
        return;
      }

      var animating = false,
          animationTime = 0;
      animationStates.forEach(function (state) {
        var time = 0,
            target = state.target,
            fromRect = target.fromRect,
            toRect = getRect(target),
            prevFromRect = target.prevFromRect,
            prevToRect = target.prevToRect,
            animatingRect = state.rect,
            targetMatrix = matrix(target, true);

        if (targetMatrix) {
          // Compensate for current animation
          toRect.top -= targetMatrix.f;
          toRect.left -= targetMatrix.e;
        }

        target.toRect = toRect;

        if (target.thisAnimationDuration) {
          // Could also check if animatingRect is between fromRect and toRect
          if (isRectEqual(prevFromRect, toRect) && !isRectEqual(fromRect, toRect) && // Make sure animatingRect is on line between toRect & fromRect
          (animatingRect.top - toRect.top) / (animatingRect.left - toRect.left) === (fromRect.top - toRect.top) / (fromRect.left - toRect.left)) {
            // If returning to same place as started from animation and on same axis
            time = calculateRealTime(animatingRect, prevFromRect, prevToRect, _this.options);
          }
        } // if fromRect != toRect: animate


        if (!isRectEqual(toRect, fromRect)) {
          target.prevFromRect = fromRect;
          target.prevToRect = toRect;

          if (!time) {
            time = _this.options.animation;
          }

          _this.animate(target, animatingRect, toRect, time);
        }

        if (time) {
          animating = true;
          animationTime = Math.max(animationTime, time);
          clearTimeout(target.animationResetTimer);
          target.animationResetTimer = setTimeout(function () {
            target.animationTime = 0;
            target.prevFromRect = null;
            target.fromRect = null;
            target.prevToRect = null;
            target.thisAnimationDuration = null;
          }, time);
          target.thisAnimationDuration = time;
        }
      });
      clearTimeout(animationCallbackId);

      if (!animating) {
        if (typeof callback === 'function') callback();
      } else {
        animationCallbackId = setTimeout(function () {
          if (typeof callback === 'function') callback();
        }, animationTime);
      }

      animationStates = [];
    },
    animate: function animate(target, currentRect, toRect, duration) {
      if (duration) {
        css(target, 'transition', '');
        css(target, 'transform', '');
        var elMatrix = matrix(this.el),
            scaleX = elMatrix && elMatrix.a,
            scaleY = elMatrix && elMatrix.d,
            translateX = (currentRect.left - toRect.left) / (scaleX || 1),
            translateY = (currentRect.top - toRect.top) / (scaleY || 1);
        target.animatingX = !!translateX;
        target.animatingY = !!translateY;
        css(target, 'transform', 'translate3d(' + translateX + 'px,' + translateY + 'px,0)');
        this.forRepaintDummy = repaint(target); // repaint

        css(target, 'transition', 'transform ' + duration + 'ms' + (this.options.easing ? ' ' + this.options.easing : ''));
        css(target, 'transform', 'translate3d(0,0,0)');
        typeof target.animated === 'number' && clearTimeout(target.animated);
        target.animated = setTimeout(function () {
          css(target, 'transition', '');
          css(target, 'transform', '');
          target.animated = false;
          target.animatingX = false;
          target.animatingY = false;
        }, duration);
      }
    }
  };
}

function repaint(target) {
  return target.offsetWidth;
}

function calculateRealTime(animatingRect, fromRect, toRect, options) {
  return Math.sqrt(Math.pow(fromRect.top - animatingRect.top, 2) + Math.pow(fromRect.left - animatingRect.left, 2)) / Math.sqrt(Math.pow(fromRect.top - toRect.top, 2) + Math.pow(fromRect.left - toRect.left, 2)) * options.animation;
}

var plugins = [];
var defaults = {
  initializeByDefault: true
};
var PluginManager = {
  mount: function mount(plugin) {
    // Set default static properties
    for (var option in defaults) {
      if (defaults.hasOwnProperty(option) && !(option in plugin)) {
        plugin[option] = defaults[option];
      }
    }

    plugins.forEach(function (p) {
      if (p.pluginName === plugin.pluginName) {
        throw "Sortable: Cannot mount plugin ".concat(plugin.pluginName, " more than once");
      }
    });
    plugins.push(plugin);
  },
  pluginEvent: function pluginEvent(eventName, sortable, evt) {
    var _this = this;

    this.eventCanceled = false;

    evt.cancel = function () {
      _this.eventCanceled = true;
    };

    var eventNameGlobal = eventName + 'Global';
    plugins.forEach(function (plugin) {
      if (!sortable[plugin.pluginName]) return; // Fire global events if it exists in this sortable

      if (sortable[plugin.pluginName][eventNameGlobal]) {
        sortable[plugin.pluginName][eventNameGlobal](_objectSpread2({
          sortable: sortable
        }, evt));
      } // Only fire plugin event if plugin is enabled in this sortable,
      // and plugin has event defined


      if (sortable.options[plugin.pluginName] && sortable[plugin.pluginName][eventName]) {
        sortable[plugin.pluginName][eventName](_objectSpread2({
          sortable: sortable
        }, evt));
      }
    });
  },
  initializePlugins: function initializePlugins(sortable, el, defaults, options) {
    plugins.forEach(function (plugin) {
      var pluginName = plugin.pluginName;
      if (!sortable.options[pluginName] && !plugin.initializeByDefault) return;
      var initialized = new plugin(sortable, el, sortable.options);
      initialized.sortable = sortable;
      initialized.options = sortable.options;
      sortable[pluginName] = initialized; // Add default options from plugin

      _extends(defaults, initialized.defaults);
    });

    for (var option in sortable.options) {
      if (!sortable.options.hasOwnProperty(option)) continue;
      var modified = this.modifyOption(sortable, option, sortable.options[option]);

      if (typeof modified !== 'undefined') {
        sortable.options[option] = modified;
      }
    }
  },
  getEventProperties: function getEventProperties(name, sortable) {
    var eventProperties = {};
    plugins.forEach(function (plugin) {
      if (typeof plugin.eventProperties !== 'function') return;

      _extends(eventProperties, plugin.eventProperties.call(sortable[plugin.pluginName], name));
    });
    return eventProperties;
  },
  modifyOption: function modifyOption(sortable, name, value) {
    var modifiedValue;
    plugins.forEach(function (plugin) {
      // Plugin must exist on the Sortable
      if (!sortable[plugin.pluginName]) return; // If static option listener exists for this option, call in the context of the Sortable's instance of this plugin

      if (plugin.optionListeners && typeof plugin.optionListeners[name] === 'function') {
        modifiedValue = plugin.optionListeners[name].call(sortable[plugin.pluginName], value);
      }
    });
    return modifiedValue;
  }
};

function dispatchEvent(_ref) {
  var sortable = _ref.sortable,
      rootEl = _ref.rootEl,
      name = _ref.name,
      targetEl = _ref.targetEl,
      cloneEl = _ref.cloneEl,
      toEl = _ref.toEl,
      fromEl = _ref.fromEl,
      oldIndex = _ref.oldIndex,
      newIndex = _ref.newIndex,
      oldDraggableIndex = _ref.oldDraggableIndex,
      newDraggableIndex = _ref.newDraggableIndex,
      originalEvent = _ref.originalEvent,
      putSortable = _ref.putSortable,
      extraEventProperties = _ref.extraEventProperties;
  sortable = sortable || rootEl && rootEl[expando];
  if (!sortable) return;
  var evt,
      options = sortable.options,
      onName = 'on' + name.charAt(0).toUpperCase() + name.substr(1); // Support for new CustomEvent feature

  if (window.CustomEvent && !IE11OrLess && !Edge) {
    evt = new CustomEvent(name, {
      bubbles: true,
      cancelable: true
    });
  } else {
    evt = document.createEvent('Event');
    evt.initEvent(name, true, true);
  }

  evt.to = toEl || rootEl;
  evt.from = fromEl || rootEl;
  evt.item = targetEl || rootEl;
  evt.clone = cloneEl;
  evt.oldIndex = oldIndex;
  evt.newIndex = newIndex;
  evt.oldDraggableIndex = oldDraggableIndex;
  evt.newDraggableIndex = newDraggableIndex;
  evt.originalEvent = originalEvent;
  evt.pullMode = putSortable ? putSortable.lastPutMode : undefined;

  var allEventProperties = _objectSpread2(_objectSpread2({}, extraEventProperties), PluginManager.getEventProperties(name, sortable));

  for (var option in allEventProperties) {
    evt[option] = allEventProperties[option];
  }

  if (rootEl) {
    rootEl.dispatchEvent(evt);
  }

  if (options[onName]) {
    options[onName].call(sortable, evt);
  }
}

var _excluded = ["evt"];

var pluginEvent = function pluginEvent(eventName, sortable) {
  var _ref = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : {},
      originalEvent = _ref.evt,
      data = _objectWithoutProperties(_ref, _excluded);

  PluginManager.pluginEvent.bind(Sortable)(eventName, sortable, _objectSpread2({
    dragEl: dragEl,
    parentEl: parentEl,
    ghostEl: ghostEl,
    rootEl: rootEl,
    nextEl: nextEl,
    lastDownEl: lastDownEl,
    cloneEl: cloneEl,
    cloneHidden: cloneHidden,
    dragStarted: moved,
    putSortable: putSortable,
    activeSortable: Sortable.active,
    originalEvent: originalEvent,
    oldIndex: oldIndex,
    oldDraggableIndex: oldDraggableIndex,
    newIndex: newIndex,
    newDraggableIndex: newDraggableIndex,
    hideGhostForTarget: _hideGhostForTarget,
    unhideGhostForTarget: _unhideGhostForTarget,
    cloneNowHidden: function cloneNowHidden() {
      cloneHidden = true;
    },
    cloneNowShown: function cloneNowShown() {
      cloneHidden = false;
    },
    dispatchSortableEvent: function dispatchSortableEvent(name) {
      _dispatchEvent({
        sortable: sortable,
        name: name,
        originalEvent: originalEvent
      });
    }
  }, data));
};

function _dispatchEvent(info) {
  dispatchEvent(_objectSpread2({
    putSortable: putSortable,
    cloneEl: cloneEl,
    targetEl: dragEl,
    rootEl: rootEl,
    oldIndex: oldIndex,
    oldDraggableIndex: oldDraggableIndex,
    newIndex: newIndex,
    newDraggableIndex: newDraggableIndex
  }, info));
}

var dragEl,
    parentEl,
    ghostEl,
    rootEl,
    nextEl,
    lastDownEl,
    cloneEl,
    cloneHidden,
    oldIndex,
    newIndex,
    oldDraggableIndex,
    newDraggableIndex,
    activeGroup,
    putSortable,
    awaitingDragStarted = false,
    ignoreNextClick = false,
    sortables = [],
    tapEvt,
    touchEvt,
    lastDx,
    lastDy,
    tapDistanceLeft,
    tapDistanceTop,
    moved,
    lastTarget,
    lastDirection,
    pastFirstInvertThresh = false,
    isCircumstantialInvert = false,
    targetMoveDistance,
    // For positioning ghost absolutely
ghostRelativeParent,
    ghostRelativeParentInitialScroll = [],
    // (left, top)
_silent = false,
    savedInputChecked = [];
/** @const */

var documentExists = typeof document !== 'undefined',
    PositionGhostAbsolutely = IOS,
    CSSFloatProperty = Edge || IE11OrLess ? 'cssFloat' : 'float',
    // This will not pass for IE9, because IE9 DnD only works on anchors
supportDraggable = documentExists && !ChromeForAndroid && !IOS && 'draggable' in document.createElement('div'),
    supportCssPointerEvents = function () {
  if (!documentExists) return; // false when <= IE11

  if (IE11OrLess) {
    return false;
  }

  var el = document.createElement('x');
  el.style.cssText = 'pointer-events:auto';
  return el.style.pointerEvents === 'auto';
}(),
    _detectDirection = function _detectDirection(el, options) {
  var elCSS = css(el),
      elWidth = parseInt(elCSS.width) - parseInt(elCSS.paddingLeft) - parseInt(elCSS.paddingRight) - parseInt(elCSS.borderLeftWidth) - parseInt(elCSS.borderRightWidth),
      child1 = getChild(el, 0, options),
      child2 = getChild(el, 1, options),
      firstChildCSS = child1 && css(child1),
      secondChildCSS = child2 && css(child2),
      firstChildWidth = firstChildCSS && parseInt(firstChildCSS.marginLeft) + parseInt(firstChildCSS.marginRight) + getRect(child1).width,
      secondChildWidth = secondChildCSS && parseInt(secondChildCSS.marginLeft) + parseInt(secondChildCSS.marginRight) + getRect(child2).width;

  if (elCSS.display === 'flex') {
    return elCSS.flexDirection === 'column' || elCSS.flexDirection === 'column-reverse' ? 'vertical' : 'horizontal';
  }

  if (elCSS.display === 'grid') {
    return elCSS.gridTemplateColumns.split(' ').length <= 1 ? 'vertical' : 'horizontal';
  }

  if (child1 && firstChildCSS["float"] && firstChildCSS["float"] !== 'none') {
    var touchingSideChild2 = firstChildCSS["float"] === 'left' ? 'left' : 'right';
    return child2 && (secondChildCSS.clear === 'both' || secondChildCSS.clear === touchingSideChild2) ? 'vertical' : 'horizontal';
  }

  return child1 && (firstChildCSS.display === 'block' || firstChildCSS.display === 'flex' || firstChildCSS.display === 'table' || firstChildCSS.display === 'grid' || firstChildWidth >= elWidth && elCSS[CSSFloatProperty] === 'none' || child2 && elCSS[CSSFloatProperty] === 'none' && firstChildWidth + secondChildWidth > elWidth) ? 'vertical' : 'horizontal';
},
    _dragElInRowColumn = function _dragElInRowColumn(dragRect, targetRect, vertical) {
  var dragElS1Opp = vertical ? dragRect.left : dragRect.top,
      dragElS2Opp = vertical ? dragRect.right : dragRect.bottom,
      dragElOppLength = vertical ? dragRect.width : dragRect.height,
      targetS1Opp = vertical ? targetRect.left : targetRect.top,
      targetS2Opp = vertical ? targetRect.right : targetRect.bottom,
      targetOppLength = vertical ? targetRect.width : targetRect.height;
  return dragElS1Opp === targetS1Opp || dragElS2Opp === targetS2Opp || dragElS1Opp + dragElOppLength / 2 === targetS1Opp + targetOppLength / 2;
},

/**
 * Detects first nearest empty sortable to X and Y position using emptyInsertThreshold.
 * @param  {Number} x      X position
 * @param  {Number} y      Y position
 * @return {HTMLElement}   Element of the first found nearest Sortable
 */
_detectNearestEmptySortable = function _detectNearestEmptySortable(x, y) {
  var ret;
  sortables.some(function (sortable) {
    var threshold = sortable[expando].options.emptyInsertThreshold;
    if (!threshold || lastChild(sortable)) return;
    var rect = getRect(sortable),
        insideHorizontally = x >= rect.left - threshold && x <= rect.right + threshold,
        insideVertically = y >= rect.top - threshold && y <= rect.bottom + threshold;

    if (insideHorizontally && insideVertically) {
      return ret = sortable;
    }
  });
  return ret;
},
    _prepareGroup = function _prepareGroup(options) {
  function toFn(value, pull) {
    return function (to, from, dragEl, evt) {
      var sameGroup = to.options.group.name && from.options.group.name && to.options.group.name === from.options.group.name;

      if (value == null && (pull || sameGroup)) {
        // Default pull value
        // Default pull and put value if same group
        return true;
      } else if (value == null || value === false) {
        return false;
      } else if (pull && value === 'clone') {
        return value;
      } else if (typeof value === 'function') {
        return toFn(value(to, from, dragEl, evt), pull)(to, from, dragEl, evt);
      } else {
        var otherGroup = (pull ? to : from).options.group.name;
        return value === true || typeof value === 'string' && value === otherGroup || value.join && value.indexOf(otherGroup) > -1;
      }
    };
  }

  var group = {};
  var originalGroup = options.group;

  if (!originalGroup || _typeof(originalGroup) != 'object') {
    originalGroup = {
      name: originalGroup
    };
  }

  group.name = originalGroup.name;
  group.checkPull = toFn(originalGroup.pull, true);
  group.checkPut = toFn(originalGroup.put);
  group.revertClone = originalGroup.revertClone;
  options.group = group;
},
    _hideGhostForTarget = function _hideGhostForTarget() {
  if (!supportCssPointerEvents && ghostEl) {
    css(ghostEl, 'display', 'none');
  }
},
    _unhideGhostForTarget = function _unhideGhostForTarget() {
  if (!supportCssPointerEvents && ghostEl) {
    css(ghostEl, 'display', '');
  }
}; // #1184 fix - Prevent click event on fallback if dragged but item not changed position


if (documentExists && !ChromeForAndroid) {
  document.addEventListener('click', function (evt) {
    if (ignoreNextClick) {
      evt.preventDefault();
      evt.stopPropagation && evt.stopPropagation();
      evt.stopImmediatePropagation && evt.stopImmediatePropagation();
      ignoreNextClick = false;
      return false;
    }
  }, true);
}

var nearestEmptyInsertDetectEvent = function nearestEmptyInsertDetectEvent(evt) {
  if (dragEl) {
    evt = evt.touches ? evt.touches[0] : evt;

    var nearest = _detectNearestEmptySortable(evt.clientX, evt.clientY);

    if (nearest) {
      // Create imitation event
      var event = {};

      for (var i in evt) {
        if (evt.hasOwnProperty(i)) {
          event[i] = evt[i];
        }
      }

      event.target = event.rootEl = nearest;
      event.preventDefault = void 0;
      event.stopPropagation = void 0;

      nearest[expando]._onDragOver(event);
    }
  }
};

var _checkOutsideTargetEl = function _checkOutsideTargetEl(evt) {
  if (dragEl) {
    dragEl.parentNode[expando]._isOutsideThisEl(evt.target);
  }
};
/**
 * @class  Sortable
 * @param  {HTMLElement}  el
 * @param  {Object}       [options]
 */


function Sortable(el, options) {
  if (!(el && el.nodeType && el.nodeType === 1)) {
    throw "Sortable: `el` must be an HTMLElement, not ".concat({}.toString.call(el));
  }

  this.el = el; // root element

  this.options = options = _extends({}, options); // Export instance

  el[expando] = this;
  var defaults = {
    group: null,
    sort: true,
    disabled: false,
    store: null,
    handle: null,
    draggable: /^[uo]l$/i.test(el.nodeName) ? '>li' : '>*',
    swapThreshold: 1,
    // percentage; 0 <= x <= 1
    invertSwap: false,
    // invert always
    invertedSwapThreshold: null,
    // will be set to same as swapThreshold if default
    removeCloneOnHide: true,
    direction: function direction() {
      return _detectDirection(el, this.options);
    },
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    dragClass: 'sortable-drag',
    ignore: 'a, img',
    filter: null,
    preventOnFilter: true,
    animation: 0,
    easing: null,
    setData: function setData(dataTransfer, dragEl) {
      dataTransfer.setData('Text', dragEl.textContent);
    },
    dropBubble: false,
    dragoverBubble: false,
    dataIdAttr: 'data-id',
    delay: 0,
    delayOnTouchOnly: false,
    touchStartThreshold: (Number.parseInt ? Number : window).parseInt(window.devicePixelRatio, 10) || 1,
    forceFallback: false,
    fallbackClass: 'sortable-fallback',
    fallbackOnBody: false,
    fallbackTolerance: 0,
    fallbackOffset: {
      x: 0,
      y: 0
    },
    supportPointer: Sortable.supportPointer !== false && 'PointerEvent' in window && !Safari,
    emptyInsertThreshold: 5
  };
  PluginManager.initializePlugins(this, el, defaults); // Set default options

  for (var name in defaults) {
    !(name in options) && (options[name] = defaults[name]);
  }

  _prepareGroup(options); // Bind all private methods


  for (var fn in this) {
    if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
      this[fn] = this[fn].bind(this);
    }
  } // Setup drag mode


  this.nativeDraggable = options.forceFallback ? false : supportDraggable;

  if (this.nativeDraggable) {
    // Touch start threshold cannot be greater than the native dragstart threshold
    this.options.touchStartThreshold = 1;
  } // Bind events


  if (options.supportPointer) {
    on(el, 'pointerdown', this._onTapStart);
  } else {
    on(el, 'mousedown', this._onTapStart);
    on(el, 'touchstart', this._onTapStart);
  }

  if (this.nativeDraggable) {
    on(el, 'dragover', this);
    on(el, 'dragenter', this);
  }

  sortables.push(this.el); // Restore sorting

  options.store && options.store.get && this.sort(options.store.get(this) || []); // Add animation state manager

  _extends(this, AnimationStateManager());
}

Sortable.prototype =
/** @lends Sortable.prototype */
{
  constructor: Sortable,
  _isOutsideThisEl: function _isOutsideThisEl(target) {
    if (!this.el.contains(target) && target !== this.el) {
      lastTarget = null;
    }
  },
  _getDirection: function _getDirection(evt, target) {
    return typeof this.options.direction === 'function' ? this.options.direction.call(this, evt, target, dragEl) : this.options.direction;
  },
  _onTapStart: function _onTapStart(
  /** Event|TouchEvent */
  evt) {
    if (!evt.cancelable) return;

    var _this = this,
        el = this.el,
        options = this.options,
        preventOnFilter = options.preventOnFilter,
        type = evt.type,
        touch = evt.touches && evt.touches[0] || evt.pointerType && evt.pointerType === 'touch' && evt,
        target = (touch || evt).target,
        originalTarget = evt.target.shadowRoot && (evt.path && evt.path[0] || evt.composedPath && evt.composedPath()[0]) || target,
        filter = options.filter;

    _saveInputCheckedState(el); // Don't trigger start event when an element is been dragged, otherwise the evt.oldindex always wrong when set option.group.


    if (dragEl) {
      return;
    }

    if (/mousedown|pointerdown/.test(type) && evt.button !== 0 || options.disabled) {
      return; // only left button and enabled
    } // cancel dnd if original target is content editable


    if (originalTarget.isContentEditable) {
      return;
    } // Safari ignores further event handling after mousedown


    if (!this.nativeDraggable && Safari && target && target.tagName.toUpperCase() === 'SELECT') {
      return;
    }

    target = closest(target, options.draggable, el, false);

    if (target && target.animated) {
      return;
    }

    if (lastDownEl === target) {
      // Ignoring duplicate `down`
      return;
    } // Get the index of the dragged element within its parent


    oldIndex = index(target);
    oldDraggableIndex = index(target, options.draggable); // Check filter

    if (typeof filter === 'function') {
      if (filter.call(this, evt, target, this)) {
        _dispatchEvent({
          sortable: _this,
          rootEl: originalTarget,
          name: 'filter',
          targetEl: target,
          toEl: el,
          fromEl: el
        });

        pluginEvent('filter', _this, {
          evt: evt
        });
        preventOnFilter && evt.cancelable && evt.preventDefault();
        return; // cancel dnd
      }
    } else if (filter) {
      filter = filter.split(',').some(function (criteria) {
        criteria = closest(originalTarget, criteria.trim(), el, false);

        if (criteria) {
          _dispatchEvent({
            sortable: _this,
            rootEl: criteria,
            name: 'filter',
            targetEl: target,
            fromEl: el,
            toEl: el
          });

          pluginEvent('filter', _this, {
            evt: evt
          });
          return true;
        }
      });

      if (filter) {
        preventOnFilter && evt.cancelable && evt.preventDefault();
        return; // cancel dnd
      }
    }

    if (options.handle && !closest(originalTarget, options.handle, el, false)) {
      return;
    } // Prepare `dragstart`


    this._prepareDragStart(evt, touch, target);
  },
  _prepareDragStart: function _prepareDragStart(
  /** Event */
  evt,
  /** Touch */
  touch,
  /** HTMLElement */
  target) {
    var _this = this,
        el = _this.el,
        options = _this.options,
        ownerDocument = el.ownerDocument,
        dragStartFn;

    if (target && !dragEl && target.parentNode === el) {
      var dragRect = getRect(target);
      rootEl = el;
      dragEl = target;
      parentEl = dragEl.parentNode;
      nextEl = dragEl.nextSibling;
      lastDownEl = target;
      activeGroup = options.group;
      Sortable.dragged = dragEl;
      tapEvt = {
        target: dragEl,
        clientX: (touch || evt).clientX,
        clientY: (touch || evt).clientY
      };
      tapDistanceLeft = tapEvt.clientX - dragRect.left;
      tapDistanceTop = tapEvt.clientY - dragRect.top;
      this._lastX = (touch || evt).clientX;
      this._lastY = (touch || evt).clientY;
      dragEl.style['will-change'] = 'all';

      dragStartFn = function dragStartFn() {
        pluginEvent('delayEnded', _this, {
          evt: evt
        });

        if (Sortable.eventCanceled) {
          _this._onDrop();

          return;
        } // Delayed drag has been triggered
        // we can re-enable the events: touchmove/mousemove


        _this._disableDelayedDragEvents();

        if (!FireFox && _this.nativeDraggable) {
          dragEl.draggable = true;
        } // Bind the events: dragstart/dragend


        _this._triggerDragStart(evt, touch); // Drag start event


        _dispatchEvent({
          sortable: _this,
          name: 'choose',
          originalEvent: evt
        }); // Chosen item


        toggleClass(dragEl, options.chosenClass, true);
      }; // Disable "draggable"


      options.ignore.split(',').forEach(function (criteria) {
        find(dragEl, criteria.trim(), _disableDraggable);
      });
      on(ownerDocument, 'dragover', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'mousemove', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'touchmove', nearestEmptyInsertDetectEvent);
      on(ownerDocument, 'mouseup', _this._onDrop);
      on(ownerDocument, 'touchend', _this._onDrop);
      on(ownerDocument, 'touchcancel', _this._onDrop); // Make dragEl draggable (must be before delay for FireFox)

      if (FireFox && this.nativeDraggable) {
        this.options.touchStartThreshold = 4;
        dragEl.draggable = true;
      }

      pluginEvent('delayStart', this, {
        evt: evt
      }); // Delay is impossible for native DnD in Edge or IE

      if (options.delay && (!options.delayOnTouchOnly || touch) && (!this.nativeDraggable || !(Edge || IE11OrLess))) {
        if (Sortable.eventCanceled) {
          this._onDrop();

          return;
        } // If the user moves the pointer or let go the click or touch
        // before the delay has been reached:
        // disable the delayed drag


        on(ownerDocument, 'mouseup', _this._disableDelayedDrag);
        on(ownerDocument, 'touchend', _this._disableDelayedDrag);
        on(ownerDocument, 'touchcancel', _this._disableDelayedDrag);
        on(ownerDocument, 'mousemove', _this._delayedDragTouchMoveHandler);
        on(ownerDocument, 'touchmove', _this._delayedDragTouchMoveHandler);
        options.supportPointer && on(ownerDocument, 'pointermove', _this._delayedDragTouchMoveHandler);
        _this._dragStartTimer = setTimeout(dragStartFn, options.delay);
      } else {
        dragStartFn();
      }
    }
  },
  _delayedDragTouchMoveHandler: function _delayedDragTouchMoveHandler(
  /** TouchEvent|PointerEvent **/
  e) {
    var touch = e.touches ? e.touches[0] : e;

    if (Math.max(Math.abs(touch.clientX - this._lastX), Math.abs(touch.clientY - this._lastY)) >= Math.floor(this.options.touchStartThreshold / (this.nativeDraggable && window.devicePixelRatio || 1))) {
      this._disableDelayedDrag();
    }
  },
  _disableDelayedDrag: function _disableDelayedDrag() {
    dragEl && _disableDraggable(dragEl);
    clearTimeout(this._dragStartTimer);

    this._disableDelayedDragEvents();
  },
  _disableDelayedDragEvents: function _disableDelayedDragEvents() {
    var ownerDocument = this.el.ownerDocument;
    off(ownerDocument, 'mouseup', this._disableDelayedDrag);
    off(ownerDocument, 'touchend', this._disableDelayedDrag);
    off(ownerDocument, 'touchcancel', this._disableDelayedDrag);
    off(ownerDocument, 'mousemove', this._delayedDragTouchMoveHandler);
    off(ownerDocument, 'touchmove', this._delayedDragTouchMoveHandler);
    off(ownerDocument, 'pointermove', this._delayedDragTouchMoveHandler);
  },
  _triggerDragStart: function _triggerDragStart(
  /** Event */
  evt,
  /** Touch */
  touch) {
    touch = touch || evt.pointerType == 'touch' && evt;

    if (!this.nativeDraggable || touch) {
      if (this.options.supportPointer) {
        on(document, 'pointermove', this._onTouchMove);
      } else if (touch) {
        on(document, 'touchmove', this._onTouchMove);
      } else {
        on(document, 'mousemove', this._onTouchMove);
      }
    } else {
      on(dragEl, 'dragend', this);
      on(rootEl, 'dragstart', this._onDragStart);
    }

    try {
      if (document.selection) {
        // Timeout neccessary for IE9
        _nextTick(function () {
          document.selection.empty();
        });
      } else {
        window.getSelection().removeAllRanges();
      }
    } catch (err) {}
  },
  _dragStarted: function _dragStarted(fallback, evt) {

    awaitingDragStarted = false;

    if (rootEl && dragEl) {
      pluginEvent('dragStarted', this, {
        evt: evt
      });

      if (this.nativeDraggable) {
        on(document, 'dragover', _checkOutsideTargetEl);
      }

      var options = this.options; // Apply effect

      !fallback && toggleClass(dragEl, options.dragClass, false);
      toggleClass(dragEl, options.ghostClass, true);
      Sortable.active = this;
      fallback && this._appendGhost(); // Drag start event

      _dispatchEvent({
        sortable: this,
        name: 'start',
        originalEvent: evt
      });
    } else {
      this._nulling();
    }
  },
  _emulateDragOver: function _emulateDragOver() {
    if (touchEvt) {
      this._lastX = touchEvt.clientX;
      this._lastY = touchEvt.clientY;

      _hideGhostForTarget();

      var target = document.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
      var parent = target;

      while (target && target.shadowRoot) {
        target = target.shadowRoot.elementFromPoint(touchEvt.clientX, touchEvt.clientY);
        if (target === parent) break;
        parent = target;
      }

      dragEl.parentNode[expando]._isOutsideThisEl(target);

      if (parent) {
        do {
          if (parent[expando]) {
            var inserted = void 0;
            inserted = parent[expando]._onDragOver({
              clientX: touchEvt.clientX,
              clientY: touchEvt.clientY,
              target: target,
              rootEl: parent
            });

            if (inserted && !this.options.dragoverBubble) {
              break;
            }
          }

          target = parent; // store last element
        }
        /* jshint boss:true */
        while (parent = parent.parentNode);
      }

      _unhideGhostForTarget();
    }
  },
  _onTouchMove: function _onTouchMove(
  /**TouchEvent*/
  evt) {
    if (tapEvt) {
      var options = this.options,
          fallbackTolerance = options.fallbackTolerance,
          fallbackOffset = options.fallbackOffset,
          touch = evt.touches ? evt.touches[0] : evt,
          ghostMatrix = ghostEl && matrix(ghostEl, true),
          scaleX = ghostEl && ghostMatrix && ghostMatrix.a,
          scaleY = ghostEl && ghostMatrix && ghostMatrix.d,
          relativeScrollOffset = PositionGhostAbsolutely && ghostRelativeParent && getRelativeScrollOffset(ghostRelativeParent),
          dx = (touch.clientX - tapEvt.clientX + fallbackOffset.x) / (scaleX || 1) + (relativeScrollOffset ? relativeScrollOffset[0] - ghostRelativeParentInitialScroll[0] : 0) / (scaleX || 1),
          dy = (touch.clientY - tapEvt.clientY + fallbackOffset.y) / (scaleY || 1) + (relativeScrollOffset ? relativeScrollOffset[1] - ghostRelativeParentInitialScroll[1] : 0) / (scaleY || 1); // only set the status to dragging, when we are actually dragging

      if (!Sortable.active && !awaitingDragStarted) {
        if (fallbackTolerance && Math.max(Math.abs(touch.clientX - this._lastX), Math.abs(touch.clientY - this._lastY)) < fallbackTolerance) {
          return;
        }

        this._onDragStart(evt, true);
      }

      if (ghostEl) {
        if (ghostMatrix) {
          ghostMatrix.e += dx - (lastDx || 0);
          ghostMatrix.f += dy - (lastDy || 0);
        } else {
          ghostMatrix = {
            a: 1,
            b: 0,
            c: 0,
            d: 1,
            e: dx,
            f: dy
          };
        }

        var cssMatrix = "matrix(".concat(ghostMatrix.a, ",").concat(ghostMatrix.b, ",").concat(ghostMatrix.c, ",").concat(ghostMatrix.d, ",").concat(ghostMatrix.e, ",").concat(ghostMatrix.f, ")");
        css(ghostEl, 'webkitTransform', cssMatrix);
        css(ghostEl, 'mozTransform', cssMatrix);
        css(ghostEl, 'msTransform', cssMatrix);
        css(ghostEl, 'transform', cssMatrix);
        lastDx = dx;
        lastDy = dy;
        touchEvt = touch;
      }

      evt.cancelable && evt.preventDefault();
    }
  },
  _appendGhost: function _appendGhost() {
    // Bug if using scale(): https://stackoverflow.com/questions/2637058
    // Not being adjusted for
    if (!ghostEl) {
      var container = this.options.fallbackOnBody ? document.body : rootEl,
          rect = getRect(dragEl, true, PositionGhostAbsolutely, true, container),
          options = this.options; // Position absolutely

      if (PositionGhostAbsolutely) {
        // Get relatively positioned parent
        ghostRelativeParent = container;

        while (css(ghostRelativeParent, 'position') === 'static' && css(ghostRelativeParent, 'transform') === 'none' && ghostRelativeParent !== document) {
          ghostRelativeParent = ghostRelativeParent.parentNode;
        }

        if (ghostRelativeParent !== document.body && ghostRelativeParent !== document.documentElement) {
          if (ghostRelativeParent === document) ghostRelativeParent = getWindowScrollingElement();
          rect.top += ghostRelativeParent.scrollTop;
          rect.left += ghostRelativeParent.scrollLeft;
        } else {
          ghostRelativeParent = getWindowScrollingElement();
        }

        ghostRelativeParentInitialScroll = getRelativeScrollOffset(ghostRelativeParent);
      }

      ghostEl = dragEl.cloneNode(true);
      toggleClass(ghostEl, options.ghostClass, false);
      toggleClass(ghostEl, options.fallbackClass, true);
      toggleClass(ghostEl, options.dragClass, true);
      css(ghostEl, 'transition', '');
      css(ghostEl, 'transform', '');
      css(ghostEl, 'box-sizing', 'border-box');
      css(ghostEl, 'margin', 0);
      css(ghostEl, 'top', rect.top);
      css(ghostEl, 'left', rect.left);
      css(ghostEl, 'width', rect.width);
      css(ghostEl, 'height', rect.height);
      css(ghostEl, 'opacity', '0.8');
      css(ghostEl, 'position', PositionGhostAbsolutely ? 'absolute' : 'fixed');
      css(ghostEl, 'zIndex', '100000');
      css(ghostEl, 'pointerEvents', 'none');
      Sortable.ghost = ghostEl;
      container.appendChild(ghostEl); // Set transform-origin

      css(ghostEl, 'transform-origin', tapDistanceLeft / parseInt(ghostEl.style.width) * 100 + '% ' + tapDistanceTop / parseInt(ghostEl.style.height) * 100 + '%');
    }
  },
  _onDragStart: function _onDragStart(
  /**Event*/
  evt,
  /**boolean*/
  fallback) {
    var _this = this;

    var dataTransfer = evt.dataTransfer;
    var options = _this.options;
    pluginEvent('dragStart', this, {
      evt: evt
    });

    if (Sortable.eventCanceled) {
      this._onDrop();

      return;
    }

    pluginEvent('setupClone', this);

    if (!Sortable.eventCanceled) {
      cloneEl = clone(dragEl);
      cloneEl.removeAttribute("id");
      cloneEl.draggable = false;
      cloneEl.style['will-change'] = '';

      this._hideClone();

      toggleClass(cloneEl, this.options.chosenClass, false);
      Sortable.clone = cloneEl;
    } // #1143: IFrame support workaround


    _this.cloneId = _nextTick(function () {
      pluginEvent('clone', _this);
      if (Sortable.eventCanceled) return;

      if (!_this.options.removeCloneOnHide) {
        rootEl.insertBefore(cloneEl, dragEl);
      }

      _this._hideClone();

      _dispatchEvent({
        sortable: _this,
        name: 'clone'
      });
    });
    !fallback && toggleClass(dragEl, options.dragClass, true); // Set proper drop events

    if (fallback) {
      ignoreNextClick = true;
      _this._loopId = setInterval(_this._emulateDragOver, 50);
    } else {
      // Undo what was set in _prepareDragStart before drag started
      off(document, 'mouseup', _this._onDrop);
      off(document, 'touchend', _this._onDrop);
      off(document, 'touchcancel', _this._onDrop);

      if (dataTransfer) {
        dataTransfer.effectAllowed = 'move';
        options.setData && options.setData.call(_this, dataTransfer, dragEl);
      }

      on(document, 'drop', _this); // #1276 fix:

      css(dragEl, 'transform', 'translateZ(0)');
    }

    awaitingDragStarted = true;
    _this._dragStartId = _nextTick(_this._dragStarted.bind(_this, fallback, evt));
    on(document, 'selectstart', _this);
    moved = true;

    if (Safari) {
      css(document.body, 'user-select', 'none');
    }
  },
  // Returns true - if no further action is needed (either inserted or another condition)
  _onDragOver: function _onDragOver(
  /**Event*/
  evt) {
    var el = this.el,
        target = evt.target,
        dragRect,
        targetRect,
        revert,
        options = this.options,
        group = options.group,
        activeSortable = Sortable.active,
        isOwner = activeGroup === group,
        canSort = options.sort,
        fromSortable = putSortable || activeSortable,
        vertical,
        _this = this,
        completedFired = false;

    if (_silent) return;

    function dragOverEvent(name, extra) {
      pluginEvent(name, _this, _objectSpread2({
        evt: evt,
        isOwner: isOwner,
        axis: vertical ? 'vertical' : 'horizontal',
        revert: revert,
        dragRect: dragRect,
        targetRect: targetRect,
        canSort: canSort,
        fromSortable: fromSortable,
        target: target,
        completed: completed,
        onMove: function onMove(target, after) {
          return _onMove(rootEl, el, dragEl, dragRect, target, getRect(target), evt, after);
        },
        changed: changed
      }, extra));
    } // Capture animation state


    function capture() {
      dragOverEvent('dragOverAnimationCapture');

      _this.captureAnimationState();

      if (_this !== fromSortable) {
        fromSortable.captureAnimationState();
      }
    } // Return invocation when dragEl is inserted (or completed)


    function completed(insertion) {
      dragOverEvent('dragOverCompleted', {
        insertion: insertion
      });

      if (insertion) {
        // Clones must be hidden before folding animation to capture dragRectAbsolute properly
        if (isOwner) {
          activeSortable._hideClone();
        } else {
          activeSortable._showClone(_this);
        }

        if (_this !== fromSortable) {
          // Set ghost class to new sortable's ghost class
          toggleClass(dragEl, putSortable ? putSortable.options.ghostClass : activeSortable.options.ghostClass, false);
          toggleClass(dragEl, options.ghostClass, true);
        }

        if (putSortable !== _this && _this !== Sortable.active) {
          putSortable = _this;
        } else if (_this === Sortable.active && putSortable) {
          putSortable = null;
        } // Animation


        if (fromSortable === _this) {
          _this._ignoreWhileAnimating = target;
        }

        _this.animateAll(function () {
          dragOverEvent('dragOverAnimationComplete');
          _this._ignoreWhileAnimating = null;
        });

        if (_this !== fromSortable) {
          fromSortable.animateAll();
          fromSortable._ignoreWhileAnimating = null;
        }
      } // Null lastTarget if it is not inside a previously swapped element


      if (target === dragEl && !dragEl.animated || target === el && !target.animated) {
        lastTarget = null;
      } // no bubbling and not fallback


      if (!options.dragoverBubble && !evt.rootEl && target !== document) {
        dragEl.parentNode[expando]._isOutsideThisEl(evt.target); // Do not detect for empty insert if already inserted


        !insertion && nearestEmptyInsertDetectEvent(evt);
      }

      !options.dragoverBubble && evt.stopPropagation && evt.stopPropagation();
      return completedFired = true;
    } // Call when dragEl has been inserted


    function changed() {
      newIndex = index(dragEl);
      newDraggableIndex = index(dragEl, options.draggable);

      _dispatchEvent({
        sortable: _this,
        name: 'change',
        toEl: el,
        newIndex: newIndex,
        newDraggableIndex: newDraggableIndex,
        originalEvent: evt
      });
    }

    if (evt.preventDefault !== void 0) {
      evt.cancelable && evt.preventDefault();
    }

    target = closest(target, options.draggable, el, true);
    dragOverEvent('dragOver');
    if (Sortable.eventCanceled) return completedFired;

    if (dragEl.contains(evt.target) || target.animated && target.animatingX && target.animatingY || _this._ignoreWhileAnimating === target) {
      return completed(false);
    }

    ignoreNextClick = false;

    if (activeSortable && !options.disabled && (isOwner ? canSort || (revert = parentEl !== rootEl) // Reverting item into the original list
    : putSortable === this || (this.lastPutMode = activeGroup.checkPull(this, activeSortable, dragEl, evt)) && group.checkPut(this, activeSortable, dragEl, evt))) {
      vertical = this._getDirection(evt, target) === 'vertical';
      dragRect = getRect(dragEl);
      dragOverEvent('dragOverValid');
      if (Sortable.eventCanceled) return completedFired;

      if (revert) {
        parentEl = rootEl; // actualization

        capture();

        this._hideClone();

        dragOverEvent('revert');

        if (!Sortable.eventCanceled) {
          if (nextEl) {
            rootEl.insertBefore(dragEl, nextEl);
          } else {
            rootEl.appendChild(dragEl);
          }
        }

        return completed(true);
      }

      var elLastChild = lastChild(el, options.draggable);

      if (!elLastChild || _ghostIsLast(evt, vertical, this) && !elLastChild.animated) {
        // Insert to end of list
        // If already at end of list: Do not insert
        if (elLastChild === dragEl) {
          return completed(false);
        } // if there is a last element, it is the target


        if (elLastChild && el === evt.target) {
          target = elLastChild;
        }

        if (target) {
          targetRect = getRect(target);
        }

        if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, !!target) !== false) {
          capture();

          if (elLastChild && elLastChild.nextSibling) {
            // the last draggable element is not the last node
            el.insertBefore(dragEl, elLastChild.nextSibling);
          } else {
            el.appendChild(dragEl);
          }

          parentEl = el; // actualization

          changed();
          return completed(true);
        }
      } else if (elLastChild && _ghostIsFirst(evt, vertical, this)) {
        // Insert to start of list
        var firstChild = getChild(el, 0, options, true);

        if (firstChild === dragEl) {
          return completed(false);
        }

        target = firstChild;
        targetRect = getRect(target);

        if (_onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, false) !== false) {
          capture();
          el.insertBefore(dragEl, firstChild);
          parentEl = el; // actualization

          changed();
          return completed(true);
        }
      } else if (target.parentNode === el) {
        targetRect = getRect(target);
        var direction = 0,
            targetBeforeFirstSwap,
            differentLevel = dragEl.parentNode !== el,
            differentRowCol = !_dragElInRowColumn(dragEl.animated && dragEl.toRect || dragRect, target.animated && target.toRect || targetRect, vertical),
            side1 = vertical ? 'top' : 'left',
            scrolledPastTop = isScrolledPast(target, 'top', 'top') || isScrolledPast(dragEl, 'top', 'top'),
            scrollBefore = scrolledPastTop ? scrolledPastTop.scrollTop : void 0;

        if (lastTarget !== target) {
          targetBeforeFirstSwap = targetRect[side1];
          pastFirstInvertThresh = false;
          isCircumstantialInvert = !differentRowCol && options.invertSwap || differentLevel;
        }

        direction = _getSwapDirection(evt, target, targetRect, vertical, differentRowCol ? 1 : options.swapThreshold, options.invertedSwapThreshold == null ? options.swapThreshold : options.invertedSwapThreshold, isCircumstantialInvert, lastTarget === target);
        var sibling;

        if (direction !== 0) {
          // Check if target is beside dragEl in respective direction (ignoring hidden elements)
          var dragIndex = index(dragEl);

          do {
            dragIndex -= direction;
            sibling = parentEl.children[dragIndex];
          } while (sibling && (css(sibling, 'display') === 'none' || sibling === ghostEl));
        } // If dragEl is already beside target: Do not insert


        if (direction === 0 || sibling === target) {
          return completed(false);
        }

        lastTarget = target;
        lastDirection = direction;
        var nextSibling = target.nextElementSibling,
            after = false;
        after = direction === 1;

        var moveVector = _onMove(rootEl, el, dragEl, dragRect, target, targetRect, evt, after);

        if (moveVector !== false) {
          if (moveVector === 1 || moveVector === -1) {
            after = moveVector === 1;
          }

          _silent = true;
          setTimeout(_unsilent, 30);
          capture();

          if (after && !nextSibling) {
            el.appendChild(dragEl);
          } else {
            target.parentNode.insertBefore(dragEl, after ? nextSibling : target);
          } // Undo chrome's scroll adjustment (has no effect on other browsers)


          if (scrolledPastTop) {
            scrollBy(scrolledPastTop, 0, scrollBefore - scrolledPastTop.scrollTop);
          }

          parentEl = dragEl.parentNode; // actualization
          // must be done before animation

          if (targetBeforeFirstSwap !== undefined && !isCircumstantialInvert) {
            targetMoveDistance = Math.abs(targetBeforeFirstSwap - getRect(target)[side1]);
          }

          changed();
          return completed(true);
        }
      }

      if (el.contains(dragEl)) {
        return completed(false);
      }
    }

    return false;
  },
  _ignoreWhileAnimating: null,
  _offMoveEvents: function _offMoveEvents() {
    off(document, 'mousemove', this._onTouchMove);
    off(document, 'touchmove', this._onTouchMove);
    off(document, 'pointermove', this._onTouchMove);
    off(document, 'dragover', nearestEmptyInsertDetectEvent);
    off(document, 'mousemove', nearestEmptyInsertDetectEvent);
    off(document, 'touchmove', nearestEmptyInsertDetectEvent);
  },
  _offUpEvents: function _offUpEvents() {
    var ownerDocument = this.el.ownerDocument;
    off(ownerDocument, 'mouseup', this._onDrop);
    off(ownerDocument, 'touchend', this._onDrop);
    off(ownerDocument, 'pointerup', this._onDrop);
    off(ownerDocument, 'touchcancel', this._onDrop);
    off(document, 'selectstart', this);
  },
  _onDrop: function _onDrop(
  /**Event*/
  evt) {
    var el = this.el,
        options = this.options; // Get the index of the dragged element within its parent

    newIndex = index(dragEl);
    newDraggableIndex = index(dragEl, options.draggable);
    pluginEvent('drop', this, {
      evt: evt
    });
    parentEl = dragEl && dragEl.parentNode; // Get again after plugin event

    newIndex = index(dragEl);
    newDraggableIndex = index(dragEl, options.draggable);

    if (Sortable.eventCanceled) {
      this._nulling();

      return;
    }

    awaitingDragStarted = false;
    isCircumstantialInvert = false;
    pastFirstInvertThresh = false;
    clearInterval(this._loopId);
    clearTimeout(this._dragStartTimer);

    _cancelNextTick(this.cloneId);

    _cancelNextTick(this._dragStartId); // Unbind events


    if (this.nativeDraggable) {
      off(document, 'drop', this);
      off(el, 'dragstart', this._onDragStart);
    }

    this._offMoveEvents();

    this._offUpEvents();

    if (Safari) {
      css(document.body, 'user-select', '');
    }

    css(dragEl, 'transform', '');

    if (evt) {
      if (moved) {
        evt.cancelable && evt.preventDefault();
        !options.dropBubble && evt.stopPropagation();
      }

      ghostEl && ghostEl.parentNode && ghostEl.parentNode.removeChild(ghostEl);

      if (rootEl === parentEl || putSortable && putSortable.lastPutMode !== 'clone') {
        // Remove clone(s)
        cloneEl && cloneEl.parentNode && cloneEl.parentNode.removeChild(cloneEl);
      }

      if (dragEl) {
        if (this.nativeDraggable) {
          off(dragEl, 'dragend', this);
        }

        _disableDraggable(dragEl);

        dragEl.style['will-change'] = ''; // Remove classes
        // ghostClass is added in dragStarted

        if (moved && !awaitingDragStarted) {
          toggleClass(dragEl, putSortable ? putSortable.options.ghostClass : this.options.ghostClass, false);
        }

        toggleClass(dragEl, this.options.chosenClass, false); // Drag stop event

        _dispatchEvent({
          sortable: this,
          name: 'unchoose',
          toEl: parentEl,
          newIndex: null,
          newDraggableIndex: null,
          originalEvent: evt
        });

        if (rootEl !== parentEl) {
          if (newIndex >= 0) {
            // Add event
            _dispatchEvent({
              rootEl: parentEl,
              name: 'add',
              toEl: parentEl,
              fromEl: rootEl,
              originalEvent: evt
            }); // Remove event


            _dispatchEvent({
              sortable: this,
              name: 'remove',
              toEl: parentEl,
              originalEvent: evt
            }); // drag from one list and drop into another


            _dispatchEvent({
              rootEl: parentEl,
              name: 'sort',
              toEl: parentEl,
              fromEl: rootEl,
              originalEvent: evt
            });

            _dispatchEvent({
              sortable: this,
              name: 'sort',
              toEl: parentEl,
              originalEvent: evt
            });
          }

          putSortable && putSortable.save();
        } else {
          if (newIndex !== oldIndex) {
            if (newIndex >= 0) {
              // drag & drop within the same list
              _dispatchEvent({
                sortable: this,
                name: 'update',
                toEl: parentEl,
                originalEvent: evt
              });

              _dispatchEvent({
                sortable: this,
                name: 'sort',
                toEl: parentEl,
                originalEvent: evt
              });
            }
          }
        }

        if (Sortable.active) {
          /* jshint eqnull:true */
          if (newIndex == null || newIndex === -1) {
            newIndex = oldIndex;
            newDraggableIndex = oldDraggableIndex;
          }

          _dispatchEvent({
            sortable: this,
            name: 'end',
            toEl: parentEl,
            originalEvent: evt
          }); // Save sorting


          this.save();
        }
      }
    }

    this._nulling();
  },
  _nulling: function _nulling() {
    pluginEvent('nulling', this);
    rootEl = dragEl = parentEl = ghostEl = nextEl = cloneEl = lastDownEl = cloneHidden = tapEvt = touchEvt = moved = newIndex = newDraggableIndex = oldIndex = oldDraggableIndex = lastTarget = lastDirection = putSortable = activeGroup = Sortable.dragged = Sortable.ghost = Sortable.clone = Sortable.active = null;
    savedInputChecked.forEach(function (el) {
      el.checked = true;
    });
    savedInputChecked.length = lastDx = lastDy = 0;
  },
  handleEvent: function handleEvent(
  /**Event*/
  evt) {
    switch (evt.type) {
      case 'drop':
      case 'dragend':
        this._onDrop(evt);

        break;

      case 'dragenter':
      case 'dragover':
        if (dragEl) {
          this._onDragOver(evt);

          _globalDragOver(evt);
        }

        break;

      case 'selectstart':
        evt.preventDefault();
        break;
    }
  },

  /**
   * Serializes the item into an array of string.
   * @returns {String[]}
   */
  toArray: function toArray() {
    var order = [],
        el,
        children = this.el.children,
        i = 0,
        n = children.length,
        options = this.options;

    for (; i < n; i++) {
      el = children[i];

      if (closest(el, options.draggable, this.el, false)) {
        order.push(el.getAttribute(options.dataIdAttr) || _generateId(el));
      }
    }

    return order;
  },

  /**
   * Sorts the elements according to the array.
   * @param  {String[]}  order  order of the items
   */
  sort: function sort(order, useAnimation) {
    var items = {},
        rootEl = this.el;
    this.toArray().forEach(function (id, i) {
      var el = rootEl.children[i];

      if (closest(el, this.options.draggable, rootEl, false)) {
        items[id] = el;
      }
    }, this);
    useAnimation && this.captureAnimationState();
    order.forEach(function (id) {
      if (items[id]) {
        rootEl.removeChild(items[id]);
        rootEl.appendChild(items[id]);
      }
    });
    useAnimation && this.animateAll();
  },

  /**
   * Save the current sorting
   */
  save: function save() {
    var store = this.options.store;
    store && store.set && store.set(this);
  },

  /**
   * For each element in the set, get the first element that matches the selector by testing the element itself and traversing up through its ancestors in the DOM tree.
   * @param   {HTMLElement}  el
   * @param   {String}       [selector]  default: `options.draggable`
   * @returns {HTMLElement|null}
   */
  closest: function closest$1(el, selector) {
    return closest(el, selector || this.options.draggable, this.el, false);
  },

  /**
   * Set/get option
   * @param   {string} name
   * @param   {*}      [value]
   * @returns {*}
   */
  option: function option(name, value) {
    var options = this.options;

    if (value === void 0) {
      return options[name];
    } else {
      var modifiedValue = PluginManager.modifyOption(this, name, value);

      if (typeof modifiedValue !== 'undefined') {
        options[name] = modifiedValue;
      } else {
        options[name] = value;
      }

      if (name === 'group') {
        _prepareGroup(options);
      }
    }
  },

  /**
   * Destroy
   */
  destroy: function destroy() {
    pluginEvent('destroy', this);
    var el = this.el;
    el[expando] = null;
    off(el, 'mousedown', this._onTapStart);
    off(el, 'touchstart', this._onTapStart);
    off(el, 'pointerdown', this._onTapStart);

    if (this.nativeDraggable) {
      off(el, 'dragover', this);
      off(el, 'dragenter', this);
    } // Remove draggable attributes


    Array.prototype.forEach.call(el.querySelectorAll('[draggable]'), function (el) {
      el.removeAttribute('draggable');
    });

    this._onDrop();

    this._disableDelayedDragEvents();

    sortables.splice(sortables.indexOf(this.el), 1);
    this.el = el = null;
  },
  _hideClone: function _hideClone() {
    if (!cloneHidden) {
      pluginEvent('hideClone', this);
      if (Sortable.eventCanceled) return;
      css(cloneEl, 'display', 'none');

      if (this.options.removeCloneOnHide && cloneEl.parentNode) {
        cloneEl.parentNode.removeChild(cloneEl);
      }

      cloneHidden = true;
    }
  },
  _showClone: function _showClone(putSortable) {
    if (putSortable.lastPutMode !== 'clone') {
      this._hideClone();

      return;
    }

    if (cloneHidden) {
      pluginEvent('showClone', this);
      if (Sortable.eventCanceled) return; // show clone at dragEl or original position

      if (dragEl.parentNode == rootEl && !this.options.group.revertClone) {
        rootEl.insertBefore(cloneEl, dragEl);
      } else if (nextEl) {
        rootEl.insertBefore(cloneEl, nextEl);
      } else {
        rootEl.appendChild(cloneEl);
      }

      if (this.options.group.revertClone) {
        this.animate(dragEl, cloneEl);
      }

      css(cloneEl, 'display', '');
      cloneHidden = false;
    }
  }
};

function _globalDragOver(
/**Event*/
evt) {
  if (evt.dataTransfer) {
    evt.dataTransfer.dropEffect = 'move';
  }

  evt.cancelable && evt.preventDefault();
}

function _onMove(fromEl, toEl, dragEl, dragRect, targetEl, targetRect, originalEvent, willInsertAfter) {
  var evt,
      sortable = fromEl[expando],
      onMoveFn = sortable.options.onMove,
      retVal; // Support for new CustomEvent feature

  if (window.CustomEvent && !IE11OrLess && !Edge) {
    evt = new CustomEvent('move', {
      bubbles: true,
      cancelable: true
    });
  } else {
    evt = document.createEvent('Event');
    evt.initEvent('move', true, true);
  }

  evt.to = toEl;
  evt.from = fromEl;
  evt.dragged = dragEl;
  evt.draggedRect = dragRect;
  evt.related = targetEl || toEl;
  evt.relatedRect = targetRect || getRect(toEl);
  evt.willInsertAfter = willInsertAfter;
  evt.originalEvent = originalEvent;
  fromEl.dispatchEvent(evt);

  if (onMoveFn) {
    retVal = onMoveFn.call(sortable, evt, originalEvent);
  }

  return retVal;
}

function _disableDraggable(el) {
  el.draggable = false;
}

function _unsilent() {
  _silent = false;
}

function _ghostIsFirst(evt, vertical, sortable) {
  var rect = getRect(getChild(sortable.el, 0, sortable.options, true));
  var spacer = 10;
  return vertical ? evt.clientX < rect.left - spacer || evt.clientY < rect.top && evt.clientX < rect.right : evt.clientY < rect.top - spacer || evt.clientY < rect.bottom && evt.clientX < rect.left;
}

function _ghostIsLast(evt, vertical, sortable) {
  var rect = getRect(lastChild(sortable.el, sortable.options.draggable));
  var spacer = 10;
  return vertical ? evt.clientX > rect.right + spacer || evt.clientX <= rect.right && evt.clientY > rect.bottom && evt.clientX >= rect.left : evt.clientX > rect.right && evt.clientY > rect.top || evt.clientX <= rect.right && evt.clientY > rect.bottom + spacer;
}

function _getSwapDirection(evt, target, targetRect, vertical, swapThreshold, invertedSwapThreshold, invertSwap, isLastTarget) {
  var mouseOnAxis = vertical ? evt.clientY : evt.clientX,
      targetLength = vertical ? targetRect.height : targetRect.width,
      targetS1 = vertical ? targetRect.top : targetRect.left,
      targetS2 = vertical ? targetRect.bottom : targetRect.right,
      invert = false;

  if (!invertSwap) {
    // Never invert or create dragEl shadow when target movemenet causes mouse to move past the end of regular swapThreshold
    if (isLastTarget && targetMoveDistance < targetLength * swapThreshold) {
      // multiplied only by swapThreshold because mouse will already be inside target by (1 - threshold) * targetLength / 2
      // check if past first invert threshold on side opposite of lastDirection
      if (!pastFirstInvertThresh && (lastDirection === 1 ? mouseOnAxis > targetS1 + targetLength * invertedSwapThreshold / 2 : mouseOnAxis < targetS2 - targetLength * invertedSwapThreshold / 2)) {
        // past first invert threshold, do not restrict inverted threshold to dragEl shadow
        pastFirstInvertThresh = true;
      }

      if (!pastFirstInvertThresh) {
        // dragEl shadow (target move distance shadow)
        if (lastDirection === 1 ? mouseOnAxis < targetS1 + targetMoveDistance // over dragEl shadow
        : mouseOnAxis > targetS2 - targetMoveDistance) {
          return -lastDirection;
        }
      } else {
        invert = true;
      }
    } else {
      // Regular
      if (mouseOnAxis > targetS1 + targetLength * (1 - swapThreshold) / 2 && mouseOnAxis < targetS2 - targetLength * (1 - swapThreshold) / 2) {
        return _getInsertDirection(target);
      }
    }
  }

  invert = invert || invertSwap;

  if (invert) {
    // Invert of regular
    if (mouseOnAxis < targetS1 + targetLength * invertedSwapThreshold / 2 || mouseOnAxis > targetS2 - targetLength * invertedSwapThreshold / 2) {
      return mouseOnAxis > targetS1 + targetLength / 2 ? 1 : -1;
    }
  }

  return 0;
}
/**
 * Gets the direction dragEl must be swapped relative to target in order to make it
 * seem that dragEl has been "inserted" into that element's position
 * @param  {HTMLElement} target       The target whose position dragEl is being inserted at
 * @return {Number}                   Direction dragEl must be swapped
 */


function _getInsertDirection(target) {
  if (index(dragEl) < index(target)) {
    return 1;
  } else {
    return -1;
  }
}
/**
 * Generate id
 * @param   {HTMLElement} el
 * @returns {String}
 * @private
 */


function _generateId(el) {
  var str = el.tagName + el.className + el.src + el.href + el.textContent,
      i = str.length,
      sum = 0;

  while (i--) {
    sum += str.charCodeAt(i);
  }

  return sum.toString(36);
}

function _saveInputCheckedState(root) {
  savedInputChecked.length = 0;
  var inputs = root.getElementsByTagName('input');
  var idx = inputs.length;

  while (idx--) {
    var el = inputs[idx];
    el.checked && savedInputChecked.push(el);
  }
}

function _nextTick(fn) {
  return setTimeout(fn, 0);
}

function _cancelNextTick(id) {
  return clearTimeout(id);
} // Fixed #973:


if (documentExists) {
  on(document, 'touchmove', function (evt) {
    if ((Sortable.active || awaitingDragStarted) && evt.cancelable) {
      evt.preventDefault();
    }
  });
} // Export utils


Sortable.utils = {
  on: on,
  off: off,
  css: css,
  find: find,
  is: function is(el, selector) {
    return !!closest(el, selector, el, false);
  },
  extend: extend,
  throttle: throttle,
  closest: closest,
  toggleClass: toggleClass,
  clone: clone,
  index: index,
  nextTick: _nextTick,
  cancelNextTick: _cancelNextTick,
  detectDirection: _detectDirection,
  getChild: getChild
};
/**
 * Get the Sortable instance of an element
 * @param  {HTMLElement} element The element
 * @return {Sortable|undefined}         The instance of Sortable
 */

Sortable.get = function (element) {
  return element[expando];
};
/**
 * Mount a plugin to Sortable
 * @param  {...SortablePlugin|SortablePlugin[]} plugins       Plugins being mounted
 */


Sortable.mount = function () {
  for (var _len = arguments.length, plugins = new Array(_len), _key = 0; _key < _len; _key++) {
    plugins[_key] = arguments[_key];
  }

  if (plugins[0].constructor === Array) plugins = plugins[0];
  plugins.forEach(function (plugin) {
    if (!plugin.prototype || !plugin.prototype.constructor) {
      throw "Sortable: Mounted plugin must be a constructor function, not ".concat({}.toString.call(plugin));
    }

    if (plugin.utils) Sortable.utils = _objectSpread2(_objectSpread2({}, Sortable.utils), plugin.utils);
    PluginManager.mount(plugin);
  });
};
/**
 * Create sortable instance
 * @param {HTMLElement}  el
 * @param {Object}      [options]
 */


Sortable.create = function (el, options) {
  return new Sortable(el, options);
}; // Export


Sortable.version = version;

var autoScrolls = [],
    scrollEl,
    scrollRootEl,
    scrolling = false,
    lastAutoScrollX,
    lastAutoScrollY,
    touchEvt$1,
    pointerElemChangedInterval;

function AutoScrollPlugin() {
  function AutoScroll() {
    this.defaults = {
      scroll: true,
      forceAutoScrollFallback: false,
      scrollSensitivity: 30,
      scrollSpeed: 10,
      bubbleScroll: true
    }; // Bind all private methods

    for (var fn in this) {
      if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
        this[fn] = this[fn].bind(this);
      }
    }
  }

  AutoScroll.prototype = {
    dragStarted: function dragStarted(_ref) {
      var originalEvent = _ref.originalEvent;

      if (this.sortable.nativeDraggable) {
        on(document, 'dragover', this._handleAutoScroll);
      } else {
        if (this.options.supportPointer) {
          on(document, 'pointermove', this._handleFallbackAutoScroll);
        } else if (originalEvent.touches) {
          on(document, 'touchmove', this._handleFallbackAutoScroll);
        } else {
          on(document, 'mousemove', this._handleFallbackAutoScroll);
        }
      }
    },
    dragOverCompleted: function dragOverCompleted(_ref2) {
      var originalEvent = _ref2.originalEvent;

      // For when bubbling is canceled and using fallback (fallback 'touchmove' always reached)
      if (!this.options.dragOverBubble && !originalEvent.rootEl) {
        this._handleAutoScroll(originalEvent);
      }
    },
    drop: function drop() {
      if (this.sortable.nativeDraggable) {
        off(document, 'dragover', this._handleAutoScroll);
      } else {
        off(document, 'pointermove', this._handleFallbackAutoScroll);
        off(document, 'touchmove', this._handleFallbackAutoScroll);
        off(document, 'mousemove', this._handleFallbackAutoScroll);
      }

      clearPointerElemChangedInterval();
      clearAutoScrolls();
      cancelThrottle();
    },
    nulling: function nulling() {
      touchEvt$1 = scrollRootEl = scrollEl = scrolling = pointerElemChangedInterval = lastAutoScrollX = lastAutoScrollY = null;
      autoScrolls.length = 0;
    },
    _handleFallbackAutoScroll: function _handleFallbackAutoScroll(evt) {
      this._handleAutoScroll(evt, true);
    },
    _handleAutoScroll: function _handleAutoScroll(evt, fallback) {
      var _this = this;

      var x = (evt.touches ? evt.touches[0] : evt).clientX,
          y = (evt.touches ? evt.touches[0] : evt).clientY,
          elem = document.elementFromPoint(x, y);
      touchEvt$1 = evt; // IE does not seem to have native autoscroll,
      // Edge's autoscroll seems too conditional,
      // MACOS Safari does not have autoscroll,
      // Firefox and Chrome are good

      if (fallback || this.options.forceAutoScrollFallback || Edge || IE11OrLess || Safari) {
        autoScroll(evt, this.options, elem, fallback); // Listener for pointer element change

        var ogElemScroller = getParentAutoScrollElement(elem, true);

        if (scrolling && (!pointerElemChangedInterval || x !== lastAutoScrollX || y !== lastAutoScrollY)) {
          pointerElemChangedInterval && clearPointerElemChangedInterval(); // Detect for pointer elem change, emulating native DnD behaviour

          pointerElemChangedInterval = setInterval(function () {
            var newElem = getParentAutoScrollElement(document.elementFromPoint(x, y), true);

            if (newElem !== ogElemScroller) {
              ogElemScroller = newElem;
              clearAutoScrolls();
            }

            autoScroll(evt, _this.options, newElem, fallback);
          }, 10);
          lastAutoScrollX = x;
          lastAutoScrollY = y;
        }
      } else {
        // if DnD is enabled (and browser has good autoscrolling), first autoscroll will already scroll, so get parent autoscroll of first autoscroll
        if (!this.options.bubbleScroll || getParentAutoScrollElement(elem, true) === getWindowScrollingElement()) {
          clearAutoScrolls();
          return;
        }

        autoScroll(evt, this.options, getParentAutoScrollElement(elem, false), false);
      }
    }
  };
  return _extends(AutoScroll, {
    pluginName: 'scroll',
    initializeByDefault: true
  });
}

function clearAutoScrolls() {
  autoScrolls.forEach(function (autoScroll) {
    clearInterval(autoScroll.pid);
  });
  autoScrolls = [];
}

function clearPointerElemChangedInterval() {
  clearInterval(pointerElemChangedInterval);
}

var autoScroll = throttle(function (evt, options, rootEl, isFallback) {
  // Bug: https://bugzilla.mozilla.org/show_bug.cgi?id=505521
  if (!options.scroll) return;
  var x = (evt.touches ? evt.touches[0] : evt).clientX,
      y = (evt.touches ? evt.touches[0] : evt).clientY,
      sens = options.scrollSensitivity,
      speed = options.scrollSpeed,
      winScroller = getWindowScrollingElement();
  var scrollThisInstance = false,
      scrollCustomFn; // New scroll root, set scrollEl

  if (scrollRootEl !== rootEl) {
    scrollRootEl = rootEl;
    clearAutoScrolls();
    scrollEl = options.scroll;
    scrollCustomFn = options.scrollFn;

    if (scrollEl === true) {
      scrollEl = getParentAutoScrollElement(rootEl, true);
    }
  }

  var layersOut = 0;
  var currentParent = scrollEl;

  do {
    var el = currentParent,
        rect = getRect(el),
        top = rect.top,
        bottom = rect.bottom,
        left = rect.left,
        right = rect.right,
        width = rect.width,
        height = rect.height,
        canScrollX = void 0,
        canScrollY = void 0,
        scrollWidth = el.scrollWidth,
        scrollHeight = el.scrollHeight,
        elCSS = css(el),
        scrollPosX = el.scrollLeft,
        scrollPosY = el.scrollTop;

    if (el === winScroller) {
      canScrollX = width < scrollWidth && (elCSS.overflowX === 'auto' || elCSS.overflowX === 'scroll' || elCSS.overflowX === 'visible');
      canScrollY = height < scrollHeight && (elCSS.overflowY === 'auto' || elCSS.overflowY === 'scroll' || elCSS.overflowY === 'visible');
    } else {
      canScrollX = width < scrollWidth && (elCSS.overflowX === 'auto' || elCSS.overflowX === 'scroll');
      canScrollY = height < scrollHeight && (elCSS.overflowY === 'auto' || elCSS.overflowY === 'scroll');
    }

    var vx = canScrollX && (Math.abs(right - x) <= sens && scrollPosX + width < scrollWidth) - (Math.abs(left - x) <= sens && !!scrollPosX);
    var vy = canScrollY && (Math.abs(bottom - y) <= sens && scrollPosY + height < scrollHeight) - (Math.abs(top - y) <= sens && !!scrollPosY);

    if (!autoScrolls[layersOut]) {
      for (var i = 0; i <= layersOut; i++) {
        if (!autoScrolls[i]) {
          autoScrolls[i] = {};
        }
      }
    }

    if (autoScrolls[layersOut].vx != vx || autoScrolls[layersOut].vy != vy || autoScrolls[layersOut].el !== el) {
      autoScrolls[layersOut].el = el;
      autoScrolls[layersOut].vx = vx;
      autoScrolls[layersOut].vy = vy;
      clearInterval(autoScrolls[layersOut].pid);

      if (vx != 0 || vy != 0) {
        scrollThisInstance = true;
        /* jshint loopfunc:true */

        autoScrolls[layersOut].pid = setInterval(function () {
          // emulate drag over during autoscroll (fallback), emulating native DnD behaviour
          if (isFallback && this.layer === 0) {
            Sortable.active._onTouchMove(touchEvt$1); // To move ghost if it is positioned absolutely

          }

          var scrollOffsetY = autoScrolls[this.layer].vy ? autoScrolls[this.layer].vy * speed : 0;
          var scrollOffsetX = autoScrolls[this.layer].vx ? autoScrolls[this.layer].vx * speed : 0;

          if (typeof scrollCustomFn === 'function') {
            if (scrollCustomFn.call(Sortable.dragged.parentNode[expando], scrollOffsetX, scrollOffsetY, evt, touchEvt$1, autoScrolls[this.layer].el) !== 'continue') {
              return;
            }
          }

          scrollBy(autoScrolls[this.layer].el, scrollOffsetX, scrollOffsetY);
        }.bind({
          layer: layersOut
        }), 24);
      }
    }

    layersOut++;
  } while (options.bubbleScroll && currentParent !== winScroller && (currentParent = getParentAutoScrollElement(currentParent, false)));

  scrolling = scrollThisInstance; // in case another function catches scrolling as false in between when it is not
}, 30);

var drop = function drop(_ref) {
  var originalEvent = _ref.originalEvent,
      putSortable = _ref.putSortable,
      dragEl = _ref.dragEl,
      activeSortable = _ref.activeSortable,
      dispatchSortableEvent = _ref.dispatchSortableEvent,
      hideGhostForTarget = _ref.hideGhostForTarget,
      unhideGhostForTarget = _ref.unhideGhostForTarget;
  if (!originalEvent) return;
  var toSortable = putSortable || activeSortable;
  hideGhostForTarget();
  var touch = originalEvent.changedTouches && originalEvent.changedTouches.length ? originalEvent.changedTouches[0] : originalEvent;
  var target = document.elementFromPoint(touch.clientX, touch.clientY);
  unhideGhostForTarget();

  if (toSortable && !toSortable.el.contains(target)) {
    dispatchSortableEvent('spill');
    this.onSpill({
      dragEl: dragEl,
      putSortable: putSortable
    });
  }
};

function Revert() {}

Revert.prototype = {
  startIndex: null,
  dragStart: function dragStart(_ref2) {
    var oldDraggableIndex = _ref2.oldDraggableIndex;
    this.startIndex = oldDraggableIndex;
  },
  onSpill: function onSpill(_ref3) {
    var dragEl = _ref3.dragEl,
        putSortable = _ref3.putSortable;
    this.sortable.captureAnimationState();

    if (putSortable) {
      putSortable.captureAnimationState();
    }

    var nextSibling = getChild(this.sortable.el, this.startIndex, this.options);

    if (nextSibling) {
      this.sortable.el.insertBefore(dragEl, nextSibling);
    } else {
      this.sortable.el.appendChild(dragEl);
    }

    this.sortable.animateAll();

    if (putSortable) {
      putSortable.animateAll();
    }
  },
  drop: drop
};

_extends(Revert, {
  pluginName: 'revertOnSpill'
});

function Remove() {}

Remove.prototype = {
  onSpill: function onSpill(_ref4) {
    var dragEl = _ref4.dragEl,
        putSortable = _ref4.putSortable;
    var parentSortable = putSortable || this.sortable;
    parentSortable.captureAnimationState();
    dragEl.parentNode && dragEl.parentNode.removeChild(dragEl);
    parentSortable.animateAll();
  },
  drop: drop
};

_extends(Remove, {
  pluginName: 'removeOnSpill'
});

var lastSwapEl;

function SwapPlugin() {
  function Swap() {
    this.defaults = {
      swapClass: 'sortable-swap-highlight'
    };
  }

  Swap.prototype = {
    dragStart: function dragStart(_ref) {
      var dragEl = _ref.dragEl;
      lastSwapEl = dragEl;
    },
    dragOverValid: function dragOverValid(_ref2) {
      var completed = _ref2.completed,
          target = _ref2.target,
          onMove = _ref2.onMove,
          activeSortable = _ref2.activeSortable,
          changed = _ref2.changed,
          cancel = _ref2.cancel;
      if (!activeSortable.options.swap) return;
      var el = this.sortable.el,
          options = this.options;

      if (target && target !== el) {
        var prevSwapEl = lastSwapEl;

        if (onMove(target) !== false) {
          toggleClass(target, options.swapClass, true);
          lastSwapEl = target;
        } else {
          lastSwapEl = null;
        }

        if (prevSwapEl && prevSwapEl !== lastSwapEl) {
          toggleClass(prevSwapEl, options.swapClass, false);
        }
      }

      changed();
      completed(true);
      cancel();
    },
    drop: function drop(_ref3) {
      var activeSortable = _ref3.activeSortable,
          putSortable = _ref3.putSortable,
          dragEl = _ref3.dragEl;
      var toSortable = putSortable || this.sortable;
      var options = this.options;
      lastSwapEl && toggleClass(lastSwapEl, options.swapClass, false);

      if (lastSwapEl && (options.swap || putSortable && putSortable.options.swap)) {
        if (dragEl !== lastSwapEl) {
          toSortable.captureAnimationState();
          if (toSortable !== activeSortable) activeSortable.captureAnimationState();
          swapNodes(dragEl, lastSwapEl);
          toSortable.animateAll();
          if (toSortable !== activeSortable) activeSortable.animateAll();
        }
      }
    },
    nulling: function nulling() {
      lastSwapEl = null;
    }
  };
  return _extends(Swap, {
    pluginName: 'swap',
    eventProperties: function eventProperties() {
      return {
        swapItem: lastSwapEl
      };
    }
  });
}

function swapNodes(n1, n2) {
  var p1 = n1.parentNode,
      p2 = n2.parentNode,
      i1,
      i2;
  if (!p1 || !p2 || p1.isEqualNode(n2) || p2.isEqualNode(n1)) return;
  i1 = index(n1);
  i2 = index(n2);

  if (p1.isEqualNode(p2) && i1 < i2) {
    i2++;
  }

  p1.insertBefore(n2, p1.children[i1]);
  p2.insertBefore(n1, p2.children[i2]);
}

var multiDragElements = [],
    multiDragClones = [],
    lastMultiDragSelect,
    // for selection with modifier key down (SHIFT)
multiDragSortable,
    initialFolding = false,
    // Initial multi-drag fold when drag started
folding = false,
    // Folding any other time
dragStarted = false,
    dragEl$1,
    clonesFromRect,
    clonesHidden;

function MultiDragPlugin() {
  function MultiDrag(sortable) {
    // Bind all private methods
    for (var fn in this) {
      if (fn.charAt(0) === '_' && typeof this[fn] === 'function') {
        this[fn] = this[fn].bind(this);
      }
    }

    if (!sortable.options.avoidImplicitDeselect) {
      if (sortable.options.supportPointer) {
        on(document, 'pointerup', this._deselectMultiDrag);
      } else {
        on(document, 'mouseup', this._deselectMultiDrag);
        on(document, 'touchend', this._deselectMultiDrag);
      }
    }

    on(document, 'keydown', this._checkKeyDown);
    on(document, 'keyup', this._checkKeyUp);
    this.defaults = {
      selectedClass: 'sortable-selected',
      multiDragKey: null,
      avoidImplicitDeselect: false,
      setData: function setData(dataTransfer, dragEl) {
        var data = '';

        if (multiDragElements.length && multiDragSortable === sortable) {
          multiDragElements.forEach(function (multiDragElement, i) {
            data += (!i ? '' : ', ') + multiDragElement.textContent;
          });
        } else {
          data = dragEl.textContent;
        }

        dataTransfer.setData('Text', data);
      }
    };
  }

  MultiDrag.prototype = {
    multiDragKeyDown: false,
    isMultiDrag: false,
    delayStartGlobal: function delayStartGlobal(_ref) {
      var dragged = _ref.dragEl;
      dragEl$1 = dragged;
    },
    delayEnded: function delayEnded() {
      this.isMultiDrag = ~multiDragElements.indexOf(dragEl$1);
    },
    setupClone: function setupClone(_ref2) {
      var sortable = _ref2.sortable,
          cancel = _ref2.cancel;
      if (!this.isMultiDrag) return;

      for (var i = 0; i < multiDragElements.length; i++) {
        multiDragClones.push(clone(multiDragElements[i]));
        multiDragClones[i].sortableIndex = multiDragElements[i].sortableIndex;
        multiDragClones[i].draggable = false;
        multiDragClones[i].style['will-change'] = '';
        toggleClass(multiDragClones[i], this.options.selectedClass, false);
        multiDragElements[i] === dragEl$1 && toggleClass(multiDragClones[i], this.options.chosenClass, false);
      }

      sortable._hideClone();

      cancel();
    },
    clone: function clone(_ref3) {
      var sortable = _ref3.sortable,
          rootEl = _ref3.rootEl,
          dispatchSortableEvent = _ref3.dispatchSortableEvent,
          cancel = _ref3.cancel;
      if (!this.isMultiDrag) return;

      if (!this.options.removeCloneOnHide) {
        if (multiDragElements.length && multiDragSortable === sortable) {
          insertMultiDragClones(true, rootEl);
          dispatchSortableEvent('clone');
          cancel();
        }
      }
    },
    showClone: function showClone(_ref4) {
      var cloneNowShown = _ref4.cloneNowShown,
          rootEl = _ref4.rootEl,
          cancel = _ref4.cancel;
      if (!this.isMultiDrag) return;
      insertMultiDragClones(false, rootEl);
      multiDragClones.forEach(function (clone) {
        css(clone, 'display', '');
      });
      cloneNowShown();
      clonesHidden = false;
      cancel();
    },
    hideClone: function hideClone(_ref5) {
      var _this = this;

      var sortable = _ref5.sortable,
          cloneNowHidden = _ref5.cloneNowHidden,
          cancel = _ref5.cancel;
      if (!this.isMultiDrag) return;
      multiDragClones.forEach(function (clone) {
        css(clone, 'display', 'none');

        if (_this.options.removeCloneOnHide && clone.parentNode) {
          clone.parentNode.removeChild(clone);
        }
      });
      cloneNowHidden();
      clonesHidden = true;
      cancel();
    },
    dragStartGlobal: function dragStartGlobal(_ref6) {
      var sortable = _ref6.sortable;

      if (!this.isMultiDrag && multiDragSortable) {
        multiDragSortable.multiDrag._deselectMultiDrag();
      }

      multiDragElements.forEach(function (multiDragElement) {
        multiDragElement.sortableIndex = index(multiDragElement);
      }); // Sort multi-drag elements

      multiDragElements = multiDragElements.sort(function (a, b) {
        return a.sortableIndex - b.sortableIndex;
      });
      dragStarted = true;
    },
    dragStarted: function dragStarted(_ref7) {
      var _this2 = this;

      var sortable = _ref7.sortable;
      if (!this.isMultiDrag) return;

      if (this.options.sort) {
        // Capture rects,
        // hide multi drag elements (by positioning them absolute),
        // set multi drag elements rects to dragRect,
        // show multi drag elements,
        // animate to rects,
        // unset rects & remove from DOM
        sortable.captureAnimationState();

        if (this.options.animation) {
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            css(multiDragElement, 'position', 'absolute');
          });
          var dragRect = getRect(dragEl$1, false, true, true);
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            setRect(multiDragElement, dragRect);
          });
          folding = true;
          initialFolding = true;
        }
      }

      sortable.animateAll(function () {
        folding = false;
        initialFolding = false;

        if (_this2.options.animation) {
          multiDragElements.forEach(function (multiDragElement) {
            unsetRect(multiDragElement);
          });
        } // Remove all auxiliary multidrag items from el, if sorting enabled


        if (_this2.options.sort) {
          removeMultiDragElements();
        }
      });
    },
    dragOver: function dragOver(_ref8) {
      var target = _ref8.target,
          completed = _ref8.completed,
          cancel = _ref8.cancel;

      if (folding && ~multiDragElements.indexOf(target)) {
        completed(false);
        cancel();
      }
    },
    revert: function revert(_ref9) {
      var fromSortable = _ref9.fromSortable,
          rootEl = _ref9.rootEl,
          sortable = _ref9.sortable,
          dragRect = _ref9.dragRect;

      if (multiDragElements.length > 1) {
        // Setup unfold animation
        multiDragElements.forEach(function (multiDragElement) {
          sortable.addAnimationState({
            target: multiDragElement,
            rect: folding ? getRect(multiDragElement) : dragRect
          });
          unsetRect(multiDragElement);
          multiDragElement.fromRect = dragRect;
          fromSortable.removeAnimationState(multiDragElement);
        });
        folding = false;
        insertMultiDragElements(!this.options.removeCloneOnHide, rootEl);
      }
    },
    dragOverCompleted: function dragOverCompleted(_ref10) {
      var sortable = _ref10.sortable,
          isOwner = _ref10.isOwner,
          insertion = _ref10.insertion,
          activeSortable = _ref10.activeSortable,
          parentEl = _ref10.parentEl,
          putSortable = _ref10.putSortable;
      var options = this.options;

      if (insertion) {
        // Clones must be hidden before folding animation to capture dragRectAbsolute properly
        if (isOwner) {
          activeSortable._hideClone();
        }

        initialFolding = false; // If leaving sort:false root, or already folding - Fold to new location

        if (options.animation && multiDragElements.length > 1 && (folding || !isOwner && !activeSortable.options.sort && !putSortable)) {
          // Fold: Set all multi drag elements's rects to dragEl's rect when multi-drag elements are invisible
          var dragRectAbsolute = getRect(dragEl$1, false, true, true);
          multiDragElements.forEach(function (multiDragElement) {
            if (multiDragElement === dragEl$1) return;
            setRect(multiDragElement, dragRectAbsolute); // Move element(s) to end of parentEl so that it does not interfere with multi-drag clones insertion if they are inserted
            // while folding, and so that we can capture them again because old sortable will no longer be fromSortable

            parentEl.appendChild(multiDragElement);
          });
          folding = true;
        } // Clones must be shown (and check to remove multi drags) after folding when interfering multiDragElements are moved out


        if (!isOwner) {
          // Only remove if not folding (folding will remove them anyways)
          if (!folding) {
            removeMultiDragElements();
          }

          if (multiDragElements.length > 1) {
            var clonesHiddenBefore = clonesHidden;

            activeSortable._showClone(sortable); // Unfold animation for clones if showing from hidden


            if (activeSortable.options.animation && !clonesHidden && clonesHiddenBefore) {
              multiDragClones.forEach(function (clone) {
                activeSortable.addAnimationState({
                  target: clone,
                  rect: clonesFromRect
                });
                clone.fromRect = clonesFromRect;
                clone.thisAnimationDuration = null;
              });
            }
          } else {
            activeSortable._showClone(sortable);
          }
        }
      }
    },
    dragOverAnimationCapture: function dragOverAnimationCapture(_ref11) {
      var dragRect = _ref11.dragRect,
          isOwner = _ref11.isOwner,
          activeSortable = _ref11.activeSortable;
      multiDragElements.forEach(function (multiDragElement) {
        multiDragElement.thisAnimationDuration = null;
      });

      if (activeSortable.options.animation && !isOwner && activeSortable.multiDrag.isMultiDrag) {
        clonesFromRect = _extends({}, dragRect);
        var dragMatrix = matrix(dragEl$1, true);
        clonesFromRect.top -= dragMatrix.f;
        clonesFromRect.left -= dragMatrix.e;
      }
    },
    dragOverAnimationComplete: function dragOverAnimationComplete() {
      if (folding) {
        folding = false;
        removeMultiDragElements();
      }
    },
    drop: function drop(_ref12) {
      var evt = _ref12.originalEvent,
          rootEl = _ref12.rootEl,
          parentEl = _ref12.parentEl,
          sortable = _ref12.sortable,
          dispatchSortableEvent = _ref12.dispatchSortableEvent,
          oldIndex = _ref12.oldIndex,
          putSortable = _ref12.putSortable;
      var toSortable = putSortable || this.sortable;
      if (!evt) return;
      var options = this.options,
          children = parentEl.children; // Multi-drag selection

      if (!dragStarted) {
        if (options.multiDragKey && !this.multiDragKeyDown) {
          this._deselectMultiDrag();
        }

        toggleClass(dragEl$1, options.selectedClass, !~multiDragElements.indexOf(dragEl$1));

        if (!~multiDragElements.indexOf(dragEl$1)) {
          multiDragElements.push(dragEl$1);
          dispatchEvent({
            sortable: sortable,
            rootEl: rootEl,
            name: 'select',
            targetEl: dragEl$1,
            originalEvent: evt
          }); // Modifier activated, select from last to dragEl

          if (evt.shiftKey && lastMultiDragSelect && sortable.el.contains(lastMultiDragSelect)) {
            var lastIndex = index(lastMultiDragSelect),
                currentIndex = index(dragEl$1);

            if (~lastIndex && ~currentIndex && lastIndex !== currentIndex) {
              // Must include lastMultiDragSelect (select it), in case modified selection from no selection
              // (but previous selection existed)
              var n, i;

              if (currentIndex > lastIndex) {
                i = lastIndex;
                n = currentIndex;
              } else {
                i = currentIndex;
                n = lastIndex + 1;
              }

              for (; i < n; i++) {
                if (~multiDragElements.indexOf(children[i])) continue;
                toggleClass(children[i], options.selectedClass, true);
                multiDragElements.push(children[i]);
                dispatchEvent({
                  sortable: sortable,
                  rootEl: rootEl,
                  name: 'select',
                  targetEl: children[i],
                  originalEvent: evt
                });
              }
            }
          } else {
            lastMultiDragSelect = dragEl$1;
          }

          multiDragSortable = toSortable;
        } else {
          multiDragElements.splice(multiDragElements.indexOf(dragEl$1), 1);
          lastMultiDragSelect = null;
          dispatchEvent({
            sortable: sortable,
            rootEl: rootEl,
            name: 'deselect',
            targetEl: dragEl$1,
            originalEvent: evt
          });
        }
      } // Multi-drag drop


      if (dragStarted && this.isMultiDrag) {
        folding = false; // Do not "unfold" after around dragEl if reverted

        if ((parentEl[expando].options.sort || parentEl !== rootEl) && multiDragElements.length > 1) {
          var dragRect = getRect(dragEl$1),
              multiDragIndex = index(dragEl$1, ':not(.' + this.options.selectedClass + ')');
          if (!initialFolding && options.animation) dragEl$1.thisAnimationDuration = null;
          toSortable.captureAnimationState();

          if (!initialFolding) {
            if (options.animation) {
              dragEl$1.fromRect = dragRect;
              multiDragElements.forEach(function (multiDragElement) {
                multiDragElement.thisAnimationDuration = null;

                if (multiDragElement !== dragEl$1) {
                  var rect = folding ? getRect(multiDragElement) : dragRect;
                  multiDragElement.fromRect = rect; // Prepare unfold animation

                  toSortable.addAnimationState({
                    target: multiDragElement,
                    rect: rect
                  });
                }
              });
            } // Multi drag elements are not necessarily removed from the DOM on drop, so to reinsert
            // properly they must all be removed


            removeMultiDragElements();
            multiDragElements.forEach(function (multiDragElement) {
              if (children[multiDragIndex]) {
                parentEl.insertBefore(multiDragElement, children[multiDragIndex]);
              } else {
                parentEl.appendChild(multiDragElement);
              }

              multiDragIndex++;
            }); // If initial folding is done, the elements may have changed position because they are now
            // unfolding around dragEl, even though dragEl may not have his index changed, so update event
            // must be fired here as Sortable will not.

            if (oldIndex === index(dragEl$1)) {
              var update = false;
              multiDragElements.forEach(function (multiDragElement) {
                if (multiDragElement.sortableIndex !== index(multiDragElement)) {
                  update = true;
                  return;
                }
              });

              if (update) {
                dispatchSortableEvent('update');
              }
            }
          } // Must be done after capturing individual rects (scroll bar)


          multiDragElements.forEach(function (multiDragElement) {
            unsetRect(multiDragElement);
          });
          toSortable.animateAll();
        }

        multiDragSortable = toSortable;
      } // Remove clones if necessary


      if (rootEl === parentEl || putSortable && putSortable.lastPutMode !== 'clone') {
        multiDragClones.forEach(function (clone) {
          clone.parentNode && clone.parentNode.removeChild(clone);
        });
      }
    },
    nullingGlobal: function nullingGlobal() {
      this.isMultiDrag = dragStarted = false;
      multiDragClones.length = 0;
    },
    destroyGlobal: function destroyGlobal() {
      this._deselectMultiDrag();

      off(document, 'pointerup', this._deselectMultiDrag);
      off(document, 'mouseup', this._deselectMultiDrag);
      off(document, 'touchend', this._deselectMultiDrag);
      off(document, 'keydown', this._checkKeyDown);
      off(document, 'keyup', this._checkKeyUp);
    },
    _deselectMultiDrag: function _deselectMultiDrag(evt) {
      if (typeof dragStarted !== "undefined" && dragStarted) return; // Only deselect if selection is in this sortable

      if (multiDragSortable !== this.sortable) return; // Only deselect if target is not item in this sortable

      if (evt && closest(evt.target, this.options.draggable, this.sortable.el, false)) return; // Only deselect if left click

      if (evt && evt.button !== 0) return;

      while (multiDragElements.length) {
        var el = multiDragElements[0];
        toggleClass(el, this.options.selectedClass, false);
        multiDragElements.shift();
        dispatchEvent({
          sortable: this.sortable,
          rootEl: this.sortable.el,
          name: 'deselect',
          targetEl: el,
          originalEvent: evt
        });
      }
    },
    _checkKeyDown: function _checkKeyDown(evt) {
      if (evt.key === this.options.multiDragKey) {
        this.multiDragKeyDown = true;
      }
    },
    _checkKeyUp: function _checkKeyUp(evt) {
      if (evt.key === this.options.multiDragKey) {
        this.multiDragKeyDown = false;
      }
    }
  };
  return _extends(MultiDrag, {
    // Static methods & properties
    pluginName: 'multiDrag',
    utils: {
      /**
       * Selects the provided multi-drag item
       * @param  {HTMLElement} el    The element to be selected
       */
      select: function select(el) {
        var sortable = el.parentNode[expando];
        if (!sortable || !sortable.options.multiDrag || ~multiDragElements.indexOf(el)) return;

        if (multiDragSortable && multiDragSortable !== sortable) {
          multiDragSortable.multiDrag._deselectMultiDrag();

          multiDragSortable = sortable;
        }

        toggleClass(el, sortable.options.selectedClass, true);
        multiDragElements.push(el);
      },

      /**
       * Deselects the provided multi-drag item
       * @param  {HTMLElement} el    The element to be deselected
       */
      deselect: function deselect(el) {
        var sortable = el.parentNode[expando],
            index = multiDragElements.indexOf(el);
        if (!sortable || !sortable.options.multiDrag || !~index) return;
        toggleClass(el, sortable.options.selectedClass, false);
        multiDragElements.splice(index, 1);
      }
    },
    eventProperties: function eventProperties() {
      var _this3 = this;

      var oldIndicies = [],
          newIndicies = [];
      multiDragElements.forEach(function (multiDragElement) {
        oldIndicies.push({
          multiDragElement: multiDragElement,
          index: multiDragElement.sortableIndex
        }); // multiDragElements will already be sorted if folding

        var newIndex;

        if (folding && multiDragElement !== dragEl$1) {
          newIndex = -1;
        } else if (folding) {
          newIndex = index(multiDragElement, ':not(.' + _this3.options.selectedClass + ')');
        } else {
          newIndex = index(multiDragElement);
        }

        newIndicies.push({
          multiDragElement: multiDragElement,
          index: newIndex
        });
      });
      return {
        items: _toConsumableArray(multiDragElements),
        clones: [].concat(multiDragClones),
        oldIndicies: oldIndicies,
        newIndicies: newIndicies
      };
    },
    optionListeners: {
      multiDragKey: function multiDragKey(key) {
        key = key.toLowerCase();

        if (key === 'ctrl') {
          key = 'Control';
        } else if (key.length > 1) {
          key = key.charAt(0).toUpperCase() + key.substr(1);
        }

        return key;
      }
    }
  });
}

function insertMultiDragElements(clonesInserted, rootEl) {
  multiDragElements.forEach(function (multiDragElement, i) {
    var target = rootEl.children[multiDragElement.sortableIndex + (clonesInserted ? Number(i) : 0)];

    if (target) {
      rootEl.insertBefore(multiDragElement, target);
    } else {
      rootEl.appendChild(multiDragElement);
    }
  });
}
/**
 * Insert multi-drag clones
 * @param  {[Boolean]} elementsInserted  Whether the multi-drag elements are inserted
 * @param  {HTMLElement} rootEl
 */


function insertMultiDragClones(elementsInserted, rootEl) {
  multiDragClones.forEach(function (clone, i) {
    var target = rootEl.children[clone.sortableIndex + (elementsInserted ? Number(i) : 0)];

    if (target) {
      rootEl.insertBefore(clone, target);
    } else {
      rootEl.appendChild(clone);
    }
  });
}

function removeMultiDragElements() {
  multiDragElements.forEach(function (multiDragElement) {
    if (multiDragElement === dragEl$1) return;
    multiDragElement.parentNode && multiDragElement.parentNode.removeChild(multiDragElement);
  });
}

Sortable.mount(new AutoScrollPlugin());
Sortable.mount(Remove, Revert);

/* harmony default export */ __webpack_exports__["default"] = (Sortable);



/***/ }),

/***/ "./node_modules/tiny-invariant/dist/tiny-invariant.esm.js":
/*!****************************************************************!*\
  !*** ./node_modules/tiny-invariant/dist/tiny-invariant.esm.js ***!
  \****************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ invariant; }
/* harmony export */ });
var isProduction = "development" === 'production';
var prefix = 'Invariant failed';
function invariant(condition, message) {
    if (condition) {
        return;
    }
    if (isProduction) {
        throw new Error(prefix);
    }
    var provided = typeof message === 'function' ? message() : message;
    var value = provided ? prefix + ": " + provided : prefix;
    throw new Error(value);
}




/***/ }),

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "@wordpress/components":
/*!************************************!*\
  !*** external ["wp","components"] ***!
  \************************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["components"];

/***/ }),

/***/ "@wordpress/element":
/*!*********************************!*\
  !*** external ["wp","element"] ***!
  \*********************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["element"];

/***/ }),

/***/ "@wordpress/i18n":
/*!******************************!*\
  !*** external ["wp","i18n"] ***!
  \******************************/
/***/ (function(module) {

"use strict";
module.exports = window["wp"]["i18n"];

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js":
/*!*********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js ***!
  \*********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayLikeToArray; }
/* harmony export */ });
function _arrayLikeToArray(arr, len) {
  if (len == null || len > arr.length) len = arr.length;

  for (var i = 0, arr2 = new Array(len); i < len; i++) {
    arr2[i] = arr[i];
  }

  return arr2;
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayWithHoles; }
/* harmony export */ });
function _arrayWithHoles(arr) {
  if (Array.isArray(arr)) return arr;
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _arrayWithoutHoles; }
/* harmony export */ });
/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");

function _arrayWithoutHoles(arr) {
  if (Array.isArray(arr)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr);
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/iterableToArray.js":
/*!********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/iterableToArray.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _iterableToArray; }
/* harmony export */ });
function _iterableToArray(iter) {
  if (typeof Symbol !== "undefined" && iter[Symbol.iterator] != null || iter["@@iterator"] != null) return Array.from(iter);
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js":
/*!*************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js ***!
  \*************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _iterableToArrayLimit; }
/* harmony export */ });
function _iterableToArrayLimit(arr, i) {
  var _i = arr == null ? null : typeof Symbol !== "undefined" && arr[Symbol.iterator] || arr["@@iterator"];

  if (_i == null) return;
  var _arr = [];
  var _n = true;
  var _d = false;

  var _s, _e;

  try {
    for (_i = _i.call(arr); !(_n = (_s = _i.next()).done); _n = true) {
      _arr.push(_s.value);

      if (i && _arr.length === i) break;
    }
  } catch (err) {
    _d = true;
    _e = err;
  } finally {
    try {
      if (!_n && _i["return"] != null) _i["return"]();
    } finally {
      if (_d) throw _e;
    }
  }

  return _arr;
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js":
/*!********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js ***!
  \********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _nonIterableRest; }
/* harmony export */ });
function _nonIterableRest() {
  throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _nonIterableSpread; }
/* harmony export */ });
function _nonIterableSpread() {
  throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/slicedToArray.js":
/*!******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/slicedToArray.js ***!
  \******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _slicedToArray; }
/* harmony export */ });
/* harmony import */ var _arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithHoles.js */ "./node_modules/@babel/runtime/helpers/esm/arrayWithHoles.js");
/* harmony import */ var _iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArrayLimit.js */ "./node_modules/@babel/runtime/helpers/esm/iterableToArrayLimit.js");
/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
/* harmony import */ var _nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableRest.js */ "./node_modules/@babel/runtime/helpers/esm/nonIterableRest.js");




function _slicedToArray(arr, i) {
  return (0,_arrayWithHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr) || (0,_iterableToArrayLimit_js__WEBPACK_IMPORTED_MODULE_1__["default"])(arr, i) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(arr, i) || (0,_nonIterableRest_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js":
/*!**********************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/toConsumableArray.js ***!
  \**********************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _toConsumableArray; }
/* harmony export */ });
/* harmony import */ var _arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayWithoutHoles.js */ "./node_modules/@babel/runtime/helpers/esm/arrayWithoutHoles.js");
/* harmony import */ var _iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./iterableToArray.js */ "./node_modules/@babel/runtime/helpers/esm/iterableToArray.js");
/* harmony import */ var _unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./unsupportedIterableToArray.js */ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js");
/* harmony import */ var _nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./nonIterableSpread.js */ "./node_modules/@babel/runtime/helpers/esm/nonIterableSpread.js");




function _toConsumableArray(arr) {
  return (0,_arrayWithoutHoles_js__WEBPACK_IMPORTED_MODULE_0__["default"])(arr) || (0,_iterableToArray_js__WEBPACK_IMPORTED_MODULE_1__["default"])(arr) || (0,_unsupportedIterableToArray_js__WEBPACK_IMPORTED_MODULE_2__["default"])(arr) || (0,_nonIterableSpread_js__WEBPACK_IMPORTED_MODULE_3__["default"])();
}

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js":
/*!*******************************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/unsupportedIterableToArray.js ***!
  \*******************************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _unsupportedIterableToArray; }
/* harmony export */ });
/* harmony import */ var _arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./arrayLikeToArray.js */ "./node_modules/@babel/runtime/helpers/esm/arrayLikeToArray.js");

function _unsupportedIterableToArray(o, minLen) {
  if (!o) return;
  if (typeof o === "string") return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(o, minLen);
  var n = Object.prototype.toString.call(o).slice(8, -1);
  if (n === "Object" && o.constructor) n = o.constructor.name;
  if (n === "Map" || n === "Set") return Array.from(o);
  if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return (0,_arrayLikeToArray_js__WEBPACK_IMPORTED_MODULE_0__["default"])(o, minLen);
}

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
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!***********************************!*\
  !*** ./src/scripts/customizer.js ***!
  \***********************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _customizer_sections__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./customizer/sections */ "./src/scripts/customizer/sections.js");
/* harmony import */ var _customizer_sections__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_customizer_sections__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _customizer_controls__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./customizer/controls */ "./src/scripts/customizer/controls.js");
/* harmony import */ var _customizer_interactions__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./customizer/interactions */ "./src/scripts/customizer/interactions.js");
/* harmony import */ var _customizer_interactions__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_customizer_interactions__WEBPACK_IMPORTED_MODULE_2__);



}();
/******/ })()
;
//# sourceMappingURL=customizer.js.map