document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('detailModal');
    const closeDetailModalBtn = document.getElementById('closeDetailModalBtn');
    const ordersList = document.getElementById('ordersList').querySelectorAll('div');

    ordersList.forEach((order) => {
        order.addEventListener('click', () => {
            const spans = order.querySelectorAll('span');
            let values = [];
            spans.forEach(ell => {
                values.push(ell.dataset.order);
            })

            detailModal.querySelector('h2').textContent = `Заказ №${values[0]} подробно`;
            detailModal.querySelector('input[name="name"]').value = values[1];
            detailModal.querySelector('textarea[name="description"]').value = values[2];
            detailModal.querySelector('input[name="delivery_date"]').value = new Date(values[3]).toLocaleDateString('en-CA');
            detailModal.querySelector('select[name="status"]').value = values[4];

            detailModal.querySelector('input[name="update_order_id"]').value = values[0];
            detailModal.querySelector('input[name="delete_order_id"]').value = values[0];

            detailModal.classList.add('flex');
            detailModal.classList.remove('hidden');
        });
    });

    closeDetailModalBtn.addEventListener('click', () => {
        detailModal.classList.add('hidden');
        detailModal.classList.remove('flex');
    });
});
