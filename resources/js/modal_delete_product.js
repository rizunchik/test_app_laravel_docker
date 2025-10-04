const modalDelete = document.getElementById('modal_delete');
if (modalDelete) {


modalDelete.addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const product_id = button.getAttribute('data-bs-product-id');
    const product_name = button.getAttribute('data-bs-product-name');


    const modalHeaderH5 = modalDelete.querySelector('.modal-header h5');
    const modalFormDelete = modalDelete.querySelector('.modal-footer form');

    modalHeaderH5.textContent = 'Видалення товару ' + product_name;
    modalFormDelete.action = `${location.origin}/products/${product_id}`;
});
}