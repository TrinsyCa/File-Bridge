let protocol = window.location.protocol === "https:" ? "https://" : "http://";
let host = window.location.host;
let baseUrl = protocol + host + "/";

const dropArea = document.querySelector(".uploadBox");
const uploadInput = document.getElementById("uploadInput");
const hrefSection = document.querySelector(".href-section");
const hrefBox = hrefSection.querySelector(".hrefBox");
const hrefURL = hrefBox.querySelector("p");

dropArea.addEventListener("dragover", function(e) {
    e.preventDefault();
    dropArea.classList.add("hover");
});
dropArea.addEventListener("drop", function(e) {
    e.preventDefault();
    uploadInput.files = e.dataTransfer.files;
    dropArea.classList.remove("hover");
    UploadFileToServer();
});
uploadInput.addEventListener("change", function() {
    UploadFileToServer();
});

function UploadFileToServer() {
    const file = uploadInput.files[0];
    if (!file) {
        console.error("Dosya seçilmedi.");
        return;
    }
    const formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: 'asset/php/upload.php',
        type: 'POST',
        data: formData,
        processData: false, 
        contentType: false, 
        success: function(response) {
            if(response) {
                hrefSection.classList.add("active");
                hrefURL.innerText = response;

                navigator.clipboard.writeText(baseUrl + response);
            }
        },
        error: function(xhr, status, error) {
            console.error("Ajax hatası: " + status + " - " + error);
        }
    });
}


// Copy Href
hrefBox.addEventListener("click", function() {
    if(hrefSection.classList.contains("active")) {
        const textToCopy = hrefBox.innerText;
        
        navigator.clipboard.writeText(textToCopy)
        .then(() => {
            hrefSection.classList.remove("active");
        });
    }
});