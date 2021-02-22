var openModalLinks = document.getElementsByClassName("open-modal");
var closeModalLinks = document.getElementsByClassName("form-modal-close");
var overlay = document.getElementsByClassName("overlay")[0];

for (var i = 0; i < openModalLinks.length; i++) {
  var modalLink = openModalLinks[i];

  modalLink.addEventListener("click", function (event) {
    var modalId = event.currentTarget.getAttribute("data-for");

    var modal = document.getElementById(modalId);
    modal.setAttribute("style", "display: block");
    overlay.setAttribute("style", "display: block");

  });
}

function closeModal(event) {
  var modal = event.currentTarget.parentElement;

  modal.removeAttribute("style");
  overlay.removeAttribute("style");
}

for (var j = 0; j < closeModalLinks.length; j++) {
  var closeModalLink = closeModalLinks[j];

  closeModalLink.addEventListener("click", closeModal)
}

var closeButton = document.getElementById('close-modal');
if (closeButton) {
  closeButton.addEventListener("click", closeModal);
}
var starRating = document.getElementsByClassName("completion-form-star");

if (starRating.length) {
  starRating = starRating[0];

  starRating.addEventListener("click", function (event) {
    var stars = event.currentTarget.childNodes;
    var rating = 0;

    for (var i = 0; i < stars.length; i++) {
      var element = stars[i];

      if (element.nodeName === "SPAN") {
        element.className = "";
        rating++;
      }

      if (element === event.target) {
        break;
      }
    }

    var inputField = document.getElementById("rating");
    inputField.value = rating;
  });
}

const lightbulb = document.getElementsByClassName('header__lightbulb')[0];
const lightbulbPopUp = document.querySelector("#js-lightbulb__pop-up-tasks");
const fragment = document.getElementById("lightbulb-template");

lightbulb.addEventListener('mouseover', function () {
  fetch('/events/index')
    .then(res => res.json())
    .then(res => {
      const info = res.info;
      const tasks = res.tasks;
      lightbulbPopUp.innerHTML = "";
      for (let i = 0; i < info.length; i++) {
        const item = info[i];
        const task = tasks.find(el => el.id === item.task_id)
        const instance = document.importNode(fragment.content, true);
        instance.querySelector('span').innerHTML = item.message;
        instance.querySelector('.link-regular').innerHTML = ` «${task.name}»`;
        instance.querySelector('.link-regular').setAttribute("href", `/tasks/${item.task_id}`);
        instance.querySelector('.lightbulb__new-task').classList.add(`lightbulb__new-task--${item.category}`);
        lightbulbPopUp.appendChild(instance);
      }
    })
});
