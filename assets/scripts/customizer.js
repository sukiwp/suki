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




function SukiColorSelectDropdown(props) {
  var palette = [];

  for (var i = 1; i <= 8; i++) {
    var color = wp.customize('color_palette_' + i).get();
    palette.push({
      name: wp.customize('color_palette_' + i + '_name').get() || (0,_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__.sprintf)(SukiCustomizerData.l10n.themeColor$d, i),
      color: color,
      value: 'var(--color-palette-' + i + ')'
    });
  }

  var value = props.value;
  var valueIsLink = value && 0 === value.indexOf('var(') ? true : false;
  var pickerIsOpened = value && !valueIsLink;
  var valueInfo = valueIsLink ? palette.find(function (item) {
    return value === item.value;
  }) : {
    name: SukiCustomizerData.l10n.custom,
    color: value,
    value: value
  };
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: "suki-color-dropdown"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.SlotFillProvider, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Dropdown, {
    position: "bottom left",
    focusOnMount: "container",
    renderToggle: function renderToggle(toggleParams) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
        isSmall: true,
        variant: "tertiary",
        label: '' !== value ? valueInfo.name + ': ' + valueInfo.color : SukiCustomizerData.l10n.notSet,
        showTooltip: true,
        "aria-expanded": toggleParams.isOpen,
        id: props.id || null,
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
        value: valueIsLink && valueInfo.color,
        disableCustomColors: true,
        clearable: false,
        className: "suki-color-dropdown__palette",
        onChange: function onChange(color) {
          if (color) {
            var colorInfo = palette.find(function (item) {
              return color === item.color;
            });
            props.changeValue(colorInfo.value);
          } else {
            props.changeValue('');
          }
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
            props.changeValue('');
          } else {
            // isPressed: false
            if (valueInfo.color) {
              props.changeValue(valueInfo.color);
            } else {
              props.changeValue(props.defaultPickerValue || '#ffffff');
            }
          }
        }
      }))), pickerIsOpened && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.ColorPicker, {
        color: value,
        enableAlpha: true,
        className: "suki-color-dropdown__picker",
        onChange: function onChange(value) {
          props.changeValue(value);
        }
      }), props.defaultValue && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.__experimentalHStack, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__.Button, {
        isSmall: true,
        variant: "secondary",
        onClick: function onClick(e) {
          props.changeValue(props.defaultValue);
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



function SukiControlDescription(props) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()(props.className, 'description', 'customize-control-description'),
    id: props.id
  }, props.children));
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



function SukiControlLabel(props) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("label", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()(props.className, 'customize-control-title'),
    htmlFor: props.for
  }, props.children));
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



function SukiControlResponsiveContainer(props) {
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_1___default()(props.className, 'suki-responsive-container'),
    "data-device": props.device
  }, props.children));
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



function SukiControlResponsiveSwitcher(props) {
  var controlDevices = ['desktop', 'tablet', 'mobile'].filter(function (device) {
    return -1 !== props.devices.indexOf(device);
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

/***/ "./src/scripts/customizer/contexts.js":
/*!********************************************!*\
  !*** ./src/scripts/customizer/contexts.js ***!
  \********************************************/
/***/ (function() {

wp.customize.bind('ready', function () {
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
});

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
/* harmony import */ var _controls_SukiColorControl__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./controls/SukiColorControl */ "./src/scripts/customizer/controls/SukiColorControl.js");
/* harmony import */ var _controls_SukiColorSelectControl__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./controls/SukiColorSelectControl */ "./src/scripts/customizer/controls/SukiColorSelectControl.js");
/* harmony import */ var _controls_SukiDimensionControl__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./controls/SukiDimensionControl */ "./src/scripts/customizer/controls/SukiDimensionControl.js");
/* harmony import */ var _controls_SukiDimensionsControl__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./controls/SukiDimensionsControl */ "./src/scripts/customizer/controls/SukiDimensionsControl.js");
/* harmony import */ var _controls_SukiMultiCheckControl__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./controls/SukiMultiCheckControl */ "./src/scripts/customizer/controls/SukiMultiCheckControl.js");
/* harmony import */ var _controls_SukiMultiSelectControl__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./controls/SukiMultiSelectControl */ "./src/scripts/customizer/controls/SukiMultiSelectControl.js");
/* harmony import */ var _controls_SukiRadioImageControl__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./controls/SukiRadioImageControl */ "./src/scripts/customizer/controls/SukiRadioImageControl.js");
/* harmony import */ var _controls_SukiShadowControl__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./controls/SukiShadowControl */ "./src/scripts/customizer/controls/SukiShadowControl.js");
/* harmony import */ var _controls_SukiSliderControl__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./controls/SukiSliderControl */ "./src/scripts/customizer/controls/SukiSliderControl.js");
/* harmony import */ var _controls_SukiToggleControl__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! ./controls/SukiToggleControl */ "./src/scripts/customizer/controls/SukiToggleControl.js");
/* harmony import */ var _controls_SukiTypographyControl__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./controls/SukiTypographyControl */ "./src/scripts/customizer/controls/SukiTypographyControl.js");
// Base controls

 // Custom controls














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
      for: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.Card, null, control.settings.image && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CardBody, {
      size: "xSmall",
      className: "suki-media-upload"
    }, control.params.imageAttachment && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, {
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
    }))), !control.params.imageAttachment && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.Fragment, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalGrid, {
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
    })))), (control.settings.attachment || control.settings.repeat || control.settings.size || control.settings.position) && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.CardBody, {
      size: "xSmall"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__.__experimentalVStack, {
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
    })))))), control.container[0]);
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
      for: '_customize-input-' + control.id
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
      for: '_customize-input-' + control.id
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
      for: '_customize-input-' + control.id
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
      for: '_customize-input-' + control.id
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
      for: '_customize-input-' + control.id
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



/**
 * Multi Select control (React)
 */



wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var valueArray = control.setting.get(); // If limit is set to `0`, it means limit is same as the number of options.

    var limit = control.params.itemsLimit || control.params.choices.length;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_2__["default"], {
      for: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_3__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), 0 < valueArray.length && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.__experimentalItemGroup, {
      isSeparated: true,
      isBordered: true,
      size: "small",
      style: {
        backgroundColor: 'white',
        marginBottom: '8px'
      }
    }, valueArray.map(function (value) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.__experimentalItem, {
        key: value,
        "data-value": value,
        className: "suki-multiselect-item"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.__experimentalHStack, {
        expanded: true,
        spacing: "3"
      }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("span", null, value), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_4__.Button, {
        isSmall: true,
        label: SukiCustomizerData.l10n.remove,
        showTooltip: true,
        className: "suki-multiselect-item__remove",
        onClick: function onClick() {
          control.removeValueItem(value);
        }
      }, "\u2715")));
    })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("select", {
      value: "",
      disabled: limit <= valueArray.length ? true : false,
      id: '_customize-input-' + control.id,
      onChange: function onChange(e) {
        control.addNewValueItem(e.target.value);
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
      value: "",
      disabled: true
    }, SukiCustomizerData.l10n.addNew), control.params.choices.map(function (choice, i) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)("option", {
        key: choice.value,
        value: choice.value,
        disabled: -1 === valueArray.indexOf(choice.value) ? false : true
      }, choice.label);
    }))), control.container[0]);
  },
  addNewValueItem: function addNewValueItem(value) {
    var control = this;
    var valueArray = control.setting.get() || []; // Add the selected item into the value array.

    if (-1 === valueArray.indexOf(value)) {
      valueArray = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(valueArray), [value]);
    } // Sort the array according to the original options order.


    if (control.params.keepOrder) {
      var choicesValues = control.params.choices.map(function (item) {
        return item.value;
      });
      valueArray = choicesValues.filter(function (choice) {
        return -1 !== valueArray.indexOf(choice);
      });
    }

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
      for: '_customize-input-' + control.id
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
        justify: "center",
        style: {
          width: '100%'
        }
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
      for: '_customize-input-' + control.id
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
        var newValue = Object.values(valueObj).join(' ');
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
          var newValue = Object.values(valueObj).join(' ');
          control.setting.set(newValue);
        }
      });
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_1__.createElement)(_components_SukiColorSelectDropdown__WEBPACK_IMPORTED_MODULE_4__["default"], {
      value: valueObj.color,
      changeValue: function changeValue(newColorValue) {
        valueObj.color = newColorValue;
        var newValue = Object.values(valueObj).join(' ');
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
      for: '_customize-input-' + control.id
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
      for: '_customize-input-' + control.id
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
      for: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_2__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Card, null, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.CardBody, {
      size: "xSmall"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_0__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalVStack, {
      spacing: "2"
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
    }))))), control.container[0]);
  }
});
wp.customize.controlConstructor['suki-typography'] = wp.customize.SukiTypographyControl;

/***/ }),

/***/ "./src/scripts/customizer/sections.js":
/*!********************************************!*\
  !*** ./src/scripts/customizer/sections.js ***!
  \********************************************/
/***/ (function() {

/**
 * Custom section
 */
wp.customize.sectionConstructor['suki-pro-link'] = wp.customize.sectionConstructor['suki-pro-teaser'] = wp.customize.sectionConstructor['suki-spacer'] = wp.customize.Section.extend({
  // No events for this type of section.
  attachEvents: function attachEvents() {},
  // Always make the section active.
  isContextuallyActive: function isContextuallyActive() {
    return true;
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
/* harmony import */ var _customizer_contexts__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./customizer/contexts */ "./src/scripts/customizer/contexts.js");
/* harmony import */ var _customizer_contexts__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_customizer_contexts__WEBPACK_IMPORTED_MODULE_2__);



}();
/******/ })()
;
//# sourceMappingURL=customizer.js.map