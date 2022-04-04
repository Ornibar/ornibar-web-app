const deleteActionBtns = document.querySelectorAll('#delete_form_btn');
const confirmModal = document.querySelector('#confirm_modal');

const closeElements = document.querySelectorAll('#close_confirm_modal, #confirm_modal');

if(deleteActionBtns){
    deleteActionBtns.forEach(deleteActionBtn => {
        deleteActionBtn.addEventListener('click', () => {
            let action = deleteActionBtn.getAttribute('data-attr');
            let form = confirmModal.querySelector("#form_confirm_modal");
            form.action = action;
            confirmModal.style.display = "block";
        })
    })

    closeElements.forEach(el => {
        el.addEventListener('click', () => {
            confirmModal.style.display = "none";
        })
    })
}