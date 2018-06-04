let modal = document.getElementById('modal')

function showModal(){
  let modalContent = this.parentNode

  if(!document.querySelectorAll('#modal .archive-work').length){
    modal.style.visibility = 'visible'
    modal.appendChild(modalContent.cloneNode(true))
  }
}

let workImg = document.querySelectorAll('.archive-work img')
workImg.forEach(element => element.onclick = showModal)

function hideModal(){
  modal.style.visibility = 'hidden'
  modal.removeChild(document.querySelector('#modal .archive-work'))
}

let closeBtn = document.getElementById('close-btn')
closeBtn.onclick = hideModal