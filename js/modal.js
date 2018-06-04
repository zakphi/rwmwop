let modal = document.querySelector('.modal')
let workImg = document.querySelectorAll('.archive-work img')
let closeBtn = document.querySelector('.close-btn')

function toggleModal(){
  modal.classList.toggle('show-modal')

  let modalContent = this.parentNode

  if(!document.querySelectorAll('.modal .archive-work').length){
    modal.prepend(modalContent.cloneNode(true))
    document.querySelector('.modal .archive-work').prepend(closeBtn)
  } else {
    modal.removeChild(document.querySelector('.modal .archive-work'))
  }
}

workImg.forEach(element => element.onclick = toggleModal)
closeBtn.onclick = toggleModal