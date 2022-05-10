/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@dnd-kit/accessibility/dist/accessibility.esm.js":
/*!***********************************************************************!*\
  !*** ./node_modules/@dnd-kit/accessibility/dist/accessibility.esm.js ***!
  \***********************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "HiddenText": function() { return /* binding */ HiddenText; },
/* harmony export */   "LiveRegion": function() { return /* binding */ LiveRegion; },
/* harmony export */   "useAnnouncement": function() { return /* binding */ useAnnouncement; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


const hiddenStyles = {
  display: 'none'
};
function HiddenText({
  id,
  value
}) {
  return react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    id: id,
    style: hiddenStyles
  }, value);
}

const visuallyHidden = {
  position: 'absolute',
  width: 1,
  height: 1,
  margin: -1,
  border: 0,
  padding: 0,
  overflow: 'hidden',
  clip: 'rect(0 0 0 0)',
  clipPath: 'inset(100%)',
  whiteSpace: 'nowrap'
};
function LiveRegion({
  id,
  announcement
}) {
  return react__WEBPACK_IMPORTED_MODULE_0___default().createElement("div", {
    id: id,
    style: visuallyHidden,
    role: "status",
    "aria-live": "assertive",
    "aria-atomic": true
  }, announcement);
}

function useAnnouncement() {
  const [announcement, setAnnouncement] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)('');
  const announce = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(value => {
    if (value != null) {
      setAnnouncement(value);
    }
  }, []);
  return {
    announce,
    announcement
  };
}


//# sourceMappingURL=accessibility.esm.js.map


/***/ }),

/***/ "./node_modules/@dnd-kit/core/dist/core.esm.js":
/*!*****************************************************!*\
  !*** ./node_modules/@dnd-kit/core/dist/core.esm.js ***!
  \*****************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "AutoScrollActivator": function() { return /* binding */ AutoScrollActivator; },
/* harmony export */   "DndContext": function() { return /* binding */ DndContext; },
/* harmony export */   "DragOverlay": function() { return /* binding */ DragOverlay; },
/* harmony export */   "KeyboardCode": function() { return /* binding */ KeyboardCode; },
/* harmony export */   "KeyboardSensor": function() { return /* binding */ KeyboardSensor; },
/* harmony export */   "MeasuringFrequency": function() { return /* binding */ MeasuringFrequency; },
/* harmony export */   "MeasuringStrategy": function() { return /* binding */ MeasuringStrategy; },
/* harmony export */   "MouseSensor": function() { return /* binding */ MouseSensor; },
/* harmony export */   "PointerSensor": function() { return /* binding */ PointerSensor; },
/* harmony export */   "TouchSensor": function() { return /* binding */ TouchSensor; },
/* harmony export */   "TraversalOrder": function() { return /* binding */ TraversalOrder; },
/* harmony export */   "applyModifiers": function() { return /* binding */ applyModifiers; },
/* harmony export */   "closestCenter": function() { return /* binding */ closestCenter; },
/* harmony export */   "closestCorners": function() { return /* binding */ closestCorners; },
/* harmony export */   "defaultAnnouncements": function() { return /* binding */ defaultAnnouncements; },
/* harmony export */   "defaultCoordinates": function() { return /* binding */ defaultCoordinates; },
/* harmony export */   "defaultDropAnimation": function() { return /* binding */ defaultDropAnimation; },
/* harmony export */   "getClientRect": function() { return /* binding */ getClientRect; },
/* harmony export */   "getFirstCollision": function() { return /* binding */ getFirstCollision; },
/* harmony export */   "getScrollableAncestors": function() { return /* binding */ getScrollableAncestors; },
/* harmony export */   "pointerWithin": function() { return /* binding */ pointerWithin; },
/* harmony export */   "rectIntersection": function() { return /* binding */ rectIntersection; },
/* harmony export */   "useDndContext": function() { return /* binding */ useDndContext; },
/* harmony export */   "useDndMonitor": function() { return /* binding */ useDndMonitor; },
/* harmony export */   "useDraggable": function() { return /* binding */ useDraggable; },
/* harmony export */   "useDroppable": function() { return /* binding */ useDroppable; },
/* harmony export */   "useSensor": function() { return /* binding */ useSensor; },
/* harmony export */   "useSensors": function() { return /* binding */ useSensors; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @dnd-kit/utilities */ "./node_modules/@dnd-kit/utilities/dist/utilities.esm.js");
/* harmony import */ var _dnd_kit_accessibility__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @dnd-kit/accessibility */ "./node_modules/@dnd-kit/accessibility/dist/accessibility.esm.js");





const screenReaderInstructions = {
  draggable: `
    To pick up a draggable item, press the space bar.
    While dragging, use the arrow keys to move the item.
    Press space again to drop the item in its new position, or press escape to cancel.
  `
};
const defaultAnnouncements = {
  onDragStart(id) {
    return `Picked up draggable item ${id}.`;
  },

  onDragOver(id, overId) {
    if (overId) {
      return `Draggable item ${id} was moved over droppable area ${overId}.`;
    }

    return `Draggable item ${id} is no longer over a droppable area.`;
  },

  onDragEnd(id, overId) {
    if (overId) {
      return `Draggable item ${id} was dropped over droppable area ${overId}`;
    }

    return `Draggable item ${id} was dropped.`;
  },

  onDragCancel(id) {
    return `Dragging was cancelled. Draggable item ${id} was dropped.`;
  }

};

var Action;

(function (Action) {
  Action["DragStart"] = "dragStart";
  Action["DragMove"] = "dragMove";
  Action["DragEnd"] = "dragEnd";
  Action["DragCancel"] = "dragCancel";
  Action["DragOver"] = "dragOver";
  Action["RegisterDroppable"] = "registerDroppable";
  Action["SetDroppableDisabled"] = "setDroppableDisabled";
  Action["UnregisterDroppable"] = "unregisterDroppable";
})(Action || (Action = {}));

function noop(..._args) {}

class DroppableContainersMap extends Map {
  get(id) {
    var _super$get;

    return id != null ? (_super$get = super.get(id)) != null ? _super$get : undefined : undefined;
  }

  toArray() {
    return Array.from(this.values());
  }

  getEnabled() {
    return this.toArray().filter(({
      disabled
    }) => !disabled);
  }

  getNodeFor(id) {
    var _this$get$node$curren, _this$get;

    return (_this$get$node$curren = (_this$get = this.get(id)) == null ? void 0 : _this$get.node.current) != null ? _this$get$node$curren : undefined;
  }

}

const defaultPublicContext = {
  activatorEvent: null,
  active: null,
  activeNode: null,
  activeNodeRect: null,
  collisions: null,
  containerNodeRect: null,
  draggableNodes: {},
  droppableRects: /*#__PURE__*/new Map(),
  droppableContainers: /*#__PURE__*/new DroppableContainersMap(),
  over: null,
  dragOverlay: {
    nodeRef: {
      current: null
    },
    rect: null,
    setRef: noop
  },
  scrollableAncestors: [],
  scrollableAncestorRects: [],
  measureDroppableContainers: noop,
  windowRect: null,
  measuringScheduled: false
};
const defaultInternalContext = {
  activatorEvent: null,
  activators: [],
  active: null,
  activeNodeRect: null,
  ariaDescribedById: {
    draggable: ''
  },
  dispatch: noop,
  draggableNodes: {},
  over: null,
  measureDroppableContainers: noop
};
const InternalContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)(defaultInternalContext);
const PublicContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)(defaultPublicContext);

function getInitialState() {
  return {
    draggable: {
      active: null,
      initialCoordinates: {
        x: 0,
        y: 0
      },
      nodes: {},
      translate: {
        x: 0,
        y: 0
      }
    },
    droppable: {
      containers: new DroppableContainersMap()
    }
  };
}
function reducer(state, action) {
  switch (action.type) {
    case Action.DragStart:
      return { ...state,
        draggable: { ...state.draggable,
          initialCoordinates: action.initialCoordinates,
          active: action.active
        }
      };

    case Action.DragMove:
      if (!state.draggable.active) {
        return state;
      }

      return { ...state,
        draggable: { ...state.draggable,
          translate: {
            x: action.coordinates.x - state.draggable.initialCoordinates.x,
            y: action.coordinates.y - state.draggable.initialCoordinates.y
          }
        }
      };

    case Action.DragEnd:
    case Action.DragCancel:
      return { ...state,
        draggable: { ...state.draggable,
          active: null,
          initialCoordinates: {
            x: 0,
            y: 0
          },
          translate: {
            x: 0,
            y: 0
          }
        }
      };

    case Action.RegisterDroppable:
      {
        const {
          element
        } = action;
        const {
          id
        } = element;
        const containers = new DroppableContainersMap(state.droppable.containers);
        containers.set(id, element);
        return { ...state,
          droppable: { ...state.droppable,
            containers
          }
        };
      }

    case Action.SetDroppableDisabled:
      {
        const {
          id,
          key,
          disabled
        } = action;
        const element = state.droppable.containers.get(id);

        if (!element || key !== element.key) {
          return state;
        }

        const containers = new DroppableContainersMap(state.droppable.containers);
        containers.set(id, { ...element,
          disabled
        });
        return { ...state,
          droppable: { ...state.droppable,
            containers
          }
        };
      }

    case Action.UnregisterDroppable:
      {
        const {
          id,
          key
        } = action;
        const element = state.droppable.containers.get(id);

        if (!element || key !== element.key) {
          return state;
        }

        const containers = new DroppableContainersMap(state.droppable.containers);
        containers.delete(id);
        return { ...state,
          droppable: { ...state.droppable,
            containers
          }
        };
      }

    default:
      {
        return state;
      }
  }
}

const DndMonitorContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)({
  type: null,
  event: null
});
function useDndMonitor({
  onDragStart,
  onDragMove,
  onDragOver,
  onDragEnd,
  onDragCancel
}) {
  const monitorState = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(DndMonitorContext);
  const previousMonitorState = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(monitorState);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (monitorState !== previousMonitorState.current) {
      const {
        type,
        event
      } = monitorState;

      switch (type) {
        case Action.DragStart:
          onDragStart == null ? void 0 : onDragStart(event);
          break;

        case Action.DragMove:
          onDragMove == null ? void 0 : onDragMove(event);
          break;

        case Action.DragOver:
          onDragOver == null ? void 0 : onDragOver(event);
          break;

        case Action.DragCancel:
          onDragCancel == null ? void 0 : onDragCancel(event);
          break;

        case Action.DragEnd:
          onDragEnd == null ? void 0 : onDragEnd(event);
          break;
      }

      previousMonitorState.current = monitorState;
    }
  }, [monitorState, onDragStart, onDragMove, onDragOver, onDragEnd, onDragCancel]);
}

function Accessibility({
  announcements = defaultAnnouncements,
  hiddenTextDescribedById,
  screenReaderInstructions
}) {
  const {
    announce,
    announcement
  } = (0,_dnd_kit_accessibility__WEBPACK_IMPORTED_MODULE_3__.useAnnouncement)();
  const liveRegionId = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useUniqueId)(`DndLiveRegion`);
  const [mounted, setMounted] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    setMounted(true);
  }, []);
  useDndMonitor((0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => ({
    onDragStart({
      active
    }) {
      announce(announcements.onDragStart(active.id));
    },

    onDragMove({
      active,
      over
    }) {
      if (announcements.onDragMove) {
        announce(announcements.onDragMove(active.id, over == null ? void 0 : over.id));
      }
    },

    onDragOver({
      active,
      over
    }) {
      announce(announcements.onDragOver(active.id, over == null ? void 0 : over.id));
    },

    onDragEnd({
      active,
      over
    }) {
      announce(announcements.onDragEnd(active.id, over == null ? void 0 : over.id));
    },

    onDragCancel({
      active
    }) {
      announce(announcements.onDragCancel(active.id));
    }

  }), [announce, announcements]));
  return mounted ? (0,react_dom__WEBPACK_IMPORTED_MODULE_1__.createPortal)(react__WEBPACK_IMPORTED_MODULE_0___default().createElement((react__WEBPACK_IMPORTED_MODULE_0___default().Fragment), null, react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_dnd_kit_accessibility__WEBPACK_IMPORTED_MODULE_3__.HiddenText, {
    id: hiddenTextDescribedById,
    value: screenReaderInstructions.draggable
  }), react__WEBPACK_IMPORTED_MODULE_0___default().createElement(_dnd_kit_accessibility__WEBPACK_IMPORTED_MODULE_3__.LiveRegion, {
    id: liveRegionId,
    announcement: announcement
  })), document.body) : null;
}

const defaultCoordinates = /*#__PURE__*/Object.freeze({
  x: 0,
  y: 0
});

/**
 * Returns the distance between two points
 */
function distanceBetween(p1, p2) {
  return Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));
}

function getRelativeTransformOrigin(event, rect) {
  const eventCoordinates = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getEventCoordinates)(event);

  if (!eventCoordinates) {
    return '0 0';
  }

  const transformOrigin = {
    x: (eventCoordinates.x - rect.left) / rect.width * 100,
    y: (eventCoordinates.y - rect.top) / rect.height * 100
  };
  return `${transformOrigin.x}% ${transformOrigin.y}%`;
}

/**
 * Sort collisions from smallest to greatest value
 */
function sortCollisionsAsc({
  data: {
    value: a
  }
}, {
  data: {
    value: b
  }
}) {
  return a - b;
}
/**
 * Sort collisions from greatest to smallest value
 */

function sortCollisionsDesc({
  data: {
    value: a
  }
}, {
  data: {
    value: b
  }
}) {
  return b - a;
}
/**
 * Returns the coordinates of the corners of a given rectangle:
 * [TopLeft {x, y}, TopRight {x, y}, BottomLeft {x, y}, BottomRight {x, y}]
 */

function cornersOfRectangle({
  left,
  top,
  height,
  width
}) {
  return [{
    x: left,
    y: top
  }, {
    x: left + width,
    y: top
  }, {
    x: left,
    y: top + height
  }, {
    x: left + width,
    y: top + height
  }];
}
function getFirstCollision(collisions, property) {
  if (!collisions || collisions.length === 0) {
    return null;
  }

  const [firstCollision] = collisions;
  return property ? firstCollision[property] : firstCollision;
}

/**
 * Returns the coordinates of the center of a given ClientRect
 */

function centerOfRectangle(rect, left = rect.left, top = rect.top) {
  return {
    x: left + rect.width * 0.5,
    y: top + rect.height * 0.5
  };
}
/**
 * Returns the closest rectangles from an array of rectangles to the center of a given
 * rectangle.
 */


const closestCenter = ({
  collisionRect,
  droppableContainers
}) => {
  const centerRect = centerOfRectangle(collisionRect, collisionRect.left, collisionRect.top);
  const collisions = [];

  for (const droppableContainer of droppableContainers) {
    const {
      id,
      rect: {
        current: rect
      }
    } = droppableContainer;

    if (rect) {
      const distBetween = distanceBetween(centerOfRectangle(rect), centerRect);
      collisions.push({
        id,
        data: {
          droppableContainer,
          value: distBetween
        }
      });
    }
  }

  return collisions.sort(sortCollisionsAsc);
};

/**
 * Returns the closest rectangles from an array of rectangles to the corners of
 * another rectangle.
 */

const closestCorners = ({
  collisionRect,
  droppableContainers
}) => {
  const corners = cornersOfRectangle(collisionRect);
  const collisions = [];

  for (const droppableContainer of droppableContainers) {
    const {
      id,
      rect: {
        current: rect
      }
    } = droppableContainer;

    if (rect) {
      const rectCorners = cornersOfRectangle(rect);
      const distances = corners.reduce((accumulator, corner, index) => {
        return accumulator + distanceBetween(rectCorners[index], corner);
      }, 0);
      const effectiveDistance = Number((distances / 4).toFixed(4));
      collisions.push({
        id,
        data: {
          droppableContainer,
          value: effectiveDistance
        }
      });
    }
  }

  return collisions.sort(sortCollisionsAsc);
};

/**
 * Returns the intersecting rectangle area between two rectangles
 */

function getIntersectionRatio(entry, target) {
  const top = Math.max(target.top, entry.top);
  const left = Math.max(target.left, entry.left);
  const right = Math.min(target.left + target.width, entry.left + entry.width);
  const bottom = Math.min(target.top + target.height, entry.top + entry.height);
  const width = right - left;
  const height = bottom - top;

  if (left < right && top < bottom) {
    const targetArea = target.width * target.height;
    const entryArea = entry.width * entry.height;
    const intersectionArea = width * height;
    const intersectionRatio = intersectionArea / (targetArea + entryArea - intersectionArea);
    return Number(intersectionRatio.toFixed(4));
  } // Rectangles do not overlap, or overlap has an area of zero (edge/corner overlap)


  return 0;
}
/**
 * Returns the rectangles that has the greatest intersection area with a given
 * rectangle in an array of rectangles.
 */

const rectIntersection = ({
  collisionRect,
  droppableContainers
}) => {
  const collisions = [];

  for (const droppableContainer of droppableContainers) {
    const {
      id,
      rect: {
        current: rect
      }
    } = droppableContainer;

    if (rect) {
      const intersectionRatio = getIntersectionRatio(rect, collisionRect);

      if (intersectionRatio > 0) {
        collisions.push({
          id,
          data: {
            droppableContainer,
            value: intersectionRatio
          }
        });
      }
    }
  }

  return collisions.sort(sortCollisionsDesc);
};

/**
 * Check if a given point is contained within a bounding rectangle
 */

function isPointWithinRect(point, rect) {
  const {
    top,
    left,
    bottom,
    right
  } = rect;
  return top <= point.y && point.y <= bottom && left <= point.x && point.x <= right;
}
/**
 * Returns the rectangles that the pointer is hovering over
 */


const pointerWithin = ({
  droppableContainers,
  pointerCoordinates
}) => {
  if (!pointerCoordinates) {
    return [];
  }

  const collisions = [];

  for (const droppableContainer of droppableContainers) {
    const {
      id,
      rect: {
        current: rect
      }
    } = droppableContainer;

    if (rect && isPointWithinRect(pointerCoordinates, rect)) {
      /* There may be more than a single rectangle intersecting
       * with the pointer coordinates. In order to sort the
       * colliding rectangles, we measure the distance between
       * the pointer and the corners of the intersecting rectangle
       */
      const corners = cornersOfRectangle(rect);
      const distances = corners.reduce((accumulator, corner) => {
        return accumulator + distanceBetween(pointerCoordinates, corner);
      }, 0);
      const effectiveDistance = Number((distances / 4).toFixed(4));
      collisions.push({
        id,
        data: {
          droppableContainer,
          value: effectiveDistance
        }
      });
    }
  }

  return collisions.sort(sortCollisionsAsc);
};

function adjustScale(transform, rect1, rect2) {
  return { ...transform,
    scaleX: rect1 && rect2 ? rect1.width / rect2.width : 1,
    scaleY: rect1 && rect2 ? rect1.height / rect2.height : 1
  };
}

function getRectDelta(rect1, rect2) {
  return rect1 && rect2 ? {
    x: rect1.left - rect2.left,
    y: rect1.top - rect2.top
  } : defaultCoordinates;
}

function createRectAdjustmentFn(modifier) {
  return function adjustClientRect(rect, ...adjustments) {
    return adjustments.reduce((acc, adjustment) => ({ ...acc,
      top: acc.top + modifier * adjustment.y,
      bottom: acc.bottom + modifier * adjustment.y,
      left: acc.left + modifier * adjustment.x,
      right: acc.right + modifier * adjustment.x
    }), { ...rect
    });
  };
}
const getAdjustedRect = /*#__PURE__*/createRectAdjustmentFn(1);

function inverseTransform(rect, transform, transformOrigin) {
  let ta, sx, sy, dx, dy;

  if (transform.startsWith('matrix3d(')) {
    ta = transform.slice(9, -1).split(/, /);
    sx = +ta[0];
    sy = +ta[5];
    dx = +ta[12];
    dy = +ta[13];
  } else if (transform.startsWith('matrix(')) {
    ta = transform.slice(7, -1).split(/, /);
    sx = +ta[0];
    sy = +ta[3];
    dx = +ta[4];
    dy = +ta[5];
  } else {
    return rect;
  }

  const x = rect.left - dx - (1 - sx) * parseFloat(transformOrigin);
  const y = rect.top - dy - (1 - sy) * parseFloat(transformOrigin.slice(transformOrigin.indexOf(' ') + 1));
  const w = sx ? rect.width / sx : rect.width;
  const h = sy ? rect.height / sy : rect.height;
  return {
    width: w,
    height: h,
    top: y,
    right: x + w,
    bottom: y + h,
    left: x
  };
}

const defaultOptions = {
  ignoreTransform: false
};
/**
 * Returns the bounding client rect of an element relative to the viewport.
 */

function getClientRect(element, options = defaultOptions) {
  let rect = element.getBoundingClientRect();

  if (options.ignoreTransform) {
    const {
      getComputedStyle
    } = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(element);
    const {
      transform,
      transformOrigin
    } = getComputedStyle(element);

    if (transform) {
      rect = inverseTransform(rect, transform, transformOrigin);
    }
  }

  const {
    top,
    left,
    width,
    height,
    bottom,
    right
  } = rect;
  return {
    top,
    left,
    width,
    height,
    bottom,
    right
  };
}
/**
 * Returns the bounding client rect of an element relative to the viewport.
 *
 * @remarks
 * The ClientRect returned by this method does not take into account transforms
 * applied to the element it measures.
 *
 */

function getTransformAgnosticClientRect(element) {
  return getClientRect(element, {
    ignoreTransform: true
  });
}

function getWindowClientRect(element) {
  const width = element.innerWidth;
  const height = element.innerHeight;
  return {
    top: 0,
    left: 0,
    right: width,
    bottom: height,
    width,
    height
  };
}

function isFixed(node, computedStyle = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(node).getComputedStyle(node)) {
  return computedStyle.position === 'fixed';
}

function isScrollable(element, computedStyle = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(element).getComputedStyle(element)) {
  const overflowRegex = /(auto|scroll|overlay)/;
  const properties = ['overflow', 'overflowX', 'overflowY'];
  return properties.find(property => {
    const value = computedStyle[property];
    return typeof value === 'string' ? overflowRegex.test(value) : false;
  }) != null;
}

function getScrollableAncestors(element) {
  const scrollParents = [];

  function findScrollableAncestors(node) {
    if (!node) {
      return scrollParents;
    }

    if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isDocument)(node) && node.scrollingElement != null && !scrollParents.includes(node.scrollingElement)) {
      scrollParents.push(node.scrollingElement);
      return scrollParents;
    }

    if (!(0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isHTMLElement)(node) || (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isSVGElement)(node)) {
      return scrollParents;
    }

    if (scrollParents.includes(node)) {
      return scrollParents;
    }

    const {
      getComputedStyle
    } = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(node);
    const computedStyle = getComputedStyle(node);

    if (node !== element) {
      if (isScrollable(node, computedStyle)) {
        scrollParents.push(node);
      }
    }

    if (isFixed(node, computedStyle)) {
      return scrollParents;
    }

    return findScrollableAncestors(node.parentNode);
  }

  if (!element) {
    return scrollParents;
  }

  return findScrollableAncestors(element);
}

function getScrollableElement(element) {
  if (!_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.canUseDOM || !element) {
    return null;
  }

  if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isWindow)(element)) {
    return element;
  }

  if (!(0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isNode)(element)) {
    return null;
  }

  if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isDocument)(element) || element === (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getOwnerDocument)(element).scrollingElement) {
    return window;
  }

  if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isHTMLElement)(element)) {
    return element;
  }

  return null;
}

function getScrollXCoordinate(element) {
  if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isWindow)(element)) {
    return element.scrollX;
  }

  return element.scrollLeft;
}
function getScrollYCoordinate(element) {
  if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isWindow)(element)) {
    return element.scrollY;
  }

  return element.scrollTop;
}
function getScrollCoordinates(element) {
  return {
    x: getScrollXCoordinate(element),
    y: getScrollYCoordinate(element)
  };
}

var Direction;

(function (Direction) {
  Direction[Direction["Forward"] = 1] = "Forward";
  Direction[Direction["Backward"] = -1] = "Backward";
})(Direction || (Direction = {}));

function getScrollPosition(scrollingContainer) {
  const minScroll = {
    x: 0,
    y: 0
  };
  const maxScroll = {
    x: scrollingContainer.scrollWidth - scrollingContainer.clientWidth,
    y: scrollingContainer.scrollHeight - scrollingContainer.clientHeight
  };
  const isTop = scrollingContainer.scrollTop <= minScroll.y;
  const isLeft = scrollingContainer.scrollLeft <= minScroll.x;
  const isBottom = scrollingContainer.scrollTop >= maxScroll.y;
  const isRight = scrollingContainer.scrollLeft >= maxScroll.x;
  return {
    isTop,
    isLeft,
    isBottom,
    isRight,
    maxScroll,
    minScroll
  };
}

function isDocumentScrollingElement(element) {
  if (!_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.canUseDOM || !element) {
    return false;
  }

  return element === document.scrollingElement;
}

const defaultThreshold = {
  x: 0.2,
  y: 0.2
};
function getScrollDirectionAndSpeed(scrollContainer, scrollContainerRect, {
  top,
  left,
  right,
  bottom
}, acceleration = 10, thresholdPercentage = defaultThreshold) {
  const {
    clientHeight,
    clientWidth
  } = scrollContainer;
  const finalScrollContainerRect = isDocumentScrollingElement(scrollContainer) ? {
    top: 0,
    left: 0,
    right: clientWidth,
    bottom: clientHeight,
    width: clientWidth,
    height: clientHeight
  } : scrollContainerRect;
  const {
    isTop,
    isBottom,
    isLeft,
    isRight
  } = getScrollPosition(scrollContainer);
  const direction = {
    x: 0,
    y: 0
  };
  const speed = {
    x: 0,
    y: 0
  };
  const threshold = {
    height: finalScrollContainerRect.height * thresholdPercentage.y,
    width: finalScrollContainerRect.width * thresholdPercentage.x
  };

  if (!isTop && top <= finalScrollContainerRect.top + threshold.height) {
    // Scroll Up
    direction.y = Direction.Backward;
    speed.y = acceleration * Math.abs((finalScrollContainerRect.top + threshold.height - top) / threshold.height);
  } else if (!isBottom && bottom >= finalScrollContainerRect.bottom - threshold.height) {
    // Scroll Down
    direction.y = Direction.Forward;
    speed.y = acceleration * Math.abs((finalScrollContainerRect.bottom - threshold.height - bottom) / threshold.height);
  }

  if (!isRight && right >= finalScrollContainerRect.right - threshold.width) {
    // Scroll Right
    direction.x = Direction.Forward;
    speed.x = acceleration * Math.abs((finalScrollContainerRect.right - threshold.width - right) / threshold.width);
  } else if (!isLeft && left <= finalScrollContainerRect.left + threshold.width) {
    // Scroll Left
    direction.x = Direction.Backward;
    speed.x = acceleration * Math.abs((finalScrollContainerRect.left + threshold.width - left) / threshold.width);
  }

  return {
    direction,
    speed
  };
}

function getScrollElementRect(element) {
  if (element === document.scrollingElement) {
    const {
      innerWidth,
      innerHeight
    } = window;
    return {
      top: 0,
      left: 0,
      right: innerWidth,
      bottom: innerHeight,
      width: innerWidth,
      height: innerHeight
    };
  }

  const {
    top,
    left,
    right,
    bottom
  } = element.getBoundingClientRect();
  return {
    top,
    left,
    right,
    bottom,
    width: element.clientWidth,
    height: element.clientHeight
  };
}

function getScrollOffsets(scrollableAncestors) {
  return scrollableAncestors.reduce((acc, node) => {
    return (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.add)(acc, getScrollCoordinates(node));
  }, defaultCoordinates);
}
function getScrollXOffset(scrollableAncestors) {
  return scrollableAncestors.reduce((acc, node) => {
    return acc + getScrollXCoordinate(node);
  }, 0);
}
function getScrollYOffset(scrollableAncestors) {
  return scrollableAncestors.reduce((acc, node) => {
    return acc + getScrollYCoordinate(node);
  }, 0);
}

const properties = [['x', ['left', 'right'], getScrollXOffset], ['y', ['top', 'bottom'], getScrollYOffset]];
class Rect {
  constructor(rect, element) {
    this.rect = void 0;
    this.width = void 0;
    this.height = void 0;
    this.top = void 0;
    this.bottom = void 0;
    this.right = void 0;
    this.left = void 0;
    const scrollableAncestors = getScrollableAncestors(element);
    const scrollOffsets = getScrollOffsets(scrollableAncestors);
    this.rect = { ...rect
    };
    this.width = rect.width;
    this.height = rect.height;

    for (const [axis, keys, getScrollOffset] of properties) {
      for (const key of keys) {
        Object.defineProperty(this, key, {
          get: () => {
            const currentOffsets = getScrollOffset(scrollableAncestors);
            const scrollOffsetsDeltla = scrollOffsets[axis] - currentOffsets;
            return this.rect[key] + scrollOffsetsDeltla;
          },
          enumerable: true
        });
      }
    }

    Object.defineProperty(this, 'rect', {
      enumerable: false
    });
  }

}

var AutoScrollActivator;

(function (AutoScrollActivator) {
  AutoScrollActivator[AutoScrollActivator["Pointer"] = 0] = "Pointer";
  AutoScrollActivator[AutoScrollActivator["DraggableRect"] = 1] = "DraggableRect";
})(AutoScrollActivator || (AutoScrollActivator = {}));

var TraversalOrder;

(function (TraversalOrder) {
  TraversalOrder[TraversalOrder["TreeOrder"] = 0] = "TreeOrder";
  TraversalOrder[TraversalOrder["ReversedTreeOrder"] = 1] = "ReversedTreeOrder";
})(TraversalOrder || (TraversalOrder = {}));

function useAutoScroller({
  acceleration,
  activator = AutoScrollActivator.Pointer,
  canScroll,
  draggingRect,
  enabled,
  interval = 5,
  order = TraversalOrder.TreeOrder,
  pointerCoordinates,
  scrollableAncestors,
  scrollableAncestorRects,
  threshold
}) {
  const [setAutoScrollInterval, clearAutoScrollInterval] = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useInterval)();
  const scrollSpeed = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)({
    x: 1,
    y: 1
  });
  const rect = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    switch (activator) {
      case AutoScrollActivator.Pointer:
        return pointerCoordinates ? {
          top: pointerCoordinates.y,
          bottom: pointerCoordinates.y,
          left: pointerCoordinates.x,
          right: pointerCoordinates.x
        } : null;

      case AutoScrollActivator.DraggableRect:
        return draggingRect;
    }

    return null;
  }, [activator, draggingRect, pointerCoordinates]);
  const scrollDirection = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(defaultCoordinates);
  const scrollContainerRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const autoScroll = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(() => {
    const scrollContainer = scrollContainerRef.current;

    if (!scrollContainer) {
      return;
    }

    const scrollLeft = scrollSpeed.current.x * scrollDirection.current.x;
    const scrollTop = scrollSpeed.current.y * scrollDirection.current.y;
    scrollContainer.scrollBy(scrollLeft, scrollTop);
  }, []);
  const sortedScrollableAncestors = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => order === TraversalOrder.TreeOrder ? [...scrollableAncestors].reverse() : scrollableAncestors, [order, scrollableAncestors]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!enabled || !scrollableAncestors.length || !rect) {
      clearAutoScrollInterval();
      return;
    }

    for (const scrollContainer of sortedScrollableAncestors) {
      if ((canScroll == null ? void 0 : canScroll(scrollContainer)) === false) {
        continue;
      }

      const index = scrollableAncestors.indexOf(scrollContainer);
      const scrollContainerRect = scrollableAncestorRects[index];

      if (!scrollContainerRect) {
        continue;
      }

      const {
        direction,
        speed
      } = getScrollDirectionAndSpeed(scrollContainer, scrollContainerRect, rect, acceleration, threshold);

      if (speed.x > 0 || speed.y > 0) {
        clearAutoScrollInterval();
        scrollContainerRef.current = scrollContainer;
        setAutoScrollInterval(autoScroll, interval);
        scrollSpeed.current = speed;
        scrollDirection.current = direction;
        return;
      }
    }

    scrollSpeed.current = {
      x: 0,
      y: 0
    };
    scrollDirection.current = {
      x: 0,
      y: 0
    };
    clearAutoScrollInterval();
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [acceleration, autoScroll, canScroll, clearAutoScrollInterval, enabled, interval, // eslint-disable-next-line react-hooks/exhaustive-deps
  JSON.stringify(rect), setAutoScrollInterval, scrollableAncestors, sortedScrollableAncestors, scrollableAncestorRects, // eslint-disable-next-line react-hooks/exhaustive-deps
  JSON.stringify(threshold)]);
}

function useCachedNode(draggableNodes, id) {
  const draggableNode = id !== null ? draggableNodes[id] : undefined;
  const node = draggableNode ? draggableNode.node.current : null;
  return (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLazyMemo)(cachedNode => {
    var _ref;

    if (id === null) {
      return null;
    } // In some cases, the draggable node can unmount while dragging
    // This is the case for virtualized lists. In those situations,
    // we fall back to the last known value for that node.


    return (_ref = node != null ? node : cachedNode) != null ? _ref : null;
  }, [node, id]);
}

function useCombineActivators(sensors, getSyntheticHandler) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => sensors.reduce((accumulator, sensor) => {
    const {
      sensor: Sensor
    } = sensor;
    const sensorActivators = Sensor.activators.map(activator => ({
      eventName: activator.eventName,
      handler: getSyntheticHandler(activator.handler, sensor)
    }));
    return [...accumulator, ...sensorActivators];
  }, []), [sensors, getSyntheticHandler]);
}

var MeasuringStrategy;

(function (MeasuringStrategy) {
  MeasuringStrategy[MeasuringStrategy["Always"] = 0] = "Always";
  MeasuringStrategy[MeasuringStrategy["BeforeDragging"] = 1] = "BeforeDragging";
  MeasuringStrategy[MeasuringStrategy["WhileDragging"] = 2] = "WhileDragging";
})(MeasuringStrategy || (MeasuringStrategy = {}));

var MeasuringFrequency;

(function (MeasuringFrequency) {
  MeasuringFrequency["Optimized"] = "optimized";
})(MeasuringFrequency || (MeasuringFrequency = {}));

const defaultValue = /*#__PURE__*/new Map();
const defaultConfig = {
  measure: getTransformAgnosticClientRect,
  strategy: MeasuringStrategy.WhileDragging,
  frequency: MeasuringFrequency.Optimized
};
function useDroppableMeasuring(containers, {
  dragging,
  dependencies,
  config
}) {
  const [containerIdsScheduledForMeasurement, setContainerIdsScheduledForMeasurement] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const measuringScheduled = containerIdsScheduledForMeasurement != null;
  const {
    frequency,
    measure,
    strategy
  } = { ...defaultConfig,
    ...config
  };
  const containersRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(containers);
  const measureDroppableContainers = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)((ids = []) => setContainerIdsScheduledForMeasurement(value => value ? value.concat(ids) : ids), []);
  const timeoutId = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const disabled = isDisabled();
  const droppableRects = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLazyMemo)(previousValue => {
    if (disabled && !dragging) {
      return defaultValue;
    }

    const ids = containerIdsScheduledForMeasurement;

    if (!previousValue || previousValue === defaultValue || containersRef.current !== containers || ids != null) {
      const map = new Map();

      for (let container of containers) {
        if (!container) {
          continue;
        }

        if (ids && ids.length > 0 && !ids.includes(container.id) && container.rect.current) {
          // This container does not need to be re-measured
          map.set(container.id, container.rect.current);
          continue;
        }

        const node = container.node.current;
        const rect = node ? new Rect(measure(node), node) : null;
        container.rect.current = rect;

        if (rect) {
          map.set(container.id, rect);
        }
      }

      return map;
    }

    return previousValue;
  }, [containers, containerIdsScheduledForMeasurement, dragging, disabled, measure]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    containersRef.current = containers;
  }, [containers]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (disabled) {
      return;
    }

    requestAnimationFrame(() => measureDroppableContainers());
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [dragging, disabled]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (measuringScheduled) {
      setContainerIdsScheduledForMeasurement(null);
    }
  }, [measuringScheduled]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (disabled || typeof frequency !== 'number' || timeoutId.current !== null) {
      return;
    }

    timeoutId.current = setTimeout(() => {
      measureDroppableContainers();
      timeoutId.current = null;
    }, frequency);
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [frequency, disabled, measureDroppableContainers, ...dependencies]);
  return {
    droppableRects,
    measureDroppableContainers,
    measuringScheduled
  };

  function isDisabled() {
    switch (strategy) {
      case MeasuringStrategy.Always:
        return false;

      case MeasuringStrategy.BeforeDragging:
        return dragging;

      default:
        return !dragging;
    }
  }
}

/**
 * Returns a new ResizeObserver instance bound to the `onResize` callback.
 * If `ResizeObserver` is undefined in the execution environment, returns `undefined`.
 */

function useResizeObserver({
  onResize,
  disabled
}) {
  const resizeObserver = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    if (disabled || typeof window === 'undefined' || typeof window.ResizeObserver === 'undefined') {
      return undefined;
    }

    const {
      ResizeObserver
    } = window;
    return new ResizeObserver(onResize);
  }, [disabled, onResize]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    return () => resizeObserver == null ? void 0 : resizeObserver.disconnect();
  }, [resizeObserver]);
  return resizeObserver;
}

function useScrollOffsets(elements) {
  const [scrollCoordinates, setScrollCoordinates] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const prevElements = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(elements); // To-do: Throttle the handleScroll callback

  const handleScroll = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(event => {
    const scrollingElement = getScrollableElement(event.target);

    if (!scrollingElement) {
      return;
    }

    setScrollCoordinates(scrollCoordinates => {
      if (!scrollCoordinates) {
        return null;
      }

      scrollCoordinates.set(scrollingElement, getScrollCoordinates(scrollingElement));
      return new Map(scrollCoordinates);
    });
  }, []);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const previousElements = prevElements.current;

    if (elements !== previousElements) {
      cleanup(previousElements);
      const entries = elements.map(element => {
        const scrollableElement = getScrollableElement(element);

        if (scrollableElement) {
          scrollableElement.addEventListener('scroll', handleScroll, {
            passive: true
          });
          return [scrollableElement, getScrollCoordinates(scrollableElement)];
        }

        return null;
      }).filter(entry => entry != null);
      setScrollCoordinates(entries.length ? new Map(entries) : null);
      prevElements.current = elements;
    }

    return () => {
      cleanup(elements);
      cleanup(previousElements);
    };

    function cleanup(elements) {
      elements.forEach(element => {
        const scrollableElement = getScrollableElement(element);
        scrollableElement == null ? void 0 : scrollableElement.removeEventListener('scroll', handleScroll);
      });
    }
  }, [handleScroll, elements]);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    if (elements.length) {
      return scrollCoordinates ? Array.from(scrollCoordinates.values()).reduce((acc, coordinates) => (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.add)(acc, coordinates), defaultCoordinates) : getScrollOffsets(elements);
    }

    return defaultCoordinates;
  }, [elements, scrollCoordinates]);
}

const defaultValue$1 = [];
function useScrollableAncestors(node) {
  const previousNode = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(node);
  const ancestors = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLazyMemo)(previousValue => {
    if (!node) {
      return defaultValue$1;
    }

    if (previousValue && node && previousNode.current && node.parentNode === previousNode.current.parentNode) {
      return previousValue;
    }

    return getScrollableAncestors(node);
  }, [node]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    previousNode.current = node;
  }, [node]);
  return ancestors;
}

function useSensorSetup(sensors) {
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.canUseDOM) {
      return;
    }

    const teardownFns = sensors.map(({
      sensor
    }) => sensor.setup == null ? void 0 : sensor.setup());
    return () => {
      for (const teardown of teardownFns) {
        teardown == null ? void 0 : teardown();
      }
    };
  }, // TO-DO: Sensors length could theoretically change which would not be a valid dependency
  // eslint-disable-next-line react-hooks/exhaustive-deps
  sensors.map(({
    sensor
  }) => sensor));
}

function useSyntheticListeners(listeners, id) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    return listeners.reduce((acc, {
      eventName,
      handler
    }) => {
      acc[eventName] = event => {
        handler(event, id);
      };

      return acc;
    }, {});
  }, [listeners, id]);
}

const useClientRect = /*#__PURE__*/createUseRectFn(getTransformAgnosticClientRect);
const useClientRects = /*#__PURE__*/createUseRectsFn(getTransformAgnosticClientRect);
function useRect(element, getRect, forceRecompute) {
  const previousElement = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(element);
  return (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLazyMemo)(previousValue => {
    if (!element) {
      return null;
    }

    if (forceRecompute || !previousValue && element || element !== previousElement.current) {
      if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isHTMLElement)(element) && element.parentNode == null) {
        return null;
      }

      return new Rect(getRect(element), element);
    }

    return previousValue != null ? previousValue : null;
  }, [element, forceRecompute, getRect]);
}
function createUseRectFn(getRect) {
  return (element, forceRecompute) => useRect(element, getRect, forceRecompute);
}

function createUseRectsFn(getRect) {
  const defaultValue = [];
  return function useRects(elements, forceRecompute) {
    const previousElements = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(elements);
    return (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLazyMemo)(previousValue => {
      if (!elements.length) {
        return defaultValue;
      }

      if (forceRecompute || !previousValue && elements.length || elements !== previousElements.current) {
        return elements.map(element => new Rect(getRect(element), element));
      }

      return previousValue != null ? previousValue : defaultValue;
    }, [elements, forceRecompute]);
  };
}

function useWindowRect(element) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => element ? getWindowClientRect(element) : null, [element]);
}

function getMeasurableNode(node) {
  if (!node) {
    return null;
  }

  if (node.children.length > 1) {
    return node;
  }

  const firstChild = node.children[0];
  return (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isHTMLElement)(firstChild) ? firstChild : node;
}

function useDragOverlayMeasuring({
  measure = getClientRect
}) {
  const [rect, setRect] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const handleResize = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(entries => {
    for (const {
      target
    } of entries) {
      if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isHTMLElement)(target)) {
        setRect(rect => {
          const newRect = measure(target);
          return rect ? { ...rect,
            width: newRect.width,
            height: newRect.height
          } : newRect;
        });
        break;
      }
    }
  }, [measure]);
  const resizeObserver = useResizeObserver({
    onResize: handleResize
  });
  const handleNodeChange = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(element => {
    const node = getMeasurableNode(element);
    resizeObserver == null ? void 0 : resizeObserver.disconnect();

    if (node) {
      resizeObserver == null ? void 0 : resizeObserver.observe(node);
    }

    setRect(node ? measure(node) : null);
  }, [measure, resizeObserver]);
  const [nodeRef, setRef] = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useNodeRef)(handleNodeChange);
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => ({
    nodeRef,
    rect,
    setRef
  }), [rect, nodeRef, setRef]);
}

function useSensor(sensor, options) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => ({
    sensor,
    options: options != null ? options : {}
  }), // eslint-disable-next-line react-hooks/exhaustive-deps
  [sensor, options]);
}

function useSensors(...sensors) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => [...sensors].filter(sensor => sensor != null), // eslint-disable-next-line react-hooks/exhaustive-deps
  [...sensors]);
}

class Listeners {
  constructor(target) {
    this.target = void 0;
    this.listeners = [];

    this.removeAll = () => {
      this.listeners.forEach(listener => {
        var _this$target;

        return (_this$target = this.target) == null ? void 0 : _this$target.removeEventListener(...listener);
      });
    };

    this.target = target;
  }

  add(eventName, handler, options) {
    var _this$target2;

    (_this$target2 = this.target) == null ? void 0 : _this$target2.addEventListener(eventName, handler, options);
    this.listeners.push([eventName, handler, options]);
  }

}

function getEventListenerTarget(target) {
  // If the `event.target` element is removed from the document events will still be targeted
  // at it, and hence won't always bubble up to the window or document anymore.
  // If there is any risk of an element being removed while it is being dragged,
  // the best practice is to attach the event listeners directly to the target.
  // https://developer.mozilla.org/en-US/docs/Web/API/EventTarget
  const {
    EventTarget
  } = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(target);
  return target instanceof EventTarget ? target : (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getOwnerDocument)(target);
}

function hasExceededDistance(delta, measurement) {
  const dx = Math.abs(delta.x);
  const dy = Math.abs(delta.y);

  if (typeof measurement === 'number') {
    return Math.sqrt(dx ** 2 + dy ** 2) > measurement;
  }

  if ('x' in measurement && 'y' in measurement) {
    return dx > measurement.x && dy > measurement.y;
  }

  if ('x' in measurement) {
    return dx > measurement.x;
  }

  if ('y' in measurement) {
    return dy > measurement.y;
  }

  return false;
}

var EventName;

(function (EventName) {
  EventName["Click"] = "click";
  EventName["DragStart"] = "dragstart";
  EventName["Keydown"] = "keydown";
  EventName["ContextMenu"] = "contextmenu";
  EventName["Resize"] = "resize";
  EventName["SelectionChange"] = "selectionchange";
  EventName["VisibilityChange"] = "visibilitychange";
})(EventName || (EventName = {}));

function preventDefault(event) {
  event.preventDefault();
}
function stopPropagation(event) {
  event.stopPropagation();
}

var KeyboardCode;

(function (KeyboardCode) {
  KeyboardCode["Space"] = "Space";
  KeyboardCode["Down"] = "ArrowDown";
  KeyboardCode["Right"] = "ArrowRight";
  KeyboardCode["Left"] = "ArrowLeft";
  KeyboardCode["Up"] = "ArrowUp";
  KeyboardCode["Esc"] = "Escape";
  KeyboardCode["Enter"] = "Enter";
})(KeyboardCode || (KeyboardCode = {}));

const defaultKeyboardCodes = {
  start: [KeyboardCode.Space, KeyboardCode.Enter],
  cancel: [KeyboardCode.Esc],
  end: [KeyboardCode.Space, KeyboardCode.Enter]
};
const defaultKeyboardCoordinateGetter = (event, {
  currentCoordinates
}) => {
  switch (event.code) {
    case KeyboardCode.Right:
      return { ...currentCoordinates,
        x: currentCoordinates.x + 25
      };

    case KeyboardCode.Left:
      return { ...currentCoordinates,
        x: currentCoordinates.x - 25
      };

    case KeyboardCode.Down:
      return { ...currentCoordinates,
        y: currentCoordinates.y + 25
      };

    case KeyboardCode.Up:
      return { ...currentCoordinates,
        y: currentCoordinates.y - 25
      };
  }

  return undefined;
};

class KeyboardSensor {
  constructor(props) {
    this.props = void 0;
    this.autoScrollEnabled = false;
    this.coordinates = defaultCoordinates;
    this.listeners = void 0;
    this.windowListeners = void 0;
    this.props = props;
    const {
      event: {
        target
      }
    } = props;
    this.props = props;
    this.listeners = new Listeners((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getOwnerDocument)(target));
    this.windowListeners = new Listeners((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(target));
    this.handleKeyDown = this.handleKeyDown.bind(this);
    this.handleCancel = this.handleCancel.bind(this);
    this.attach();
  }

  attach() {
    this.handleStart();
    this.windowListeners.add(EventName.Resize, this.handleCancel);
    this.windowListeners.add(EventName.VisibilityChange, this.handleCancel);
    setTimeout(() => this.listeners.add(EventName.Keydown, this.handleKeyDown));
  }

  handleStart() {
    const {
      activeNode,
      onStart
    } = this.props;

    if (!activeNode.node.current) {
      throw new Error('Active draggable node is undefined');
    }

    const activeNodeRect = getTransformAgnosticClientRect(activeNode.node.current);
    const coordinates = {
      x: activeNodeRect.left,
      y: activeNodeRect.top
    };
    this.coordinates = coordinates;
    onStart(coordinates);
  }

  handleKeyDown(event) {
    if ((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isKeyboardEvent)(event)) {
      const {
        coordinates
      } = this;
      const {
        active,
        context,
        options
      } = this.props;
      const {
        keyboardCodes = defaultKeyboardCodes,
        coordinateGetter = defaultKeyboardCoordinateGetter,
        scrollBehavior = 'smooth'
      } = options;
      const {
        code
      } = event;

      if (keyboardCodes.end.includes(code)) {
        this.handleEnd(event);
        return;
      }

      if (keyboardCodes.cancel.includes(code)) {
        this.handleCancel(event);
        return;
      }

      const newCoordinates = coordinateGetter(event, {
        active,
        context: context.current,
        currentCoordinates: coordinates
      });

      if (newCoordinates) {
        const scrollDelta = {
          x: 0,
          y: 0
        };
        const {
          scrollableAncestors
        } = context.current;

        for (const scrollContainer of scrollableAncestors) {
          const direction = event.code;
          const coordinatesDelta = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.subtract)(newCoordinates, coordinates);
          const {
            isTop,
            isRight,
            isLeft,
            isBottom,
            maxScroll,
            minScroll
          } = getScrollPosition(scrollContainer);
          const scrollElementRect = getScrollElementRect(scrollContainer);
          const clampedCoordinates = {
            x: Math.min(direction === KeyboardCode.Right ? scrollElementRect.right - scrollElementRect.width / 2 : scrollElementRect.right, Math.max(direction === KeyboardCode.Right ? scrollElementRect.left : scrollElementRect.left + scrollElementRect.width / 2, newCoordinates.x)),
            y: Math.min(direction === KeyboardCode.Down ? scrollElementRect.bottom - scrollElementRect.height / 2 : scrollElementRect.bottom, Math.max(direction === KeyboardCode.Down ? scrollElementRect.top : scrollElementRect.top + scrollElementRect.height / 2, newCoordinates.y))
          };
          const canScrollX = direction === KeyboardCode.Right && !isRight || direction === KeyboardCode.Left && !isLeft;
          const canScrollY = direction === KeyboardCode.Down && !isBottom || direction === KeyboardCode.Up && !isTop;

          if (canScrollX && clampedCoordinates.x !== newCoordinates.x) {
            const canFullyScrollToNewCoordinates = direction === KeyboardCode.Right && scrollContainer.scrollLeft + coordinatesDelta.x <= maxScroll.x || direction === KeyboardCode.Left && scrollContainer.scrollLeft + coordinatesDelta.x >= minScroll.x;

            if (canFullyScrollToNewCoordinates) {
              // We don't need to update coordinates, the scroll adjustment alone will trigger
              // logic to auto-detect the new container we are over
              scrollContainer.scrollBy({
                left: coordinatesDelta.x,
                behavior: scrollBehavior
              });
              return;
            }

            scrollDelta.x = direction === KeyboardCode.Right ? scrollContainer.scrollLeft - maxScroll.x : scrollContainer.scrollLeft - minScroll.x;
            scrollContainer.scrollBy({
              left: -scrollDelta.x,
              behavior: scrollBehavior
            });
            break;
          } else if (canScrollY && clampedCoordinates.y !== newCoordinates.y) {
            const canFullyScrollToNewCoordinates = direction === KeyboardCode.Down && scrollContainer.scrollTop + coordinatesDelta.y <= maxScroll.y || direction === KeyboardCode.Up && scrollContainer.scrollTop + coordinatesDelta.y >= minScroll.y;

            if (canFullyScrollToNewCoordinates) {
              // We don't need to update coordinates, the scroll adjustment alone will trigger
              // logic to auto-detect the new container we are over
              scrollContainer.scrollBy({
                top: coordinatesDelta.y,
                behavior: scrollBehavior
              });
              return;
            }

            scrollDelta.y = direction === KeyboardCode.Down ? scrollContainer.scrollTop - maxScroll.y : scrollContainer.scrollTop - minScroll.y;
            scrollContainer.scrollBy({
              top: -scrollDelta.y,
              behavior: scrollBehavior
            });
            break;
          }
        }

        this.handleMove(event, (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.add)(newCoordinates, scrollDelta));
      }
    }
  }

  handleMove(event, coordinates) {
    const {
      onMove
    } = this.props;
    event.preventDefault();
    onMove(coordinates);
    this.coordinates = coordinates;
  }

  handleEnd(event) {
    const {
      onEnd
    } = this.props;
    event.preventDefault();
    this.detach();
    onEnd();
  }

  handleCancel(event) {
    const {
      onCancel
    } = this.props;
    event.preventDefault();
    this.detach();
    onCancel();
  }

  detach() {
    this.listeners.removeAll();
    this.windowListeners.removeAll();
  }

}
KeyboardSensor.activators = [{
  eventName: 'onKeyDown',
  handler: (event, {
    keyboardCodes = defaultKeyboardCodes,
    onActivation
  }) => {
    const {
      code
    } = event.nativeEvent;

    if (keyboardCodes.start.includes(code)) {
      event.preventDefault();
      onActivation == null ? void 0 : onActivation({
        event: event.nativeEvent
      });
      return true;
    }

    return false;
  }
}];

function isDistanceConstraint(constraint) {
  return Boolean(constraint && 'distance' in constraint);
}

function isDelayConstraint(constraint) {
  return Boolean(constraint && 'delay' in constraint);
}

class AbstractPointerSensor {
  constructor(props, events, listenerTarget = getEventListenerTarget(props.event.target)) {
    var _getEventCoordinates;

    this.props = void 0;
    this.events = void 0;
    this.autoScrollEnabled = true;
    this.document = void 0;
    this.activated = false;
    this.initialCoordinates = void 0;
    this.timeoutId = null;
    this.listeners = void 0;
    this.documentListeners = void 0;
    this.windowListeners = void 0;
    this.props = props;
    this.events = events;
    const {
      event
    } = props;
    const {
      target
    } = event;
    this.props = props;
    this.events = events;
    this.document = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getOwnerDocument)(target);
    this.documentListeners = new Listeners(this.document);
    this.listeners = new Listeners(listenerTarget);
    this.windowListeners = new Listeners((0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getWindow)(target));
    this.initialCoordinates = (_getEventCoordinates = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getEventCoordinates)(event)) != null ? _getEventCoordinates : defaultCoordinates;
    this.handleStart = this.handleStart.bind(this);
    this.handleMove = this.handleMove.bind(this);
    this.handleEnd = this.handleEnd.bind(this);
    this.handleCancel = this.handleCancel.bind(this);
    this.handleKeydown = this.handleKeydown.bind(this);
    this.removeTextSelection = this.removeTextSelection.bind(this);
    this.attach();
  }

  attach() {
    const {
      events,
      props: {
        options: {
          activationConstraint
        }
      }
    } = this;
    this.listeners.add(events.move.name, this.handleMove, {
      passive: false
    });
    this.listeners.add(events.end.name, this.handleEnd);
    this.windowListeners.add(EventName.Resize, this.handleCancel);
    this.windowListeners.add(EventName.DragStart, preventDefault);
    this.windowListeners.add(EventName.VisibilityChange, this.handleCancel);
    this.windowListeners.add(EventName.ContextMenu, preventDefault);
    this.documentListeners.add(EventName.Keydown, this.handleKeydown);

    if (activationConstraint) {
      if (isDistanceConstraint(activationConstraint)) {
        return;
      }

      if (isDelayConstraint(activationConstraint)) {
        this.timeoutId = setTimeout(this.handleStart, activationConstraint.delay);
        return;
      }
    }

    this.handleStart();
  }

  detach() {
    this.listeners.removeAll();
    this.windowListeners.removeAll(); // Wait until the next event loop before removing document listeners
    // This is necessary because we listen for `click` and `selection` events on the document

    setTimeout(this.documentListeners.removeAll, 50);

    if (this.timeoutId !== null) {
      clearTimeout(this.timeoutId);
      this.timeoutId = null;
    }
  }

  handleStart() {
    const {
      initialCoordinates
    } = this;
    const {
      onStart
    } = this.props;

    if (initialCoordinates) {
      this.activated = true; // Stop propagation of click events once activation constraints are met

      this.documentListeners.add(EventName.Click, stopPropagation, {
        capture: true
      }); // Remove any text selection from the document

      this.removeTextSelection(); // Prevent further text selection while dragging

      this.documentListeners.add(EventName.SelectionChange, this.removeTextSelection);
      onStart(initialCoordinates);
    }
  }

  handleMove(event) {
    var _getEventCoordinates2;

    const {
      activated,
      initialCoordinates,
      props
    } = this;
    const {
      onMove,
      options: {
        activationConstraint
      }
    } = props;

    if (!initialCoordinates) {
      return;
    }

    const coordinates = (_getEventCoordinates2 = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getEventCoordinates)(event)) != null ? _getEventCoordinates2 : defaultCoordinates;
    const delta = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.subtract)(initialCoordinates, coordinates);

    if (!activated && activationConstraint) {
      // Constraint validation
      if (isDelayConstraint(activationConstraint)) {
        if (hasExceededDistance(delta, activationConstraint.tolerance)) {
          return this.handleCancel();
        }

        return;
      }

      if (isDistanceConstraint(activationConstraint)) {
        if (activationConstraint.tolerance != null && hasExceededDistance(delta, activationConstraint.tolerance)) {
          return this.handleCancel();
        }

        if (hasExceededDistance(delta, activationConstraint.distance)) {
          return this.handleStart();
        }

        return;
      }
    }

    if (event.cancelable) {
      event.preventDefault();
    }

    onMove(coordinates);
  }

  handleEnd() {
    const {
      onEnd
    } = this.props;
    this.detach();
    onEnd();
  }

  handleCancel() {
    const {
      onCancel
    } = this.props;
    this.detach();
    onCancel();
  }

  handleKeydown(event) {
    if (event.code === KeyboardCode.Esc) {
      this.handleCancel();
    }
  }

  removeTextSelection() {
    var _this$document$getSel;

    (_this$document$getSel = this.document.getSelection()) == null ? void 0 : _this$document$getSel.removeAllRanges();
  }

}

const events = {
  move: {
    name: 'pointermove'
  },
  end: {
    name: 'pointerup'
  }
};
class PointerSensor extends AbstractPointerSensor {
  constructor(props) {
    const {
      event
    } = props; // Pointer events stop firing if the target is unmounted while dragging
    // Therefore we attach listeners to the owner document instead

    const listenerTarget = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getOwnerDocument)(event.target);
    super(props, events, listenerTarget);
  }

}
PointerSensor.activators = [{
  eventName: 'onPointerDown',
  handler: ({
    nativeEvent: event
  }, {
    onActivation
  }) => {
    if (!event.isPrimary || event.button !== 0) {
      return false;
    }

    onActivation == null ? void 0 : onActivation({
      event
    });
    return true;
  }
}];

const events$1 = {
  move: {
    name: 'mousemove'
  },
  end: {
    name: 'mouseup'
  }
};
var MouseButton;

(function (MouseButton) {
  MouseButton[MouseButton["RightClick"] = 2] = "RightClick";
})(MouseButton || (MouseButton = {}));

class MouseSensor extends AbstractPointerSensor {
  constructor(props) {
    super(props, events$1, (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getOwnerDocument)(props.event.target));
  }

}
MouseSensor.activators = [{
  eventName: 'onMouseDown',
  handler: ({
    nativeEvent: event
  }, {
    onActivation
  }) => {
    if (event.button === MouseButton.RightClick) {
      return false;
    }

    onActivation == null ? void 0 : onActivation({
      event
    });
    return true;
  }
}];

const events$2 = {
  move: {
    name: 'touchmove'
  },
  end: {
    name: 'touchend'
  }
};
class TouchSensor extends AbstractPointerSensor {
  constructor(props) {
    super(props, events$2);
  }

  static setup() {
    // Adding a non-capture and non-passive `touchmove` listener in order
    // to force `event.preventDefault()` calls to work in dynamically added
    // touchmove event handlers. This is required for iOS Safari.
    window.addEventListener(events$2.move.name, noop, {
      capture: false,
      passive: false
    });
    return function teardown() {
      window.removeEventListener(events$2.move.name, noop);
    }; // We create a new handler because the teardown function of another sensor
    // could remove our event listener if we use a referentially equal listener.

    function noop() {}
  }

}
TouchSensor.activators = [{
  eventName: 'onTouchStart',
  handler: ({
    nativeEvent: event
  }, {
    onActivation
  }) => {
    const {
      touches
    } = event;

    if (touches.length > 1) {
      return false;
    }

    onActivation == null ? void 0 : onActivation({
      event
    });
    return true;
  }
}];

function applyModifiers(modifiers, {
  transform,
  ...args
}) {
  return (modifiers == null ? void 0 : modifiers.length) ? modifiers.reduce((accumulator, modifier) => {
    return modifier({
      transform: accumulator,
      ...args
    });
  }, transform) : transform;
}

const defaultSensors = [{
  sensor: PointerSensor,
  options: {}
}, {
  sensor: KeyboardSensor,
  options: {}
}];
const defaultData = {
  current: {}
};
const ActiveDraggableContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)({ ...defaultCoordinates,
  scaleX: 1,
  scaleY: 1
});
const DndContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.memo)(function DndContext({
  id,
  autoScroll = true,
  announcements,
  children,
  sensors = defaultSensors,
  collisionDetection = rectIntersection,
  measuring,
  modifiers,
  screenReaderInstructions: screenReaderInstructions$1 = screenReaderInstructions,
  ...props
}) {
  var _measuring$draggable$, _measuring$draggable, _sensorContext$curren, _measuring$dragOverla, _dragOverlay$nodeRef$, _dragOverlay$rect, _over$rect;

  const store = (0,react__WEBPACK_IMPORTED_MODULE_0__.useReducer)(reducer, undefined, getInitialState);
  const [state, dispatch] = store;
  const [monitorState, setMonitorState] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(() => ({
    type: null,
    event: null
  }));
  const [isDragging, setIsDragging] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  const {
    draggable: {
      active: activeId,
      nodes: draggableNodes,
      translate
    },
    droppable: {
      containers: droppableContainers
    }
  } = state;
  const node = activeId ? draggableNodes[activeId] : null;
  const activeRects = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)({
    initial: null,
    translated: null
  });
  const active = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    var _node$data;

    return activeId != null ? {
      id: activeId,
      // It's possible for the active node to unmount while dragging
      data: (_node$data = node == null ? void 0 : node.data) != null ? _node$data : defaultData,
      rect: activeRects
    } : null;
  }, [activeId, node]);
  const activeRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const [activeSensor, setActiveSensor] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const [activatorEvent, setActivatorEvent] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const latestProps = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLatestValue)(props, Object.values(props));
  const draggableDescribedById = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useUniqueId)(`DndDescribedBy`, id);
  const enabledDroppableContainers = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => droppableContainers.getEnabled(), [droppableContainers]);
  const {
    droppableRects,
    measureDroppableContainers,
    measuringScheduled
  } = useDroppableMeasuring(enabledDroppableContainers, {
    dragging: isDragging,
    dependencies: [translate.x, translate.y],
    config: measuring == null ? void 0 : measuring.droppable
  });
  const activeNode = useCachedNode(draggableNodes, activeId);
  const activationCoordinates = activatorEvent ? (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.getEventCoordinates)(activatorEvent) : null;
  const activeNodeRect = useRect(activeNode, (_measuring$draggable$ = measuring == null ? void 0 : (_measuring$draggable = measuring.draggable) == null ? void 0 : _measuring$draggable.measure) != null ? _measuring$draggable$ : getTransformAgnosticClientRect);
  const containerNodeRect = useClientRect(activeNode ? activeNode.parentElement : null);
  const sensorContext = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)({
    active: null,
    activeNode,
    collisionRect: null,
    collisions: null,
    droppableRects,
    draggableNodes,
    draggingNode: null,
    draggingNodeRect: null,
    droppableContainers,
    over: null,
    scrollableAncestors: [],
    scrollAdjustedTranslate: null
  });
  const overNode = droppableContainers.getNodeFor((_sensorContext$curren = sensorContext.current.over) == null ? void 0 : _sensorContext$curren.id);
  const dragOverlay = useDragOverlayMeasuring({
    measure: measuring == null ? void 0 : (_measuring$dragOverla = measuring.dragOverlay) == null ? void 0 : _measuring$dragOverla.measure
  }); // Use the rect of the drag overlay if it is mounted

  const draggingNode = (_dragOverlay$nodeRef$ = dragOverlay.nodeRef.current) != null ? _dragOverlay$nodeRef$ : activeNode;
  const draggingNodeRect = (_dragOverlay$rect = dragOverlay.rect) != null ? _dragOverlay$rect : activeNodeRect;
  const initialActiveNodeRectRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const initialActiveNodeRect = initialActiveNodeRectRef.current; // The delta between the previous and new position of the draggable node
  // is only relevant when there is no drag overlay

  const nodeRectDelta = draggingNodeRect === activeNodeRect ? getRectDelta(activeNodeRect, initialActiveNodeRect) : defaultCoordinates; // Get the window rect of the dragging node

  const windowRect = useWindowRect(draggingNode ? draggingNode.ownerDocument.defaultView : null); // Get scrollable ancestors of the dragging node

  const scrollableAncestors = useScrollableAncestors(activeId ? overNode != null ? overNode : draggingNode : null);
  const scrollableAncestorRects = useClientRects(scrollableAncestors); // Apply modifiers

  const modifiedTranslate = applyModifiers(modifiers, {
    transform: {
      x: translate.x - nodeRectDelta.x,
      y: translate.y - nodeRectDelta.y,
      scaleX: 1,
      scaleY: 1
    },
    activatorEvent,
    active,
    activeNodeRect,
    containerNodeRect,
    draggingNodeRect,
    over: sensorContext.current.over,
    overlayNodeRect: dragOverlay.rect,
    scrollableAncestors,
    scrollableAncestorRects,
    windowRect
  });
  const pointerCoordinates = activationCoordinates ? (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.add)(activationCoordinates, translate) : null;
  const scrollAdjustment = useScrollOffsets(scrollableAncestors);
  const scrollAdjustedTranslate = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.add)(modifiedTranslate, scrollAdjustment);
  const collisionRect = draggingNodeRect ? getAdjustedRect(draggingNodeRect, modifiedTranslate) : null;
  const collisions = active && collisionRect ? collisionDetection({
    active,
    collisionRect,
    droppableContainers: enabledDroppableContainers,
    pointerCoordinates
  }) : null;
  const overId = getFirstCollision(collisions, 'id');
  const [over, setOver] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const transform = adjustScale(modifiedTranslate, (_over$rect = over == null ? void 0 : over.rect) != null ? _over$rect : null, activeNodeRect);
  const instantiateSensor = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)((event, {
    sensor: Sensor,
    options
  }) => {
    if (!activeRef.current) {
      return;
    }

    const activeNode = draggableNodes[activeRef.current];

    if (!activeNode) {
      return;
    }

    const sensorInstance = new Sensor({
      active: activeRef.current,
      activeNode,
      event: event.nativeEvent,
      options,
      // Sensors need to be instantiated with refs for arguments that change over time
      // otherwise they are frozen in time with the stale arguments
      context: sensorContext,

      onStart(initialCoordinates) {
        const id = activeRef.current;

        if (!id) {
          return;
        }

        const node = draggableNodes[id];

        if (!node) {
          return;
        }

        const {
          onDragStart
        } = latestProps.current;
        const event = {
          active: {
            id,
            data: node.data,
            rect: activeRects
          }
        };
        (0,react_dom__WEBPACK_IMPORTED_MODULE_1__.unstable_batchedUpdates)(() => {
          dispatch({
            type: Action.DragStart,
            initialCoordinates,
            active: id
          });
          setMonitorState({
            type: Action.DragStart,
            event
          });
        });
        onDragStart == null ? void 0 : onDragStart(event);
      },

      onMove(coordinates) {
        dispatch({
          type: Action.DragMove,
          coordinates
        });
      },

      onEnd: createHandler(Action.DragEnd),
      onCancel: createHandler(Action.DragCancel)
    });
    (0,react_dom__WEBPACK_IMPORTED_MODULE_1__.unstable_batchedUpdates)(() => {
      setActiveSensor(sensorInstance);
      setActivatorEvent(event.nativeEvent);
    });

    function createHandler(type) {
      return async function handler() {
        const {
          active,
          collisions,
          over,
          scrollAdjustedTranslate
        } = sensorContext.current;
        let event = null;

        if (active && scrollAdjustedTranslate) {
          const {
            cancelDrop
          } = latestProps.current;
          event = {
            active: active,
            collisions,
            delta: scrollAdjustedTranslate,
            over
          };

          if (type === Action.DragEnd && typeof cancelDrop === 'function') {
            const shouldCancel = await Promise.resolve(cancelDrop(event));

            if (shouldCancel) {
              type = Action.DragCancel;
            }
          }
        }

        activeRef.current = null;
        (0,react_dom__WEBPACK_IMPORTED_MODULE_1__.unstable_batchedUpdates)(() => {
          dispatch({
            type
          });
          setOver(null);
          setIsDragging(false);
          setActiveSensor(null);
          setActivatorEvent(null);

          if (event) {
            setMonitorState({
              type,
              event
            });
          }

          if (event) {
            const {
              onDragCancel,
              onDragEnd
            } = latestProps.current;
            const handler = type === Action.DragEnd ? onDragEnd : onDragCancel;
            handler == null ? void 0 : handler(event);
          }
        });
      };
    }
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [draggableNodes]);
  const bindActivatorToSensorInstantiator = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)((handler, sensor) => {
    return (event, active) => {
      const nativeEvent = event.nativeEvent;

      if ( // No active draggable
      activeRef.current !== null || // Event has already been captured
      nativeEvent.dndKit || nativeEvent.defaultPrevented) {
        return;
      }

      if (handler(event, sensor.options) === true) {
        nativeEvent.dndKit = {
          capturedBy: sensor.sensor
        };
        activeRef.current = active;
        instantiateSensor(event, sensor);
      }
    };
  }, [instantiateSensor]);
  const activators = useCombineActivators(sensors, bindActivatorToSensorInstantiator);
  useSensorSetup(sensors);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (activeId != null) {
      setIsDragging(true);
    }
  }, [activeId]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!active) {
      initialActiveNodeRectRef.current = null;
    }

    if (active && activeNodeRect && !initialActiveNodeRectRef.current) {
      initialActiveNodeRectRef.current = activeNodeRect;
    }
  }, [activeNodeRect, active]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const {
      onDragMove
    } = latestProps.current;
    const {
      active,
      collisions,
      over
    } = sensorContext.current;

    if (!active) {
      return;
    }

    const event = {
      active,
      collisions,
      delta: {
        x: scrollAdjustedTranslate.x,
        y: scrollAdjustedTranslate.y
      },
      over
    };
    setMonitorState({
      type: Action.DragMove,
      event
    });
    onDragMove == null ? void 0 : onDragMove(event);
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [scrollAdjustedTranslate.x, scrollAdjustedTranslate.y]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    const {
      active,
      collisions,
      droppableContainers,
      scrollAdjustedTranslate
    } = sensorContext.current;

    if (!active || !activeRef.current || !scrollAdjustedTranslate) {
      return;
    }

    const {
      onDragOver
    } = latestProps.current;
    const overContainer = droppableContainers.get(overId);
    const over = overContainer && overContainer.rect.current ? {
      id: overContainer.id,
      rect: overContainer.rect.current,
      data: overContainer.data,
      disabled: overContainer.disabled
    } : null;
    const event = {
      active,
      collisions,
      delta: {
        x: scrollAdjustedTranslate.x,
        y: scrollAdjustedTranslate.y
      },
      over
    };
    (0,react_dom__WEBPACK_IMPORTED_MODULE_1__.unstable_batchedUpdates)(() => {
      setOver(over);
      setMonitorState({
        type: Action.DragOver,
        event
      });
      onDragOver == null ? void 0 : onDragOver(event);
    });
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [overId]);
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    sensorContext.current = {
      active,
      activeNode,
      collisionRect,
      collisions,
      droppableRects,
      draggableNodes,
      draggingNode,
      draggingNodeRect,
      droppableContainers,
      over,
      scrollableAncestors,
      scrollAdjustedTranslate: scrollAdjustedTranslate
    };
    activeRects.current = {
      initial: draggingNodeRect,
      translated: collisionRect
    };
  }, [active, activeNode, collisions, collisionRect, draggableNodes, draggingNode, draggingNodeRect, droppableRects, droppableContainers, over, scrollableAncestors, scrollAdjustedTranslate]);
  useAutoScroller({ ...getAutoScrollerOptions(),
    draggingRect: collisionRect,
    pointerCoordinates,
    scrollableAncestors,
    scrollableAncestorRects
  });
  const publicContext = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    const context = {
      active,
      activeNode,
      activeNodeRect,
      activatorEvent,
      collisions,
      containerNodeRect,
      dragOverlay,
      draggableNodes,
      droppableContainers,
      droppableRects,
      over,
      measureDroppableContainers,
      scrollableAncestors,
      scrollableAncestorRects,
      measuringScheduled,
      windowRect
    };
    return context;
  }, [active, activeNode, activeNodeRect, activatorEvent, collisions, containerNodeRect, dragOverlay, draggableNodes, droppableContainers, droppableRects, over, measureDroppableContainers, scrollableAncestors, scrollableAncestorRects, measuringScheduled, windowRect]);
  const internalContext = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    const context = {
      activatorEvent,
      activators,
      active,
      activeNodeRect,
      ariaDescribedById: {
        draggable: draggableDescribedById
      },
      dispatch,
      draggableNodes,
      over,
      measureDroppableContainers
    };
    return context;
  }, [activatorEvent, activators, active, activeNodeRect, dispatch, draggableDescribedById, draggableNodes, over, measureDroppableContainers]);
  return react__WEBPACK_IMPORTED_MODULE_0___default().createElement(DndMonitorContext.Provider, {
    value: monitorState
  }, react__WEBPACK_IMPORTED_MODULE_0___default().createElement(InternalContext.Provider, {
    value: internalContext
  }, react__WEBPACK_IMPORTED_MODULE_0___default().createElement(PublicContext.Provider, {
    value: publicContext
  }, react__WEBPACK_IMPORTED_MODULE_0___default().createElement(ActiveDraggableContext.Provider, {
    value: transform
  }, children))), react__WEBPACK_IMPORTED_MODULE_0___default().createElement(Accessibility, {
    announcements: announcements,
    hiddenTextDescribedById: draggableDescribedById,
    screenReaderInstructions: screenReaderInstructions$1
  }));

  function getAutoScrollerOptions() {
    const activeSensorDisablesAutoscroll = (activeSensor == null ? void 0 : activeSensor.autoScrollEnabled) === false;
    const autoScrollGloballyDisabled = typeof autoScroll === 'object' ? autoScroll.enabled === false : autoScroll === false;
    const enabled = !activeSensorDisablesAutoscroll && !autoScrollGloballyDisabled;

    if (typeof autoScroll === 'object') {
      return { ...autoScroll,
        enabled
      };
    }

    return {
      enabled
    };
  }
});

const NullContext = /*#__PURE__*/(0,react__WEBPACK_IMPORTED_MODULE_0__.createContext)(null);
const defaultRole = 'button';
const ID_PREFIX = 'Droppable';
function useDraggable({
  id,
  data,
  disabled = false,
  attributes
}) {
  const key = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useUniqueId)(ID_PREFIX);
  const {
    activators,
    activatorEvent,
    active,
    activeNodeRect,
    ariaDescribedById,
    draggableNodes,
    over
  } = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(InternalContext);
  const {
    role = defaultRole,
    roleDescription = 'draggable',
    tabIndex = 0
  } = attributes != null ? attributes : {};
  const isDragging = (active == null ? void 0 : active.id) === id;
  const transform = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(isDragging ? ActiveDraggableContext : NullContext);
  const [node, setNodeRef] = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useNodeRef)();
  const listeners = useSyntheticListeners(activators, id);
  const dataRef = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLatestValue)(data);
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    draggableNodes[id] = {
      id,
      key,
      node,
      data: dataRef
    };
    return () => {
      const node = draggableNodes[id];

      if (node && node.key === key) {
        delete draggableNodes[id];
      }
    };
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [draggableNodes, id]);
  const memoizedAttributes = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => ({
    role,
    tabIndex,
    'aria-pressed': isDragging && role === defaultRole ? true : undefined,
    'aria-roledescription': roleDescription,
    'aria-describedby': ariaDescribedById.draggable
  }), [role, tabIndex, isDragging, roleDescription, ariaDescribedById.draggable]);
  return {
    active,
    activatorEvent,
    activeNodeRect,
    attributes: memoizedAttributes,
    isDragging,
    listeners: disabled ? undefined : listeners,
    node,
    over,
    setNodeRef,
    transform
  };
}

function useDndContext() {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(PublicContext);
}

const ID_PREFIX$1 = 'Droppable';
const defaultResizeObserverConfig = {
  timeout: 25
};
function useDroppable({
  data,
  disabled = false,
  id,
  resizeObserverConfig
}) {
  const key = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useUniqueId)(ID_PREFIX$1);
  const {
    active,
    dispatch,
    over,
    measureDroppableContainers
  } = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(InternalContext);
  const resizeObserverConnected = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(false);
  const rect = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const callbackId = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const {
    disabled: resizeObserverDisabled,
    updateMeasurementsFor,
    timeout: resizeObserverTimeout
  } = { ...defaultResizeObserverConfig,
    ...resizeObserverConfig
  };
  const ids = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLatestValue)(updateMeasurementsFor != null ? updateMeasurementsFor : id);
  const handleResize = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(() => {
    if (!resizeObserverConnected.current) {
      // ResizeObserver invokes the `handleResize` callback as soon as `observe` is called,
      // assuming the element is rendered and displayed.
      resizeObserverConnected.current = true;
      return;
    }

    if (callbackId.current != null) {
      clearTimeout(callbackId.current);
    }

    callbackId.current = setTimeout(() => {
      measureDroppableContainers(typeof ids.current === 'string' ? [ids.current] : ids.current);
      callbackId.current = null;
    }, resizeObserverTimeout);
  }, //eslint-disable-next-line react-hooks/exhaustive-deps
  [resizeObserverTimeout]);
  const resizeObserver = useResizeObserver({
    onResize: handleResize,
    disabled: resizeObserverDisabled || !active
  });
  const handleNodeChange = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)((newElement, previousElement) => {
    if (!resizeObserver) {
      return;
    }

    if (previousElement) {
      resizeObserver.unobserve(previousElement);
      resizeObserverConnected.current = false;
    }

    if (newElement) {
      resizeObserver.observe(newElement);
    }
  }, [resizeObserver]);
  const [nodeRef, setNodeRef] = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useNodeRef)(handleNodeChange);
  const dataRef = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLatestValue)(data);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (!resizeObserver || !nodeRef.current) {
      return;
    }

    resizeObserver.disconnect();
    resizeObserverConnected.current = false;
    resizeObserver.observe(nodeRef.current);
  }, [nodeRef, resizeObserver]);
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    dispatch({
      type: Action.RegisterDroppable,
      element: {
        id,
        key,
        disabled,
        node: nodeRef,
        rect,
        data: dataRef
      }
    });
    return () => dispatch({
      type: Action.UnregisterDroppable,
      key,
      id
    });
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [id]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    dispatch({
      type: Action.SetDroppableDisabled,
      id,
      key,
      disabled
    });
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [disabled]);
  return {
    active,
    rect,
    isOver: (over == null ? void 0 : over.id) === id,
    node: nodeRef,
    over,
    setNodeRef
  };
}

const defaultDropAnimation = {
  duration: 250,
  easing: 'ease',
  dragSourceOpacity: 0
};
function useDropAnimation({
  animate,
  adjustScale,
  activeId,
  draggableNodes,
  duration,
  dragSourceOpacity,
  easing,
  node,
  transform
}) {
  const [dropAnimationComplete, setDropAnimationComplete] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(false);
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    var _draggableNodes$activ;

    if (!animate || !activeId || !easing || !duration) {
      if (animate) {
        setDropAnimationComplete(true);
      }

      return;
    }

    const finalNode = (_draggableNodes$activ = draggableNodes[activeId]) == null ? void 0 : _draggableNodes$activ.node.current;

    if (transform && node && finalNode && finalNode.parentNode !== null) {
      const fromNode = getMeasurableNode(node);

      if (fromNode) {
        const from = fromNode.getBoundingClientRect();
        const to = getTransformAgnosticClientRect(finalNode);
        const delta = {
          x: from.left - to.left,
          y: from.top - to.top
        };

        if (Math.abs(delta.x) || Math.abs(delta.y)) {
          const scaleDelta = {
            scaleX: adjustScale ? to.width * transform.scaleX / from.width : 1,
            scaleY: adjustScale ? to.height * transform.scaleY / from.height : 1
          };
          const finalTransform = _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.CSS.Transform.toString({
            x: transform.x - delta.x,
            y: transform.y - delta.y,
            ...scaleDelta
          });
          const originalOpacity = finalNode.style.opacity;

          if (dragSourceOpacity != null) {
            finalNode.style.opacity = `${dragSourceOpacity}`;
          }

          const nodeAnimation = node.animate([{
            transform: _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.CSS.Transform.toString(transform)
          }, {
            transform: finalTransform
          }], {
            easing,
            duration
          });

          nodeAnimation.onfinish = () => {
            node.style.display = 'none';
            setDropAnimationComplete(true);

            if (finalNode && dragSourceOpacity != null) {
              finalNode.style.opacity = originalOpacity;
            }
          };

          return;
        }
      }
    }

    setDropAnimationComplete(true);
  }, [animate, activeId, adjustScale, draggableNodes, duration, easing, dragSourceOpacity, node, transform]);
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    if (dropAnimationComplete) {
      setDropAnimationComplete(false);
    }
  }, [dropAnimationComplete]);
  return dropAnimationComplete;
}

const defaultTransform = {
  x: 0,
  y: 0,
  scaleX: 1,
  scaleY: 1
};

const defaultTransition = activatorEvent => {
  const isKeyboardActivator = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isKeyboardEvent)(activatorEvent);
  return isKeyboardActivator ? 'transform 250ms ease' : undefined;
};

const DragOverlay = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().memo(({
  adjustScale = false,
  children,
  dropAnimation = defaultDropAnimation,
  style: styleProp,
  transition = defaultTransition,
  modifiers,
  wrapperElement = 'div',
  className,
  zIndex = 999
}) => {
  var _active$id, _attributesSnapshot$c;

  const {
    active,
    activeNodeRect,
    containerNodeRect,
    draggableNodes,
    activatorEvent,
    over,
    dragOverlay,
    scrollableAncestors,
    scrollableAncestorRects,
    windowRect
  } = useDndContext();
  const transform = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(ActiveDraggableContext);
  const modifiedTransform = applyModifiers(modifiers, {
    activatorEvent,
    active,
    activeNodeRect,
    containerNodeRect,
    draggingNodeRect: dragOverlay.rect,
    over,
    overlayNodeRect: dragOverlay.rect,
    scrollableAncestors,
    scrollableAncestorRects,
    transform,
    windowRect
  });
  const isDragging = active !== null;
  const finalTransform = adjustScale ? modifiedTransform : { ...modifiedTransform,
    scaleX: 1,
    scaleY: 1
  };
  const initialRect = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useLazyMemo)(previousValue => {
    if (isDragging) {
      if (previousValue) {
        return previousValue;
      }

      if (!activeNodeRect) {
        return null;
      }

      return { ...activeNodeRect
      };
    }

    return null;
  }, [isDragging, activeNodeRect]);
  const style = initialRect ? {
    position: 'fixed',
    width: initialRect.width,
    height: initialRect.height,
    top: initialRect.top,
    left: initialRect.left,
    zIndex,
    transform: _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.CSS.Transform.toString(finalTransform),
    touchAction: 'none',
    transformOrigin: adjustScale && activatorEvent ? getRelativeTransformOrigin(activatorEvent, initialRect) : undefined,
    transition: typeof transition === 'function' ? transition(activatorEvent) : transition,
    ...styleProp
  } : undefined;
  const attributes = isDragging ? {
    style,
    children,
    className,
    transform: finalTransform
  } : undefined;
  const attributesSnapshot = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(attributes);
  const derivedAttributes = attributes != null ? attributes : attributesSnapshot.current;
  const {
    children: finalChildren,
    transform: _,
    ...otherAttributes
  } = derivedAttributes != null ? derivedAttributes : {};
  const prevActiveId = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)((_active$id = active == null ? void 0 : active.id) != null ? _active$id : null);
  const dropAnimationComplete = useDropAnimation({
    animate: Boolean(dropAnimation && prevActiveId.current && !active),
    adjustScale,
    activeId: prevActiveId.current,
    draggableNodes,
    duration: dropAnimation == null ? void 0 : dropAnimation.duration,
    easing: dropAnimation == null ? void 0 : dropAnimation.easing,
    dragSourceOpacity: dropAnimation == null ? void 0 : dropAnimation.dragSourceOpacity,
    node: dragOverlay.nodeRef.current,
    transform: (_attributesSnapshot$c = attributesSnapshot.current) == null ? void 0 : _attributesSnapshot$c.transform
  });
  const shouldRender = Boolean(finalChildren && (children || dropAnimation && !dropAnimationComplete));
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if ((active == null ? void 0 : active.id) !== prevActiveId.current) {
      var _active$id2;

      prevActiveId.current = (_active$id2 = active == null ? void 0 : active.id) != null ? _active$id2 : null;
    }

    if (active && attributesSnapshot.current !== attributes) {
      attributesSnapshot.current = attributes;
    }
  }, [active, attributes]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (dropAnimationComplete) {
      attributesSnapshot.current = undefined;
    }
  }, [dropAnimationComplete]);

  if (!shouldRender) {
    return null;
  }

  return react__WEBPACK_IMPORTED_MODULE_0___default().createElement(InternalContext.Provider, {
    value: defaultInternalContext
  }, react__WEBPACK_IMPORTED_MODULE_0___default().createElement(ActiveDraggableContext.Provider, {
    value: defaultTransform
  }, react__WEBPACK_IMPORTED_MODULE_0___default().createElement(wrapperElement, { ...otherAttributes,
    ref: dragOverlay.setRef
  }, finalChildren)));
});


//# sourceMappingURL=core.esm.js.map


/***/ }),

/***/ "./node_modules/@dnd-kit/modifiers/dist/modifiers.esm.js":
/*!***************************************************************!*\
  !*** ./node_modules/@dnd-kit/modifiers/dist/modifiers.esm.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "createSnapModifier": function() { return /* binding */ createSnapModifier; },
/* harmony export */   "restrictToFirstScrollableAncestor": function() { return /* binding */ restrictToFirstScrollableAncestor; },
/* harmony export */   "restrictToHorizontalAxis": function() { return /* binding */ restrictToHorizontalAxis; },
/* harmony export */   "restrictToParentElement": function() { return /* binding */ restrictToParentElement; },
/* harmony export */   "restrictToVerticalAxis": function() { return /* binding */ restrictToVerticalAxis; },
/* harmony export */   "restrictToWindowEdges": function() { return /* binding */ restrictToWindowEdges; },
/* harmony export */   "snapCenterToCursor": function() { return /* binding */ snapCenterToCursor; }
/* harmony export */ });
/* harmony import */ var _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @dnd-kit/utilities */ "./node_modules/@dnd-kit/utilities/dist/utilities.esm.js");


function createSnapModifier(gridSize) {
  return ({
    transform
  }) => ({ ...transform,
    x: Math.ceil(transform.x / gridSize) * gridSize,
    y: Math.ceil(transform.y / gridSize) * gridSize
  });
}

const restrictToHorizontalAxis = ({
  transform
}) => {
  return { ...transform,
    y: 0
  };
};

function restrictToBoundingRect(transform, rect, boundingRect) {
  const value = { ...transform
  };

  if (rect.top + transform.y <= boundingRect.top) {
    value.y = boundingRect.top - rect.top;
  } else if (rect.bottom + transform.y >= boundingRect.top + boundingRect.height) {
    value.y = boundingRect.top + boundingRect.height - rect.bottom;
  }

  if (rect.left + transform.x <= boundingRect.left) {
    value.x = boundingRect.left - rect.left;
  } else if (rect.right + transform.x >= boundingRect.left + boundingRect.width) {
    value.x = boundingRect.left + boundingRect.width - rect.right;
  }

  return value;
}

const restrictToParentElement = ({
  containerNodeRect,
  draggingNodeRect,
  transform
}) => {
  if (!draggingNodeRect || !containerNodeRect) {
    return transform;
  }

  return restrictToBoundingRect(transform, draggingNodeRect, containerNodeRect);
};

const restrictToFirstScrollableAncestor = ({
  draggingNodeRect,
  transform,
  scrollableAncestorRects
}) => {
  const firstScrollableAncestorRect = scrollableAncestorRects[0];

  if (!draggingNodeRect || !firstScrollableAncestorRect) {
    return transform;
  }

  return restrictToBoundingRect(transform, draggingNodeRect, firstScrollableAncestorRect);
};

const restrictToVerticalAxis = ({
  transform
}) => {
  return { ...transform,
    x: 0
  };
};

const restrictToWindowEdges = ({
  transform,
  draggingNodeRect,
  windowRect
}) => {
  if (!draggingNodeRect || !windowRect) {
    return transform;
  }

  return restrictToBoundingRect(transform, draggingNodeRect, windowRect);
};

const snapCenterToCursor = ({
  activatorEvent,
  draggingNodeRect,
  transform
}) => {
  if (draggingNodeRect && activatorEvent) {
    const activatorCoordinates = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_0__.getEventCoordinates)(activatorEvent);

    if (!activatorCoordinates) {
      return transform;
    }

    const offsetX = activatorCoordinates.x - draggingNodeRect.left;
    const offsetY = activatorCoordinates.y - draggingNodeRect.top;
    return { ...transform,
      x: transform.x + offsetX - draggingNodeRect.width / 2,
      y: transform.y + offsetY - draggingNodeRect.height / 2
    };
  }

  return transform;
};


//# sourceMappingURL=modifiers.esm.js.map


/***/ }),

/***/ "./node_modules/@dnd-kit/sortable/dist/sortable.esm.js":
/*!*************************************************************!*\
  !*** ./node_modules/@dnd-kit/sortable/dist/sortable.esm.js ***!
  \*************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "SortableContext": function() { return /* binding */ SortableContext; },
/* harmony export */   "arrayMove": function() { return /* binding */ arrayMove; },
/* harmony export */   "arraySwap": function() { return /* binding */ arraySwap; },
/* harmony export */   "defaultAnimateLayoutChanges": function() { return /* binding */ defaultAnimateLayoutChanges; },
/* harmony export */   "defaultNewIndexGetter": function() { return /* binding */ defaultNewIndexGetter; },
/* harmony export */   "horizontalListSortingStrategy": function() { return /* binding */ horizontalListSortingStrategy; },
/* harmony export */   "rectSortingStrategy": function() { return /* binding */ rectSortingStrategy; },
/* harmony export */   "rectSwappingStrategy": function() { return /* binding */ rectSwappingStrategy; },
/* harmony export */   "sortableKeyboardCoordinates": function() { return /* binding */ sortableKeyboardCoordinates; },
/* harmony export */   "useSortable": function() { return /* binding */ useSortable; },
/* harmony export */   "verticalListSortingStrategy": function() { return /* binding */ verticalListSortingStrategy; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @dnd-kit/core */ "./node_modules/@dnd-kit/core/dist/core.esm.js");
/* harmony import */ var _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @dnd-kit/utilities */ "./node_modules/@dnd-kit/utilities/dist/utilities.esm.js");




/**
 * Move an array item to a different position. Returns a new array with the item moved to the new position.
 */
function arrayMove(array, from, to) {
  const newArray = array.slice();
  newArray.splice(to < 0 ? newArray.length + to : to, 0, newArray.splice(from, 1)[0]);
  return newArray;
}

/**
 * Swap an array item to a different position. Returns a new array with the item swapped to the new position.
 */
function arraySwap(array, from, to) {
  const newArray = array.slice();
  newArray[from] = array[to];
  newArray[to] = array[from];
  return newArray;
}

function getSortedRects(items, rects) {
  return items.reduce((accumulator, id, index) => {
    const rect = rects.get(id);

    if (rect) {
      accumulator[index] = rect;
    }

    return accumulator;
  }, Array(items.length));
}

function isValidIndex(index) {
  return index !== null && index >= 0;
}

// To-do: We should be calculating scale transformation
const defaultScale = {
  scaleX: 1,
  scaleY: 1
};
const horizontalListSortingStrategy = ({
  rects,
  activeNodeRect: fallbackActiveRect,
  activeIndex,
  overIndex,
  index
}) => {
  var _rects$activeIndex;

  const activeNodeRect = (_rects$activeIndex = rects[activeIndex]) != null ? _rects$activeIndex : fallbackActiveRect;

  if (!activeNodeRect) {
    return null;
  }

  const itemGap = getItemGap(rects, index, activeIndex);

  if (index === activeIndex) {
    const newIndexRect = rects[overIndex];

    if (!newIndexRect) {
      return null;
    }

    return {
      x: activeIndex < overIndex ? newIndexRect.left + newIndexRect.width - (activeNodeRect.left + activeNodeRect.width) : newIndexRect.left - activeNodeRect.left,
      y: 0,
      ...defaultScale
    };
  }

  if (index > activeIndex && index <= overIndex) {
    return {
      x: -activeNodeRect.width - itemGap,
      y: 0,
      ...defaultScale
    };
  }

  if (index < activeIndex && index >= overIndex) {
    return {
      x: activeNodeRect.width + itemGap,
      y: 0,
      ...defaultScale
    };
  }

  return {
    x: 0,
    y: 0,
    ...defaultScale
  };
};

function getItemGap(rects, index, activeIndex) {
  const currentRect = rects[index];
  const previousRect = rects[index - 1];
  const nextRect = rects[index + 1];

  if (!currentRect || !previousRect && !nextRect) {
    return 0;
  }

  if (activeIndex < index) {
    return previousRect ? currentRect.left - (previousRect.left + previousRect.width) : nextRect.left - (currentRect.left + currentRect.width);
  }

  return nextRect ? nextRect.left - (currentRect.left + currentRect.width) : currentRect.left - (previousRect.left + previousRect.width);
}

const rectSortingStrategy = ({
  rects,
  activeIndex,
  overIndex,
  index
}) => {
  const newRects = arrayMove(rects, overIndex, activeIndex);
  const oldRect = rects[index];
  const newRect = newRects[index];

  if (!newRect || !oldRect) {
    return null;
  }

  return {
    x: newRect.left - oldRect.left,
    y: newRect.top - oldRect.top,
    scaleX: newRect.width / oldRect.width,
    scaleY: newRect.height / oldRect.height
  };
};

const rectSwappingStrategy = ({
  activeIndex,
  index,
  rects,
  overIndex
}) => {
  let oldRect;
  let newRect;

  if (index === activeIndex) {
    oldRect = rects[index];
    newRect = rects[overIndex];
  }

  if (index === overIndex) {
    oldRect = rects[index];
    newRect = rects[activeIndex];
  }

  if (!newRect || !oldRect) {
    return null;
  }

  return {
    x: newRect.left - oldRect.left,
    y: newRect.top - oldRect.top,
    scaleX: newRect.width / oldRect.width,
    scaleY: newRect.height / oldRect.height
  };
};

// To-do: We should be calculating scale transformation
const defaultScale$1 = {
  scaleX: 1,
  scaleY: 1
};
const verticalListSortingStrategy = ({
  activeIndex,
  activeNodeRect: fallbackActiveRect,
  index,
  rects,
  overIndex
}) => {
  var _rects$activeIndex;

  const activeNodeRect = (_rects$activeIndex = rects[activeIndex]) != null ? _rects$activeIndex : fallbackActiveRect;

  if (!activeNodeRect) {
    return null;
  }

  if (index === activeIndex) {
    const overIndexRect = rects[overIndex];

    if (!overIndexRect) {
      return null;
    }

    return {
      x: 0,
      y: activeIndex < overIndex ? overIndexRect.top + overIndexRect.height - (activeNodeRect.top + activeNodeRect.height) : overIndexRect.top - activeNodeRect.top,
      ...defaultScale$1
    };
  }

  const itemGap = getItemGap$1(rects, index, activeIndex);

  if (index > activeIndex && index <= overIndex) {
    return {
      x: 0,
      y: -activeNodeRect.height - itemGap,
      ...defaultScale$1
    };
  }

  if (index < activeIndex && index >= overIndex) {
    return {
      x: 0,
      y: activeNodeRect.height + itemGap,
      ...defaultScale$1
    };
  }

  return {
    x: 0,
    y: 0,
    ...defaultScale$1
  };
};

function getItemGap$1(clientRects, index, activeIndex) {
  const currentRect = clientRects[index];
  const previousRect = clientRects[index - 1];
  const nextRect = clientRects[index + 1];

  if (!currentRect) {
    return 0;
  }

  if (activeIndex < index) {
    return previousRect ? currentRect.top - (previousRect.top + previousRect.height) : nextRect ? nextRect.top - (currentRect.top + currentRect.height) : 0;
  }

  return nextRect ? nextRect.top - (currentRect.top + currentRect.height) : previousRect ? currentRect.top - (previousRect.top + previousRect.height) : 0;
}

const ID_PREFIX = 'Sortable';
const Context = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default().createContext({
  activeIndex: -1,
  containerId: ID_PREFIX,
  disableTransforms: false,
  items: [],
  overIndex: -1,
  useDragOverlay: false,
  sortedRects: [],
  strategy: rectSortingStrategy
});
function SortableContext({
  children,
  id,
  items: userDefinedItems,
  strategy = rectSortingStrategy
}) {
  const {
    active,
    dragOverlay,
    droppableRects,
    over,
    measureDroppableContainers,
    measuringScheduled
  } = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.useDndContext)();
  const containerId = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useUniqueId)(ID_PREFIX, id);
  const useDragOverlay = Boolean(dragOverlay.rect !== null);
  const items = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => userDefinedItems.map(item => typeof item === 'string' ? item : item.id), [userDefinedItems]);
  const isDragging = active != null;
  const activeIndex = active ? items.indexOf(active.id) : -1;
  const overIndex = over ? items.indexOf(over.id) : -1;
  const previousItemsRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(items);
  const itemsHaveChanged = !isEqual(items, previousItemsRef.current);
  const disableTransforms = overIndex !== -1 && activeIndex === -1 || itemsHaveChanged;
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    if (itemsHaveChanged && isDragging && !measuringScheduled) {
      measureDroppableContainers(items);
    }
  }, [itemsHaveChanged, items, isDragging, measureDroppableContainers, measuringScheduled]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    previousItemsRef.current = items;
  }, [items]);
  const contextValue = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => ({
    activeIndex,
    containerId,
    disableTransforms,
    items,
    overIndex,
    useDragOverlay,
    sortedRects: getSortedRects(items, droppableRects),
    strategy
  }), [activeIndex, containerId, disableTransforms, items, overIndex, droppableRects, useDragOverlay, strategy]);
  return react__WEBPACK_IMPORTED_MODULE_0___default().createElement(Context.Provider, {
    value: contextValue
  }, children);
}

function isEqual(arr1, arr2) {
  return arr1.join() === arr2.join();
}

const defaultNewIndexGetter = ({
  id,
  items,
  activeIndex,
  overIndex
}) => arrayMove(items, activeIndex, overIndex).indexOf(id);
const defaultAnimateLayoutChanges = ({
  containerId,
  isSorting,
  wasDragging,
  index,
  items,
  newIndex,
  previousItems,
  previousContainerId,
  transition
}) => {
  if (!transition || !wasDragging) {
    return false;
  }

  if (previousItems !== items && index === newIndex) {
    return false;
  }

  if (isSorting) {
    return true;
  }

  return newIndex !== index && containerId === previousContainerId;
};
const defaultTransition = {
  duration: 200,
  easing: 'ease'
};
const transitionProperty = 'transform';
const disabledTransition = /*#__PURE__*/_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.CSS.Transition.toString({
  property: transitionProperty,
  duration: 0,
  easing: 'linear'
});
const defaultAttributes = {
  roleDescription: 'sortable'
};

/*
 * When the index of an item changes while sorting,
 * we need to temporarily disable the transforms
 */

function useDerivedTransform({
  disabled,
  index,
  node,
  rect
}) {
  const [derivedTransform, setDerivedtransform] = (0,react__WEBPACK_IMPORTED_MODULE_0__.useState)(null);
  const previousIndex = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(index);
  (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useIsomorphicLayoutEffect)(() => {
    if (!disabled && index !== previousIndex.current && node.current) {
      const initial = rect.current;

      if (initial) {
        const current = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.getClientRect)(node.current, {
          ignoreTransform: true
        });
        const delta = {
          x: initial.left - current.left,
          y: initial.top - current.top,
          scaleX: initial.width / current.width,
          scaleY: initial.height / current.height
        };

        if (delta.x || delta.y) {
          setDerivedtransform(delta);
        }
      }
    }

    if (index !== previousIndex.current) {
      previousIndex.current = index;
    }
  }, [disabled, index, node, rect]);
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (derivedTransform) {
      requestAnimationFrame(() => {
        setDerivedtransform(null);
      });
    }
  }, [derivedTransform]);
  return derivedTransform;
}

function useSortable({
  animateLayoutChanges = defaultAnimateLayoutChanges,
  attributes: userDefinedAttributes,
  disabled,
  data: customData,
  getNewIndex = defaultNewIndexGetter,
  id,
  strategy: localStrategy,
  resizeObserverConfig,
  transition = defaultTransition
}) {
  const {
    items,
    containerId,
    activeIndex,
    disableTransforms,
    sortedRects,
    overIndex,
    useDragOverlay,
    strategy: globalStrategy
  } = (0,react__WEBPACK_IMPORTED_MODULE_0__.useContext)(Context);
  const index = items.indexOf(id);
  const data = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => ({
    sortable: {
      containerId,
      index,
      items
    },
    ...customData
  }), [containerId, customData, index, items]);
  const itemsAfterCurrentSortable = (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => items.slice(items.indexOf(id)), [items, id]);
  const {
    rect,
    node,
    isOver,
    setNodeRef: setDroppableNodeRef
  } = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.useDroppable)({
    id,
    data,
    resizeObserverConfig: {
      updateMeasurementsFor: itemsAfterCurrentSortable,
      ...resizeObserverConfig
    }
  });
  const {
    active,
    activatorEvent,
    activeNodeRect,
    attributes,
    setNodeRef: setDraggableNodeRef,
    listeners,
    isDragging,
    over,
    transform
  } = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.useDraggable)({
    id,
    data,
    attributes: { ...defaultAttributes,
      ...userDefinedAttributes
    },
    disabled
  });
  const setNodeRef = (0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.useCombinedRefs)(setDroppableNodeRef, setDraggableNodeRef);
  const isSorting = Boolean(active);
  const displaceItem = isSorting && !disableTransforms && isValidIndex(activeIndex) && isValidIndex(overIndex);
  const shouldDisplaceDragSource = !useDragOverlay && isDragging;
  const dragSourceDisplacement = shouldDisplaceDragSource && displaceItem ? transform : null;
  const strategy = localStrategy != null ? localStrategy : globalStrategy;
  const finalTransform = displaceItem ? dragSourceDisplacement != null ? dragSourceDisplacement : strategy({
    rects: sortedRects,
    activeNodeRect,
    activeIndex,
    overIndex,
    index
  }) : null;
  const newIndex = isValidIndex(activeIndex) && isValidIndex(overIndex) ? getNewIndex({
    id,
    items,
    activeIndex,
    overIndex
  }) : index;
  const activeId = active == null ? void 0 : active.id;
  const previous = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)({
    activeId,
    items,
    newIndex,
    containerId
  });
  const itemsHaveChanged = items !== previous.current.items;
  const shouldAnimateLayoutChanges = animateLayoutChanges({
    active,
    containerId,
    isDragging,
    isSorting,
    id,
    index,
    items,
    newIndex: previous.current.newIndex,
    previousItems: previous.current.items,
    previousContainerId: previous.current.containerId,
    transition,
    wasDragging: previous.current.activeId != null
  });
  const derivedTransform = useDerivedTransform({
    disabled: !shouldAnimateLayoutChanges,
    index,
    node,
    rect
  });
  (0,react__WEBPACK_IMPORTED_MODULE_0__.useEffect)(() => {
    if (isSorting && previous.current.newIndex !== newIndex) {
      previous.current.newIndex = newIndex;
    }

    if (containerId !== previous.current.containerId) {
      previous.current.containerId = containerId;
    }

    if (items !== previous.current.items) {
      previous.current.items = items;
    }

    if (activeId !== previous.current.activeId) {
      previous.current.activeId = activeId;
    }
  }, [activeId, isSorting, newIndex, containerId, items]);
  return {
    active,
    activeIndex,
    attributes,
    rect,
    index,
    newIndex,
    items,
    isOver,
    isSorting,
    isDragging,
    listeners,
    node,
    overIndex,
    over,
    setNodeRef,
    setDroppableNodeRef,
    setDraggableNodeRef,
    transform: derivedTransform != null ? derivedTransform : finalTransform,
    transition: getTransition()
  };

  function getTransition() {
    if ( // Temporarily disable transitions for a single frame to set up derived transforms
    derivedTransform || // Or to prevent items jumping to back to their "new" position when items change
    itemsHaveChanged && previous.current.newIndex === index) {
      return disabledTransition;
    }

    if (shouldDisplaceDragSource && !(0,_dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.isKeyboardEvent)(activatorEvent) || !transition) {
      return undefined;
    }

    if (isSorting || shouldAnimateLayoutChanges) {
      return _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_2__.CSS.Transition.toString({ ...transition,
        property: transitionProperty
      });
    }

    return undefined;
  }
}

const directions = [_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Down, _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Right, _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Up, _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Left];
const sortableKeyboardCoordinates = (event, {
  context: {
    active,
    droppableContainers,
    collisionRect,
    scrollableAncestors
  }
}) => {
  if (directions.includes(event.code)) {
    event.preventDefault();

    if (!active || !collisionRect) {
      return;
    }

    const filteredContainers = [];
    droppableContainers.getEnabled().forEach(entry => {
      if (!entry || (entry == null ? void 0 : entry.disabled)) {
        return;
      }

      const rect = entry == null ? void 0 : entry.rect.current;

      if (!rect) {
        return;
      }

      switch (event.code) {
        case _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Down:
          if (collisionRect.top + collisionRect.height <= rect.top) {
            filteredContainers.push(entry);
          }

          break;

        case _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Up:
          if (collisionRect.top >= rect.top + rect.height) {
            filteredContainers.push(entry);
          }

          break;

        case _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Left:
          if (collisionRect.left >= rect.left + rect.width) {
            filteredContainers.push(entry);
          }

          break;

        case _dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.KeyboardCode.Right:
          if (collisionRect.left + collisionRect.width <= rect.left) {
            filteredContainers.push(entry);
          }

          break;
      }
    });
    const collisions = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.closestCorners)({
      active,
      collisionRect: collisionRect,
      droppableContainers: filteredContainers,
      pointerCoordinates: null
    });
    const closestId = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.getFirstCollision)(collisions, 'id');

    if (closestId != null) {
      const newDroppable = droppableContainers.get(closestId);
      const newNode = newDroppable == null ? void 0 : newDroppable.node.current;
      const newRect = newDroppable == null ? void 0 : newDroppable.rect.current;

      if (newNode && newRect) {
        const newScrollAncestors = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_1__.getScrollableAncestors)(newNode);
        const hasDifferentScrollAncestors = newScrollAncestors.some((element, index) => scrollableAncestors[index] !== element);
        const offset = hasDifferentScrollAncestors ? {
          x: 0,
          y: 0
        } : {
          x: collisionRect.width - newRect.width,
          y: collisionRect.height - newRect.height
        };
        const newCoordinates = {
          x: newRect.left - offset.x,
          y: newRect.top - offset.y
        };
        return newCoordinates;
      }
    }
  }

  return undefined;
};


//# sourceMappingURL=sortable.esm.js.map


/***/ }),

/***/ "./node_modules/@dnd-kit/utilities/dist/utilities.esm.js":
/*!***************************************************************!*\
  !*** ./node_modules/@dnd-kit/utilities/dist/utilities.esm.js ***!
  \***************************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "CSS": function() { return /* binding */ CSS; },
/* harmony export */   "add": function() { return /* binding */ add; },
/* harmony export */   "canUseDOM": function() { return /* binding */ canUseDOM; },
/* harmony export */   "getEventCoordinates": function() { return /* binding */ getEventCoordinates; },
/* harmony export */   "getOwnerDocument": function() { return /* binding */ getOwnerDocument; },
/* harmony export */   "getWindow": function() { return /* binding */ getWindow; },
/* harmony export */   "hasViewportRelativeCoordinates": function() { return /* binding */ hasViewportRelativeCoordinates; },
/* harmony export */   "isDocument": function() { return /* binding */ isDocument; },
/* harmony export */   "isHTMLElement": function() { return /* binding */ isHTMLElement; },
/* harmony export */   "isKeyboardEvent": function() { return /* binding */ isKeyboardEvent; },
/* harmony export */   "isNode": function() { return /* binding */ isNode; },
/* harmony export */   "isSVGElement": function() { return /* binding */ isSVGElement; },
/* harmony export */   "isTouchEvent": function() { return /* binding */ isTouchEvent; },
/* harmony export */   "isWindow": function() { return /* binding */ isWindow; },
/* harmony export */   "subtract": function() { return /* binding */ subtract; },
/* harmony export */   "useCombinedRefs": function() { return /* binding */ useCombinedRefs; },
/* harmony export */   "useInterval": function() { return /* binding */ useInterval; },
/* harmony export */   "useIsomorphicLayoutEffect": function() { return /* binding */ useIsomorphicLayoutEffect; },
/* harmony export */   "useLatestValue": function() { return /* binding */ useLatestValue; },
/* harmony export */   "useLazyMemo": function() { return /* binding */ useLazyMemo; },
/* harmony export */   "useNodeRef": function() { return /* binding */ useNodeRef; },
/* harmony export */   "useUniqueId": function() { return /* binding */ useUniqueId; }
/* harmony export */ });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);


function useCombinedRefs(...refs) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => node => {
    refs.forEach(ref => ref(node));
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  refs);
}

// https://github.com/facebook/react/blob/master/packages/shared/ExecutionEnvironment.js
const canUseDOM = typeof window !== 'undefined' && typeof window.document !== 'undefined' && typeof window.document.createElement !== 'undefined';

function isWindow(element) {
  const elementString = Object.prototype.toString.call(element);
  return elementString === '[object Window]' || // In Electron context the Window object serializes to [object global]
  elementString === '[object global]';
}

function isNode(node) {
  return 'nodeType' in node;
}

function getWindow(target) {
  var _target$ownerDocument, _target$ownerDocument2;

  if (!target) {
    return window;
  }

  if (isWindow(target)) {
    return target;
  }

  if (!isNode(target)) {
    return window;
  }

  return (_target$ownerDocument = (_target$ownerDocument2 = target.ownerDocument) == null ? void 0 : _target$ownerDocument2.defaultView) != null ? _target$ownerDocument : window;
}

function isDocument(node) {
  const {
    Document
  } = getWindow(node);
  return node instanceof Document;
}

function isHTMLElement(node) {
  if (isWindow(node)) {
    return false;
  }

  return node instanceof getWindow(node).HTMLElement;
}

function isSVGElement(node) {
  return node instanceof getWindow(node).SVGElement;
}

function getOwnerDocument(target) {
  if (!target) {
    return document;
  }

  if (isWindow(target)) {
    return target.document;
  }

  if (!isNode(target)) {
    return document;
  }

  if (isDocument(target)) {
    return target;
  }

  if (isHTMLElement(target)) {
    return target.ownerDocument;
  }

  return document;
}

/**
 * A hook that resolves to useEffect on the server and useLayoutEffect on the client
 * @param callback {function} Callback function that is invoked when the dependencies of the hook change
 */

const useIsomorphicLayoutEffect = canUseDOM ? react__WEBPACK_IMPORTED_MODULE_0__.useLayoutEffect : react__WEBPACK_IMPORTED_MODULE_0__.useEffect;

function useInterval() {
  const intervalRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const set = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)((listener, duration) => {
    intervalRef.current = setInterval(listener, duration);
  }, []);
  const clear = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(() => {
    if (intervalRef.current !== null) {
      clearInterval(intervalRef.current);
      intervalRef.current = null;
    }
  }, []);
  return [set, clear];
}

function useLatestValue(value, dependencies = [value]) {
  const valueRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(value);
  useIsomorphicLayoutEffect(() => {
    if (valueRef.current !== value) {
      valueRef.current = value;
    }
  }, dependencies);
  return valueRef;
}

function useLazyMemo(callback, dependencies) {
  const valueRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)();
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    const newValue = callback(valueRef.current);
    valueRef.current = newValue;
    return newValue;
  }, // eslint-disable-next-line react-hooks/exhaustive-deps
  [...dependencies]);
}

function useNodeRef(onChange) {
  const onChangeRef = useLatestValue(onChange);
  const node = (0,react__WEBPACK_IMPORTED_MODULE_0__.useRef)(null);
  const setNodeRef = (0,react__WEBPACK_IMPORTED_MODULE_0__.useCallback)(element => {
    if (element !== node.current) {
      onChangeRef.current == null ? void 0 : onChangeRef.current(element, node.current);
    }

    node.current = element;
  }, //eslint-disable-next-line
  []);
  return [node, setNodeRef];
}

let ids = {};
function useUniqueId(prefix, value) {
  return (0,react__WEBPACK_IMPORTED_MODULE_0__.useMemo)(() => {
    if (value) {
      return value;
    }

    const id = ids[prefix] == null ? 0 : ids[prefix] + 1;
    ids[prefix] = id;
    return `${prefix}-${id}`;
  }, [prefix, value]);
}

function createAdjustmentFn(modifier) {
  return (object, ...adjustments) => {
    return adjustments.reduce((accumulator, adjustment) => {
      const entries = Object.entries(adjustment);

      for (const [key, valueAdjustment] of entries) {
        const value = accumulator[key];

        if (value != null) {
          accumulator[key] = value + modifier * valueAdjustment;
        }
      }

      return accumulator;
    }, { ...object
    });
  };
}

const add = /*#__PURE__*/createAdjustmentFn(1);
const subtract = /*#__PURE__*/createAdjustmentFn(-1);

function hasViewportRelativeCoordinates(event) {
  return 'clientX' in event && 'clientY' in event;
}

function isKeyboardEvent(event) {
  if (!event) {
    return false;
  }

  const {
    KeyboardEvent
  } = getWindow(event.target);
  return KeyboardEvent && event instanceof KeyboardEvent;
}

function isTouchEvent(event) {
  if (!event) {
    return false;
  }

  const {
    TouchEvent
  } = getWindow(event.target);
  return TouchEvent && event instanceof TouchEvent;
}

/**
 * Returns the normalized x and y coordinates for mouse and touch events.
 */

function getEventCoordinates(event) {
  if (isTouchEvent(event)) {
    if (event.touches && event.touches.length) {
      const {
        clientX: x,
        clientY: y
      } = event.touches[0];
      return {
        x,
        y
      };
    } else if (event.changedTouches && event.changedTouches.length) {
      const {
        clientX: x,
        clientY: y
      } = event.changedTouches[0];
      return {
        x,
        y
      };
    }
  }

  if (hasViewportRelativeCoordinates(event)) {
    return {
      x: event.clientX,
      y: event.clientY
    };
  }

  return null;
}

const CSS = /*#__PURE__*/Object.freeze({
  Translate: {
    toString(transform) {
      if (!transform) {
        return;
      }

      const {
        x,
        y
      } = transform;
      return `translate3d(${x ? Math.round(x) : 0}px, ${y ? Math.round(y) : 0}px, 0)`;
    }

  },
  Scale: {
    toString(transform) {
      if (!transform) {
        return;
      }

      const {
        scaleX,
        scaleY
      } = transform;
      return `scaleX(${scaleX}) scaleY(${scaleY})`;
    }

  },
  Transform: {
    toString(transform) {
      if (!transform) {
        return;
      }

      return [CSS.Translate.toString(transform), CSS.Scale.toString(transform)].join(' ');
    }

  },
  Transition: {
    toString({
      property,
      duration,
      easing
    }) {
      return `${property} ${duration}ms ${easing}`;
    }

  }
});


//# sourceMappingURL=utilities.esm.js.map


/***/ }),

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
/* harmony import */ var _babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @babel/runtime/helpers/extends */ "./node_modules/@babel/runtime/helpers/esm/extends.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/SukiControlLabel */ "./src/scripts/customizer/components/SukiControlLabel.js");
/* harmony import */ var _components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../components/SukiControlDescription */ "./src/scripts/customizer/components/SukiControlDescription.js");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @dnd-kit/core */ "./node_modules/@dnd-kit/core/dist/core.esm.js");
/* harmony import */ var _dnd_kit_sortable__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @dnd-kit/sortable */ "./node_modules/@dnd-kit/sortable/dist/sortable.esm.js");
/* harmony import */ var _dnd_kit_modifiers__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @dnd-kit/modifiers */ "./node_modules/@dnd-kit/modifiers/dist/modifiers.esm.js");
/* harmony import */ var _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @dnd-kit/utilities */ "./node_modules/@dnd-kit/utilities/dist/utilities.esm.js");




/**
 * Multi Select control (React)
 */








function SukiMultiSelectList(props) {
  var control = props.control;
  var values = control.setting.get();

  if (1 > values.length) {
    return null;
  }

  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalVStack, {
    spacing: "1",
    className: "suki-multiselect__list"
  }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(SukiMultiSelectConditionalWrapper, {
    values: values,
    sortable: control.params.sortable,
    handleUpdateValues: function handleUpdateValues(items) {
      control.setting.set(items);
    }
  }, values.map(function (value) {
    var valueInfo = control.params.choices.find(function (choice) {
      return value === choice.value;
    });
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(SukiMultiSelectItem, {
      key: value,
      value: value,
      label: valueInfo.label,
      sortable: control.params.sortable,
      handleRemoveItem: function handleRemoveItem(item) {
        control.handleRemoveItem(item);
      }
    });
  })));
}

function SukiMultiSelectConditionalWrapper(props) {
  var sensors = (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.useSensors)((0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.useSensor)(_dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.PointerSensor), (0,_dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.useSensor)(_dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.KeyboardSensor, {
    coordinateGetter: _dnd_kit_sortable__WEBPACK_IMPORTED_MODULE_7__.sortableKeyboardCoordinates
  }));

  if (props.sortable) {
    return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.DndContext, {
      sensors: sensors,
      collisionDetection: _dnd_kit_core__WEBPACK_IMPORTED_MODULE_6__.closestCenter,
      modifiers: [_dnd_kit_modifiers__WEBPACK_IMPORTED_MODULE_8__.restrictToVerticalAxis, _dnd_kit_modifiers__WEBPACK_IMPORTED_MODULE_8__.restrictToParentElement],
      onDragEnd: function onDragEnd(e) {
        if (e.active.id !== e.over.id) {
          var items = props.values;
          var oldIndex = items.indexOf(e.active.id);
          var newIndex = items.indexOf(e.over.id);
          items = (0,_dnd_kit_sortable__WEBPACK_IMPORTED_MODULE_7__.arrayMove)(items, oldIndex, newIndex);
          props.handleUpdateValues(items);
        }
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_dnd_kit_sortable__WEBPACK_IMPORTED_MODULE_7__.SortableContext, {
      items: props.values,
      strategy: _dnd_kit_sortable__WEBPACK_IMPORTED_MODULE_7__.verticalListSortingStrategy
    }, props.children));
  }

  return props.children;
}

function SukiMultiSelectItem(props) {
  var _useSortable = (0,_dnd_kit_sortable__WEBPACK_IMPORTED_MODULE_7__.useSortable)({
    id: props.value
  }),
      attributes = _useSortable.attributes,
      listeners = _useSortable.listeners,
      setNodeRef = _useSortable.setNodeRef,
      transform = _useSortable.transform,
      transition = _useSortable.transition;

  var itemStyle = {
    transform: _dnd_kit_utilities__WEBPACK_IMPORTED_MODULE_9__.CSS.Transform.toString(transform),
    transition: transition
  };
  var itemAttributes = props.sortable ? attributes : undefined;
  return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)("div", (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_1__["default"])({
    ref: setNodeRef,
    style: itemStyle
  }, itemAttributes, {
    size: "xSmall",
    "data-value": props.value,
    className: "suki-multiselect__list__item"
  }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalHStack, {
    expanded: true,
    spacing: "2"
  }, props.sortable && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Icon, (0,_babel_runtime_helpers_extends__WEBPACK_IMPORTED_MODULE_1__["default"])({
    icon: "move"
  }, listeners, {
    className: "suki-multiselect__list__item__move"
  })), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalSpacer, null, props.label), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.Button, {
    isSmall: true,
    icon: "no-alt",
    label: SukiCustomizerData.l10n.remove,
    showTooltip: true,
    className: "suki-multiselect__list__item__remove",
    onClick: function onClick() {
      props.handleRemoveItem(props.value);
    }
  })));
}

wp.customize.SukiMultiSelectControl = wp.customize.SukiReactControl.extend({
  renderContent: function renderContent() {
    var control = this;
    var values = control.setting.get(); // If limit is set to `0`, it means limit is same as the number of options.

    var limit = control.params.itemsLimit || control.params.choices.length;
    ReactDOM.render((0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.Fragment, null, control.params.label && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_components_SukiControlLabel__WEBPACK_IMPORTED_MODULE_3__["default"], {
      for: '_customize-input-' + control.id
    }, control.params.label), control.params.description && (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_components_SukiControlDescription__WEBPACK_IMPORTED_MODULE_4__["default"], {
      id: '_customize-description-' + control.id
    }, control.params.description), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(_wordpress_components__WEBPACK_IMPORTED_MODULE_5__.__experimentalVStack, {
      spacing: "1"
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)(SukiMultiSelectList, {
      control: control
    }), (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)("select", {
      value: "",
      id: '_customize-input-' + control.id,
      hidden: limit <= values.length,
      onChange: function onChange(e) {
        control.handleAddNewItem(e.target.value);
      }
    }, (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)("option", {
      value: "",
      disabled: true
    }, SukiCustomizerData.l10n.addNew), control.params.choices.map(function (choice, i) {
      return (0,_wordpress_element__WEBPACK_IMPORTED_MODULE_2__.createElement)("option", {
        key: choice.value,
        value: choice.value,
        disabled: -1 === values.indexOf(choice.value) ? false : true
      }, choice.label);
    })))), control.container[0]);
  },
  handleAddNewItem: function handleAddNewItem(value) {
    var control = this;
    var valueArray = control.setting.get() || []; // Add the selected item into the value array.

    if (-1 === valueArray.indexOf(value)) {
      valueArray = [].concat((0,_babel_runtime_helpers_toConsumableArray__WEBPACK_IMPORTED_MODULE_0__["default"])(valueArray), [value]);
    } // If sortable mode is deisabled, sort the array according to the original options order.


    if (!control.params.sortable) {
      var choicesValues = control.params.choices.map(function (item) {
        return item.value;
      });
      valueArray = choicesValues.filter(function (choice) {
        return -1 !== valueArray.indexOf(choice);
      });
    }

    control.setting.set(valueArray);
  },
  handleRemoveItem: function handleRemoveItem(removedValue) {
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

/***/ "react":
/*!************************!*\
  !*** external "React" ***!
  \************************/
/***/ (function(module) {

"use strict";
module.exports = window["React"];

/***/ }),

/***/ "react-dom":
/*!***************************!*\
  !*** external "ReactDOM" ***!
  \***************************/
/***/ (function(module) {

"use strict";
module.exports = window["ReactDOM"];

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

/***/ "./node_modules/@babel/runtime/helpers/esm/extends.js":
/*!************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/extends.js ***!
  \************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _extends; }
/* harmony export */ });
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