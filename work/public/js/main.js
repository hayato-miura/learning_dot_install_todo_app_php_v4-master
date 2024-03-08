'use strict';

{
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');  
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            fetch('?action = toggle',{
                method: 'POST',
                body : new URLSearchParams({
                    id: 'checkbox.dataset.id',   
                    token: 'checkbox.dataset.token', 
                })
            });
            checkbox.nextElementSibling.classList.toggle('done');
        });
    });


    const deletes = document.querySelectorAll('.delete');  
    deletes.forEach(span => {
        span.addEventListener('click', () => {
            if(!confirm('Are you sure you want to delete?')){
                return ;
            }
            span.parentNode.submit();
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
