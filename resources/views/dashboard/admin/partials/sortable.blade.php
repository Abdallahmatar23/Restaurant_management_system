<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    const list = document.getElementById('sortable');
    if (list) {
        new Sortable(list, {
            handle: '.bi-grip-vertical',
            animation: 150,
            onEnd() {
                const order = [...list.querySelectorAll('tr[data-id]')].map(tr => tr.dataset.id);
                fetch(list.dataset.url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ order }),
                });
            },
        });
    }
</script>
