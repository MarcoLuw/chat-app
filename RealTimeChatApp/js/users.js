const searchBar = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"), usersList = document.querySelector(".users .users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";       // Sau khi ket thuc thi dua search bar ve lai rong
}

// Handle with dynamic search bar
searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;

    if (searchTerm != "") {
        searchBar.classList.add("active");
    }
    else {
        searchBar.classList.remove("active");
    }

    // Start Ajax
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("POST", "php/search.php", true);     // using GET because need to receive data not to send
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                usersList.innerHTML = data;
                //console.log(data);
            }
        }
    }
    // Sending user search term to php file with ajax
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);
}

setInterval( () => {
    let xhr = new XMLHttpRequest(); //creating XML object
    xhr.open("GET", "php/users.php", true);     // using GET because need to receive data not to send
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                if (!searchBar.classList.contains("active")) {
                     usersList.innerHTML = data;
                }
            }
        }
    }
    xhr.send();  
} , 500);   //this function will run frequently after 500ms