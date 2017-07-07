(function() {
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        context = canvas.getContext('2d'),
        photo = document.getElementById('photo'),
        vendorUrl = window.URL || window.webkitURL;
    navigator.getMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.
            mozGetUserMedia || navigator.msGetUserMedia;
    navigator.getMedia({
        video: true,
        audio: false
    }, function(stream) {
        video.src = vendorUrl.createObjectURL(stream);
        video.play();
    }, function(error) {
        alert('Ошибка! Что-то пошло не так, попробуйте позже.');
    });
    document.getElementById('capture').addEventListener('click', function() {
        context.drawImage(video, 0, 0, 400, 300);
        photo.setAttribute('src', canvas.toDataURL('image/png'));
    });
})();

var korona = document.getElementById('korona');
var ramka = document.getElementById('ramka');
var btn = document.getElementById('capture');


korona.onclick = function () {

    var src = korona.src;
    var ph = document.getElementById('ph');
    ph.src = src;
    ph.style.width = "150px";
    ph.style.height = "140px";
    ph.style.left = "47%";
    btn.style.display = "block"

};

ramka.onclick = function () {
    var src = ramka.src;
    var ph = document.getElementById('ph');
    ph.src = src;
    ph.style.width = "150px";
    ph.style.height = "140px";
    ph.style.left = "47%";
    btn.style.display = "block"
};

var save = document.getElementById("save");
var cancel = document.getElementById("cancel");
btn.onclick = function () {
    save.style.display = "inline-block";
    cancel.style.display = "inline-block";

    var photo = document.getElementById('for_photo');
    var ph = document.getElementById('ph');
    var src = ph.src;
    photo.src = src;
    photo.style.width = "150px";
    photo.style.height = "140px";
    photo.style.left = "47%";
    photo.style.display = "block";

}



save.onclick = function () {
    console.log("Save");
    var capture = document.getElementById('capture');

    var a = document.getElementById('photo');
    var src = a.src;
    var xmlhttp = new XMLHttpRequest();
    var ph = document.getElementById('ph');
    var srcph = ph.src;
    var nn = srcph.split("mvc_camagru");
    srcph = nn[1];

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {

        }
    };
    xmlhttp.open("POST", "/mvc_camagru/config/get_img.php", true);

    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.send('photo=' + src + '&src1=' + srcph);

    photo.src = "https://hi-tech.imgsmail.ru/hitech_img/deee7bf59fae6aae0679b6eb6e79191a/c/640x-/i/44/5e/fdd2cba60760b3c5468079882605.jpg";
    save.style.display = "none";
    cancel.style.display = "none";
    var p = document.getElementById("for_photo");
    p.style.display = "none";
};


cancel.onclick = function () {
    var photo = document.getElementById('photo');
    photo.src = "https://hi-tech.imgsmail.ru/hitech_img/deee7bf59fae6aae0679b6eb6e79191a/c/640x-/i/44/5e/fdd2cba60760b3c5468079882605.jpg";
    save.style.display = "none";
    cancel.style.display = "none";
    var p = document.getElementById("for_photo");
    p.style.display = "none";
};
