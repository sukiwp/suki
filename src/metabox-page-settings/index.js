import classnames from 'classnames';
import { __ } from "@wordpress/i18n";
import { registerPlugin } from "@wordpress/plugins";
import { PluginSidebar, PluginSidebarMoreMenuItem } from "@wordpress/edit-post";
import {
    PanelBody,
    Button,
    SelectControl,
    Icon,
    Notice,
} from "@wordpress/components";

import { settings } from '@wordpress/icons';

import {
    withSelect,
    withDispatch
} from "@wordpress/data";

import {
    applyFilters,
    createHooks,
} from '@wordpress/hooks';

import getIcon from './icon';

function checkModule(module, array) {
    {
        if (array.indexOf(module) !== -1) {
            return true;
        } else {
            return false;
        }
    }
}

function removeEmptyOrNull(obj) {
    Object.keys(obj).forEach(k =>
        (obj[k] && typeof obj[k] === 'object') && removeEmptyOrNull(obj[k]) ||
        (!obj[k] && obj[k] !== undefined) && delete obj[k]
    );
    return obj;
}

let MetaBoxPageSettings = (props) => {
    
    var pageSettings = removeEmptyOrNull(props.suki_page_settings);
    var sukiPro = suki_metabox_page_settings_globals.suki_pro;
    var moduleHeaderTransparent = checkModule('header-transparent', sukiPro);
    var moduleHeaderAltColors = checkModule('header-alt-colors', sukiPro);
    var moduleHeaderSticky = checkModule('header-sticky', sukiPro);
    var moduleSidebarSticky = checkModule('sidebar-sticky', sukiPro);
    var moduleCustomBlocks = checkModule('custom-blocks', sukiPro);
    var modulePreloaderScreen = checkModule('preloader-screen', sukiPro);

    if (pageSettings) {
        var classNameContentContainer = pageSettings.content_container;
        var classNameContentLayout = pageSettings.content_layout;
        var classNameDisableContentHeader = pageSettings.disable_content_header;
        var classNameHero = pageSettings.hero;
        var classNameDisableThumbnail = pageSettings.disable_thumbnail;
        var classNameDisableHeader = pageSettings.disable_header;
        var classNameDisableMobileHeader = pageSettings.disable_mobile_header;
        var classNameDisableFooterWidgets = pageSettings.disable_footer_widgets;
        var classNameDisableFooterBottom = pageSettings.disable_footer_bottom;
    } else {
        var classNameContentContainer = '';
        var classNameContentLayout = '';
        var classNameDisableContentHeader = '';
        var classNameHero = '';
        var classNameDisableThumbnail = '';
        var classNameDisableHeader = '';
        var classNameDisableMobileHeader = '';
        var classNameDisableFooterWidgets = '';
        var classNameDisableFooterBottom = '';
    }

    return (
        <>
            <PanelBody
                title={__("Content & Sidebar", "suki-theme")}
                initialOpen={true}
            >
                <div className="suki-metabox-panel-row">
                    <label>{__("Container", "suki-theme")}</label>
                    <ul>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentContainer === undefined ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('', 'content_container', pageSettings)}
                            >
                                {getIcon('customizer')}
                                <span>({__("Customizer", "suki-theme")})</span>
                            </Button>
                        </li>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentContainer === 'default' ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('default', 'content_container', pageSettings)}
                            >
                                {getIcon('container-normal')}
                                <span>{__("Normal", "suki-theme")}</span>
                            </Button>
                        </li>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentContainer === 'full-width' ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('full-width', 'content_container', pageSettings)}
                            >
                                {getIcon('container-full-width')}
                                <span>{__("Full width", "suki-theme")}</span>
                            </Button>
                        </li>
                        <li>
                            <Button className={classnames(
                                "box",
                                classNameContentContainer === 'narrow' ? 'active' : ''
                            )}
                                onClick={() => props.onChangeMetaBox('narrow', 'content_container', pageSettings)}
                            >
                                {getIcon('container-narrow')}
                                <span>{__("Narrow", "suki-theme")}</span>
                            </Button>
                        </li>
                    </ul>
                </div>
                <Notice
                    className="suki-metabox-no-margin-x"
                    status="info"
                    isDismissible={false}
                >
                    <p>If you are using Page Builder and want a full width layout, please set the "Page Attributes &gt; Template" to "Page Builder" or the one provided by your page builder.
                    </p>
                </Notice>
                <br />
                <div className="suki-metabox-panel-row">
                    <label>{__("Sidebar", "suki-theme")}</label>
                    <ul>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentLayout === undefined ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('', 'content_layout', pageSettings)}
                            >
                                {getIcon('customizer')}
                                <span>({__("Customizer", "suki-theme")})</span>
                            </Button>
                        </li>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentLayout === 'right-sidebar' ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('right-sidebar', 'content_layout', pageSettings)}
                            >
                                {getIcon('content-sidebar-right')}
                                <span>{__("Right", "suki-theme")}</span>
                            </Button>
                        </li>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentLayout === 'left-sidebar' ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('left-sidebar', 'content_layout', pageSettings)}
                            >
                                {getIcon('content-sidebar-left')}
                                <span>{__("Left", "suki-theme")}</span>
                            </Button>
                        </li>
                        <li>
                            <Button
                                className={classnames(
                                    "box",
                                    classNameContentLayout === 'wide' ? 'active' : ''
                                )}
                                onClick={() => props.onChangeMetaBox('wide', 'content_layout', pageSettings)}
                            >
                                {getIcon('content-sidebar-wide')}
                                <span>{__("Disabled", "suki-theme")}</span>
                            </Button>
                        </li>
                    </ul>
                </div>
                {moduleSidebarSticky === true && (
                    applyFilters("suki.page.setting.sidebar.sticky", props)
                )}
            </PanelBody>
            <PanelBody
                title={__("Content Header", "suki-theme")}
                initialOpen={false}
            >
                <div className="suki-metabox-panel-flex">
                    <label>
                        {__("Content header", "suki-theme")}
                    </label>
                    <SelectControl
                        value={classNameDisableContentHeader}
                        onChange={(value) => props.onChangeMetaBox(value, 'disable_content_header', pageSettings)}
                        options={
                            [
                                {
                                    value: "",
                                    label: __("✔ Visible", "suki-theme")
                                },
                                {
                                    value: "1",
                                    label: __("✘ Hidden", "suki-theme")
                                },
                            ]
                        }
                    />
                </div>
                <div className="suki-metabox-panel-flex">
                    <label>
                        {__("Hero section", "suki-theme")}
                    </label>
                    <SelectControl
                        value={classNameHero}
                        onChange={(value) => props.onChangeMetaBox(value, 'hero', pageSettings)}
                        options={
                            [
                                {
                                    value: "",
                                    label: __("(Customizer)", "suki-theme")
                                },
                                {
                                    value: "0",
                                    label: __("✘ Disabled", "suki-theme")
                                },
                                {
                                    value: "1",
                                    label: __("✔ Enabled", "suki-theme")
                                },
                            ]
                        }
                    />
                </div>
                <div className="suki-metabox-panel-flex">
                    <label>
                        {__("Featured image", "suki-theme")}
                    </label>
                    <SelectControl
                        value={classNameDisableThumbnail}
                        onChange={(value) => props.onChangeMetaBox(value, 'disable_thumbnail', pageSettings)}
                        options={
                            [
                                {
                                    value: "",
                                    label: __("✔ Visible", "suki-theme")
                                },
                                {
                                    value: "1",
                                    label: __("✘ Hidden", "suki-theme")
                                },
                            ]
                        }
                    />
                </div>
            </PanelBody>
            <PanelBody
                title={__("Header", "suki-theme")}
                initialOpen={false}
            >
                {(() => {
                    if (moduleHeaderTransparent === false && moduleHeaderSticky === false && moduleHeaderAltColors === false) {
                        return (<>
                            <div className="suki-metabox-panel-flex">
                                <label>
                                    <Icon icon="desktop" /> {__("Desktop", "suki-theme")}
                                </label>
                                <SelectControl
                                    value={classNameDisableHeader}
                                    onChange={(value) => props.onChangeMetaBox(value, 'disable_header', pageSettings)}
                                    options={
                                        [
                                            {
                                                value: "",
                                                label: __("✔ Visible", "suki-theme")
                                            },
                                            {
                                                value: "1",
                                                label: __("✘ Hidden", "suki-theme")
                                            },
                                        ]
                                    }
                                />
                            </div>
                            <div className="suki-metabox-panel-flex">
                                <label>
                                    <Icon icon="tablet" /> {__("Tablet", "suki-theme")}
                                </label>
                                <SelectControl
                                    value={classNameDisableMobileHeader}
                                    onChange={(value) => props.onChangeMetaBox(value, 'disable_mobile_header', pageSettings)}
                                    options={
                                        [
                                            {
                                                value: "",
                                                label: __("✔ Visible", "suki-theme")
                                            },
                                            {
                                                value: "1",
                                                label: __("✘ Hidden", "suki-theme")
                                            },
                                        ]
                                    }
                                />
                            </div>
                        </>)
                    } else {
                        return (
                            <>
                                <div>
                                    <label style={{ display: 'block', marginBottom: '5px' }}>{__("Header", "suki-theme")}</label>
                                    <div className="suki-meta-panel-flex">
                                        <div className="w-50">
                                            <div className="suki-metabox-panel-flex">
                                                <label style={{ width: '20px', height: '25px' }}>
                                                    <Icon icon="desktop" />
                                                </label>
                                                <div style={{ width: '100%', paddingLeft: '5px', paddingRight: '5px' }}>
                                                    <SelectControl
                                                        value={classNameDisableHeader}
                                                        onChange={(value) => props.onChangeMetaBox(value, 'disable_header', pageSettings)}
                                                        options={
                                                            [
                                                                {
                                                                    value: "",
                                                                    label: __("✔ Visible", "suki-theme")
                                                                },
                                                                {
                                                                    value: "1",
                                                                    label: __("✘ Hidden", "suki-theme")
                                                                },
                                                            ]
                                                        }
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div className="w-50">
                                            <div className="suki-metabox-panel-flex">
                                                <label style={{ width: '20px', height: '25px' }}>
                                                    <Icon icon="tablet" />
                                                </label>
                                                <div style={{ width: '100%', paddingLeft: '5px' }}>
                                                    <SelectControl
                                                        value={classNameDisableMobileHeader}
                                                        onChange={(value) => props.onChangeMetaBox(value, 'disable_mobile_header', pageSettings)}
                                                        options={
                                                            [
                                                                {
                                                                    value: "",
                                                                    label: __("✔ Visible", "suki-theme")
                                                                },
                                                                {
                                                                    value: "1",
                                                                    label: __("✘ Hidden", "suki-theme")
                                                                },
                                                            ]
                                                        }
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {moduleHeaderTransparent === true && (
                                    applyFilters("suki.page.setting.header.transparent", props)
                                )}
                                {moduleHeaderSticky === true && (
                                    applyFilters("suki.page.setting.header.sticky", props)
                                )}
                                {moduleHeaderAltColors === true && (
                                    applyFilters("suki.page.setting.header.color", props)
                                )}
                            </>
                        )
                    }
                })()}
            </PanelBody>
            <PanelBody
                title={__("Footer", "suki-theme")}
                initialOpen={false}
            >
                <div className="suki-metabox-panel-flex">
                    <label>
                        {__("Footer widgets", "suki-theme")}
                    </label>
                    <SelectControl
                        value={classNameDisableFooterWidgets}
                        onChange={(value) => props.onChangeMetaBox(value, 'disable_footer_widgets', pageSettings)}
                        options={
                            [
                                {
                                    value: "",
                                    label: __("✔ Visible", "suki-theme")
                                },
                                {
                                    value: "1",
                                    label: __("✘ Hidden", "suki-theme")
                                },
                            ]
                        }
                    />
                </div>
                <div className="suki-metabox-panel-flex">
                    <label>
                        {__("Footer bottom", "suki-theme")}
                    </label>
                    <SelectControl
                        value={classNameDisableFooterBottom}
                        onChange={(value) => props.onChangeMetaBox(value, 'disable_footer_bottom', pageSettings)}
                        options={
                            [
                                {
                                    value: "",
                                    label: __("✔ Visible", "suki-theme")
                                },
                                {
                                    value: "1",
                                    label: __("✘ Hidden", "suki-theme")
                                },
                            ]
                        }
                    />
                </div>
            </PanelBody>
            {moduleCustomBlocks === true && (
                applyFilters("suki.page.setting.custom.block", props)
            )}
            {modulePreloaderScreen === true && (
                applyFilters("suki.page.setting.preloader.screen", props)
            )}
        </>
    )
}

MetaBoxPageSettings = withSelect(
    (select) => {
        return {
            suki_page_settings: select('core/editor').getEditedPostAttribute('meta')['_suki_page_settings'],
        }
    }
)(MetaBoxPageSettings);

MetaBoxPageSettings = withDispatch(
    (dispatch) => {
        return {
            onChangeMetaBox: (value, prop, oldMeta) => {

                let metas = oldMeta;

                metas = {
                    ...metas,
                };

                metas[prop] = value;

                dispatch('core/editor').editPost({ meta: { _suki_page_settings: metas } })
            }
        }
    }
)(MetaBoxPageSettings);

registerPlugin('suki-metabox-page-settings', {
    render: () => {
        var postTypes = suki_metabox_page_settings_globals.post_types_for_page_settings;
        var CurrentPostType = wp.data.select('core/editor').getCurrentPostType();


        if (postTypes.indexOf(CurrentPostType) > -1) {
            return (
                <>
                    <PluginSidebarMoreMenuItem
                        target="suki-metabox-page-settings"
                        icon={settings}
                    >
                        {__('Theme Page Settings', 'suki-theme')}
                    </PluginSidebarMoreMenuItem>
                    <PluginSidebar
                        name="suki-metabox-page-settings"
                        title={__('Theme Page Settings', 'suki-theme')}
                        icon={settings}
                    >
                        <MetaBoxPageSettings />
                    </PluginSidebar>
                </>
            )
        } else {
            return '';
        }
    }
});