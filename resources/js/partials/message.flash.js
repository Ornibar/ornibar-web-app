window.setMessageFlash = function(message, type = 'success', fix = false, timeout = 3000) {
    let msgFlash = document.querySelector('#message-flash')
    msgFlash.style.display = "grid"
    let messageFlashClose = document.querySelectorAll(".message-flash-close, .background-close")
    msgFlash.classList.add('open')
    msgFlash.setAttribute(type, '')
    msgFlash.querySelector('.message-flash--content').textContent = message 
    if (!fix) {
        setTimeout(() => {
            msgFlash.classList.remove('open')
            // location.reload();
        }, timeout);
    }

    messageFlashClose.forEach(el => {
        el.addEventListener('click', () => {
        msgFlash.style.visibility = "hidden";
        })
    })
}
