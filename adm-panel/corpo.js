var img;
var input;
window.onload = function() {
    input0 = document.getElementById("first");
    input0.focus();
    img = document.getElementById("img");
    input = document.getElementById("input");
    
}
pri_mai = (obj) => {
    str = obj.value;
    letras = str.length;
    pri = str.substr(0,1);
    resto = str.substr(1,letras);
    obj.value = pri.toUpperCase() + resto;
}
changeImg = () => {
    var reader = new FileReader();
    //console.log(reader);
    reader.onload = () => {
    img.src = reader.result;
    img.style.display = "block";  
    //console.log(reader);  
    }
    reader.readAsDataURL(input.files[0]);
 
}