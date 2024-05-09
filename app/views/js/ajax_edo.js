function loadAjaxCiudadHive(str, ciudad){
    var xmlhttp;
    
    if (window.XMLHttpRequest){
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }else{// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            //respuesta = xmlhttp.responseText;
            //console.log("pase", respuesta);
            document.getElementById("city").innerHTML=xmlhttp.responseText;
        }else{
            //console.log("error", xmlhttp.readyState + ", " + xmlhttp.status);
        }
    }
    xmlhttp.open("GET","http://localhost/multimarket/app/views/inc/findcity.php?q="+str+"&c="+ciudad,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str);
}