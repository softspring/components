const STORAGE_KEY = 'sfs-components:admin-sidebar-collapsed';
const COLLAPSED_CLASS = 'sfs-admin-sidebar-collapsed';

function getClassTargets() {
    return [document.documentElement, document.body].filter(Boolean);
}

function setCollapsed(collapsed) {
    getClassTargets().forEach((target) => {
        target.classList.toggle(COLLAPSED_CLASS, collapsed);
    });
}

function isDesktop() {
    return window.matchMedia('(min-width: 992px)').matches;
}

function readStoredState() {
    try {
        return window.localStorage.getItem(STORAGE_KEY) === '1';
    } catch (error) {
        return false;
    }
}

function writeStoredState(collapsed) {
    try {
        window.localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
    } catch (error) {
    }
}

function syncState() {
    if (!isDesktop()) {
        setCollapsed(false);
        return;
    }

    setCollapsed(readStoredState());
}

function handleToggle() {
    if (!isDesktop()) {
        return;
    }

    const collapsed = !document.documentElement.classList.contains(COLLAPSED_CLASS);
    setCollapsed(collapsed);
    writeStoredState(collapsed);
}

syncState();

function initSidebarToggles() {
    if (window.sfsAdminSidebarInitialized) {
        syncState();
        return;
    }

    window.sfsAdminSidebarInitialized = true;

    document.querySelectorAll('[data-sfs-admin-sidebar-toggle="desktop"]').forEach((button) => {
        if (button.dataset.sfsAdminSidebarBound === '1') {
            return;
        }

        button.dataset.sfsAdminSidebarBound = '1';
        button.addEventListener('click', handleToggle);
    });

    syncState();
    window.addEventListener('resize', syncState, { passive: true });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSidebarToggles, { once: true });
} else {
    initSidebarToggles();
}

document.addEventListener('click', function (event) {
    if (!event.target || !(event.target instanceof Element)) {
        return;
    }

    if (event.target.closest('a')) {
        return;
    }

    const row = event.target.closest('tr[data-row-href]');

    if (!row) {
        return;
    }

    const href = row.dataset.rowHref;

    if (!href) {
        return;
    }

    window.location.href = href;
});
