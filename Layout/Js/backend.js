let confirmes = document.querySelectorAll(".confirme");
confirmes.forEach(confirme => {
  confirme.onclick = function () {
    return confirm("Are You Sure!!");
  };
});

//Show And Hide The Password
let membersPassField = document.querySelector(".password .password"),
  membersShowPass = document.querySelector(".password .re .pass-btn"),
  membersLabel = document.querySelector(".label");
  if(membersShowPass != null &&  membersLabel != null && (membersLabel.innerHTML == "Add Page" ||  membersLabel.innerHTML == "Edite Page")){
      membersShowPass.onclick = function () {
      if(membersPassField.classList.contains("active")){
        membersPassField.setAttribute("type","password");
        membersPassField.classList.remove("active");
      } else {
        membersPassField.setAttribute("type","text");
        membersPassField.classList.add("active");
      }
    }
  }

let loginPassFiled = document.querySelector(".login-form .password"),
  loginShowPass = document.querySelector(".login-form .pass-btn"),
  loginLabel = document.querySelector(".label");
if(loginLabel != null && loginLabel.innerHTML == "Login Forms" ){
  loginShowPass.onclick = function () {
    if(loginPassFiled.classList.contains("active")){
      loginPassFiled.setAttribute("type","password");
      loginPassFiled.classList.remove("active");
    } else {
      loginPassFiled.setAttribute("type","text");
      loginPassFiled.classList.add("active");
    }
  }
}
// Show And Hide Info In The Categories page
let title = document.querySelector("body h1.label");
if (title != null) {
  if (title.innerHTML == "Mange Page") {
    let categorie = document.querySelector(".panel .panel-body ul"),
      categories = Array.from(categorie.children);
    categories.forEach(cat => {
      cat.addEventListener("click", function () {
        cat.classList.toggle("show-info");
      });
    });
  }
}
// Show And Hide Latest Items And Users
let dashboardTitle = document.querySelector("body h1.label");
if (dashboardTitle != null) {
  if (dashboardTitle.innerHTML == "Dashboard Page") {
    var lastUsersArrow = document.querySelector(".users .panel-heading .arrow"),
      lastItemsArrow = document.querySelector(".items .panel-heading .arrow"),
      usersBox = document.querySelector(".users"),
      itemsBox = document.querySelector(".items");
    lastUsersArrow.onclick = function () {
      lastUsersArrow.classList.toggle("flip");
      usersBox.classList.toggle("closed");
    };
    lastItemsArrow.onclick = function () {
      lastItemsArrow.classList.toggle("flip");
      itemsBox.classList.toggle("closed");
    };
  }
}


