function easterEgg() {
    alert('Yavuz Kutuk! formateur php citation prefere ( je suis une machine, tu es une machine, vous etes des machines)');
 changeImage();
setTimeout(changeLogo, 5000)
}
function changeImage(){
let easterImage = document.getElementById('logo-image')
easterImage.src ="/assets/images/22395288.jpg"; 
}
function changeLogo(){
    let easterImage = document.getElementById('logo-image')
    easterImage.src ="/assets/images/logo-strashelp-300px.png"; 
}