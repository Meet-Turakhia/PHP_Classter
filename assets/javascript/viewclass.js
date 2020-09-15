$(document).ready(function () {
    $("#preexisting").hide();
    $("#nonexisting").show();
    $("#studentlink").css("color", "#009933");
    $("#prebtn").click(function () {
        $("#preexisting").show();
        $("#nonexisting").hide();
    });

    $("#nonbtn").click(function () {
        $("#preexisting").hide();
        $("#nonexisting").show();
    });

    $("#studentlink").click(function () {
        $("#studentsection").show();
        $("#studentlink").css("color", "#009933");
        $("#announcesection").hide();
        $("#announcelink").css("color", "#000000");
    });

    $("#announcelink").click(function () {
        $("#studentsection").hide();
        $("#studentlink").css("color", "#000000");
        $("#announcesection").show();
        $("#announcelink").css("color", "#009933");
    });

});

function urlify1() {
    var text = document.getElementById("titleurl").value;
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    var url = text.replace(urlRegex, '<a href="$1">$1</a>');
    document.getElementById("titleurl").value = url;
    // or alternatively
    //'<a href="$1">$1</a>' iske badle niche waala
    // return text.replace(urlRegex, function (url) {
    //     return '<a href="' + url + '">' + url + '</a>';
    // })
}

function urlify2() {
    var text = document.getElementById("descriptionurl").value;
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    var url = text.replace(urlRegex, '<a href="$1">$1</a>');
    document.getElementById("descriptionurl").value = url;
}

function urlify3() {
    var text = document.getElementById("commenturl").value;
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    var url = text.replace(urlRegex, '<a href="$1">$1</a>');
    document.getElementById("commenturl").value = url;
}

function urlify4() {
    var text = document.getElementById("commentediturl").value;
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    var url = text.replace(urlRegex, '<a href="$1">$1</a>');
    document.getElementById("commentediturl").value = url;
}

function commenttoggle(id) {
    var commentsection = "section" + id;
    var x = document.getElementById(commentsection);
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function commentedit(id) {
    var editform = "edit" + id;
    var commentvalue = "commentvalue" + id;
    var x = document.getElementById(editform);
    var y = document.getElementById(commentvalue);
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "block";
    }
}