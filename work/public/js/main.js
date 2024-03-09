'use strict';

{
    const token = document.querySelector('main').dataset.token;
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');  
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            fetch('?action=toggle', { 
                method: 'POST',
                body: new URLSearchParams({
                    id: checkbox.dataset.id,   
                    token: token, 
                })
            });
        });
    });

    const deletes = document.querySelectorAll('.delete');  
    deletes.forEach(span => {
        span.addEventListener('click', () => {
            if (!confirm('Are you sure?')) { 
                return ;
            }
            fetch('?action=delete', { 
                method: 'POST',
                body: new URLSearchParams({
                    id: span.dataset.id,   
                    token: token, 
                })
            });
            span.parentNode.remove();
        });
    });

    const purge = document.querySelector('.purge');  
    purge.addEventListener('click', () => {
        if (!confirm('Are you sure?')) { 
            return ;
        }
        fetch('?action=purge', { 
            method: 'POST',
            body: new URLSearchParams({
                token: token, 
            })
        });

        const lis = document.querySelectorAll('li'); 
        lis.forEach(li => {
            if (li.children[0].checked) {
                li.remove(); 
            } 
        });
    });
}
