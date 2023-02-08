
/** -------- SCROLL SPY NAVBAR -------- **/
const navbar = document.getElementById('mainNav');
const avatarButton = document.querySelector('.nav-link.dropdown-toggle')

window.onscroll = () => {
    let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

    if(scrollPosition > 100) {
        navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.7)'
        avatarButton.style.borderColor = 'black'
    } else {
        navbar.style.backgroundColor = 'unset'
        avatarButton.style.borderColor = '#acafb1'

    }
}
/** -------- END SCROLL SPY NAVBAR -------- **/


/** TINY MCE INIT **/
tinymce.init({
    selector: 'textarea',
    height: 300,
    relative_urls: false,
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table paste imagetools wordcount",
        'image code'
    ],
    toolbar: "insertfile undo redo | image code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    // content_css: [
    //     'css/back/material-dashboard.css',
    // ]
});

/** -------- AUTO COMPLETE -------- **/
