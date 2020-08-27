$(document).ready(function () {
    $("#preexisting").hide();
    $("#nonexisting").show();
    $("#prebtn").click(function () {
        $("#preexisting").show();
        $("#nonexisting").hide();
    });

    $("#nonbtn").click(function () {
        $("#preexisting").hide();
        $("#nonexisting").show();
    });
});
