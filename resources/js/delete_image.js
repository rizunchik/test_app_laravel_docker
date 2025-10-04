document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-del');
    const deleteInputsEl = document.getElementById('delete-inputs');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.value = 0;
    input.name = 'delete_images[]';
    if (!btn) {
      deleteInputsEl.appendChild(input);
      return;
    }

    const id = btn.getAttribute('data-image-id'); 
    if (!id) {
      deleteInputsEl.appendChild(input);
      return;
    }

    const closestParent = btn.closest('.ratio');
    closestParent.remove();

    const inputDeleteImagesEl = deleteInputsEl.querySelector(`input[name="delete_images[]"][value="${id}"]`);
    if (inputDeleteImagesEl) {
      inputDeleteImagesEl.remove();
    } else {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'delete_images[]';
      input.value = id;
      deleteInputsEl.appendChild(input);
    }
  });


