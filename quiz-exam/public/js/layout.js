const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      searchBtn = body.querySelector(".search-box");

sidebar.addEventListener("mouseenter" , () =>{
    sidebar.classList.toggle("close");
});
sidebar.addEventListener("mouseleave" , () =>{
    sidebar.classList.toggle("close");
});


searchBtn.addEventListener("click" , () =>{
    sidebar.classList.remove("close");
});

const btnPopup = document.querySelector('.btnLogin-popup');

btnPopup.addEventListener("click", () => {
    window.location.href = "/login";
});

// const wrapper = document.querySelector('.wrapper');
// const loginLink = document.querySelector('.login-link');
// const registerLink = document.querySelector('.register-link');



// registerLink.addEventListener('click', ()=> {
//     wrapper.classList.add('active');
// });

// loginLink.addEventListener('click', ()=> {
//     wrapper.classList.remove('active');
// });

// btnPopup.addEventListener('click', ()=> {
//     wrapper.classList.toggle('active-popup');
// });