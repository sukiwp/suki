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

import hookAction from './hook_action';
import { settings } from '@wordpress/icons';

import {
    withSelect,
    withDispatch
} from "@wordpress/data";
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

let PluginMetaFields = (props) => {
    var pageSettings = removeEmptyOrNull(props.suki_page_settings);
    var sukiPro = suki_metabox_globals.suki_pro;
    var moduleHeaderTransparent = checkModule('header-transparent', sukiPro);
    var moduleHeaderAltColors = checkModule('header-alt-colors', sukiPro);
    var moduleHeaderElementsPlus = checkModule('header-elements-plus', sukiPro);
    var moduleHeaderSticky = checkModule('header-sticky', sukiPro);
    var moduleSidebarSticky = checkModule('sidebar-sticky', sukiPro);
    var moduleCustomBlocks = checkModule('custom-blocks', sukiPro);
    var modulePreloaderScreen = checkModule('preloader-screen', sukiPro);

    if (pageSettings) {
        var classNameContentContainer = pageSettings.content_container;
        var classNameContentLayout = pageSettings.content_layout;
        var classNameStickySidebar = pageSettings.sticky_sidebar;
        var classNameDisableContentHeader = pageSettings.disable_content_header;
        var classNameHero = pageSettings.hero;
        var classNameDisableThumbnail = pageSettings.disable_thumbnail;
        var classNameDisableHeader = pageSettings.disable_header;
        var classNameDisableMobileHeader = pageSettings.disable_mobile_header;
        var classNameHeaderTransparent = pageSettings.header_transparent;
        var classNameHeaderMobileTransparent = pageSettings.header_mobile_transparent;
        var classNameHeaderSticky = pageSettings.header_sticky;
        var classNameHeaderMobileSticky = pageSettings.header_mobile_sticky;
        var classNameHeaderAltColors = pageSettings.header_alt_colors;
        var classNameHeaderMobileAltColors = pageSettings.header_mobile_alt_colors;
        var classNameDisableFooterWidgets = pageSettings.disable_footer_widgets;
        var classNameDisableFooterBottom = pageSettings.disable_footer_bottom;
        var classNamePreloaderScreen = pageSettings.preloader_screen;
    } else {
        var classNameContentContainer = '';
        var classNameContentLayout = '';
        var classNameStickySidebar = '';
        var classNameDisableContentHeader = '';
        var classNameHero = '';
        var classNameDisableThumbnail = '';
        var classNameDisableHeader = '';
        var classNameDisableMobileHeader = '';
        var classNameHeaderTransparent = '';
        var classNameHeaderMobileTransparent = '';
        var classNameHeaderSticky = '';
        var classNameHeaderMobileSticky = '';
        var classNameHeaderAltColors = '';
        var classNameHeaderMobileAltColors = '';
        var classNameDisableFooterWidgets = '';
        var classNameDisableFooterBottom = '';
        var classNamePreloaderScreen = '';
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
                    <div className="suki-metabox-panel-flex">
                        <label>
                            {__("Sticky sidebar", "suki-theme")}
                        </label>
                        <SelectControl
                            value={classNameStickySidebar}
                            onChange={(value) => props.onChangeMetaBox(value, 'sticky_sidebar', pageSettings)}
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
                                    <div>
                                        <label style={{ display: 'block', marginBottom: '5px' }}>{__("Transparent header", "suki-theme")}</label>
                                        <div className="suki-meta-panel-flex">
                                            <div className="w-50">
                                                <div className="suki-metabox-panel-flex">
                                                    <label style={{ width: '20px', height: '25px' }}>
                                                        <Icon icon="desktop" />
                                                    </label>
                                                    <div style={{ width: '100%', paddingLeft: '5px', paddingRight: '5px' }}>
                                                        <SelectControl
                                                            value={classNameHeaderTransparent}
                                                            onChange={(value) => props.onChangeMetaBox(value, 'header_transparent', pageSettings)}
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
                                                </div>
                                            </div>
                                            <div className="w-50">
                                                <div className="suki-metabox-panel-flex">
                                                    <label style={{ width: '20px', height: '25px' }}>
                                                        <Icon icon="tablet" />
                                                    </label>
                                                    <div style={{ width: '100%', paddingLeft: '5px' }}>
                                                        <SelectControl
                                                            value={classNameHeaderMobileTransparent}
                                                            onChange={(value) => props.onChangeMetaBox(value, 'header_mobile_transparent', pageSettings)}
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )}
                                {moduleHeaderSticky === true && (
                                    <div>
                                        <label style={{ display: 'block', marginBottom: '5px' }}>{__("Sticky header", "suki-theme")}</label>
                                        <div className="suki-meta-panel-flex">
                                            <div className="w-50">
                                                <div className="suki-metabox-panel-flex">
                                                    <label style={{ width: '20px', height: '25px' }}>
                                                        <Icon icon="desktop" />
                                                    </label>
                                                    <div style={{ width: '100%', paddingLeft: '5px', paddingRight: '5px' }}>
                                                        <SelectControl
                                                            value={classNameHeaderSticky}
                                                            onChange={(value) => props.onChangeMetaBox(value, 'header_sticky', pageSettings)}
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
                                                </div>
                                            </div>
                                            <div className="w-50">
                                                <div className="suki-metabox-panel-flex">
                                                    <label style={{ width: '20px', height: '25px' }}>
                                                        <Icon icon="tablet" />
                                                    </label>
                                                    <div style={{ width: '100%', paddingLeft: '5px' }}>
                                                        <SelectControl
                                                            value={classNameHeaderMobileSticky}
                                                            onChange={(value) => props.onChangeMetaBox(value, 'header_mobile_sticky', pageSettings)}
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
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                )}
                                {moduleHeaderAltColors === true && (
                                    <div>
                                        <label style={{ display: 'block', marginBottom: '5px' }}>{__("Colors", "suki-theme")}</label>
                                        <div className="suki-meta-panel-flex">
                                            <div className="w-50">
                                                <div className="suki-metabox-panel-flex">
                                                    <label style={{ width: '20px', height: '25px' }}>
                                                        <Icon icon="desktop" />
                                                    </label>
                                                    <div style={{ width: '100%', paddingLeft: '5px', paddingRight: '5px' }}>
                                                        <SelectControl
                                                            value={classNameHeaderAltColors}
                                                            onChange={(value) => props.onChangeMetaBox(value, 'header_alt_colors', pageSettings)}
                                                            options={
                                                                [
                                                                    {
                                                                        value: "",
                                                                        label: __("(Customizer)", "suki-theme")
                                                                    },
                                                                    {
                                                                        value: "0",
                                                                        label: __("○ Primary", "suki-theme")
                                                                    },
                                                                    {
                                                                        value: "1",
                                                                        label: __("● Alternate", "suki-theme")
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
                                                            value={classNameHeaderMobileAltColors}
                                                            onChange={(value) => props.onChangeMetaBox(value, 'header_mobile_alt_colors', pageSettings)}
                                                            options={
                                                                [
                                                                    {
                                                                        value: "",
                                                                        label: __("(Customizer)", "suki-theme")
                                                                    },
                                                                    {
                                                                        value: "0",
                                                                        label: __("○ Primary", "suki-theme")
                                                                    },
                                                                    {
                                                                        value: "1",
                                                                        label: __("● Alternate", "suki-theme")
                                                                    },
                                                                ]
                                                            }
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                <PanelBody
                    title={__("Custom Blocks (Hooks)", "suki-theme")}
                    initialOpen={false}
                >
                    <div className="tabel-custom-block">
                        {props.suki_custom_blocks && (
                            <table>
                                <thead>
                                    <tr>
                                        <th width="70%">{__("Title", "suki-theme")}</th>
                                        <th width="30%">{__("Attached Hook", "suki-theme")}</th>
                                        <th width="100px">{__("Priority", "suki-theme")}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {props.suki_custom_blocks.map(post => (
                                        <tr>
                                            <td>{post.title.rendered}</td>
                                            <td>{hookAction(post.meta.hook_action)}</td>
                                            <td>{post.meta.hook_priority ? post.meta.hook_priority : '10'}
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}
                        <br />
                        <p>{__("NOTE: Blocks that were added via shortcode are not included in the above list.", "suki-theme")}</p>
                        <p>
                            <a href="/wp-admin/edit.php?post_type=suki_block" className="button button-secondary">{__("Add or Manage Custom Blocks", "suki-theme")}</a>
                        </p>
                    </div>
                </PanelBody>
            )}
            {modulePreloaderScreen === true && (
                <PanelBody
                    title={__("Preloader Screen", "suki-theme")}
                    initialOpen={false}
                >
                    <div className="suki-metabox-panel-flex">
                        <label>
                            {__("Preloader Screen", "suki-theme")}
                        </label>
                        <SelectControl
                            value={classNamePreloaderScreen}
                            onChange={(value) => props.onChangeMetaBox(value, 'preloader_screen', pageSettings)}
                            options={
                                [
                                    {
                                        value: "",
                                        label: __("(Customizer)", "suki-theme")
                                    },
                                    {
                                        value: "0",
                                        label: __("No", "suki-theme")
                                    },
                                    {
                                        value: "1",
                                        label: __("Yes", "suki-theme")
                                    },
                                ]
                            }
                        />
                    </div>
                </PanelBody>
            )}
        </>
    )
}

PluginMetaFields = withSelect(
    (select) => {

        return {

            suki_custom_blocks: select('core').getEntityRecords('postType', 'suki_block'),
            suki_page_settings: select('core/editor').getEditedPostAttribute('meta')['_suki_page_settings'],

            getMetaBox: (value) => {
                return value
            }
        }
    }
)(PluginMetaFields);

PluginMetaFields = withDispatch(
    (dispatch) => {
        return {
            onChangeMetaBox: (value, prop, oldMeta) => {

                let metas = oldMeta;

                metas = {
                    ...metas,
                };

                metas[prop] = value;

                console.log(metas)

                dispatch('core/editor').editPost({ meta: { _suki_page_settings: metas } })
            }
        }
    }
)(PluginMetaFields);

registerPlugin('suki-metabox', {
    render: () => {
        var postTypes = suki_metabox_globals.post_types;
        var CurrentPostType = wp.data.select('core/editor').getCurrentPostType();


        if (postTypes.indexOf(CurrentPostType) > -1) {
            return (
                <>
                    <PluginSidebarMoreMenuItem
                        target="suki-metabox"
                        icon={settings}
                    >
                        {__('Theme Page Settings', 'suki-theme')}
                    </PluginSidebarMoreMenuItem>
                    <PluginSidebar
                        name="suki-metabox"
                        title={__('Theme Page Settings', 'suki-theme')}
                        icon={settings}
                    >
                        <PluginMetaFields />
                    </PluginSidebar>
                </>
            )
        } else {
            return '';
        }
    }
});