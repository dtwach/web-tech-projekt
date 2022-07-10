function show_form_desc() {
  let x = document.getElementsByClassName("form_desc");
  var str = "block";
  if (x[0].style.display == "block"){
    str = "none";
  }
  for (i = 0; i < x.length; i++) {
    x[i].style.display = str;
  }
}

function show_form_img() {
  let x = document.getElementsByClassName("form_img");
  var str = "block";
  if (x[0].style.display == "block"){
    str = "none";
  }
  for (i = 0; i < x.length; i++) {
    x[i].style.display = str;
  }
}
