// This file is using AJAX for sending Signup Form from details in index.php

const form = document.querySelector(".signup form");
const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error-txt");

form.onsubmit = (e) => {
    e.preventDefault();     //preventing form from submitting
}

continueBtn.onclick = () => {
    //console.log("test");
    // start AJAX
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("POST", "php/signup.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                //console.log(data);
                if (data === "Success") {
                    window.location.href = "users.php";
                }
                else {
                    errorText.style.display = "block"; 
                    errorText.textContent = data;
                }
            }
        }
    }
    // we have to send the form data through ajax to php
    let formData = new FormData(form);  // create new formData object
    
    xhr.send(formData); // sending the form data to php
}
