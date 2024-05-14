
document.getElementById('post').classList.toggle("visible");


function aff_edition(id){
    var elts = document.querySelectorAll('.panel');
    var act = document.querySelectorAll('.bar li');
    var i = 0;
    for (i = 0; i < elts.length; i++) {
        if (elts[i].id != id) {
            elts[i].classList.remove("visible");       
        }
    }
    for(i = 0; i < act.length; i++){
         act[i].classList.remove("active");
    }

    document.getElementById(id).classList.toggle("visible");
    var elementsByName = document.getElementsByName(id);
    if (elementsByName.length > 0) {
        elementsByName[0].classList.toggle("active");
    }
}

function saut_ligne(name){
    var element = document.querySelector(name);
    if(element){
        var text = element.textContent;
        var newT = "";
        for(var i = 0; i < text.length ; i++){
            newT +=text[i];
            if( (i+1) %100 === 0){
                newT +="<br>";
            }
        }
        element.innerHTML = newT;
    }
}

