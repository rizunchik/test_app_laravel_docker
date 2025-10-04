document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-del');
    
    const deleteInputsEl = document.getElementById('delete-inputs');
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_images[]';
    if (!btn) {
      deleteInputsEl.appendChild(input);
      return;
    }

  
    const id = btn.getAttribute('data-image-id'); 
    console.log(id);
    if (!id) {
      alert('fdf');
      
      deleteInputsEl.appendChild(input);
      return;
    }

    const closestParent = btn.closest('.ratio');
    closestParent.remove();


    
    const existing = deleteInputsEl.querySelector(`input[name="delete_images[]"][value="${id}"]`);
    if (existing) {
      existing.remove();
    } else {
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'delete_images[]';
      input.value = id;
      deleteInputsEl.appendChild(input);
    }
  });


