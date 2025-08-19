document.addEventListener('DOMContentLoaded', function () {
    const createModal = document.getElementById('createModal');
    const openCreateModalBtn = document.getElementById('openCreateModalBtn');
    const closeCreateModalBtn = document.getElementById('closeCreateModalBtn');

    openCreateModalBtn.addEventListener('click', function () {
        createModal.classList.add('flex');
        createModal.classList.remove('hidden');
    });

    closeCreateModalBtn.addEventListener('click', function () {
        createModal.classList.add('hidden');
        createModal.classList.remove('flex');
    });
});
