function search() {
    let input = document.getElementById('search').value
    input=input.toLowerCase();
    let x = document.getElementsByClassName('alt');
    for (i = 0; i < x.length; i++) { 
        if (!x[i].textContent.toLowerCase().includes(input)) {
            x[i].style.display="none";
        }
        else {
            x[i].style.display="initial";                 
        }
    }
}