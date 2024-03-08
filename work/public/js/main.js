'use strict';

{
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');  
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            checkbox.parentNode.submit();
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
}
