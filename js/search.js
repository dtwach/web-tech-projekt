function search() {
  let input = document.getElementById("search").value;
  input = input.toLowerCase();
  let x = document.getElementsByClassName("searchable");
  for (i = 0; i < x.length; i++) {
    if (!x[i].textContent.toLowerCase().includes(input)) {
      x[i].parentElement.style.display = "none";
    } else {
      x[i].parentElement.style.display = "initial";
    }
  }
}
