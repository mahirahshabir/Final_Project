fetch('/get-users')
    .then(response => response.json())
    .then(users => {
        let select = document.getElementById('assignee-select');
        select.innerHTML = '<option value="">Unassigned</option>'; 
        users.forEach(user => {
            let option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;
            select.appendChild(option);
        });
    });
