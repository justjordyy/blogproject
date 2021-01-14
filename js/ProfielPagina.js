
var buttonchangeinfopage = document.getElementById("btn1");
buttonchangeinfopage.addEventListener("click", editUserInfoPage);


var buttonchangeinfopage2 = document.getElementById("btn2");
buttonchangeinfopage2.addEventListener("click", mijnBlogPosts);

var canselupdatebtn = document.getElementById("CancelUpdate");
canselupdatebtn.addEventListener("click", cancelUpdate);


function editUserInfoPage(){

    document.getElementById("EditProfilePage").style.display='block';
    //hide my blog posts
}

function mijnBlogPosts(){
    document.getElementById("EditProfilePage").style.display='none';
    //show my blog posts
}

function cancelUpdate(){
    document.getElementById("EditProfilePage").style.display='none';
}