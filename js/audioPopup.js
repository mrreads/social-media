let buttonShow = document.querySelector(".audio-list h3 .add");
let buttonHide = document.querySelector(".popup .remove");
let popup = document.querySelector(".popup-wrapper");

buttonShow.addEventListener("click", function ()
{
    popup.style.display = "flex";
    document.body.style.overflow = "hidden";
    document.querySelector(".content").style.zIndex = "-1";
    document.querySelector(".content").style.filter = "blur(7px)";
});

buttonHide.addEventListener("click", function ()
{
    popup.style.display = "none";
    document.body.style.overflow = "unset";
    document.querySelector(".content").style.zIndex = "unset";
    document.querySelector(".content").style.filter = "unset";
});