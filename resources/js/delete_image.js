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



// document.addEventListener('click', function (e) {
//   const btn = e.target.closest('.js-del');
//   if (!btn) return;                          // слухаємо тільки .js-del

//   // дістаємо id картинки
//   const id = btn.dataset.imageId || btn.getAttribute('data-image-id');
//   if (!id) return;                           // нічого робити без id

//   // контейнер для hidden-полів delete_images[]
//   let holder = document.getElementById('delete-inputs');
//   if (!holder) {
//     holder = document.createElement('div');
//     holder.id = 'delete-inputs';
//     (document.querySelector('form') || document.body).appendChild(holder);
//   }

//   // прибрати прев’юшку з інтерфейсу
//   btn.closest('.ratio')?.remove();

//   // додати/зняти hidden input з id на видалення
//   const selector = `input[name="delete_images[]"][value="${id}"]`;
//   const existing = holder.querySelector(selector);
//   if (existing) {
//     existing.remove();
//   } else {
//     const input = document.createElement('input');
//     input.type = 'hidden';
//     input.name = 'delete_images[]';
//     input.value = id;
//     holder.appendChild(input);
//   }

//   e.preventDefault();
//   e.stopPropagation();
// });