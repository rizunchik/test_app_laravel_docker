document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-del');
    if (!btn) return;
  
  //   const tile = btn.closest('[data-id]');
  //   const id = tile?.dataset?.id || btn.dataset.id; // для головного фото
    const id = btn.getAttribute('data-image-id'); 
    console.log(id);
    if (!id) return;

    const closestParent = btn.closest('.ratio');
    closestParent.remove();


    const holder = document.getElementById('delete-inputs');
    const existing = holder.querySelector(`input[name="delete_images[]"][value="${id}"]`);
    if (existing) {
      existing.remove();
    } else {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'delete_images[]';
      input.value = id;
      holder.appendChild(input);
    }
  });