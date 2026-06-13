
        const viewState = document.getElementById('profile-view-state');
        const editForm = document.getElementById('profile-edit-form');
        const editBtn = document.getElementById('edit-profile-btn');
        const cancelBtn = document.getElementById('cancel-edit-btn');

        editBtn.addEventListener('click', () => {
            viewState.style.display = 'none';
            editForm.style.display = 'block';
        });

        cancelBtn.addEventListener('click', () => {
            editForm.style.display = 'none';
            viewState.style.display = 'block';
        });
