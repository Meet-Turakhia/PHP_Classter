var textWrapper = document.querySelector('.ml2');
textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

anime.timeline({ loop: true })
  .add({
    targets: '.ml2 .letter',
    scale: [4, 1],
    opacity: [0, 1],
    translateZ: 0,
    easing: "easeOutExpo",
    duration: 950,
    delay: (el, i) => 70 * i
  }).add({
    targets: '.ml2',
    opacity: 0,
    duration: 1000,
    easing: "easeOutExpo",
    delay: 3000
  });

$(document).ready(function () {

  $("#registerlink").click(function () {
    $("#registerform").show();
    $("#loginform").hide();
  });

  $("#loginlink").click(function () {
    $("#loginform").show();
    $("#registerform").hide();
  });

  $("#admin").click(function () {
    $("#adminsecretcode").removeAttr("disabled");
    $("#adminsecretcode").show();
    $("#adminclass").removeAttr("disabled");
    $("#hodsecretcode").attr("disabled", "disabled");
    $("#hodsecretcode").hide();
    $("#hodclasslabel").hide();
    $("#hodclassselect").attr("disabled", "disabled");
    $("#hodclassselect").hide();
    $("#teachersecretcode").attr("disabled", "disabled");
    $("#teachersecretcode").hide();
    $("#teacherclass").attr("disabled", "disabled");
    $("#viewersecretcode").attr("disabled", "disabled");
    $("#viewersecretcode").hide();
    $("#viewerclass").attr("disabled", "disabled");
  });

  $("#hod").click(function () {
    $("#hodsecretcode").removeAttr("disabled");
    $("#hodsecretcode").show();
    $('#hodclasslabel').show();
    $('#hodclassselect').show();
    $('#hodclassselect').removeAttr('disabled');
    $("#adminsecretcode").attr("disabled", "disabled");
    $("#adminsecretcode").hide();
    $("#adminclass").attr("disabled", "disabled");
    $("#teachersecretcode").attr("disabled", "disabled");
    $("#teachersecretcode").hide();
    $("#teacherclass").attr("disabled", "disabled");
    $("#viewersecretcode").attr("disabled", "disabled");
    $("#viewersecretcode").hide();
    $("#viewerclass").attr("disabled", "disabled");
  });

  $("#teacher").click(function () {
    $("#teachersecretcode").removeAttr("disabled");
    $("#teachersecretcode").show();
    $("#teacherclass").removeAttr("disabled");
    $("#adminsecretcode").attr("disabled", "disabled");
    $("#adminsecretcode").hide();
    $("#adminclass").attr("disabled", "disabled");
    $("#hodsecretcode").attr("disabled", "disabled");
    $("#hodsecretcode").hide();
    $("#hodclasslabel").hide();
    $("#hodclassselect").attr("disabled", "disabled");
    $("#hodclassselect").hide();
    $("#viewersecretcode").attr("disabled", "disabled");
    $("#viewersecretcode").hide();
    $("#viewerclass").attr("disabled", "disabled");
  });

  $("#viewer").click(function () {
    $("#viewersecretcode").removeAttr("disabled");
    $("#viewersecretcode").hide();
    $("#viewerclass").removeAttr("disabled");
    $("#adminsecretcode").attr("disabled", "disabled");
    $("#adminsecretcode").hide();
    $("#adminclass").attr("disabled", "disabled");
    $("#hodsecretcode").attr("disabled", "disabled");
    $("#hodsecretcode").hide();
    $("#hodclasslabel").hide();
    $("#hodclassselect").attr("disabled", "disabled");
    $("#hodclassselect").hide();
    $("#teachersecretcode").attr("disabled", "disabled");
    $("#teachersecretcode").hide();
    $("#teacherclass").attr("disabled", "disabled");
  });
});

const verify = (e) => {
  const confirmpassword = e.target.value;
  const errorMsg = document.getElementById("verifymessage");
  const password = document.getElementById("originalpassword").value;
  if (confirmpassword !== password) {
    errorMsg.classList.remove('d-none');
    errorMsg.classList.add('d-inline');
    document.getElementById("register").setAttribute("disabled", "disabled");
  } else {
    console.log("haa");
    errorMsg.classList.remove('d-inline');
    errorMsg.classList.add('d-none');
    document.getElementById("register").removeAttribute("disabled");
  }
};
const confirmpassword = document.getElementById("verify");
confirmpassword.addEventListener('change', verify);
