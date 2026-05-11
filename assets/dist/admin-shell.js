const STORAGE_KEY = 'sfs-components:admin-sidebar-collapsed';
const COLLAPSED_CLASS = 'sfs-admin-sidebar-collapsed';

function setCollapsed(collapsed) {
    document.body.classList.toggle(COLLAPSED_CLASS, collapsed);
}

function isDesktop() {
    return window.matchMedia('(min-width: 992px)').matches;
}

function readStoredState() {
    return window.localStorage.getItem(STORAGE_KEY) === '1';
}

function writeStoredState(collapsed) {
    window.localStorage.setItem(STORAGE_KEY, collapsed ? '1' : '0');
}

function syncState() {
    if (!isDesktop()) {
        document.body.classList.remove(COLLAPSED_CLASS);
        return;
    }

    setCollapsed(readStoredState());
}

function handleToggle() {
    if (!isDesktop()) {
        return;
    }

    const collapsed = !document.body.classList.contains(COLLAPSED_CLASS);
    setCollapsed(collapsed);
    writeStoredState(collapsed);
}

function initSidebarToggles() {
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
