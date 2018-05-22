function showModal(){
  let modal = document.getElementById('modal')
  let modalContent = this.parentNode

  modal.style.visibility = 'visible'
  modal.appendChild(modalContent.cloneNode(true))
}

let workImg = document.querySelectorAll('.archive .work img')
workImg.forEach(element => element.onclick = showModal)