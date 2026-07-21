(function () {
    var root = document.getElementById('wkit-admin-app');
    if (!root) {
        return;
    }

    var data = window.WiraElementorKitAdmin || {};
    var EXTENDED_LICENSE_ACTIVE = !!data.extendedLicenseActive;
    var DISPLAY_OPTIONS_BY_TYPE = data.templateBuilderDisplayOptions || {};
    var GET_ALL_ACCESS_URL = data.getAllAccessUrl || 'https://wiratheme.com/wirakit/wira-extended/';
    var TEMPLATE_IMPORTER_AUTO_INSTALL_ENABLED = !!data.templateImporterAutoInstallEnabled;
    var DISPLAY_OPTIONS = DISPLAY_OPTIONS_BY_TYPE.default || {
        all: 'All Pages',
        'front-page': 'Front Page',
        singular: 'Singular',
        archive: 'Archive',
        blog: 'Blog Home',
        '404': '404 Page',
        shop: 'Shop Page'
    };

    var TEMPLATE_TYPES = ['wkit-header', 'wkit-footer', 'wkit-single', 'wkit-archive', 'wkit-search', 'wkit-404'];
    var TEMPLATE_TYPE_MODULE_MAP = {
        'wkit-header': 'template-builder-header',
        'wkit-footer': 'template-builder-footer',
        'wkit-single': 'template-builder-single',
        'wkit-archive': 'template-builder-archive',
        'wkit-search': 'template-builder-search',
        'wkit-404': 'template-builder-404'
    };

    function getEnabledTemplateBuilderTypes() {
        var moduleSettings = (state.settings && state.settings.modules) ? state.settings.modules : {};
        return TEMPLATE_TYPES.filter(function (type) {
            var moduleId = TEMPLATE_TYPE_MODULE_MAP[type];
            if (!moduleId) {
                return true;
            }
            return !!moduleSettings[moduleId];
        });
    }

    function getDisplayOptionsForTemplateType(type) {
        return DISPLAY_OPTIONS_BY_TYPE[type] || DISPLAY_OPTIONS_BY_TYPE.default || DISPLAY_OPTIONS;
    }

    var state = {
        path: normalizePath(data.path || (root.dataset ? root.dataset.path : 'dashboard')),
        settings: normalizeSettings(data.settings),
        baseline: normalizeSettings(data.settings),
        saveState: 'idle',
        errorMessage: '',
        extendedLicenseActive: EXTENDED_LICENSE_ACTIVE,
        wiraTemplatesBusy: false,
        templateBuilder: {
            loading: false,
            loaded: false,
            errorMessage: '',
            activeTab: 'wkit-header',
            items: {
                'wkit-header': [],
                'wkit-footer': [],
                'wkit-single': [],
                'wkit-archive': [],
                'wkit-search': [],
                'wkit-404': []
            },
            modalOpen: false,
            modalSaving: false,
            modalError: '',
            form: getDefaultTemplateForm('wkit-header')
        },
        templateImporter: {
            loading: false,
            loaded: false,
            errorMessage: '',
            activeTab: 'full-import',
            autoInstallEnabled: TEMPLATE_IMPORTER_AUTO_INSTALL_ENABLED,
            fullImportMessage: '',
            fullImportRunning: false,
            fullImportConfirmOpen: false,
            fullImportPendingInputId: '',
            fullImportPendingFileName: '',
            fullImportPendingFile: null,
            fullImportPendingKitId: 0,
            fullImportPendingRemoteSlug: '',
            fullImportPendingFeatures: [],
            fullImportPendingWhatImport: [],
            fullImportCancelConfirmOpen: false,
            fullImportAwaitingPluginStep: false,
            fullImportCompleted: false,
            fullImportProgress: {
                phase: 'idle',
                label: '',
                current: 0,
                total: 0
            },
            uploading: false,
            kits: [],
            selectedKitId: 0,
            templatesLoading: false,
            templatesLoaded: false,
            templatesError: '',
            templates: [],
            requiredPlugins: [],
            elementorSettings: {
                disable_default_colors: false,
                disable_default_fonts: false
            },
            actionLoadingId: '',
            importingAll: false,
            installingRequiredPlugins: false,
            installModalOpen: false,
            installModalError: '',
            installModalSelections: {},
            disableElementorDefaultColors: true,
            disableElementorDefaultFonts: true,
            remoteLoading: false,
            remoteLoaded: false,
            remoteError: '',
            remoteKits: [],
            browseSearch: '',
            browsePricingFilter: 'all',
            browsePage: 1,
            fullRemoteLoading: false,
            fullRemoteLoaded: false,
            fullRemoteError: '',
            fullRemoteKits: [],
            fullImportBrowseSearch: '',
            fullImportPricingFilter: 'all',
            fullImportPage: 1
        }
    };

    function cloneSettings(settings) {
        return JSON.parse(JSON.stringify(settings || { widgets: {}, modules: {} }));
    }

    function normalizeSettings(settings) {
        var normalized = cloneSettings(settings);
        if (!normalized.widgets || typeof normalized.widgets !== 'object') {
            normalized.widgets = {};
        }
        if (!normalized.modules || typeof normalized.modules !== 'object') {
            normalized.modules = {};
        }
        return normalized;
    }

    function normalizePath(path) {
        if (path === 'widgets') {
            return 'widgets';
        }
        if (path === 'template-builder') {
            return 'template-builder';
        }
        if (path === 'starter-template' || path === 'template-kit' || path === 'template-importer') {
            return 'starter-template';
        }
        return 'dashboard';
    }

    function paginateItems(items, page, perPage) {
        var list = Array.isArray(items) ? items : [];
        var totalPages = Math.max(1, Math.ceil(list.length / perPage));
        var currentPage = Math.max(1, Math.min(parseInt(page || 1, 10) || 1, totalPages));
        var start = (currentPage - 1) * perPage;

        return {
            items: list.slice(start, start + perPage),
            currentPage: currentPage,
            totalPages: totalPages
        };
    }

    function renderTemplatePagination(kind, pageData) {
        if (!pageData || pageData.totalPages <= 1) {
            return '';
        }

        var pages = [];
        for (var page = 1; page <= pageData.totalPages; page += 1) {
            pages.push(
                '<button type="button" class="wkit-template-page-button ' + (page === pageData.currentPage ? 'is-active' : '') + '" data-ti-page="' + escapeHtml(kind) + '" data-ti-page-number="' + String(page) + '">' + String(page) + '</button>'
            );
        }

        return [
            '<div class="wkit-template-pagination" aria-label="Template pagination">',
            '<button type="button" class="wkit-template-page-button" data-ti-page="' + escapeHtml(kind) + '" data-ti-page-number="' + String(pageData.currentPage - 1) + '" ' + (pageData.currentPage <= 1 ? 'disabled' : '') + '>&lsaquo;</button>',
            pages.join(''),
            '<button type="button" class="wkit-template-page-button" data-ti-page="' + escapeHtml(kind) + '" data-ti-page-number="' + String(pageData.currentPage + 1) + '" ' + (pageData.currentPage >= pageData.totalPages ? 'disabled' : '') + '>&rsaquo;</button>',
            '</div>'
        ].join('');
    }

    function renderWiraTemplatesActionButton() {
        var dependency = data.wiraTemplates || {};
        var label = 'Install Wira Templates';
        var url = dependency.installUrl || dependency.installScreenUrl || '';

        if (dependency.active) {
            label = 'Go to Wira Templates';
            url = dependency.adminUrl || '';
        } else if (dependency.installed) {
            label = 'Activate Wira Templates';
        }

        if (dependency.active) {
            if (!url) {
                return '<button type="button" class="button wkit-button-primary" disabled>' + escapeHtml(label) + '</button>';
            }
            return '<a class="button wkit-button-primary" href="' + escapeHtml(url) + '">' + escapeHtml(label) + '</a>';
        }

        return '<button type="button" class="button wkit-button-primary" data-wkit-wira-templates-setup="1" ' + (state.wiraTemplatesBusy ? 'disabled' : '') + '>' + escapeHtml(state.wiraTemplatesBusy ? 'Processing...' : label) + '</button>';
    }

    function getDefaultTemplateForm(type) {
        var resolvedType = type || 'wkit-header';
        var defaultDisplay = 'all';
        if (resolvedType === 'wkit-single') {
            defaultDisplay = 'singular';
        } else if (resolvedType === 'wkit-archive') {
            defaultDisplay = 'archive';
        } else if (resolvedType === 'wkit-search') {
            defaultDisplay = 'search';
        } else if (resolvedType === 'wkit-404') {
            defaultDisplay = '404';
        }
        return {
            id: 0,
            type: resolvedType,
            title: '',
            conditionStatus: 'active',
            conditionDisplay: defaultDisplay
        };
    }

    function escapeHtml(value) {
        return String(value || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function isDirty() {
        return JSON.stringify(state.settings) !== JSON.stringify(state.baseline);
    }

    function areAllEnabled() {
        var widgetKeys = Object.keys(state.settings.widgets || {});
        var moduleKeys = Object.keys(state.settings.modules || {});
        var allKeys = widgetKeys.concat(moduleKeys);

        if (!allKeys.length) {
            return false;
        }

        return widgetKeys.every(function (id) { return !!state.settings.widgets[id]; }) &&
            moduleKeys.every(function (id) { return !!state.settings.modules[id]; });
    }

    function setAdminPath(path, push) {
        var normalized = normalizePath(path);
        var url = new URL(window.location.href);

        if (normalized === 'dashboard') {
            url.searchParams.set('page', 'wira-kit-for-elementor');
            url.searchParams.delete('path');
        } else {
            url.searchParams.set('page', 'wira-kit-for-elementor');
            url.searchParams.set('path', normalized);
        }

        if (push !== false) {
            window.history.pushState({ path: normalized }, '', url.toString());
        }
    }

    function getPathFromHref(href) {
        try {
            var url = new URL(href, window.location.origin);
            var page = url.searchParams.get('page');
            if (page && page.indexOf('wira-kit-for-elementor&path=') === 0) {
                return normalizePath(page.split('&path=')[1] || 'dashboard');
            }
            if (page === 'wkit-template-builder') {
                return 'template-builder';
            }
            if (page !== 'wira-kit-for-elementor') {
                return null;
            }
            return normalizePath(url.searchParams.get('path') || 'dashboard');
        } catch (error) {
            return null;
        }
    }

    function syncSidebarActive(path) {
        var topLevel = document.getElementById('toplevel_page_wira-kit-for-elementor');
        if (!topLevel) {
            return;
        }

        topLevel.classList.add('wp-has-current-submenu', 'wp-menu-open', 'current');
        topLevel.querySelectorAll('.wp-submenu a[href*="page=wira-kit-for-elementor"]').forEach(function (link) {
            var item = link.closest('li');
            var active = getPathFromHref(link.href) === path;
            if (item) {
                item.classList.toggle('current', active);
            }
            if (active) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    function renderToggleItem(group, item) {
        var checked = !!(state.settings[group] && state.settings[group][item.id]);
        return [
            '<div class="wkit-setting-item toggle-item">',
            '<span class="accent-text">', escapeHtml(item.label || item.id), '</span>',
            '<div class="wkit-toggle-button-cover">',
            '<div class="wkit-toggle-button wkit-toggle-button-r">',
            '<input class="wkit-toggle-checkbox" type="checkbox" data-group="', escapeHtml(group), '" data-id="', escapeHtml(item.id), '" ', checked ? 'checked' : '', '>',
            '<div class="wkit-toggle-knobs"></div>',
            '<div class="wkit-toggle-layer"></div>',
            '</div>',
            '</div>',
            '</div>'
        ].join('');
    }

    function renderGroup(title, group, items) {
        if (!items || !items.length) {
            return '';
        }

        return [
            '<div class="wkit-settings-group">',
            '<h5 class="wkit-settings-group-heading">', escapeHtml(title), '</h5>',
            '<div class="wkit-settings-group-grid">',
            items.map(function (item) {
                return renderToggleItem(group, item);
            }).join(''),
            '</div>',
            '</div>'
        ].join('');
    }

    function renderSaveButton() {
        var dirty = isDirty();
        var disabled = !dirty || state.saveState === 'saving';
        var classes = 'button wkit-button-primary wkit-save-button' + (dirty ? ' is-dirty' : '');

        if (state.saveState === 'saving') {
            return '<button type="button" class="' + classes + '" data-action="save" disabled><span class="wkit-save-label"><span class="wkit-spinner"></span>Saving...</span></button>';
        }
        if (state.saveState === 'saved') {
            return '<button type="button" class="' + classes + '" data-action="save" disabled><span class="wkit-save-label"><span class="wkit-check">&#10003;</span>Saved</span></button>';
        }

        return '<button type="button" class="' + classes + '" data-action="save" ' + (disabled ? 'disabled' : '') + '>Save Changes</button>';
    }

    function renderWidgetsView() {
        var widgets = Array.isArray(data.widgetItems) ? data.widgetItems : [];
        var modules = (Array.isArray(data.moduleItems) ? data.moduleItems : []).filter(function (item) {
            return !item || (item.id !== 'advanced-template-import' && item.id !== 'template-importer-auto-install');
        });
        var masterChecked = areAllEnabled();
        var widgetCategoryOrder = [];
        var widgetCategoryMap = {};

        widgets.forEach(function (item) {
            var category = item.category || 'wira-kit-for-elementor';
            var categoryLabel = item.category_label || 'Wira Kit for Elementor';

            if (!widgetCategoryMap[category]) {
                widgetCategoryMap[category] = {
                    label: categoryLabel,
                    items: []
                };
                widgetCategoryOrder.push(category);
            }

            widgetCategoryMap[category].items.push(item);
        });

        var widgetGroupsHtml = widgetCategoryOrder.map(function (category) {
            var group = widgetCategoryMap[category];
            return renderGroup(group.label, 'widgets', group.items);
        }).join('');

        var moduleCategoryOrder = [];
        var moduleCategoryMap = {};
        modules.forEach(function (item) {
            var category = item.category || 'modules';
            var categoryLabel = item.category_label || (category === 'modules' ? 'Modules' : category);

            if (!moduleCategoryMap[category]) {
                moduleCategoryMap[category] = { label: categoryLabel, items: [] };
                moduleCategoryOrder.push(category);
            }
            moduleCategoryMap[category].items.push(item);
        });
        var moduleGroupsHtml = moduleCategoryOrder.map(function (category) {
            var group = moduleCategoryMap[category];
            return renderGroup(group.label, 'modules', group.items);
        }).join('');

        return [
            '<div class="wkit-admin-panel">',
            '<div class="panel-wrapper">',
            '<h4>Widgets and Moduls Setting</h4>',
            '<p>Enable or disable widgets and modules, then save changes.</p>',
            '<div class="wkit-settings-toolbar">',
            '<div class="global-enabler-btn-wrapper">',
            '<button type="button" class="button-enabler" data-action="disable-all">Disable All</button>',
            '<div class="wkit-toggle-button-cover">',
            '<div class="wkit-toggle-button wkit-toggle-button-r">',
            '<input class="wkit-toggle-checkbox" type="checkbox" data-master-toggle="all" ', masterChecked ? 'checked' : '', '>',
            '<div class="wkit-toggle-knobs"></div>',
            '<div class="wkit-toggle-layer"></div>',
            '</div>',
            '</div>',
            '<button type="button" class="button-enabler" data-action="enable-all">Enable All</button>',
            '</div>',
            renderSaveButton(),
            '</div>',
            state.errorMessage ? '<p class="wkit-error-text">' + escapeHtml(state.errorMessage) + '</p>' : '',
            widgetGroupsHtml,
            moduleGroupsHtml,
            '</div>',
            '</div>'
        ].join('');
    }

    function renderDashboardView() {
        var starterTemplatesEnabled = !!(state.settings && state.settings.modules && state.settings.modules['starter-templates']);
        return [
            '<div class="wkit-admin-panel">',
            '<div class="panel-row">',
            '<div class="panel-column">',
            '<div class="panel-wrapper featured">',
            '<div class="subheading-dashboard">',
            '<strong>' + escapeHtml(data.pluginName || 'Wira Kit for Elementor') + '</strong>',
            '<span>Version ' + escapeHtml(data.pluginVersion || '') + '</span>',
            '</div>',
            '<p>Wira Kit for Elementor brings together powerful custom widgets and a flexible template builder system to enhance your Elementor experience. Enable only the widgets you need, keep your site lightweight, and prepare your workflow for scalable.</p>',
            '</div>',
            '<div class="panel-column-hz">',
            (starterTemplatesEnabled ? [
                '<div class="panel-wrapper featured enjoy">',
                '<span class="dashicons dashicons-art"></span>',
                '<h5>Starter Templates</h5>',
                '<p>Build site faster using Starter Templates, just import and settings.</p>',
                '<button href="' + escapeHtml(data.templateKitUrl || data.templateImporterUrl || '#') + '" class="button wkit-admin-btn-text" data-route="starter-template">Starter Template<span class="dashicons dashicons-arrow-right-alt margin-left-7"></span></button>',
                '</div>'
            ].join('') : ''),
            '<div class="panel-wrapper featured enjoy">',
            '<span class="dashicons dashicons-welcome-widgets-menus"></span>',
            '<h5>Template Builder</h5>',
            '<p>Create or edit every aspec of template using template builder.</p>',
            '<button href="' + escapeHtml(data.templateBuilderUrl || '#') + '" class="button wkit-admin-btn-text" data-route="template-builder">Template Builder<span class="dashicons dashicons-arrow-right-alt margin-left-7"></span></button>',
            '</div>',
            '<div class="panel-wrapper featured enjoy">',
            '<span class="dashicons dashicons-admin-generic"></span>',
            '<h5>Widgets And Modules</h5>',
            '<p>Keep your site faster, enable or disable widgets and modules.</p>',
            '<button href="' + escapeHtml(data.widgetsUrl || '#') + '" class="button wkit-admin-btn-text" data-route="widgets">Widgets And Modules<span class="dashicons dashicons-arrow-right-alt margin-left-7"></span></button>',
            '</div>',
            '</div>',
            '</div>',
            '<div class="panel-column-5">',
            '<div class="bg-featured">',
            '<div class="panel-wrapper featured panel-featured-wrapper enjoy">',
            '<span class="dashicons dashicons-awards"></span>',
            '<h5>Enjoy the plugin without locked features</h5>',
            '<p>We bring premium features for fully free without locked, Perfect and Template kit developer friendly.</p>',
            '</div>',
            '</div>',
            '<div class="panel-wrapper sticky tkit-tutorial-used">',
            '<div>',
            '<h5>Explore Our WiraKit Documentation</h5>',
            '<a type="button" class="button wkit-button-tertiary" href="https://doc.wiratheme.com/wirakit/" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-book margin-right-7"></span>Documentation</a>',
            '</div>',
            '</div>',
            '</div>',
            '</div>',
            '</div>'
        ].join('');
    }

    function getTemplateTypeLabel(type) {
        if (type === 'wkit-footer') {
            return 'Footer Builder';
        }
        if (type === 'wkit-single') {
            return 'Single Builder';
        }
        if (type === 'wkit-archive') {
            return 'Archive Builder';
        }
        if (type === 'wkit-search') {
            return 'Search Result Builder';
        }
        if (type === 'wkit-404') {
            return '404 Builder';
        }
        return 'Header Builder';
    }

    function renderTemplateBuilderTableRows(type) {
        var list = state.templateBuilder.items[type] || [];
        if (!list.length) {
            return '<tr><td colspan="4" class="wkit-template-builder-empty">No items found.</td></tr>';
        }

        return list.map(function (item) {
            return [
                '<tr>',
                '<td>', escapeHtml(item.title || '(No title)'), '</td>',
                '<td>', escapeHtml(item.condition_status || 'active'), '</td>',
                '<td>', escapeHtml(item.condition_display_text || item.condition_display || 'all'), '</td>',
                '<td><button type="button" class="button wkit-button-secondary" data-tb-edit="', String(item.id), '" data-tb-type="', escapeHtml(type), '">Action</button></td>',
                '</tr>'
            ].join('');
        }).join('');
    }

    function renderTemplateBuilderModal() {
        if (!state.templateBuilder.modalOpen) {
            return '';
        }

        var form = state.templateBuilder.form;
        var isNew = !form.id;
        var optionsMap = getDisplayOptionsForTemplateType(form.type);
        var displayOptions = Object.keys(optionsMap).map(function (key) {
            var selected = form.conditionDisplay === key ? ' selected' : '';
            return '<option value="' + escapeHtml(key) + '"' + selected + '>' + escapeHtml(optionsMap[key]) + '</option>';
        }).join('');

        return [
            '<div class="wkit-modal-overlay" data-tb-close="1">',
            '<div class="wkit-modal" role="dialog" aria-modal="true" aria-label="Template Builder Form">',
            '<div class="wkit-modal-header">',
            '<h5>', isNew ? 'Add New ' + escapeHtml(getTemplateTypeLabel(form.type)) : 'Edit ' + escapeHtml(getTemplateTypeLabel(form.type)), '</h5>',
            '<button type="button" class="wkit-modal-close" data-tb-close="1" aria-label="Close">&times;</button>',
            '</div>',
            '<div class="wkit-modal-body modal-template-builder">',
            state.templateBuilder.modalError ? '<p class="wkit-error-text">' + escapeHtml(state.templateBuilder.modalError) + '</p>' : '',
            '<div class="wkit-form-row">',
            '<label for="wkit-tb-title">Title</label>',
            '<input id="wkit-tb-title" type="text" value="', escapeHtml(form.title), '" data-tb-field="title" placeholder="Template title">',
            '</div>',
            '<div class="wkit-form-row wkit-form-row-toggle">',
            '<label for="wkit-tb-status">Active/Inactive</label>',
            '<div class="wkit-toggle-button-cover">',
            '<div class="wkit-toggle-button wkit-toggle-button-r">',
            '<input id="wkit-tb-status" class="wkit-toggle-checkbox" type="checkbox" data-tb-field="conditionStatus" ', form.conditionStatus === 'active' ? 'checked' : '', '>',
            '<div class="wkit-toggle-knobs"></div>',
            '<div class="wkit-toggle-layer"></div>',
            '</div>',
            '</div>',
            '</div>',
            '<div class="wkit-form-row">',
            '<label for="wkit-tb-display">Condition Display</label>',
            '<select id="wkit-tb-display" data-tb-field="conditionDisplay">',
            displayOptions,
            '</select>',
            '</div>',
            '</div>',
            '<div class="wkit-modal-footer">',
            form.id ? '<a class="button" target="_blank" href="' + escapeHtml(form.editUrl || '#') + '" data-tb-open-editor="1">Edit With Elementor</a>' : '<span></span>',
            '<div class="wkit-modal-footer-btn-wrapper">',
            form.id ? '<button type="button" class="button button-warning" data-tb-delete="1" ' + (state.templateBuilder.modalSaving ? 'disabled' : '') + '>Delete</button>' : '',
            '<button type="button" class="button wkit-button-primary" data-tb-save="1" ', state.templateBuilder.modalSaving ? 'disabled' : '', '>',
            state.templateBuilder.modalSaving ? 'Saving...' : (isNew ? 'Publish' : 'Update'),
            '</button>',
            '</div>',
            '</div>',
            '</div>',
            '</div>'
        ].join('');
    }

    function renderTemplateBuilderView() {
        var enabledTypes = getEnabledTemplateBuilderTypes();
        var activeTab = state.templateBuilder.activeTab;

        if (enabledTypes.length && enabledTypes.indexOf(activeTab) === -1) {
            activeTab = enabledTypes[0];
            state.templateBuilder.activeTab = activeTab;
            state.templateBuilder.form = getDefaultTemplateForm(activeTab);
        }

        return [
            '<div class="wkit-admin-panel">',
            '<div class="panel-row">',
            '<div class="panel-column-5">',
            '<div class="bg-featured">',
            '<div class="panel-wrapper featured panel-featured-wrapper">',
            '<div class="wkit-template-builder-tabs">',
            '<h6>Template Builder</h6>',
            (enabledTypes.indexOf('wkit-header') !== -1 ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'wkit-header' ? 'is-active' : '') + '" data-tb-tab="wkit-header"><span class="dashicons dashicons-table-row-after margin-right-7"></span>Header Builder</button>' : ''),
            (enabledTypes.indexOf('wkit-footer') !== -1 ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'wkit-footer' ? 'is-active' : '') + '" data-tb-tab="wkit-footer"><span class="dashicons dashicons-table-row-before margin-right-7"></span>Footer Builder</button>' : ''),
            (enabledTypes.indexOf('wkit-single') !== -1 ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'wkit-single' ? 'is-active' : '') + '" data-tb-tab="wkit-single"><span class="dashicons dashicons-admin-page margin-right-7"></span>Single Builder</button>' : ''),
            (enabledTypes.indexOf('wkit-archive') !== -1 ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'wkit-archive' ? 'is-active' : '') + '" data-tb-tab="wkit-archive"><span class="dashicons dashicons-category margin-right-7"></span>Archive Builder</button>' : ''),
            (enabledTypes.indexOf('wkit-search') !== -1 ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'wkit-search' ? 'is-active' : '') + '" data-tb-tab="wkit-search"><span class="dashicons dashicons-search margin-right-7"></span>Search Result Builder</button>' : ''),
            (enabledTypes.indexOf('wkit-404') !== -1 ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'wkit-404' ? 'is-active' : '') + '" data-tb-tab="wkit-404"><span class="dashicons dashicons-warning margin-right-7"></span>404 Builder</button>' : ''),
            '</div>',
            '</div>',
            '</div>',
            '</div>',
            '<div class="panel-column">',
            '<div class="panel-wrapper">',
            '<div class="wkit-template-builder-toolbar">',
            '<h4>', escapeHtml(getTemplateTypeLabel(activeTab)), '</h4>',
            '<button type="button" class="button wkit-button-primary" data-tb-add="', escapeHtml(activeTab), '">Add Item</button>',
            '</div>',
            state.templateBuilder.errorMessage ? '<p class="wkit-error-text">' + escapeHtml(state.templateBuilder.errorMessage) + '</p>' : '',
            state.templateBuilder.loading ? '<p>Loading...</p>' : [
                '<div class="wkit-template-builder-table-wrap">',
                '<table class="widefat striped wkit-template-builder-table">',
                '<thead>',
                '<tr>',
                '<th>Title</th>',
                '<th>Active/Inactive</th>',
                '<th>Condition Display</th>',
                '<th>Action</th>',
                '</tr>',
                '</thead>',
                '<tbody>',
                renderTemplateBuilderTableRows(activeTab),
                '</tbody>',
                '</table>',
                '</div>'
            ].join(''),
            '</div>',
            '</div>',
            '</div>',
            renderTemplateBuilderModal(),
            '</div>'
        ].join('');
    }

    function getTemplateImporterKitById(id) {
        var kits = state.templateImporter.kits || [];
        for (var i = 0; i < kits.length; i++) {
            if (String(kits[i].id) === String(id)) {
                return kits[i];
            }
        }
        return null;
    }

    function getTemplateTypeBadgeLabel(type) {
        if (!type) {
            return 'template';
        }
        return String(type).replace(/-/g, ' ');
    }

    function getAdminBaseUrl() {
        var ajaxUrl = data.ajaxUrl || window.ajaxurl || '';
        if (typeof ajaxUrl !== 'string' || !ajaxUrl) {
            return '/wp-admin/';
        }
        return ajaxUrl.replace(/admin-ajax\.php.*$/i, '');
    }

    function getTemplateEditElementorUrl(templateId) {
        return getAdminBaseUrl() + 'post.php?post=' + encodeURIComponent(String(templateId || 0)) + '&action=elementor';
    }

    function isAdvancedTemplateImportEnabled() {
        return false;
    }

    function renderTemplateImporterTabButtons() {
        var activeTab = getVisibleTemplateImporterTab(state.templateImporter.activeTab);
        var advancedImportEnabled = isAdvancedTemplateImportEnabled();
        return [
            '<div class="wkit-template-builder-tabs">',
            '<h6>Starter Templates</h6>',
            '<button type="button" class="wkit-template-builder-tab accent-text ', activeTab === 'full-import' ? 'is-active' : '', '" data-ti-tab="full-import"><span class="dashicons dashicons-superhero-alt margin-right-7"></span>Full Site Templates</button>',
            '<button type="button" class="wkit-template-builder-tab accent-text ', activeTab === 'browse-demo' ? 'is-active' : '', '" data-ti-tab="browse-demo"><span class="dashicons dashicons-admin-site-alt3 margin-right-7"></span>Template Kits</button>',
            advancedImportEnabled ? '<button type="button" class="wkit-template-builder-tab accent-text ' + (activeTab === 'import-template' ? 'is-active' : '') + '" data-ti-tab="import-template"><span class="dashicons dashicons-media-archive margin-right-7"></span>Import Template Kit</button>' : '',
            '</div>'
        ].join('');
    }

    function getVisibleTemplateImporterTab(tab) {
        return (tab === 'browse-demo' || tab === 'full-import') ? tab : 'full-import';
    }

    function renderTemplateImporterUploadTab() {
        return [
            '<div class="wkit-template-builder-toolbar">',
            '<h4>Import Template Kit</h4>',
            '</div>',
            state.templateImporter.errorMessage ? '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.errorMessage) + '</p>' : '',
            '<p>Upload a .zip template kit file, then manage and import templates from the Imported Template tab.</p>',
            '<label class="wkit-custom-file-upload" for="wkit-ti-upload-file">',
            '<div class="wkit-custom-file-upload-icon">',
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true"><path d="M10 1C9.73478 1 9.48043 1.10536 9.29289 1.29289L3.29289 7.29289C3.10536 7.48043 3 7.73478 3 8V20C3 21.6569 4.34315 23 6 23H7C7.55228 23 8 22.5523 8 22C8 21.4477 7.55228 21 7 21H6C5.44772 21 5 20.5523 5 20V9H10C10.5523 9 11 8.55228 11 8V3H18C18.5523 3 19 3.44772 19 4V9C19 9.55228 19.4477 10 20 10C20.5523 10 21 9.55228 21 9V4C21 2.34315 19.6569 1 18 1H10ZM9 7H6.41421L9 4.41421V7ZM14 15.5C14 14.1193 15.1193 13 16.5 13C17.8807 13 19 14.1193 19 15.5V16V17H20C21.1046 17 22 17.8954 22 19C22 20.1046 21.1046 21 20 21H13C11.8954 21 11 20.1046 11 19C11 17.8954 11.8954 17 13 17H14V16V15.5ZM16.5 11C14.142 11 12.2076 12.8136 12.0156 15.122C10.2825 15.5606 9 17.1305 9 19C9 21.2091 10.7909 23 13 23H20C22.2091 23 24 21.2091 24 19C24 17.1305 22.7175 15.5606 20.9844 15.122C20.7924 12.8136 18.858 11 16.5 11Z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>',
            '</div>',
            '<div class="wkit-custom-file-upload-text"><span>Click to upload ZIP</span></div>',
            '<input id="wkit-ti-upload-file" type="file" accept=".zip,application/zip,application/x-zip-compressed">',
            '</label>',
            state.templateImporter.uploading ? '<p>Uploading ZIP...</p>' : ''
        ].join('');
    }

    function renderTemplateImporterFullImportTab() {
        return [
            '<div class="wkit-template-builder-toolbar imported-tkit">',
            '<h4>Full Site Templates <span class="dashicons dashicons-editor-help wkit-inline-tooltip" title="Just One click Installation. This will automatic import templates, template builder assignments, forms, menus, and front page settings." aria-label="Full Site Template info"></span></h4>',
            '<button type="button" class="button wkit-button-secondary" data-ti-full-browse-refresh="1">Refresh</button>',
            '</div>',
            '<div class="wkit-search-filter-row">',
            '<div class="wkit-search-group">',
            '<svg class="wkit-search-icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>',
            '<input type="search" class="wkit-search-input" value="' + escapeHtml(state.templateImporter.fullImportBrowseSearch || '') + '" placeholder="Search template..." data-ti-search-full-import="1">',
            '</div>',
            '</div>',
            renderTemplateImporterFullImportBrowseGrid()
        ].join('');
    }

    function getFullImportProgressPercent() {
        var progress = state.templateImporter.fullImportProgress || {};
        if (progress.phase === 'upload' || progress.phase === 'prepare') {
            return 0;
        }
        if (progress.phase === 'import') {
            var total = parseInt(progress.total || 0, 10);
            var current = parseInt(progress.current || 0, 10);
            if (total <= 0) {
                return 0;
            }
            return Math.max(0, Math.min(99, Math.round((current / total) * 100)));
        }
        if (progress.phase === 'done') {
            return 100;
        }
        return 0;
    }

    function renderTemplateImporterFullImportModal() {
        if (state.templateImporter.activeTab !== 'full-import') {
            return '';
        }
        if (!state.templateImporter.fullImportConfirmOpen && !state.templateImporter.uploading && !state.templateImporter.fullImportRunning) {
            return '';
        }

        var isDownloadingRemote = String(state.templateImporter.actionLoadingId || '').indexOf('import-full-remote-') === 0;
        var isBusy = state.templateImporter.uploading || state.templateImporter.fullImportRunning || isDownloadingRemote;
        var showImportProgress = !!state.templateImporter.fullImportRunning;
        var progress = state.templateImporter.fullImportProgress || {};
        var label = progress.label || (isBusy ? 'Processing import...' : 'Confirm full site for selected template.');
        var percent = getFullImportProgressPercent();
        var canClose = !isBusy;
        var isCompleted = !!state.templateImporter.fullImportCompleted;
        var awaitingPluginStep = !!state.templateImporter.fullImportAwaitingPluginStep;
        var requiredPlugins = Array.isArray(state.templateImporter.requiredPlugins) ? state.templateImporter.requiredPlugins : [];
        var autoInstallEnabled = !!state.templateImporter.autoInstallEnabled;
        var allPluginsReady = requiredPlugins.length
            ? requiredPlugins.every(function (plugin) { return !!plugin.installed && !!plugin.active; })
            : true;
        var allRequirementsReady = allPluginsReady;
        var pluginRows = requiredPlugins.map(function (plugin) {
            var key = getRequiredPluginSelectionKey(plugin);
            var checked = !!state.templateImporter.installModalSelections[key];
            var status = (plugin.installed && plugin.active)
                ? 'Installed & Active'
                : (plugin.installed ? 'Installed (Inactive)' : 'Not Installed');
            var purchaseBadge = plugin && plugin.requires_purchase
                ? (' <span class="wkit-ti-plugin-purchase-warning">' + escapeHtml(String(plugin.purchase_label || 'Need additional purchase')) + '</span>')
                : '';
            var actions = [];
            if (autoInstallEnabled) {
                // In AJAX mode we keep UI simple: use checkbox selection + bottom "Install & Refresh" button.
                // Only show "Purchase" for premium requirements (e.g. Elementor Pro).
                if (plugin && plugin.requires_purchase && plugin.purchase_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.purchase_url)) + '" target="_blank" rel="noopener">' + escapeHtml(String(plugin.purchase_button_label || 'Purchase')) + '</a>');
                }
            } else {
                if (!plugin.installed && plugin.install_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.install_url)) + '" target="_blank" rel="noopener">Install</a>');
                } else if (!plugin.installed && plugin.install_screen_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.install_screen_url)) + '" target="_blank" rel="noopener">Install</a>');
                }
                if (plugin.installed && !plugin.active && plugin.activate_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.activate_url)) + '" target="_blank" rel="noopener">Activate</a>');
                } else if (plugin.installed && !plugin.active && plugin.activate_screen_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.activate_screen_url)) + '" target="_blank" rel="noopener">Activate</a>');
                }
                if (plugin && plugin.requires_purchase && plugin.purchase_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.purchase_url)) + '" target="_blank" rel="noopener">' + escapeHtml(String(plugin.purchase_button_label || 'Purchase')) + '</a>');
                }
            }
            return [
                '<label class="wkit-ti-plugin-check-row">',
                '<input type="checkbox" data-ti-install-plugin-toggle="' + escapeHtml(key) + '" ' + (checked ? 'checked' : '') + ' ' + (isBusy ? 'disabled' : '') + '>',
                '<span class="wkit-ti-plugin-check-text">',
                '<strong>' + escapeHtml(plugin.name || plugin.slug || plugin.file || 'Plugin') + purchaseBadge + '</strong>',
                '<small>' + escapeHtml(state.templateImporter.installingRequiredPlugins && checked ? 'Checking...' : status) + '</small>',
                '</span>',
                actions.length ? '<span class="wkit-ti-plugin-check-actions">' + actions.join(' ') + '</span>' : '',
                '</label>'
            ].join('');
        }).join('');
        var hasPendingKit = !!(parseInt(state.templateImporter.fullImportPendingKitId || 0, 10) || 0);
        var hasPendingRemoteSlug = !!String(state.templateImporter.fullImportPendingRemoteSlug || '');
        var features = Array.isArray(state.templateImporter.fullImportPendingFeatures) ? state.templateImporter.fullImportPendingFeatures : [];
        var whatImportItems = Array.isArray(state.templateImporter.fullImportPendingWhatImport) ? state.templateImporter.fullImportPendingWhatImport : [];
        var pendingRemoteKit = hasPendingRemoteSlug
            ? (state.templateImporter.fullRemoteKits || []).find(function (item) {
                return String(item && item.slug ? item.slug : '') === String(state.templateImporter.fullImportPendingRemoteSlug || '');
            })
            : null;
        var isSubscribeOnly = !!(pendingRemoteKit && String(pendingRemoteKit.pricing_type || '').toLowerCase() === 'subscribe');
        var shouldGuardSubscribe = hasPendingRemoteSlug && !pendingRemoteKit;
        var canInstallSubscribe = !isSubscribeOnly || state.extendedLicenseActive;
        var featureItems = features.filter(function (item) {
            return String(item || '').trim().length > 0;
        });
        var normalizedWhatImportItems = whatImportItems.filter(function (item) {
            return String(item || '').trim().length > 0;
        });
        var showFeatureList = !showImportProgress && !awaitingPluginStep && hasPendingRemoteSlug && featureItems.length;
        var showWhatImportList = !showImportProgress && !awaitingPluginStep && hasPendingKit && label === 'You can start template import now.' && normalizedWhatImportItems.length;
        var featureIcon = '<svg class="wkit-ti-feature-icon" xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" aria-hidden="true" focusable="false"><path d="m422-232 207-248H469l29-227-185 267h139l-30 208ZM320-80l40-280H160l360-520h80l-40 320h240L400-80h-80Zm151-390Z"/></svg>';
        var wwiIcon = '<svg class="wkit-ti-feature-icon" xmlns="http://www.w3.org/2000/svg" height="18" viewBox="0 -960 960 960" width="18" fill="currentColor" aria-hidden="true" focusable="false"><path d="m424-408-86-86q-11-11-28-11t-28 11q-11 11-11 28t11 28l114 114q12 12 28 12t28-12l226-226q11-11 11-28t-11-28q-11-11-28-11t-28 11L424-408Zm56 328q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>';        
        var featureListMarkup = showFeatureList ? [
            '<div class="wkit-ti-feature-list">',
            '<strong class="accent-text">Features:</strong>',
            '<ul class="wirakit-fi-features-list">',
            featureItems.map(function (item) {
                return '<li><span class="wkit-ti-feature-icon-wrap" style="color: var(--wkit-color-primary);">' + featureIcon + '</span><span class="wkit-ti-feature-text">' + escapeHtml(item) + '</span></li>';
            }).join(''),
            '</ul>',
            '</div>'
        ].join('') : '';
        var whatImportMarkup = showWhatImportList ? [
            '<div class="wkit-ti-feature-list wkit-ti-what-import-list">',
            '<strong class="accent-text">What Will Import:</strong>',
            '<ul class="wirakit-fi-features-list">',
            normalizedWhatImportItems.map(function (item) {
                return '<li><span class="wkit-ti-feature-icon-wrap" style="color: var(--wkit-color-primary);">' + wwiIcon + '</span><span class="wkit-ti-feature-text">' + escapeHtml(item) + '</span></li>';
            }).join(''),
            '</ul>',
            '</div>'
        ].join('') : '';

        return [
            '<div class="wkit-modal-overlay" data-ti-full-import-modal-overlay="1">',
            '<div class="wkit-modal" role="dialog" aria-modal="true" aria-label="Full Site Import">',
            '<div class="wkit-modal-header">',
            '<h5>Full Site Import</h5>',
            canClose ? '<button type="button" class="wkit-modal-close" data-ti-full-import-modal-close="1" aria-label="Close">&times;</button>' : '',
            '</div>',
            '<div class="wkit-modal-body">',
            state.templateImporter.errorMessage ? '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.errorMessage) + '</p>' : '',
            (!isBusy && !hasPendingKit && hasPendingRemoteSlug) ? '<div class="wkit-warning-box"><strong>Warning:</strong> Full Site Template will override existing pages, template assignments, and menu locations.</div>' : '',
            showImportProgress ? '<div class="wkit-warning-box"><strong>Warning:</strong> Do not reload or close this page while template import is running.</div>' : '',
            '<p><strong>Template:</strong> ' + escapeHtml(state.templateImporter.fullImportPendingFileName || '-') + '</p>',
            featureListMarkup,
            whatImportMarkup,
            '<p>' + escapeHtml(label) + '</p>',
            awaitingPluginStep ? [
                '<div class="wkit-ti-plugin-checklist">',
                pluginRows || '<p class="description">No required plugins found.</p>',
                '</div>',
                '<div class="wkit-ti-elementor-options">',
                '<label class="wkit-ti-plugin-check-row">',
                '<input type="checkbox" data-ti-disable-default-colors="1" ' + (state.templateImporter.disableElementorDefaultColors ? 'checked' : '') + ' ' + (isBusy ? 'disabled' : '') + '>',
                '<span class="wkit-ti-plugin-check-text"><strong>Disable Default Colors (Elementor)</strong><small>' + (state.templateImporter.disableElementorDefaultColors ? 'Checked' : 'Unchecked') + '</small></span>',
                '</label>',
                '<label class="wkit-ti-plugin-check-row">',
                '<input type="checkbox" data-ti-disable-default-fonts="1" ' + (state.templateImporter.disableElementorDefaultFonts ? 'checked' : '') + ' ' + (isBusy ? 'disabled' : '') + '>',
                '<span class="wkit-ti-plugin-check-text"><strong>Disable Default Fonts (Elementor)</strong><small>' + (state.templateImporter.disableElementorDefaultFonts ? 'Checked' : 'Unchecked') + '</small></span>',
                '</label>',
                '</div>'
            ].join('') : '',
            showImportProgress ? [
                '<div class="wkit-ti-full-import-progress">',
                '<div class="wkit-ti-full-import-progress-bar" style="width: ' + String(percent) + '%;"></div>',
                '</div>',
                '<p class="description">', escapeHtml(String(percent) + '% completed'), '</p>'
            ].join('') : '',
            '</div>',
            '<div class="wkit-modal-footer">',
            isCompleted
                ? '<button type="button" class="button wkit-button-secondary" data-ti-full-import-close="1">Close</button>'
                : '',
            isCompleted
                ? '<a class="button wkit-button-primary" href="' + escapeHtml((data.homeUrl || data.siteUrl || '/')) + '" target="_blank" rel="noopener noreferrer">Visit Site</a>'
                : '',
            canClose && !isCompleted && !awaitingPluginStep && !hasPendingKit && hasPendingRemoteSlug
                ? '<button type="button" class="button wkit-button-secondary" data-ti-full-import-modal-cancel="1">Cancel</button>'
                : '',
            canClose && !awaitingPluginStep && hasPendingKit
                ? '<button type="button" class="button wkit-button-secondary" data-ti-full-import-back-step="1">Back Step</button>'
                : '',
            canClose && awaitingPluginStep
                ? '<button type="button" class="button wkit-button-warning" data-ti-full-import-install="1" ' + (state.templateImporter.installingRequiredPlugins ? 'disabled' : '') + '>' + (state.templateImporter.installingRequiredPlugins ? 'Processing...' : (autoInstallEnabled ? 'Complete Setup' : 'Apply & Refresh')) + '</button>'
                : '',
            canClose && awaitingPluginStep
                ? '<button type="button" class="button wkit-button-primary" data-ti-full-import-next-step="1" ' + ((!allRequirementsReady || state.templateImporter.installingRequiredPlugins) ? 'disabled' : '') + '>Next Step</button>'
                : '',
            canClose && !awaitingPluginStep && !isCompleted && (hasPendingKit || hasPendingRemoteSlug)
                ? (
                    ((!canInstallSubscribe && hasPendingRemoteSlug) || shouldGuardSubscribe)
                        ? '<a class="button wkit-button-tertiary" href="' + escapeHtml(GET_ALL_ACCESS_URL) + '" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-awards margin-right-7"></span>Get All Access</a>'
                        : '<button type="button" class="button wkit-button-primary" data-ti-full-import-modal-start="1" ' + (isDownloadingRemote ? 'disabled' : '') + '>' + (isDownloadingRemote ? 'Downloading Package...' : (hasPendingKit ? 'Start Import Template' : 'Start Import')) + '</button>'
                )
                : (canClose ? '' : '<button type="button" class="button wkit-button-primary" disabled>Importing...</button>'),
            '</div>',
            '</div>',
            '</div>'
        ].join('');
    }

    function renderTemplateImporterFullImportCancelModal() {
        if (!state.templateImporter.fullImportCancelConfirmOpen) {
            return '';
        }

        return [
            '<div class="wkit-modal-overlay" data-ti-full-import-cancel-modal-overlay="1">',
            '<div class="wkit-modal modal-warning" role="dialog" aria-modal="true" aria-label="Cancel Import Confirmation">',
            '<div class="wkit-modal-header">',
            '<h5>Cancel Import</h5>',
            '<button type="button" class="wkit-modal-close" data-ti-full-import-cancel-no="1" aria-label="Close">&times;</button>',
            '</div>',
            '<div class="wkit-modal-body">',
            '<button type="button" class="button wkit-button-secondary" data-ti-full-import-cancel-no="1">Keep Import</button>',
            '<button type="button" class="button wkit-button-primary" data-ti-full-import-cancel-yes="1">Cancel Import</button>',
            '</div>',
            '</div>',
            '</div>'
        ].join('');
    }

    function renderTemplateImporterKitsGrid() {
        var kits = state.templateImporter.kits || [];

        if (state.templateImporter.loading) {
            return '<p>Loading imported kits...</p>';
        }

        if (!kits.length) {
            return '<p>No imported template kits yet. Browse and import template or Upload a kit from Import Template tab.</p>';
        }

        return [
            '<div class="wkit-settings-group-grid template-kit">',
            kits.map(function (kit) {
                var busy = state.templateImporter.actionLoadingId === ('delete-kit-' + String(kit.id));
                return [
                    '<div class="wkit-setting-item row-box">',
                    kit.screenshot ? '<div class="wkit-ti-kit-thumb"><img src="' + escapeHtml(kit.screenshot) + '" alt="' + escapeHtml(kit.title || 'Template Kit') + '"></div>' : '<div class="wkit-ti-kit-thumb wkit-ti-kit-thumb-empty"></div>',
                    '<div class="wkit-tk-wrapper">',
                    '<div class="template-kit-imported">',
                    '<h6>', escapeHtml(kit.title || 'Untitled Kit'), '</h6>',
                    '<p class="description">', escapeHtml((kit.template_count || 0) + ' templates'), '</p>',
                    '</div>',
                    '<div class="wkit-template-builder-toolbar no-margin">',
                    '<button type="button" class="button wkit-button-primary" data-ti-view-kit="', String(kit.id), '">View Templates</button>',
                    '<button type="button" class="button button-warning" data-ti-delete-kit="', String(kit.id), '" ', busy ? 'disabled' : '', '>',
                    busy ? 'Deleting...' : 'Delete',
                    '</button>',
                    '</div>',
                    '</div>',
                    '</div>'
                ].join('');
            }).join(''),
            '</div>'
        ].join('');
    }

    function renderTemplateImporterTemplatesGrid() {
        var templates = state.templateImporter.templates || [];
        var kit = getTemplateImporterKitById(state.templateImporter.selectedKitId);
        var requiredPlugins = Array.isArray(state.templateImporter.requiredPlugins) ? state.templateImporter.requiredPlugins : [];
        var hasMissingRequiredPlugins = requiredPlugins.some(function (plugin) {
            return !plugin.installed || !plugin.active;
        });

        if (state.templateImporter.templatesLoading) {
            return '<p>Loading templates...</p>';
        }

        if (state.templateImporter.templatesError) {
            return '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.templatesError) + '</p>';
        }

        if (!templates.length) {
            return '<p>No templates found in this kit.</p>';
        }

        return [
            '<div class="wkit-template-builder-toolbar no-border">',
            '<strong class="template-kit-imported-name">', escapeHtml((kit && kit.title ? kit.title : 'Template Kit') + ' Templates'), '</strong class="template-kit-imported-name">',
            '<button type="button" class="button wkit-button-primary" data-ti-import-all="', String(state.templateImporter.selectedKitId), '" ', state.templateImporter.importingAll ? 'disabled' : '', '>',
            state.templateImporter.importingAll ? 'Importing...' : 'Import All',
            '</button>',
            '</div>',
            hasMissingRequiredPlugins ? [
                '<div class="wkit-template-builder-toolbar required-warning">',
                '<span class="description">Required plugins are not fully installed or activated.</span>',
                '<button type="button" class="button wkit-button-warning" data-ti-install-required-plugins="', String(state.templateImporter.selectedKitId), '" ', state.templateImporter.installingRequiredPlugins ? 'disabled' : '', '>',
                state.templateImporter.installingRequiredPlugins ? 'Checking...' : 'Required Plugins',
                '</button>',
                '</div>'
            ].join('') : '',
            '<div class="wkit-settings-group-grid template-kit">',
            templates.map(function (template) {
                var key = 'import-template-' + String(template.id);
                var busy = state.templateImporter.actionLoadingId === key;
                var hasImported = Array.isArray(template.imports) && template.imports.length > 0;
                var latestImport = hasImported ? template.imports[template.imports.length - 1] : null;
                var latestImportedId = latestImport && latestImport.imported_template_id ? parseInt(latestImport.imported_template_id, 10) : 0;

                return [
                    '<div class="wkit-setting-item row-box">',
                    hasImported ? '<p class="imported-total">Imported ' + String(template.imports.length) + 'x</p>' : '',
                    template.screenshot ? '<div class="wkit-ti-template-thumb"><img src="' + escapeHtml(template.screenshot) + '" alt="' + escapeHtml(template.name || 'Template') + '"></div>' : '<div class="wkit-ti-template-thumb wkit-ti-template-thumb-empty"></div>',
                    '<div class="wkit-w100">',
                    '<div class="wkit-tk-wrapper">',
                    '<div class="template-kit-imported">',
                    '<h6>', escapeHtml(template.name || 'Untitled Template'), '</h6>',
                    template.unmet_requirements && template.unmet_requirements.length ? '<p class="wkit-error-text">' + escapeHtml(template.unmet_requirements.join(', ')) + '</p>' : '',
                    '</div>',
                    '<div class="wkit-template-builder-toolbar no-margin">',
                    hasImported
                        ? '<button type="button" class="button wkit-button-secondary" data-ti-import-template-again="' + String(template.id) + '" ' + (busy ? 'disabled' : '') + '>' + (busy ? 'Importing...' : 'Import Again') + '</button>'
                        : '<button type="button" class="button wkit-button-primary" data-ti-import-template="' + String(template.id) + '" ' + (busy ? 'disabled' : '') + '>' + (busy ? 'Importing...' : 'Import Template') + '</button>',
                    hasImported && latestImportedId ? '<a class="button wkit-button-tertiary" href="' + escapeHtml(getTemplateEditElementorUrl(latestImportedId)) + '" target="_blank" rel="noopener noreferrer">Edit Elementor</a>' : '',
                    '</div>',
                    '</div>',
                    '</div>',
                    '</div>'
                ].join('');
            }).join(''),
            '</div>'
        ].join('');
    }

    function getRequiredPluginSelectionKey(plugin) {
        if (!plugin || typeof plugin !== 'object') {
            return '';
        }
        if (plugin.slug) {
            return String(plugin.slug);
        }
        if (plugin.file) {
            return String(plugin.file);
        }
        if (plugin.name) {
            return String(plugin.name);
        }
        return '';
    }

    function openInstallRequiredPluginsModal() {
        var requiredPlugins = Array.isArray(state.templateImporter.requiredPlugins) ? state.templateImporter.requiredPlugins : [];
        if (!requiredPlugins.length) {
            state.templateImporter.templatesError = 'No required plugins found.';
            render();
            return;
        }

        var selections = {};
        requiredPlugins.forEach(function (plugin) {
            var key = getRequiredPluginSelectionKey(plugin);
            if (!key) {
                return;
            }
            selections[key] = (!plugin.installed || !plugin.active);
        });

        state.templateImporter.installModalOpen = true;
        state.templateImporter.installModalError = '';
        state.templateImporter.installModalSelections = selections;
        // Default checked for smoother imports; user can uncheck if they want Elementor defaults kept.
        state.templateImporter.disableElementorDefaultColors = true;
        state.templateImporter.disableElementorDefaultFonts = true;
        render();
    }

    function closeInstallRequiredPluginsModal() {
        if (state.templateImporter.installingRequiredPlugins) {
            return;
        }
        var pendingFullImport = !!state.templateImporter.fullImportAwaitingPluginStep;
        var pendingKitId = parseInt(state.templateImporter.fullImportPendingKitId || 0, 10) || 0;
        state.templateImporter.installModalOpen = false;
        state.templateImporter.installModalError = '';
        state.templateImporter.installModalSelections = {};
        state.templateImporter.disableElementorDefaultColors = false;
        state.templateImporter.disableElementorDefaultFonts = false;
        if (pendingFullImport) {
            state.templateImporter.fullImportAwaitingPluginStep = false;
            state.templateImporter.fullImportPendingKitId = 0;
        }
        render();

        if (pendingFullImport && pendingKitId) {
            runFullImportFlow(pendingKitId);
        }
    }

    function renderInstallRequiredPluginsModal() {
        if (!state.templateImporter.installModalOpen) {
            return '';
        }

        var requiredPlugins = Array.isArray(state.templateImporter.requiredPlugins) ? state.templateImporter.requiredPlugins : [];
        var autoInstallEnabled = !!state.templateImporter.autoInstallEnabled;
        var pluginRows = requiredPlugins.map(function (plugin) {
            var key = getRequiredPluginSelectionKey(plugin);
            var checked = !!state.templateImporter.installModalSelections[key];
            var status = (plugin.installed && plugin.active)
                ? 'Installed & Active'
                : (plugin.installed ? 'Installed (Inactive)' : 'Not Installed');
            var purchaseBadge = plugin && plugin.requires_purchase
                ? (' <span class="wkit-ti-plugin-purchase-warning">' + escapeHtml(String(plugin.purchase_label || 'Need additional purchase')) + '</span>')
                : '';
            var actions = [];
            if (autoInstallEnabled) {
                // In AJAX mode we keep UI simple: use checkbox selection + bottom "Install & Refresh" button.
                // Only show "Purchase" for premium requirements (e.g. Elementor Pro).
                if (plugin && plugin.requires_purchase && plugin.purchase_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.purchase_url)) + '" target="_blank" rel="noopener">' + escapeHtml(String(plugin.purchase_button_label || 'Purchase')) + '</a>');
                }
            } else {
                if (!plugin.installed && plugin.install_url) {
                    // Open in a new tab to keep the Template Kit UI in place.
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.install_url)) + '" target="_blank" rel="noopener">Install</a>');
                } else if (!plugin.installed && plugin.install_screen_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.install_screen_url)) + '" target="_blank" rel="noopener">Install</a>');
                }
                if (plugin.installed && !plugin.active && plugin.activate_url) {
                    // Open in a new tab to keep the Template Kit UI in place.
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.activate_url)) + '" target="_blank" rel="noopener">Activate</a>');
                } else if (plugin.installed && !plugin.active && plugin.activate_screen_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.activate_screen_url)) + '" target="_blank" rel="noopener">Activate</a>');
                }
                if (plugin && plugin.requires_purchase && plugin.purchase_url) {
                    actions.push('<a class="button wkit-button-tertiary" href="' + escapeHtml(String(plugin.purchase_url)) + '" target="_blank" rel="noopener">' + escapeHtml(String(plugin.purchase_button_label || 'Purchase')) + '</a>');
                }
            }
            return [
                '<label class="wkit-ti-plugin-check-row">',
                '<input type="checkbox" data-ti-install-plugin-toggle="' + escapeHtml(key) + '" ' + (checked ? 'checked' : '') + ' ' + (state.templateImporter.installingRequiredPlugins ? 'disabled' : '') + '>',
                '<span class="wkit-ti-plugin-check-text">',
                '<strong>' + escapeHtml(plugin.name || plugin.slug || plugin.file || 'Plugin') + purchaseBadge + '</strong>',
                '<small>' + escapeHtml(status) + '</small>',
                '</span>',
                actions.length ? '<span class="wkit-ti-plugin-check-actions">' + actions.join(' ') + '</span>' : '',
                '</label>'
            ].join('');
        }).join('');
        var colorsDisabled = !!(state.templateImporter.elementorSettings && state.templateImporter.elementorSettings.disable_default_colors);
        var fontsDisabled = !!(state.templateImporter.elementorSettings && state.templateImporter.elementorSettings.disable_default_fonts);

        return [
            '<div class="wkit-modal-overlay" data-ti-install-modal-overlay="1">',
            '<div class="wkit-modal" role="dialog" aria-modal="true" aria-label="Required Plugins">',
            '<div class="wkit-modal-header">',
            '<h5>Required Plugins</h5>',
            '<button type="button" class="wkit-modal-close" data-ti-install-modal-close-control="1" aria-label="Close">&times;</button>',
            '</div>',
            '<div class="wkit-modal-body">',
            state.templateImporter.installModalError ? '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.installModalError) + '</p>' : '',
            autoInstallEnabled
                ? '<p class="description">Install/Activate runs via AJAX. Select plugins below and click Complete Setup.</p>'
                : '<p class="description">Install/Activate opens WordPress core in a new tab. After you finish there, return here and click Apply & Refresh. This plugin does not install or activate other plugins automatically.</p>',
            '<div class="wkit-ti-plugin-checklist">',
            pluginRows,
            '</div>',
            '<div class="wkit-ti-elementor-options">',
            '<label class="wkit-ti-plugin-check-row">',
            '<input type="checkbox" data-ti-disable-default-colors="1" ' + (state.templateImporter.disableElementorDefaultColors ? 'checked' : '') + ' ' + (state.templateImporter.installingRequiredPlugins ? 'disabled' : '') + '>',
            '<span class="wkit-ti-plugin-check-text"><strong>Disable Default Colors (Elementor)</strong><small>' + (colorsDisabled ? 'Checked' : 'Unchecked') + '</small></span>',
            '</label>',
            '<label class="wkit-ti-plugin-check-row">',
            '<input type="checkbox" data-ti-disable-default-fonts="1" ' + (state.templateImporter.disableElementorDefaultFonts ? 'checked' : '') + ' ' + (state.templateImporter.installingRequiredPlugins ? 'disabled' : '') + '>',
            '<span class="wkit-ti-plugin-check-text"><strong>Disable Default Fonts (Elementor)</strong><small>' + (fontsDisabled ? 'Checked' : 'Unchecked') + '</small></span>',
            '</label>',
            '</div>',
            '</div>',
            '<div class="wkit-modal-footer">',
            '<button type="button" class="button wkit-button-secondary" data-ti-install-modal-close-control="1" ' + (state.templateImporter.installingRequiredPlugins ? 'disabled' : '') + '>Cancel</button>',
            '<button type="button" class="button wkit-button-primary" data-ti-install-modal-submit="1" ' + (state.templateImporter.installingRequiredPlugins ? 'disabled' : '') + '>',
            state.templateImporter.installingRequiredPlugins ? 'Processing...' : (autoInstallEnabled ? 'Complete Setup' : 'Apply & Refresh'),
            '</button>',
            '</div>',
            '</div>',
            '</div>'
        ].join('');
    }

    function renderTemplateImporterImportedTab() {
        var selectedKitId = state.templateImporter.selectedKitId;
        return [
            '<div class="wkit-template-builder-toolbar imported-tkit">',
            '<h4>Imported Template Kits <span class="dashicons dashicons-editor-help wkit-inline-tooltip" title="Imported Template Kits only lists Template Kit imports. Full Site Templates appear in the My Templates Elementor" aria-label="Imported Template Kits info"></span></h4>',
            selectedKitId ? '<button type="button" class="button wkit-button-secondary" data-ti-back-list="1">Back to Kits</button>' : '<button type="button" class="button wkit-button-secondary" data-ti-refresh-kits="1">Refresh</button>',
            '</div>',
            state.templateImporter.errorMessage ? '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.errorMessage) + '</p>' : '',
            selectedKitId ? renderTemplateImporterTemplatesGrid() : renderTemplateImporterKitsGrid()
        ].join('');
    }

    function renderTemplateImporterBrowseGrid() {
        var kits = state.templateImporter.remoteKits || [];
        var query = (state.templateImporter.browseSearch || '').toLowerCase().trim();
        var pricingFilter = String(state.templateImporter.browsePricingFilter || 'all').toLowerCase();

        if (query) {
            kits = kits.filter(function (kit) {
                var haystack = [
                    kit && kit.name ? String(kit.name) : '',
                    kit && kit.slug ? String(kit.slug) : '',
                    kit && kit.version ? String(kit.version) : ''
                ].join(' ').toLowerCase();
                return haystack.indexOf(query) !== -1;
            });
        }

        if (pricingFilter === 'free' || pricingFilter === 'subscribe') {
            kits = kits.filter(function (kit) {
                return String(kit && kit.pricing_type ? kit.pricing_type : 'free').toLowerCase() === pricingFilter;
            });
        }

        if (state.templateImporter.remoteLoading) {
            return '<p>Loading templates...</p>';
        }

        if (state.templateImporter.remoteError) {
            return '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.remoteError) + '</p>';
        }

        if (!kits.length) {
            return '<p>No templates found.</p>';
        }

        var pageData = paginateItems(kits, state.templateImporter.browsePage, 6);
        state.templateImporter.browsePage = pageData.currentPage;
        kits = pageData.items;

        return [
            '<div class="wkit-settings-group-grid template-kit">',
            kits.map(function (kit) {
                var isSubscribeOnly = String(kit && kit.pricing_type ? kit.pricing_type : '').toLowerCase() === 'subscribe';
                return [
                    '<div class="wkit-setting-item row-box">',
                    kit.thumbnail ? '<div class="wkit-ti-template-thumb"><img src="' + escapeHtml(kit.thumbnail) + '" alt="' + escapeHtml(kit.name || kit.slug || 'Demo Kit') + '"></div>' : '<div class="wkit-ti-template-thumb wkit-ti-kit-thumb-empty"></div>',
                    '<div class="wkit-tk-wrapper">',
                    '<div class="template-kit-imported">',
                    '<h6>', escapeHtml(kit.name || kit.slug || 'Untitled Kit'), '</h6>',
                    '<p class="description">', escapeHtml(kit.version ? 'v' + kit.version : ''), '</p>',
                    '</div>',
                    '<div class="wkit-template-builder-toolbar no-margin">',
                    kit.demo ? '<a class="button wkit-button-secondary" href="' + escapeHtml(kit.demo) + '" target="_blank" rel="noopener noreferrer">Demo</a>' : '',
                    renderWiraTemplatesActionButton(),
                    '</div>',
                    '</div>',
                    '</div>'
                ].join('');
            }).join(''),
            '</div>',
            renderTemplatePagination('browse', pageData)
        ].join('');
    }

    function renderTemplateImporterFullImportBrowseGrid() {
        var kits = state.templateImporter.fullRemoteKits || [];
        var query = (state.templateImporter.fullImportBrowseSearch || '').toLowerCase().trim();
        var pricingFilter = String(state.templateImporter.fullImportPricingFilter || 'all').toLowerCase();

        kits = kits.filter(function (kit) {
            return String(kit && kit.import_type ? kit.import_type : 'template_kit') === 'full_import';
        });

        if (query) {
            kits = kits.filter(function (kit) {
                var haystack = [
                    kit && kit.name ? String(kit.name) : '',
                    kit && kit.slug ? String(kit.slug) : '',
                    kit && kit.version ? String(kit.version) : ''
                ].join(' ').toLowerCase();
                return haystack.indexOf(query) !== -1;
            });
        }

        if (pricingFilter === 'free' || pricingFilter === 'subscribe') {
            kits = kits.filter(function (kit) {
                return String(kit && kit.pricing_type ? kit.pricing_type : 'free').toLowerCase() === pricingFilter;
            });
        }

        if (state.templateImporter.fullRemoteLoading) {
            return '<p>Loading templates...</p>';
        }

        if (state.templateImporter.fullRemoteError) {
            return '<p class="wkit-error-text">' + escapeHtml(state.templateImporter.fullRemoteError) + '</p>';
        }

        if (!kits.length) {
            return '<p>No full site templates found.</p>';
        }

        var pageData = paginateItems(kits, state.templateImporter.fullImportPage, 6);
        state.templateImporter.fullImportPage = pageData.currentPage;
        kits = pageData.items;

        return [
            '<div class="wkit-settings-group-grid template-kit">',
            kits.map(function (kit) {
                var isSubscribeOnly = String(kit && kit.pricing_type ? kit.pricing_type : '').toLowerCase() === 'subscribe';
                return [
                    '<div class="wkit-setting-item row-box">',
                    kit.thumbnail ? '<div class="wkit-ti-kit-thumb"><img src="' + escapeHtml(kit.thumbnail) + '" alt="' + escapeHtml(kit.name || kit.slug || 'Full Site Template') + '"></div>' : '<div class="wkit-ti-kit-thumb wkit-ti-kit-thumb-empty"></div>',
                    '<div class="wkit-tk-wrapper">',
                    '<div class="template-kit-imported">',
                    '<h6>', escapeHtml(kit.name || kit.slug || 'Untitled Template'), '</h6>',
                    '<p class="description">', escapeHtml(kit.version ? 'v' + kit.version : ''), '</p>',
                    '</div>',
                    '<div class="wkit-template-builder-toolbar no-margin">',
                    kit.demo ? '<a class="button wkit-button-secondary" href="' + escapeHtml(kit.demo) + '" target="_blank" rel="noopener noreferrer">Demo</a>' : '',
                    renderWiraTemplatesActionButton(),
                    '</div>',
                    '</div>',
                    '</div>'
                ].join('');
            }).join(''),
            '</div>',
            renderTemplatePagination('full-import', pageData)
        ].join('');
    }

    function renderTemplateImporterBrowseDemoTab() {
        return [
            '<div class="wkit-template-builder-toolbar imported-tkit">',
            '<h4>Template Kits <span class="dashicons dashicons-editor-help wkit-inline-tooltip" title="Template Kits import individual templates. After import, you need to assign templates manually." aria-label="Template Kits info"></span></h4>',
            '<button type="button" class="button wkit-button-secondary" data-ti-browse-refresh="1">Refresh</button>',
            '</div>',
            '<div class="wkit-search-filter-row">',
            '<div class="wkit-search-group">',
            '<svg class="wkit-search-icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>',
            '<input type="search" class="wkit-search-input" value="' + escapeHtml(state.templateImporter.browseSearch || '') + '" placeholder="Search template..." data-ti-search-browse="1">',
            '</div>',
            '</div>',
            renderTemplateImporterBrowseGrid()
        ].join('');
    }

    function renderTemplateImporterView() {
        state.templateImporter.activeTab = getVisibleTemplateImporterTab(state.templateImporter.activeTab);
        var importerBody = renderTemplateImporterFullImportTab();
        if (state.templateImporter.activeTab === 'browse-demo') {
            importerBody = renderTemplateImporterBrowseDemoTab();
        }

        return [
            '<div class="wkit-admin-panel">',
            '<div class="panel-row">',
            '<div class="panel-column-5">',
            '<div class="bg-featured">',
            '<div class="panel-wrapper featured panel-featured-wrapper">',
            renderTemplateImporterTabButtons(),
            '</div>',
            '</div>',
            '<div class="panel-wrapper sticky tkit-tutorial-used">',
            '<div>',
            '<h5>Getting stuck ? Explore Our Plugin Documentation Here</h5>',
            '<a type="button" class="button wkit-button-tertiary" href="https://doc.wiratheme.com/wirakit/" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-book margin-right-7"></span>Documentation</a>',
            '</div>',
            '</div>',
            '</div>',
            '<div class="panel-column">',
            '<div class="panel-wrapper">',
            importerBody,
            '</div>',
            '</div>',
            '</div>',
            renderInstallRequiredPluginsModal(),
            renderTemplateImporterFullImportModal(),
            renderTemplateImporterFullImportCancelModal(),
            '</div>'
        ].join('');
    }

    function render() {
        var navDashboard = state.path === 'dashboard' ? 'active' : '';
        var navWidgets = state.path === 'widgets' ? 'active' : '';
        var navTemplateBuilder = state.path === 'template-builder' ? 'active' : '';
        var navTemplateImporter = state.path === 'starter-template' ? 'active' : '';
        var starterTemplatesEnabled = !!(state.settings && state.settings.modules && state.settings.modules['starter-templates']);
        var logoUrl = data.logoUrl ? escapeHtml(data.logoUrl) : '';
        var logoWidth = data.logoWidth ? String(parseInt(data.logoWidth, 10) || 170) : '170';
        var content = renderDashboardView();

        if (state.path === 'widgets') {
            content = renderWidgetsView();
        } else if (state.path === 'template-builder') {
            content = renderTemplateBuilderView();
        } else if (state.path === 'starter-template') {
            content = renderTemplateImporterView();
        }

        root.innerHTML = [
            '<div class="wkit-admin-dashboard-wrapper wkit-admin">',
            '<div class="wkit-admin-header">',
            '<div class="wkit-admin-header-wrapper">',
            '<div class="logo-wrapper">',
            logoUrl ? '<img src="' + logoUrl + '" alt="Wira Kit" width="' + logoWidth + '" height="auto" decoding="async" class="custom-logo">' : '<h1>Wira Kit</h1>',
            '</div>',
            '<div>',
            '<ul>',
            '<li class="' + navDashboard + '"><a href="' + escapeHtml(data.dashboardUrl || '#') + '" class="accent-text" data-route="dashboard">Dashboard</a></li>',
            (starterTemplatesEnabled
                ? '<li class="' + navTemplateImporter + '"><a href="' + escapeHtml(data.templateKitUrl || data.templateImporterUrl || '#') + '" class="accent-text" data-route="starter-template">Starter Templates</a></li>'
                : ''
            ),
            '<li class="' + navWidgets + '"><a href="' + escapeHtml(data.widgetsUrl || '#') + '" class="accent-text" data-route="widgets">Modul Settings</a></li>',
            '<li class="' + navTemplateBuilder + '"><a href="' + escapeHtml(data.templateBuilderUrl || '#') + '" class="accent-text" data-route="template-builder">Template Builder</a></li>',
            '</ul>',
            '</div>',
            '<a type="button" class="button wkit-button-tertiary" href="https://wiratheme.com/contact-us/" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-email margin-right-7"></span>Contact Us</a>',
            '</div>',
            '</div>',
            content,
            '</div>'
        ].join('');

        syncSidebarActive(state.path);
    }

    function renderWithBrowseSearchFocus() {
        var currentValue = state.templateImporter.browseSearch || '';
        render();

        window.requestAnimationFrame(function () {
            var input = root.querySelector('[data-ti-search-browse]');
            if (!input) {
                return;
            }
            input.focus();
            try {
                input.setSelectionRange(currentValue.length, currentValue.length);
            } catch (error) {
                // noop
            }
        });
    }

    function renderWithFullImportSearchFocus() {
        var currentValue = state.templateImporter.fullImportBrowseSearch || '';
        render();

        window.requestAnimationFrame(function () {
            var input = root.querySelector('[data-ti-search-full-import]');
            if (!input) {
                return;
            }
            input.focus();
            try {
                input.setSelectionRange(currentValue.length, currentValue.length);
            } catch (error) {
                // noop
            }
        });
    }

    function setPath(path, push) {
        var normalizedPath = normalizePath(path);
        var starterTemplatesEnabled = !!(state.settings && state.settings.modules && state.settings.modules['starter-templates']);
        if (normalizedPath === 'starter-template' && !starterTemplatesEnabled) {
            normalizedPath = 'dashboard';
        }

        state.path = normalizedPath;
        setAdminPath(state.path, push);

        if (state.path === 'template-builder') {
            ensureTemplateBuilderLoaded();
        } else if (state.path === 'starter-template') {
            state.templateImporter.activeTab = getVisibleTemplateImporterTab(state.templateImporter.activeTab);
            if (state.templateImporter.activeTab === 'browse-demo') {
                ensureRemoteBrowseLoaded();
            } else if (state.templateImporter.activeTab === 'full-import') {
                ensureFullImportRemoteLoaded();
            }
        }

        render();
    }

    function setAll(value) {
        Object.keys(state.settings.widgets || {}).forEach(function (id) {
            state.settings.widgets[id] = !!value;
        });
        Object.keys(state.settings.modules || {}).forEach(function (id) {
            state.settings.modules[id] = !!value;
        });
        state.errorMessage = '';
        if (state.saveState === 'saved') {
            state.saveState = 'idle';
        }
        render();
    }

    function postAjax(action, payload, nonce) {
        var formData = new window.FormData();
        formData.append('action', action);
        formData.append('nonce', nonce || '');

        Object.keys(payload || {}).forEach(function (key) {
            formData.append(key, payload[key]);
        });

        return window.fetch(data.ajaxUrl || window.ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            body: formData
        }).then(function (response) {
            return response.text().then(function (text) {
                try {
                    return JSON.parse(text);
                } catch (error) {
                    throw new Error(text ? text.substring(0, 200) : 'Invalid server response.');
                }
            });
        });
    }

    function installActivateWiraTemplates() {
        if (state.wiraTemplatesBusy) {
            return;
        }

        state.wiraTemplatesBusy = true;
        state.templateImporter.errorMessage = '';
        render();

        postAjax('Wirakit_install_activate_wira_templates', {}, data.wiraTemplatesNonce || data.settingsNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to prepare Wira Templates.';
                    throw new Error(message);
                }

                data.wiraTemplates = (result.data && result.data.wiraTemplates) ? result.data.wiraTemplates : data.wiraTemplates;
                var redirectUrl = (result.data && result.data.redirectUrl)
                    || (data.wiraTemplates && data.wiraTemplates.adminUrl)
                    || '';

                if (redirectUrl) {
                    window.location.href = redirectUrl;
                    return;
                }

                state.wiraTemplatesBusy = false;
                render();
            })
            .catch(function (error) {
                state.wiraTemplatesBusy = false;
                state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed to prepare Wira Templates.';
                render();
            });
    }

    function saveSettings() {
        if (!isDirty() || state.saveState === 'saving') {
            return;
        }

        state.saveState = 'saving';
        state.errorMessage = '';
        render();

        postAjax('Wirakit_save_settings', { settings: JSON.stringify(state.settings) }, data.settingsNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to save settings.';
                    throw new Error(message);
                }

                state.settings = normalizeSettings(result.data && result.data.settings ? result.data.settings : state.settings);
                state.baseline = cloneSettings(state.settings);
                state.saveState = 'saved';
                render();

                window.setTimeout(function () {
                    if (!isDirty()) {
                        state.saveState = 'idle';
                        render();
                    }
                }, 2000);
            })
            .catch(function (error) {
                state.saveState = 'idle';
                state.errorMessage = error && error.message ? error.message : 'Failed to save settings.';
                render();
            });
    }

    function ensureTemplateBuilderLoaded(force) {
        if (state.templateBuilder.loading) {
            return;
        }
        if (state.templateBuilder.loaded && !force) {
            return;
        }

        state.templateBuilder.loading = true;
        state.templateBuilder.errorMessage = '';
        render();

        Promise.all(TEMPLATE_TYPES.map(function (type) {
            return postAjax('Wirakit_tb_list', { template_type: type }, data.templateBuilderNonce)
                .then(function (result) {
                    if (!result || !result.success) {
                        var message = result && result.data && result.data.message ? result.data.message : 'Failed to load Template Builder items.';
                        throw new Error(message);
                    }

                    state.templateBuilder.items[type] = Array.isArray(result.data && result.data.items) ? result.data.items : [];
                });
        }))
            .then(function () {
                state.templateBuilder.loaded = true;
                state.templateBuilder.loading = false;
                render();
            })
            .catch(function (error) {
                state.templateBuilder.loading = false;
                state.templateBuilder.errorMessage = error && error.message ? error.message : 'Failed to load Template Builder items.';
                render();
            });
    }

    function openTemplateBuilderModal(type, item) {
        var nextForm = getDefaultTemplateForm(type);
        if (item) {
            nextForm.id = parseInt(item.id, 10) || 0;
            nextForm.title = item.title || '';
            nextForm.conditionStatus = item.condition_status === 'inactive' ? 'inactive' : 'active';
            nextForm.conditionDisplay = item.condition_display || 'all';
            nextForm.editUrl = item.edit_url || '';
        }

        state.templateBuilder.modalOpen = true;
        state.templateBuilder.modalSaving = false;
        state.templateBuilder.modalError = '';
        state.templateBuilder.form = nextForm;
        render();
    }

    function closeTemplateBuilderModal() {
        state.templateBuilder.modalOpen = false;
        state.templateBuilder.modalSaving = false;
        state.templateBuilder.modalError = '';
        state.templateBuilder.form = getDefaultTemplateForm(state.templateBuilder.activeTab);
        render();
    }

    function saveTemplateBuilderItem() {
        if (state.templateBuilder.modalSaving) {
            return;
        }

        var form = state.templateBuilder.form;
        if (!form.title || !form.title.trim()) {
            state.templateBuilder.modalError = 'Title is required.';
            render();
            return;
        }

        state.templateBuilder.modalSaving = true;
        state.templateBuilder.modalError = '';
        render();

        postAjax('Wirakit_tb_upsert', {
            id: form.id || 0,
            template_type: form.type,
            title: form.title.trim(),
            condition_status: form.conditionStatus,
            condition_display: form.conditionDisplay,
            publish: '1'
        }, data.templateBuilderNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to save item.';
                    throw new Error(message);
                }

                ensureTemplateBuilderLoaded(true);
                closeTemplateBuilderModal();
            })
            .catch(function (error) {
                state.templateBuilder.modalSaving = false;
                state.templateBuilder.modalError = error && error.message ? error.message : 'Failed to save item.';
                render();
            });
    }

    function deleteTemplateBuilderItem() {
        if (state.templateBuilder.modalSaving) {
            return;
        }

        var form = state.templateBuilder.form;
        if (!form.id) {
            return;
        }

        if (!window.confirm('Delete this item permanently?')) {
            return;
        }

        state.templateBuilder.modalSaving = true;
        state.templateBuilder.modalError = '';
        render();

        postAjax('Wirakit_tb_delete', {
            id: form.id,
            template_type: form.type
        }, data.templateBuilderNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to delete item.';
                    throw new Error(message);
                }

                ensureTemplateBuilderLoaded(true);
                closeTemplateBuilderModal();
            })
            .catch(function (error) {
                state.templateBuilder.modalSaving = false;
                state.templateBuilder.modalError = error && error.message ? error.message : 'Failed to delete item.';
                render();
            });
    }

    function getTemplateBuilderItemById(type, id) {
        var list = state.templateBuilder.items[type] || [];
        for (var i = 0; i < list.length; i++) {
            if (String(list[i].id) === String(id)) {
                return list[i];
            }
        }
        return null;
    }

    function ensureTemplateImporterLoaded(force) {
        if (state.templateImporter.loading) {
            return;
        }
        if (state.templateImporter.loaded && !force) {
            return;
        }

        state.templateImporter.loading = true;
        state.templateImporter.errorMessage = '';
        render();

        postAjax('Wirakit_ti_list_kits', {}, data.templateKitNonce || data.templateImporterNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to load imported kits.';
                    throw new Error(message);
                }

                state.templateImporter.kits = Array.isArray(result.data && result.data.kits) ? result.data.kits : [];
                state.templateImporter.loaded = true;
                state.templateImporter.loading = false;

                if (state.templateImporter.selectedKitId) {
                    var found = getTemplateImporterKitById(state.templateImporter.selectedKitId);
                    if (!found) {
                        state.templateImporter.selectedKitId = 0;
                        state.templateImporter.templates = [];
                    }
                }

                render();
            })
            .catch(function (error) {
                state.templateImporter.loading = false;
                state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed to load imported kits.';
                render();
            });
    }

    function ensureRemoteBrowseLoaded(force) {
        if (state.templateImporter.remoteLoading) {
            return;
        }
        if (state.templateImporter.remoteLoaded && !force) {
            return;
        }

        state.templateImporter.remoteLoading = true;
        state.templateImporter.remoteError = '';
        render();

        postAjax('Wirakit_ti_browse_kits', {}, data.templateKitNonce || data.templateImporterNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to load template kits.';
                    throw new Error(message);
                }

                state.templateImporter.remoteKits = Array.isArray(result.data && result.data.kits) ? result.data.kits : [];
                state.templateImporter.remoteLoaded = true;
                state.templateImporter.remoteLoading = false;
                render();
            })
            .catch(function (error) {
                state.templateImporter.remoteLoading = false;
                state.templateImporter.remoteError = error && error.message ? error.message : 'Failed to load template kits.';
                render();
            });
    }

    function ensureFullImportRemoteLoaded(force) {
        if (state.templateImporter.fullRemoteLoading) {
            return;
        }
        if (state.templateImporter.fullRemoteLoaded && !force) {
            return;
        }

        state.templateImporter.fullRemoteLoading = true;
        state.templateImporter.fullRemoteError = '';
        render();

        postAjax('Wirakit_ti_browse_full_import_kits', {}, data.templateKitNonce || data.templateImporterNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to load full site templates.';
                    throw new Error(message);
                }

                state.templateImporter.fullRemoteKits = Array.isArray(result.data && result.data.kits) ? result.data.kits : [];
                state.templateImporter.fullRemoteLoaded = true;
                state.templateImporter.fullRemoteLoading = false;
                render();
            })
            .catch(function (error) {
                state.templateImporter.fullRemoteLoading = false;
                state.templateImporter.fullRemoteError = error && error.message ? error.message : 'Failed to load full site templates.';
                render();
            });
    }

    function importRemoteKitBySlug(slug) {
        if (!slug) {
            return;
        }

        state.templateImporter.actionLoadingId = 'import-remote-' + String(slug);
        state.templateImporter.remoteError = '';
        render();

        postAjax(
            'Wirakit_ti_import_remote_kit',
            { slug: slug },
            data.templateKitNonce || data.templateImporterNonce
        )
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to import remote kit.';
                    throw new Error(message);
                }

                state.templateImporter.actionLoadingId = '';
                state.templateImporter.activeTab = 'browse-demo';
                ensureRemoteBrowseLoaded(true);
            })
            .catch(function (error) {
                state.templateImporter.actionLoadingId = '';
                state.templateImporter.remoteError = error && error.message ? error.message : 'Failed to import remote kit.';
                render();
            });
    }

    function importFullImportRemoteKitBySlug(slug, displayName) {
        if (!slug) {
            return;
        }

        var pendingKit = (state.templateImporter.fullRemoteKits || []).find(function (item) {
            return String(item && item.slug ? item.slug : '') === String(slug);
        });

        state.templateImporter.actionLoadingId = '';
        state.templateImporter.fullRemoteError = '';
        state.templateImporter.errorMessage = '';
        state.templateImporter.fullImportConfirmOpen = true;
        state.templateImporter.fullImportCompleted = false;
        state.templateImporter.fullImportPendingFileName = displayName || slug;
        state.templateImporter.fullImportPendingRemoteSlug = String(slug);
        state.templateImporter.fullImportPendingFeatures = pendingKit && Array.isArray(pendingKit.features) ? pendingKit.features : [];
        state.templateImporter.fullImportPendingWhatImport = pendingKit && Array.isArray(pendingKit.what_will_import) ? pendingKit.what_will_import : [];
        state.templateImporter.fullImportPendingKitId = 0;
        state.templateImporter.fullImportProgress = {
            phase: 'idle',
            label: 'Click Start Import to continue.',
            current: 0,
            total: 0
        };
        render();
    }

    function startFullImportRemoteDownload(slug) {
        if (!slug) {
            return;
        }

        state.templateImporter.actionLoadingId = 'import-full-remote-' + String(slug);
        state.templateImporter.fullRemoteError = '';
        state.templateImporter.errorMessage = '';
        state.templateImporter.fullImportConfirmOpen = true;
        state.templateImporter.fullImportProgress = {
            phase: 'prepare',
            label: 'Downloading full site template package...',
            current: 0,
            total: 1
        };
        render();

        postAjax(
            'Wirakit_ti_import_full_import_remote_kit',
            { slug: slug },
            data.templateKitNonce || data.templateImporterNonce
        )
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to prepare full site template.';
                    throw new Error(message);
                }

                var newKitId = result && result.data && result.data.templateKitId ? parseInt(result.data.templateKitId, 10) : 0;
                if (!newKitId) {
                    throw new Error('Invalid imported template kit ID.');
                }

                state.templateImporter.actionLoadingId = '';
                state.templateImporter.fullImportPendingRemoteSlug = '';
                prepareFullImportAfterUpload(newKitId);
            })
            .catch(function (error) {
                state.templateImporter.actionLoadingId = '';
                state.templateImporter.fullImportConfirmOpen = true;
                state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed to prepare full site template.';
                state.templateImporter.fullImportProgress = {
                    phase: 'idle',
                    label: '',
                    current: 0,
                    total: 0
                };
                render();
            });
    }

    function uploadTemplateKitZipFromInput(inputId, successMessage, directFile) {
        if (state.templateImporter.uploading) {
            return;
        }

        var input = null;
        var file = directFile || null;
        if (!file) {
            input = document.getElementById(inputId || 'wkit-ti-upload-file');
            if (!input || !input.files || !input.files.length) {
                state.templateImporter.errorMessage = 'Please choose a ZIP file first.';
                render();
                return;
            }
            file = input.files[0];
        }

        if (!file || !/\.zip$/i.test(file.name || '')) {
            state.templateImporter.errorMessage = 'Only .zip files are allowed.';
            render();
            return;
        }

        state.templateImporter.uploading = true;
        state.templateImporter.errorMessage = '';
        if (state.templateImporter.activeTab === 'full-import') {
            state.templateImporter.fullImportMessage = '';
            state.templateImporter.fullImportProgress = {
                phase: 'upload',
                label: 'Uploading ZIP file...',
                current: 0,
                total: 0
            };
        }
        render();

        postAjax('Wirakit_ti_upload_zip', { file: file }, data.templateKitNonce || data.templateImporterNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to upload ZIP.';
                    throw new Error(message);
                }

                var newKitId = result && result.data && result.data.templateKitId ? parseInt(result.data.templateKitId, 10) : 0;
                state.templateImporter.uploading = false;
                if (state.templateImporter.activeTab === 'full-import') {
                    state.templateImporter.fullImportMessage = successMessage || '';
                }
                if (input) {
                    input.value = '';
                }
                state.templateImporter.fullImportPendingFile = null;

                if (state.templateImporter.activeTab === 'full-import' && newKitId) {
                    prepareFullImportAfterUpload(newKitId);
                    return;
                }

                state.templateImporter.activeTab = 'full-import';
                render();
            })
            .catch(function (error) {
                state.templateImporter.uploading = false;
                state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed to upload ZIP.';
                render();
            });
    }

    function uploadTemplateKitZip() {
        uploadTemplateKitZipFromInput('wkit-ti-upload-file', '');
    }

    function prepareFullImportAfterUpload(kitId) {
        if (!kitId) {
            state.templateImporter.errorMessage = 'Invalid template kit ID.';
            render();
            return;
        }

        state.templateImporter.selectedKitId = parseInt(kitId, 10) || 0;
        state.templateImporter.fullImportMessage = '2. Required Plugins and Elementor Settings';
        state.templateImporter.fullImportProgress = {
            phase: 'prepare',
            label: 'Checking required plugins...',
            current: 0,
            total: 1
        };
        render();

        var templatesPromise = postAjax(
            'Wirakit_ti_list_templates',
            { template_kit_id: state.templateImporter.selectedKitId },
            data.templateKitNonce || data.templateImporterNonce
        );
        var kitsPromise = postAjax(
            'Wirakit_ti_list_kits',
            {},
            data.templateKitNonce || data.templateImporterNonce
        );

        Promise.all([templatesPromise, kitsPromise]).then(function (responses) {
            var result = responses[0];
            var kitsResult = responses[1];
            if (!result || !result.success) {
                var message = result && result.data && result.data.message ? result.data.message : 'Failed to read required plugins.';
                throw new Error(message);
            }

            if (kitsResult && kitsResult.success) {
                var kits = Array.isArray(kitsResult.data && kitsResult.data.kits) ? kitsResult.data.kits : [];
                var matchedKit = kits.find(function (kit) {
                    return String(kit && kit.id) === String(state.templateImporter.selectedKitId);
                });
                if (matchedKit && matchedKit.title) {
                    state.templateImporter.fullImportPendingFileName = String(matchedKit.title);
                }
            }

            state.templateImporter.requiredPlugins = Array.isArray(result.data && result.data.required_plugins) ? result.data.required_plugins : [];
            state.templateImporter.elementorSettings = (result.data && result.data.elementor_settings && typeof result.data.elementor_settings === 'object')
                ? result.data.elementor_settings
                : { disable_default_colors: false, disable_default_fonts: false };

            if (state.templateImporter.requiredPlugins.length) {
                state.templateImporter.fullImportAwaitingPluginStep = true;
                state.templateImporter.fullImportPendingKitId = state.templateImporter.selectedKitId;
                var selections = {};
                state.templateImporter.requiredPlugins.forEach(function (plugin) {
                    var key = getRequiredPluginSelectionKey(plugin);
                    if (!key) {
                        return;
                    }
                    selections[key] = (!plugin.installed || !plugin.active);
                });
                state.templateImporter.installModalSelections = selections;
                // Default checked for smoother imports; user can uncheck if they want Elementor defaults kept.
                state.templateImporter.disableElementorDefaultColors = true;
                state.templateImporter.disableElementorDefaultFonts = true;
                var hasInstallablePlugins = state.templateImporter.requiredPlugins.some(function (plugin) {
                    return !plugin.installed || !plugin.active;
                });
                var colorReady = !!(state.templateImporter.elementorSettings && state.templateImporter.elementorSettings.disable_default_colors);
                var fontReady = !!(state.templateImporter.elementorSettings && state.templateImporter.elementorSettings.disable_default_fonts);
                state.templateImporter.fullImportMessage = (hasInstallablePlugins || !colorReady || !fontReady)
                    ? '2. Required Plugins and Elementor Settings'
                    : 'All required plugins and requirements are already installed.';
                render();
                return;
            }

            state.templateImporter.fullImportAwaitingPluginStep = false;
            state.templateImporter.fullImportPendingKitId = state.templateImporter.selectedKitId;
            state.templateImporter.fullImportMessage = '3. Ready to import templates.';
            state.templateImporter.fullImportProgress = {
                phase: 'prepare',
                label: 'Required plugins checked. You can now start template import.',
                current: 0,
                total: 1
            };
            render();
        }).catch(function (error) {
            state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed preparing full site.';
            render();
        });
    }

    function refreshRequiredPluginsForKit(kitId) {
        if (!kitId) {
            return Promise.resolve();
        }

        return postAjax(
            'Wirakit_ti_list_templates',
            { template_kit_id: kitId },
            data.templateKitNonce || data.templateImporterNonce
        ).then(function (result) {
            if (!result || !result.success) {
                var message = result && result.data && result.data.message ? result.data.message : 'Failed to refresh required plugins.';
                throw new Error(message);
            }

            state.templateImporter.requiredPlugins = Array.isArray(result.data && result.data.required_plugins) ? result.data.required_plugins : [];
            state.templateImporter.elementorSettings = (result.data && result.data.elementor_settings && typeof result.data.elementor_settings === 'object')
                ? result.data.elementor_settings
                : state.templateImporter.elementorSettings;
            // Keep the user's checkbox preferences (default checked) instead of mirroring current option state.
        });
    }

    function runFullImportFlow(kitId) {
        if (!kitId || state.templateImporter.fullImportRunning) {
            return;
        }

        state.templateImporter.fullImportRunning = true;
        state.templateImporter.errorMessage = '';
        state.templateImporter.fullImportMessage = 'Preparing templates...';
        state.templateImporter.fullImportProgress = {
            phase: 'prepare',
            label: 'Reading templates from kit...',
            current: 0,
            total: 0
        };
        render();

        postAjax(
            'Wirakit_ti_list_templates',
            { template_kit_id: kitId },
            data.templateKitNonce || data.templateImporterNonce
        ).then(function (result) {
            if (!result || !result.success) {
                var message = result && result.data && result.data.message ? result.data.message : 'Failed to load templates for full site.';
                throw new Error(message);
            }

            var templates = Array.isArray(result.data && result.data.templates) ? result.data.templates : [];
            if (!templates.length) {
                state.templateImporter.fullImportRunning = false;
                state.templateImporter.fullImportMessage = 'ZIP uploaded, but no templates found in kit.';
                state.templateImporter.fullImportProgress = {
                    phase: 'done',
                    label: 'No templates found in kit.',
                    current: 0,
                    total: 0
                };
                render();
                return;
            }

            var assignmentSteps = [
                { key: 'import-acf', label: 'Import ACF/SCF' },
                { key: 'assign-template-builder', label: 'Assign Template Builder' },
                { key: 'assign-metform', label: 'Assign MetForm' },
                { key: 'assign-template', label: 'Assign Template' },
                { key: 'assign-menu', label: 'Assign Menu' },
                { key: 'assign-front-page', label: 'Assign Front Page' }
            ];

            var total = templates.length + assignmentSteps.length;
            var completed = 0;
            var sequence = Promise.resolve();

            templates.forEach(function (template) {
                sequence = sequence.then(function () {
                    state.templateImporter.fullImportMessage = '1. Import template - ' + String(completed + 1) + '/' + String(total) + ': ' + String(template.name || template.id || 'Template');
                    state.templateImporter.fullImportProgress = {
                        phase: 'import',
                        label: state.templateImporter.fullImportMessage,
                        current: completed,
                        total: total
                    };
                    render();

                    return postAjax(
                        'Wirakit_ti_import_template',
                        {
                            template_kit_id: kitId,
                            template_id: template.id,
                            import_again: '0'
                        },
                        data.templateKitNonce || data.templateImporterNonce
                    ).then(function (importResult) {
                        if (!importResult || !importResult.success) {
                            var importMessage = importResult && importResult.data && importResult.data.message
                                ? importResult.data.message
                                : ('Failed importing template: ' + String(template.name || template.id));
                            throw new Error(importMessage);
                        }
                        completed += 1;
                        state.templateImporter.fullImportProgress = {
                            phase: 'import',
                            label: 'Imported template ' + String(completed) + '/' + String(total) + '.',
                            current: completed,
                            total: total
                        };
                    });
                });
            });

            assignmentSteps.forEach(function (step, index) {
                sequence = sequence.then(function () {
                    state.templateImporter.fullImportMessage = String(index + 2) + '. ' + step.label + '...';
                    state.templateImporter.fullImportProgress = {
                        phase: 'import',
                        label: state.templateImporter.fullImportMessage,
                        current: completed,
                        total: total
                    };
                    render();

                    return postAjax(
                        'Wirakit_ti_full_process_step',
                        {
                            template_kit_id: kitId,
                            step: step.key
                        },
                        data.templateKitNonce || data.templateImporterNonce
                    ).then(function (stepResult) {
                        if (!stepResult || !stepResult.success) {
                            var stepMessage = stepResult && stepResult.data && stepResult.data.message
                                ? stepResult.data.message
                                : ('Failed on step: ' + step.label);
                            throw new Error(stepMessage);
                        }

                        completed += 1;
                        state.templateImporter.fullImportProgress = {
                            phase: 'import',
                            label: String(index + 2) + '. ' + step.label + ' done.',
                            current: completed,
                            total: total
                        };
                    });
                });
            });

            return sequence.then(function () {
                state.templateImporter.fullImportRunning = false;
                state.templateImporter.fullImportConfirmOpen = true;
                state.templateImporter.fullImportCompleted = true;
                state.templateImporter.fullImportMessage = 'Import completed successfully. All steps finished.';
                state.templateImporter.fullImportProgress = {
                    phase: 'done',
                    label: state.templateImporter.fullImportMessage,
                    current: completed,
                    total: total
                };
                var importedKitId = parseInt(kitId, 10) || 0;
                if (importedKitId) {
                    postAjax(
                        'Wirakit_ti_delete_kit',
                        { template_kit_id: importedKitId },
                        data.templateKitNonce || data.templateImporterNonce
                    ).then(function () {
                        state.templateImporter.fullImportPendingKitId = 0;
                        state.templateImporter.selectedKitId = 0;
                        state.templateImporter.kits = (state.templateImporter.kits || []).filter(function (kit) {
                            return String(kit && kit.id) !== String(importedKitId);
                        });
                        render();
                    }).catch(function () {
                        render();
                    });
                } else {
                    render();
                }
            });
        }).catch(function (error) {
            state.templateImporter.fullImportRunning = false;
            state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed to Install Template.';
            render();
        });
    }

    function openFullImportConfirmModal(inputId) {
        var input = document.getElementById(inputId || 'wkit-ti-upload-file');
        if (!input || !input.files || !input.files.length) {
            state.templateImporter.errorMessage = 'Please choose a ZIP file first.';
            render();
            return;
        }

        var file = input.files[0];
        if (!file || !/\.zip$/i.test(file.name || '')) {
            state.templateImporter.errorMessage = 'Only .zip files are allowed.';
            render();
            return;
        }

        state.templateImporter.errorMessage = '';
        state.templateImporter.fullImportPendingInputId = inputId || 'wkit-ti-upload-file';
        state.templateImporter.fullImportPendingFileName = file.name || '';
        state.templateImporter.fullImportPendingFile = file;
        state.templateImporter.fullImportConfirmOpen = true;
        state.templateImporter.fullImportCompleted = false;
        state.templateImporter.fullImportPendingFeatures = [];
        state.templateImporter.fullImportPendingWhatImport = [];
        state.templateImporter.fullImportProgress = {
            phase: 'idle',
            label: '',
            current: 0,
            total: 0
        };
        render();
    }

    function closeFullImportConfirmModal() {
        if (state.templateImporter.uploading || state.templateImporter.fullImportRunning) {
            return;
        }
        state.templateImporter.fullImportConfirmOpen = false;
        state.templateImporter.fullImportCancelConfirmOpen = false;
        state.templateImporter.fullImportPendingInputId = '';
        state.templateImporter.fullImportPendingFileName = '';
        state.templateImporter.fullImportPendingFile = null;
        state.templateImporter.fullImportPendingKitId = 0;
        state.templateImporter.fullImportPendingRemoteSlug = '';
        state.templateImporter.fullImportPendingFeatures = [];
        state.templateImporter.fullImportPendingWhatImport = [];
        state.templateImporter.fullImportAwaitingPluginStep = false;
        state.templateImporter.fullImportCompleted = false;
        state.templateImporter.installModalSelections = {};
        state.templateImporter.disableElementorDefaultColors = false;
        state.templateImporter.disableElementorDefaultFonts = false;
        state.templateImporter.fullImportProgress = {
            phase: 'idle',
            label: '',
            current: 0,
            total: 0
        };
        var input = document.getElementById('wkit-ti-upload-file');
        if (input) {
            input.value = '';
        }
        render();
    }

    function requestFullImportCancelConfirmation() {
        if (state.templateImporter.uploading || state.templateImporter.fullImportRunning) {
            return;
        }
        if (!state.templateImporter.fullImportConfirmOpen) {
            return;
        }
        state.templateImporter.fullImportCancelConfirmOpen = true;
        render();
    }

    function closeFullImportCancelConfirmation() {
        state.templateImporter.fullImportCancelConfirmOpen = false;
        render();
    }

    function confirmFullImportCancelAndCleanup() {
        if (state.templateImporter.uploading || state.templateImporter.fullImportRunning) {
            return;
        }

        var kitId = parseInt(state.templateImporter.fullImportPendingKitId || 0, 10) || 0;
        state.templateImporter.fullImportCancelConfirmOpen = false;

        if (!kitId) {
            closeFullImportConfirmModal();
            return;
        }

        state.templateImporter.actionLoadingId = 'delete-kit-' + String(kitId);
        render();

        postAjax('Wirakit_ti_delete_kit', { template_kit_id: kitId }, data.templateKitNonce || data.templateImporterNonce)
            .then(function () {
                state.templateImporter.actionLoadingId = '';
                state.templateImporter.kits = (state.templateImporter.kits || []).filter(function (kit) {
                    return String(kit && kit.id) !== String(kitId);
                });
                closeFullImportConfirmModal();
            })
            .catch(function () {
                state.templateImporter.actionLoadingId = '';
                closeFullImportConfirmModal();
            });
    }

    function loadTemplatesByKit(kitId) {
        if (!kitId) {
            return;
        }

        state.templateImporter.selectedKitId = parseInt(kitId, 10) || 0;
        state.templateImporter.templatesLoading = true;
        state.templateImporter.templatesLoaded = false;
        state.templateImporter.templatesError = '';
        state.templateImporter.templates = [];
        state.templateImporter.requiredPlugins = [];
        state.templateImporter.installModalOpen = false;
        state.templateImporter.installModalError = '';
        state.templateImporter.installModalSelections = {};
        state.templateImporter.disableElementorDefaultColors = false;
        state.templateImporter.disableElementorDefaultFonts = false;
        render();

        postAjax('Wirakit_ti_list_templates', { template_kit_id: state.templateImporter.selectedKitId }, data.templateKitNonce || data.templateImporterNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to load templates.';
                    throw new Error(message);
                }

                state.templateImporter.templatesLoading = false;
                state.templateImporter.templatesLoaded = true;
                state.templateImporter.templates = Array.isArray(result.data && result.data.templates) ? result.data.templates : [];
                state.templateImporter.requiredPlugins = Array.isArray(result.data && result.data.required_plugins) ? result.data.required_plugins : [];
                state.templateImporter.elementorSettings = (result.data && result.data.elementor_settings && typeof result.data.elementor_settings === 'object')
                    ? result.data.elementor_settings
                    : { disable_default_colors: false, disable_default_fonts: false };
                render();
            })
            .catch(function (error) {
                state.templateImporter.templatesLoading = false;
                state.templateImporter.templatesLoaded = false;
                state.templateImporter.templatesError = error && error.message ? error.message : 'Failed to load templates.';
                render();
            });
    }

    function deleteTemplateKit(kitId) {
        if (!kitId) {
            return;
        }

        if (!window.confirm('Delete this imported template kit permanently?')) {
            return;
        }

        state.templateImporter.actionLoadingId = 'delete-kit-' + String(kitId);
        state.templateImporter.errorMessage = '';
        render();

        postAjax('Wirakit_ti_delete_kit', { template_kit_id: kitId }, data.templateKitNonce || data.templateImporterNonce)
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to delete template kit.';
                    throw new Error(message);
                }

                state.templateImporter.actionLoadingId = '';
                if (String(state.templateImporter.selectedKitId) === String(kitId)) {
                    state.templateImporter.selectedKitId = 0;
            state.templateImporter.templates = [];
            state.templateImporter.requiredPlugins = [];
        }
        ensureTemplateImporterLoaded(true);
            })
            .catch(function (error) {
                state.templateImporter.actionLoadingId = '';
                state.templateImporter.errorMessage = error && error.message ? error.message : 'Failed to delete template kit.';
                render();
            });
    }

    function importTemplateFromSelectedKit(templateId, importAgain) {
        var kitId = state.templateImporter.selectedKitId;
        if (!kitId) {
            return Promise.resolve();
        }

        state.templateImporter.actionLoadingId = 'import-template-' + String(templateId);
        state.templateImporter.templatesError = '';
        render();

        return postAjax(
            'Wirakit_ti_import_template',
            {
                template_kit_id: kitId,
                template_id: templateId,
                import_again: importAgain ? '1' : '0'
            },
            data.templateKitNonce || data.templateImporterNonce
        ).then(function (result) {
            if (!result || !result.success) {
                var message = result && result.data && result.data.message ? result.data.message : 'Failed to import template.';
                throw new Error(message);
            }

            state.templateImporter.actionLoadingId = '';
            loadTemplatesByKit(kitId);
        }).catch(function (error) {
            state.templateImporter.actionLoadingId = '';
            state.templateImporter.templatesError = error && error.message ? error.message : 'Failed to import template.';
            render();
        });
    }

    function importAllTemplatesFromSelectedKit() {
        var templates = state.templateImporter.templates || [];
        var kitId = state.templateImporter.selectedKitId;
        if (!kitId || !templates.length || state.templateImporter.importingAll) {
            return;
        }

        state.templateImporter.importingAll = true;
        state.templateImporter.templatesError = '';
        render();

        var sequence = Promise.resolve();
        templates.forEach(function (template) {
            sequence = sequence.then(function () {
                return postAjax(
                    'Wirakit_ti_import_template',
                    {
                        template_kit_id: kitId,
                        template_id: template.id,
                        import_again: '0'
                    },
                    data.templateKitNonce || data.templateImporterNonce
                ).then(function (result) {
                    if (!result || !result.success) {
                        var message = result && result.data && result.data.message ? result.data.message : ('Failed to import template: ' + (template.name || template.id));
                        throw new Error(message);
                    }
                });
            });
        });

        sequence.then(function () {
            state.templateImporter.importingAll = false;
            loadTemplatesByKit(kitId);
        }).catch(function (error) {
            state.templateImporter.importingAll = false;
            state.templateImporter.templatesError = error && error.message ? error.message : 'Failed to import all templates.';
            render();
        });
    }

    function installRequiredPluginsForSelectedKit() {
        var kitId = parseInt(state.templateImporter.selectedKitId || state.templateImporter.fullImportPendingKitId || 0, 10) || 0;
        if (!kitId || state.templateImporter.installingRequiredPlugins) {
            return;
        }

        var selectedPlugins = Object.keys(state.templateImporter.installModalSelections || {}).filter(function (key) {
            return !!state.templateImporter.installModalSelections[key];
        });
        var disableColors = !!state.templateImporter.disableElementorDefaultColors;
        var disableFonts = !!state.templateImporter.disableElementorDefaultFonts;

        state.templateImporter.installingRequiredPlugins = true;
        state.templateImporter.installModalError = '';
        state.templateImporter.templatesError = '';
        render();

        postAjax(
            'Wirakit_ti_install_required_plugins',
            {
                template_kit_id: kitId,
                selected_plugins: JSON.stringify(selectedPlugins),
                disable_default_colors: disableColors ? '1' : '0',
                disable_default_fonts: disableFonts ? '1' : '0'
            },
            data.templateKitNonce || data.templateImporterNonce
        )
            .then(function (result) {
                if (!result || !result.success) {
                    var message = result && result.data && result.data.message ? result.data.message : 'Failed to refresh required plugin status.';
                    throw new Error(message);
                }

                state.templateImporter.installingRequiredPlugins = false;

                if (result.data && Array.isArray(result.data.required_plugins)) {
                    state.templateImporter.requiredPlugins = result.data.required_plugins;
                }
                state.templateImporter.elementorSettings = (result.data && result.data.elementor_settings && typeof result.data.elementor_settings === 'object')
                    ? result.data.elementor_settings
                    : state.templateImporter.elementorSettings;
                // Keep the user's checkbox preferences (default checked) instead of mirroring current option state.

                if (result.data && Array.isArray(result.data.unmet_required_plugins) && result.data.unmet_required_plugins.length) {
                    state.templateImporter.installModalError = (result.data && result.data.message) ? String(result.data.message) : 'Some required plugins are missing or inactive.';
                    render();
                    return;
                }

                state.templateImporter.installModalOpen = false;
                state.templateImporter.installModalError = '';
                state.templateImporter.installModalSelections = {};

                if (state.templateImporter.fullImportAwaitingPluginStep) {
                    refreshRequiredPluginsForKit(kitId).then(function () {
                        state.templateImporter.fullImportMessage = '2. Plugin settings applied. You can install more plugins or go to next step.';
                        state.templateImporter.fullImportProgress = {
                            phase: 'prepare',
                            label: 'Plugin step has been updated.',
                            current: 0,
                            total: 1
                        };
                        render();
                    }).catch(function (refreshError) {
                        state.templateImporter.installModalError = refreshError && refreshError.message ? refreshError.message : 'Failed to refresh plugin status.';
                        render();
                    });
                    return;
                }
                loadTemplatesByKit(kitId);
            })
            .catch(function (error) {
                state.templateImporter.installingRequiredPlugins = false;
                state.templateImporter.installModalError = error && error.message ? error.message : 'Failed to refresh required plugin status.';
                render();
            });
    }

    root.addEventListener('click', function (event) {
        var itemEl = event.target.closest('.wkit-setting-item');
        if (itemEl && !event.target.closest('input[type="checkbox"]')) {
            var itemCheckbox = itemEl.querySelector('input[type="checkbox"][data-group][data-id]');
            if (itemCheckbox) {
                itemCheckbox.checked = !itemCheckbox.checked;
                itemCheckbox.dispatchEvent(new Event('change', { bubbles: true }));
                return;
            }
        }

        var routeEl = event.target.closest('[data-route]');
        if (routeEl) {
            event.preventDefault();
            setPath(routeEl.getAttribute('data-route'));
            return;
        }

        var wiraTemplatesSetupEl = event.target.closest('[data-wkit-wira-templates-setup]');
        if (wiraTemplatesSetupEl) {
            event.preventDefault();
            installActivateWiraTemplates();
            return;
        }

        var modalToggleRow = event.target.closest('.wkit-form-row-toggle');
        if (modalToggleRow && !event.target.closest('input[type="checkbox"][data-tb-field="conditionStatus"]')) {
            event.preventDefault();
            var modalToggleInput = modalToggleRow.querySelector('input[type="checkbox"][data-tb-field="conditionStatus"]');
            if (modalToggleInput) {
                modalToggleInput.checked = !modalToggleInput.checked;
                modalToggleInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
            return;
        }

        var tabEl = event.target.closest('[data-tb-tab]');
        if (tabEl) {
            event.preventDefault();
            state.templateBuilder.activeTab = tabEl.getAttribute('data-tb-tab') || 'wkit-header';
            render();
            return;
        }

        var tiTabEl = event.target.closest('[data-ti-tab]');
        if (tiTabEl) {
            event.preventDefault();
            var requestedTiTab = getVisibleTemplateImporterTab(tiTabEl.getAttribute('data-ti-tab') || 'full-import');
            state.templateImporter.activeTab = requestedTiTab;
            state.templateImporter.errorMessage = '';
            if (state.templateImporter.activeTab !== 'full-import') {
                state.templateImporter.fullImportMessage = '';
            }
            if (state.templateImporter.activeTab === 'browse-demo') {
                ensureRemoteBrowseLoaded();
            } else if (state.templateImporter.activeTab === 'full-import') {
                ensureFullImportRemoteLoaded();
            }
            render();
            return;
        }

        var addEl = event.target.closest('[data-tb-add]');
        if (addEl) {
            event.preventDefault();
            openTemplateBuilderModal(addEl.getAttribute('data-tb-add') || state.templateBuilder.activeTab);
            return;
        }

        var editEl = event.target.closest('[data-tb-edit]');
        if (editEl) {
            event.preventDefault();
            var editType = editEl.getAttribute('data-tb-type') || state.templateBuilder.activeTab;
            var target = getTemplateBuilderItemById(editType, editEl.getAttribute('data-tb-edit'));
            if (target) {
                openTemplateBuilderModal(editType, target);
            }
            return;
        }

        var closeEl = event.target.closest('[data-tb-close]');
        if (closeEl) {
            if (event.target.classList.contains('wkit-modal-overlay') || event.target.closest('.wkit-modal-close')) {
                event.preventDefault();
                closeTemplateBuilderModal();
                return;
            }
        }

        var saveTbEl = event.target.closest('[data-tb-save]');
        if (saveTbEl) {
            event.preventDefault();
            saveTemplateBuilderItem();
            return;
        }

        var deleteTbEl = event.target.closest('[data-tb-delete]');
        if (deleteTbEl) {
            event.preventDefault();
            deleteTemplateBuilderItem();
            return;
        }

        var tiRefreshEl = event.target.closest('[data-ti-refresh-kits]');
        if (tiRefreshEl) {
            event.preventDefault();
            ensureTemplateImporterLoaded(true);
            return;
        }

        var tiBrowseRefreshEl = event.target.closest('[data-ti-browse-refresh]');
        if (tiBrowseRefreshEl) {
            event.preventDefault();
            state.templateImporter.browsePage = 1;
            ensureRemoteBrowseLoaded(true);
            return;
        }

        var tiFullBrowseRefreshEl = event.target.closest('[data-ti-full-browse-refresh]');
        if (tiFullBrowseRefreshEl) {
            event.preventDefault();
            state.templateImporter.fullImportPage = 1;
            ensureFullImportRemoteLoaded(true);
            return;
        }

        var tiPageEl = event.target.closest('[data-ti-page]');
        if (tiPageEl) {
            event.preventDefault();
            var pageKind = tiPageEl.getAttribute('data-ti-page') || '';
            var pageNumber = parseInt(tiPageEl.getAttribute('data-ti-page-number') || '1', 10) || 1;
            if (pageKind === 'browse') {
                state.templateImporter.browsePage = pageNumber;
            } else if (pageKind === 'full-import') {
                state.templateImporter.fullImportPage = pageNumber;
            }
            render();
            return;
        }

        var tiViewKitEl = event.target.closest('[data-ti-view-kit]');
        if (tiViewKitEl) {
            event.preventDefault();
            loadTemplatesByKit(tiViewKitEl.getAttribute('data-ti-view-kit'));
            return;
        }

        var tiBackListEl = event.target.closest('[data-ti-back-list]');
        if (tiBackListEl) {
            event.preventDefault();
            state.templateImporter.selectedKitId = 0;
            state.templateImporter.templates = [];
            state.templateImporter.templatesError = '';
            state.templateImporter.templatesLoaded = false;
            render();
            return;
        }

        var tiDeleteKitEl = event.target.closest('[data-ti-delete-kit]');
        if (tiDeleteKitEl) {
            event.preventDefault();
            deleteTemplateKit(tiDeleteKitEl.getAttribute('data-ti-delete-kit'));
            return;
        }

        var tiImportTemplateEl = event.target.closest('[data-ti-import-template]');
        if (tiImportTemplateEl) {
            event.preventDefault();
            importTemplateFromSelectedKit(tiImportTemplateEl.getAttribute('data-ti-import-template'), false);
            return;
        }

        var tiImportTemplateAgainEl = event.target.closest('[data-ti-import-template-again]');
        if (tiImportTemplateAgainEl) {
            event.preventDefault();
            importTemplateFromSelectedKit(tiImportTemplateAgainEl.getAttribute('data-ti-import-template-again'), true);
            return;
        }

        var tiImportAllEl = event.target.closest('[data-ti-import-all]');
        if (tiImportAllEl) {
            event.preventDefault();
            importAllTemplatesFromSelectedKit();
            return;
        }

        var tiInstallReqEl = event.target.closest('[data-ti-install-required-plugins]');
        if (tiInstallReqEl) {
            event.preventDefault();
            openInstallRequiredPluginsModal();
            return;
        }

        var tiInstallModalOverlayEl = event.target.closest('[data-ti-install-modal-overlay]');
        if (tiInstallModalOverlayEl) {
            var isBackdropClick = event.target === tiInstallModalOverlayEl;
            var isCloseControlClick = !!event.target.closest('[data-ti-install-modal-close-control]');
            if (isBackdropClick || isCloseControlClick) {
                event.preventDefault();
                closeInstallRequiredPluginsModal();
                return;
            }
        }

        var tiInstallModalSubmitEl = event.target.closest('[data-ti-install-modal-submit]');
        if (tiInstallModalSubmitEl) {
            event.preventDefault();
            installRequiredPluginsForSelectedKit();
            return;
        }

        var tiAutoInstallPluginEl = event.target.closest('[data-ti-auto-install-plugin]');
        if (tiAutoInstallPluginEl) {
            event.preventDefault();
            var pluginKey = tiAutoInstallPluginEl.getAttribute('data-ti-auto-install-plugin') || '';
            if (!pluginKey) {
                return;
            }
            if (!state.templateImporter.installModalSelections || typeof state.templateImporter.installModalSelections !== 'object') {
                state.templateImporter.installModalSelections = {};
            }
            state.templateImporter.installModalSelections[String(pluginKey)] = true;
            installRequiredPluginsForSelectedKit();
            return;
        }

        var fullCancelModalOverlayEl = event.target.closest('[data-ti-full-import-cancel-modal-overlay]');
        if (fullCancelModalOverlayEl) {
            var fullCancelBackdropClick = event.target === fullCancelModalOverlayEl;
            var fullCancelNoClick = !!event.target.closest('[data-ti-full-import-cancel-no]');
            if (fullCancelBackdropClick || fullCancelNoClick) {
                event.preventDefault();
                closeFullImportCancelConfirmation();
                return;
            }
        }

        var fullCancelYesEl = event.target.closest('[data-ti-full-import-cancel-yes]');
        if (fullCancelYesEl) {
            event.preventDefault();
            confirmFullImportCancelAndCleanup();
            return;
        }

        var tiImportRemoteEl = event.target.closest('[data-ti-import-remote]');
        if (tiImportRemoteEl) {
            event.preventDefault();
            importRemoteKitBySlug(tiImportRemoteEl.getAttribute('data-ti-import-remote'));
            return;
        }

        var tiFullImportRemoteEl = event.target.closest('[data-ti-full-import-remote]');
        if (tiFullImportRemoteEl) {
            event.preventDefault();
            importFullImportRemoteKitBySlug(
                tiFullImportRemoteEl.getAttribute('data-ti-full-import-remote'),
                tiFullImportRemoteEl.getAttribute('data-ti-full-import-name') || ''
            );
            return;
        }

        var betaModalOverlayEl = event.target.closest('[data-ti-full-import-modal-overlay]');
        if (betaModalOverlayEl) {
            var betaIsBackdropClick = event.target === betaModalOverlayEl;
            var betaIsCloseClick = !!event.target.closest('[data-ti-full-import-modal-close]');
            var betaIsCancelClick = !!event.target.closest('[data-ti-full-import-modal-cancel]');
            if (betaIsBackdropClick || betaIsCloseClick || betaIsCancelClick) {
                event.preventDefault();
                if (state.templateImporter.fullImportCompleted) {
                    closeFullImportConfirmModal();
                } else {
                    requestFullImportCancelConfirmation();
                }
                return;
            }
        }

        var fullInstallEl = event.target.closest('[data-ti-full-import-install]');
        if (fullInstallEl) {
            event.preventDefault();
            installRequiredPluginsForSelectedKit();
            return;
        }

        var fullNextStepEl = event.target.closest('[data-ti-full-import-next-step]');
        if (fullNextStepEl) {
            event.preventDefault();
            state.templateImporter.fullImportAwaitingPluginStep = false;
            state.templateImporter.fullImportPendingKitId = parseInt(state.templateImporter.selectedKitId || state.templateImporter.fullImportPendingKitId || 0, 10) || 0;
            state.templateImporter.fullImportMessage = '3. Ready to import templates.';
            state.templateImporter.fullImportProgress = {
                phase: 'prepare',
                label: 'You can start template import now.',
                current: 0,
                total: 1
            };
            render();
            return;
        }

        var fullBackStepEl = event.target.closest('[data-ti-full-import-back-step]');
        if (fullBackStepEl) {
            event.preventDefault();
            state.templateImporter.fullImportAwaitingPluginStep = true;
            state.templateImporter.fullImportMessage = '2. Required Plugins and Elementor Settings';
            state.templateImporter.fullImportProgress = {
                phase: 'prepare',
                label: 'Configure plugin and Elementor options before template import.',
                current: 0,
                total: 1
            };
            render();
            return;
        }

        var fullCloseEl = event.target.closest('[data-ti-full-import-close]');
        if (fullCloseEl) {
            event.preventDefault();
            closeFullImportConfirmModal();
            return;
        }

        var betaStartEl = event.target.closest('[data-ti-full-import-modal-start]');
        if (betaStartEl) {
            event.preventDefault();
            var hasPendingKit = !!(parseInt(state.templateImporter.fullImportPendingKitId || 0, 10) || 0);
            var hasPendingRemoteSlug = !!String(state.templateImporter.fullImportPendingRemoteSlug || '');
            if (hasPendingKit) {
                runFullImportFlow(state.templateImporter.fullImportPendingKitId);
            } else if (hasPendingRemoteSlug) {
                startFullImportRemoteDownload(String(state.templateImporter.fullImportPendingRemoteSlug));
            } else {
                state.templateImporter.errorMessage = 'Choose a Full Site Template first.';
                render();
            }
            return;
        }

        var actionEl = event.target.closest('[data-action]');
        if (!actionEl) {
            return;
        }

        event.preventDefault();
        var action = actionEl.getAttribute('data-action');
        if (action === 'enable-all') {
            setAll(true);
        } else if (action === 'disable-all') {
            setAll(false);
        } else if (action === 'save') {
            saveSettings();
        }
    });

    root.addEventListener('change', function (event) {
        var input = event.target;

        if (input.matches('#wkit-ti-upload-file')) {
            if (state.templateImporter.activeTab === 'full-import') {
                openFullImportConfirmModal('wkit-ti-upload-file');
            } else {
                uploadTemplateKitZip();
            }
            return;
        }

        if (input.matches('[data-ti-filter-browse]')) {
            state.templateImporter.browsePricingFilter = input.value || 'all';
            state.templateImporter.browsePage = 1;
            render();
            return;
        }

        if (input.matches('[data-ti-filter-full-import]')) {
            state.templateImporter.fullImportPricingFilter = input.value || 'all';
            state.templateImporter.fullImportPage = 1;
            render();
            return;
        }


        if (input.matches('input[type="checkbox"][data-master-toggle="all"]')) {
            setAll(!!input.checked);
            return;
        }

        if (input.matches('input[type="checkbox"][data-group][data-id]')) {
            var group = input.getAttribute('data-group');
            var id = input.getAttribute('data-id');
            if (!state.settings[group]) {
                state.settings[group] = {};
            }

            state.settings[group][id] = !!input.checked;

            if (group === 'modules' && id === 'starter-templates' && !input.checked) {
                state.settings.modules['advanced-template-import'] = false;
                state.settings.modules['template-importer-auto-install'] = false;
                if (state.path === 'starter-template') {
                    state.path = 'dashboard';
                    setAdminPath(state.path, true);
                }
            }
            state.errorMessage = '';
            if (state.saveState === 'saved') {
                state.saveState = 'idle';
            }
            render();
            return;
        }

        if (input.matches('[data-tb-field="title"]')) {
            state.templateBuilder.form.title = input.value || '';
            return;
        }

        if (input.matches('[data-tb-field="conditionStatus"]')) {
            state.templateBuilder.form.conditionStatus = input.checked ? 'active' : 'inactive';
            return;
        }

        if (input.matches('[data-tb-field="conditionDisplay"]')) {
            state.templateBuilder.form.conditionDisplay = input.value || 'all';
            return;
        }

        if (input.matches('[data-ti-install-plugin-toggle]')) {
            var pluginKey = input.getAttribute('data-ti-install-plugin-toggle') || '';
            if (pluginKey) {
                state.templateImporter.installModalSelections[pluginKey] = !!input.checked;
            }
            render();
            return;
        }

        if (input.matches('[data-ti-disable-default-colors]')) {
            state.templateImporter.disableElementorDefaultColors = !!input.checked;
            render();
            return;
        }

        if (input.matches('[data-ti-disable-default-fonts]')) {
            state.templateImporter.disableElementorDefaultFonts = !!input.checked;
            render();
            return;
        }
    });

    root.addEventListener('input', function (event) {
        var input = event.target;
        if (input.matches('[data-ti-search-browse]')) {
            state.templateImporter.browseSearch = input.value || '';
            state.templateImporter.browsePage = 1;
            renderWithBrowseSearchFocus();
            return;
        }
        if (input.matches('[data-ti-search-full-import]')) {
            state.templateImporter.fullImportBrowseSearch = input.value || '';
            state.templateImporter.fullImportPage = 1;
            renderWithFullImportSearchFocus();
            return;
        }
        if (input.matches('[data-tb-field="title"]')) {
            state.templateBuilder.form.title = input.value || '';
        }
    });

    document.addEventListener('click', function (event) {
        var link = event.target.closest('#adminmenu a');
        if (!link || !link.href) {
            return;
        }

        var nextPath = getPathFromHref(link.href);
        if (!nextPath) {
            return;
        }

        event.preventDefault();
        setPath(nextPath);
    });

    window.addEventListener('popstate', function () {
        var url = new URL(window.location.href);
        setPath(url.searchParams.get('path') || 'dashboard', false);
    });

    window.addEventListener('beforeunload', function (event) {
        if (!state.templateImporter.fullImportRunning) {
            return;
        }
        event.preventDefault();
        event.returnValue = 'Template import is still running. Do not reload this page.';
        return event.returnValue;
    });

    // Canonicalize URL so Template Builder always uses `path=template-builder`.
    setAdminPath(state.path, false);

        if (state.path === 'template-builder') {
            ensureTemplateBuilderLoaded();
        } else if (state.path === 'starter-template') {
            state.templateImporter.activeTab = getVisibleTemplateImporterTab(state.templateImporter.activeTab);
            if (state.templateImporter.activeTab === 'browse-demo') {
                ensureRemoteBrowseLoaded();
            } else if (state.templateImporter.activeTab === 'full-import') {
                ensureFullImportRemoteLoaded();
            }
        }

    render();
})();
