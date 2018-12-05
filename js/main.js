// Global Vars
let width = 500,
    height = 0,
    filter = 'none',
    streaming = false;

// DOM Elements
var video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
var streamObject;
const photoButton = document.getElementById('photo-button');
const cameraButton = document.getElementById('camera_on');
const clearButton = document.getElementById('clear-button');
const photoFilter = document.getElementById('photo-filter');
const addtogalleryButton = document.getElementById('addtogallery-button');
//attempt to add the pngs
const photoSuper = document.getElementById('super');

// Get media stream


cameraButton.onclick = function(){
    video.style.display = "none";
    video = document.getElementById('video');
    video.srcObject  = streamObject;
    video.style.display = "block";
};
navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
        // Link to the video source
        video.srcObject = stream;
        streamObject = stream;
        // Play video
        video.play();
    })
    .catch(function(err) {
        console.log(`Error: ${err}`);
    });

// Play when ready
video.addEventListener('canplay', function(e) {
    if(!streaming) {
        // Set video / canvas height
        height = video.videoHeight / (video.videoWidth / width);

        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);

        streaming = true;
    }
}, false);

// Photo button event
photoButton.addEventListener('click', function(e) {
    takePicture();

    e.preventDefault();
}, false);

// Filter event
photoFilter.addEventListener('change', function(e) {
    // Set filter to chosen option
    filter = e.target.value;
    // Set filter to video
    video.style.filter = filter;

    e.preventDefault();
});

/*
//Camera button event
cameraButton.addEventListener('click', function(e) {
    takePicture();

    e.preventDefault();
}, false); */

// Clear event
clearButton.addEventListener('click', function(e) {
    // Clear photos
    photos.innerHTML = '';
    // Change filter back to none
    filter = 'none';
    // Set video filter
    if(video.isEqualNode(document.querySelector("#video")))
    video.style.filter = filter;
    // Reset select list
    photoFilter.selectedIndex = 0;
});


// Noelle upload logic
addtogalleryButton.addEventListener('click', function(e){

    var items = document.querySelectorAll(".upload_item");
    e.preventDefault();
    var ajax = new XMLHttpRequest();
    var formdata = new FormData();
    window.alert(items.length);
    for (var x = 0; x < items.length; x++)
    {
        var all_images = Array();

        all_images.push(items[x].querySelector(".base_image").src);
        var overs = items[x].querySelectorAll('.over_image');
        for (var  j = 0; j < overs.length; j++)
            all_images.push(overs[j].src);
        
        var to_append = JSON.stringify(all_images);
        formdata.append("images", to_append);
        //ajax.addEventListener("load", function(event) { uploadcomplete(event);}, false);
        ajax.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                all_images = Array ();
                formdata =  new FormData();
               
                //return this.responseText;
            }
            console.log(this.responseText);
        }
        ajax.open("POST", "./upload.php", true);
        ajax.send(formdata);
    }
});

// Take picture from canvas
function takePicture() {
    // Create canvas
    const context = canvas.getContext('2d');
    console.log(context);
    allOverlays = document.querySelectorAll(".final_overlay");
    if(width && height){
        // set canvas props
        canvas.width = width;
        canvas.height = height;
        // Draw an image of the video on the canvas
        var capture_div = document.createElement("div");
        video.style.filter = filter;
        context.drawImage(video, 0, 0, width, height);
        var tmp_canvas = document.createElement("canvas");
        var tmp_image;
        var output = document.createElement("img");
        tmp_canvas.width = width;
        tmp_canvas.height = height;
        tmp_canvas.getContext("2d").drawImage(video, 0, 0, width , height);
        tmp_image = tmp_canvas.toDataURL('image/png');
        output.setAttribute("src", tmp_image);
        //tmp_image.style.filter = filter;
        capture_div.appendChild(output);
        output.style.display = "none";
        output.setAttribute("class", "base_image");
        // Draw an image of the overlays on the canvas
        for (var x = 0; x < allOverlays.length; x++)
        {

            var tmp_canvas = document.createElement("canvas");
            var tmp_image;
            var output = document.createElement("img");

            tmp_canvas.width = width;
            tmp_canvas.height = height;
            tmp_canvas.getContext("2d").drawImage(allOverlays[x], width / 2, height / 2, width / 2, height / 2);
            tmp_image = tmp_canvas.toDataURL('image/png');
            output.setAttribute("src", tmp_image);
            output.style.display = "none";
            capture_div.appendChild(output);
            context.drawImage(allOverlays[x], width / 2, height / 2, width / 2, height / 2);
            output.setAttribute("class", "over_image");


        }
        // Create image from the canvas
        const imgUrl = canvas.toDataURL('image/png');

        // Create img element
        const img = document.createElement('img');

        // Set img src
        img.setAttribute('src', imgUrl);

        // Set image filter
        img.style.filter = filter;
        capture_div.appendChild(img);
        // Add image to photos
        photos.insertBefore(capture_div, photos.firstChild);
        //capture_div.setAttribute("id", "fullPhoto"+photos.childElementCount);
        capture_div.setAttribute("class", "upload_item");
    }
}

var reader = new FileReader();
document.querySelector("input[type=file]").addEventListener("change", function()
{
    var filelist = this.files;
    if(filelist.length > 0)
    {
        //video.hide();
        video.style.display = "none";
        video = document.querySelector("#preview_img");
        reader.readAsDataURL(filelist[0]);

        //video.setAttribute("src", reader.result);
        reader.addEventListener("load", function() {
            video.src = reader.result;
        }, false);
        video.src = reader.result;
        video.style.display = "block";
    }
});

var count = 0;
var img1 = "";
var img2 = "";

function overlay(image) {

if (image == img1) {
    document.getElementById("imgid").src="";
    img1 = "";
}
else if (image == img2) {
    document.getElementById("img2id").src="";
    img2 = "";
    }
    else if (img1 == "") {
    img1 = image;
    document.getElementById("imgid").src=img1;
    count+= 1;
    }
    else if (img2 == "" && count > 0) {
    img2 = image;
    document.getElementById("img2id").src=img2;
}
}