'use strict';

{
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');  
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            fetch('?action = toggle',{
                method: 'POST',
                body : new URLSearchParams({
                    id: checkbox.dataset.id,   
                    token: checkbox.dataset.token, 
                })
            });
        });
    });


    const deletes = document.querySelectorAll('.delete');  
    deletes.forEach(span => {
        span.addEventListener('click', () => {
            if(!confirm('Are you sure ?')){
                return ;
            }
            fetch('?action = delete',{
                method: 'POST',
                body : new URLSearchParams({
                    id: span.dataset.id,   
                    token: span.dataset.token, 
                })
            });
            span.parentNode.remove();

        });
    });

    const purge = document.querySelector('.purge');  
    purge.addEventListener('click', () => {
        if(!confirm('Are you sure you want to delete?')){
            return ;
        }
        purge.parentNode.submit();
    });



}
