

function showImg(elem)
{

    //var photo_href = document.getElementById("modal_photo");
    var images = document.getElementById("images");
    var modal = document.createElement('div');
    var modal_form = document.createElement('div');
    var img = document.createElement('img');
    var like = document.createElement('label');
    var text = document.createElement('textarea');
    var btn_send = document.createElement('button');

    text.name = "text";
    text.cols = "60";
    text.rows = "4";
    text.placeholder = "Your comment...";

    btn_send.title = "Submit";
    btn_send.id = "comment_btn";
    btn_send.innerHTML = "Send";


    var icon = document.createElement('i');
    icon.className = "fa fa-thumbs-o-up";
    icon.setAttribute("aria-hidden", "true");

    like.appendChild(icon);

    img.src = elem.src;

    btn_send.onclick = function ()
    {
        var xml = new XMLHttpRequest();

        var src = img.src.substr(49);
        var comment = text.value;



        xml.open("POST", 'comment');
        xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xml.send("comment=" + comment + "&photo_src=" + src);


    };

    modal_form.className = "modal_form_gallery";

    modal_form.appendChild(img);
    modal_form.appendChild(like);
    modal_form.appendChild(text);
    modal_form.appendChild(btn_send);

    modal.className = "modal_gallery";
    modal.appendChild(modal_form);
    document.body.appendChild(modal);

    modal.style.display = "block";



    function get_likes()
    {
        var xml = new XMLHttpRequest();

        var src = img.src.substr(49);

        xml.open("POST", 'for_likes');
        xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xml.send("photo=" + src);

        xml.onreadystatechange = function () {
            if (xml.readyState == 4 && xml.status == 200) {
                var result = xml.responseText;
                var likes = document.createElement('strong');
                result = " " + result;
                likes.innerHTML = result;
                like.appendChild(likes);
            }
        }
    }

    get_likes();

    like.addEventListener('click', function()
    {

        var xml = new XMLHttpRequest();
        var src = img.src.substr(49);


        xml.open("POST", 'photo_like', true);

        xml.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xml.send('photo=' + src);


    });

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

}
