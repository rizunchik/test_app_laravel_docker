const modelDelete = document.getElementById('modal_delete');
modelDelete.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const product_id = button.getAttribute('data-bs-product-id');
    const product_name = button.getAttribute('data-bs-product-name');


    const modalHeaderH5 = modelDelete.querySelector('.modal-header h5');
    const modalFormDelete = modelDelete.querySelector('.modal-footer form');

    modalHeaderH5.textContent = 'Видалення товару ' + product_name;
    modalFormDelete.action = `${location.origin}/products/${product_id}`;
});