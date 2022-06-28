// display menu
document.querySelector("#hamburger").addEventListener('click', function () {
        document.querySelector(".navigation").style.width = "400px";
        document.querySelector(".navigation").style.padding = "2em";
        document.querySelector("#hide-navigation").style.display = 'block';
        document.querySelector(".main").style.width = 'calc(100vw-400px)';

})


document.querySelector("#hide-navigation").addEventListener('click', function () {
    document.querySelector(".navigation").style.width = "0px";
    document.querySelector(".navigation").style.padding = "0px";
    this.style.display = 'none';
    document.querySelector(".main").style.width = '100vw';
})