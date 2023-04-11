// This file is to make chat area dynamic
const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendBtn = form.querySelector("button");
const chatBox = document.querySelector(".chat-box");

form.onsubmit = (e) => {
    e.preventDefault();     //preventing form from submitting
}

sendBtn.onclick = () => {
    // start AJAX
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("POST", "php/insert-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                inputField.value = "";  // once message inserted into database then leave blank the input field
                srcollToBottom();
            }
        }
    }
    // we have to send the form data through ajax to php
    let formData = new FormData(form);  // create new formData object
    
    xhr.send(formData); // sending the form data to php
}

// This function is to stop the scrolling function when user try to scroll up
chatBox.onmouseenter = () => {
    chatBox.onwheel = () => {
        chatBox.classList.add("active");
    }  
}

chatBox.onmouseleave = () => {
    chatBox.classList.remove("active");
}

setInterval( () => {
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("POST", "php/get-chat.php", true);     // using GET because need to receive data not to send
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                chatBox.innerHTML = data;
                // If active class -> scroll automatically
                if (!chatBox.classList.contains("active")) {
                    srcollToBottom();
                }
            }
        }
    }
    // we have to send the form data through ajax to php
    let formData = new FormData(form);  // create new formData object

    xhr.send(formData); // sending the form data to php
} , 500);   //this function will run frequently after 500ms

// Scroll chat automatically
function srcollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}