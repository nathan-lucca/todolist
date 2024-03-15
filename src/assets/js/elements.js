window.addEventListener("load", function () {
  var elements = document.getElementsByClassName("blur-background");

  for (var i = 0; i < elements.length; i++) {
    elements[i].style.backdropFilter = "none";
    elements[i].style.backgroundColor = "transparent";
    elements[i].style.position = "static";
    elements[i].style.top = "auto";
    elements[i].style.left = "auto";
    elements[i].style.width = "auto";
    elements[i].style.height = "auto";
    elements[i].style.zIndex = "auto";
  }
});
