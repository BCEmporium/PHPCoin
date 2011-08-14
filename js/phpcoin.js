function changeMyAddress(){
    $.ajax({
        url:"index.php",
        type:"post",
        data:{
            f:"getnewaddress",
            nh:1
        },
        success: function(data){
            if(data.substr(0,4) != "ERR"){
                $("#btaddress").html(data);
            }else{
                alert(data.substr(4));
            }
        },
        error: function(){alert("Ajax Error!");}
    })
}

function copyToClipboard(text,el){
    clip.setText(text);
    clip.glue(el);
}