let confirmes = document.querySelectorAll(".confirme");
confirmes.forEach(confirme => {
  confirme.onclick = function () {
    return confirm("Are You Sure!!");
  };
});
// Show And Hide The Password
// Fileds
let membersPassField = document.querySelector("input.password"),
  membersShowPass = document.querySelector(".password .re .pass-btn");
let loginPassFiled = document.querySelector("input.password"),
  loginShowPass = document.querySelector("span.pass-btn");
//Function
  function showpass (field,btn) {
    if(field.classList.contains("active")){
      field.setAttribute("type","password");
      field.classList.remove("active");
      btn.classList.remove("active");
    } else {
      field.setAttribute("type","text");
      field.classList.add("active");
      btn.classList.add("active");
    }
  }
// Add The Function To The Btn
if(membersShowPass != null){
  membersShowPass.onclick = function () {
      showpass(membersPassField,membersShowPass);
    }
  }
if(loginShowPass != null){
  loginShowPass.onclick = function () {
    showpass(loginPassFiled,loginShowPass);
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
var lastUsersArrow = document.querySelector(".users .panel-heading .arrow"),
      lastItemsArrow = document.querySelector(".items .panel-heading .arrow"),
      usersBox = document.querySelector(".users"),
      itemsBox = document.querySelector(".items");
function showLatest(panel,btn) {
  btn.classList.toggle("flip");
  panel.classList.toggle("closed");
}
if(lastUsersArrow != null){
  lastUsersArrow.onclick = function (){
    showLatest(usersBox,lastUsersArrow);
  }
}
if(lastItemsArrow != null){
  lastItemsArrow.onclick = function (){
    showLatest(itemsBox,lastItemsArrow);
  }
}

