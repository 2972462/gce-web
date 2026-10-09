import Sortable from 'sortablejs';

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]').content;
}

function enviarOrden(url, ids) {
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken(),
            Accept: 'application/json',
        },
        body: JSON.stringify({ orden: ids }),
    }).catch(() => window.location.reload());
}

function initSortables() {
    document.querySelectorAll('[data-sortable]').forEach((contenedor) => {
        if (contenedor.dataset.sortableInit) {
            return;
        }
        contenedor.dataset.sortableInit = '1';

        Sortable.create(contenedor, {
            handle: '.drag-handle',
            animation: 150,
            forceFallback: true,
            fallbackTolerance: 3,
            onEnd() {
                const ids = Array.from(contenedor.children).map((el) => el.dataset.id);
                enviarOrden(contenedor.dataset.sortable, ids);
            },
        });
    });
}

initSortables();
