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
    //console.log("error ", str + " " +  ciudad);
    xmlhttp.open("GET","http://localhost/multimarket/app/views/inc/findcity.php?q="+str+"&c="+ciudad,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str);
}

function loadAjaxCatSubcat(str, subcat){
    var xmlhttp;
    if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
    }else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function(){
        if (xmlhttp.readyState==4 && xmlhttp.status==200){
            //respuesta = xmlhttp.responseText;
            //console.log("pase", respuesta);
            document.getElementById("product_subcat").innerHTML=xmlhttp.responseText;
        }else{
            //console.log("error", xmlhttp.readyState + ", " + xmlhttp.status);
        }
    }
    //console.log("valores ", str + "," +  subcat);
    xmlhttp.open("GET","http://localhost/multimarket/app/views/inc/findCatSubcat.php?q="+str+"&c="+subcat,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str);
}

function loadAjaxCategoryCat(str, categorySub){
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
            document.getElementById("company_category_sub").innerHTML=xmlhttp.responseText;
        }else{
            //console.log("error", xmlhttp.readyState + ", " + xmlhttp.status);
        }
    }
    //console.log("error ", str + " " +  marketCat);
    xmlhttp.open("GET","http://localhost/multimarket/app/views/inc/findCategorySub.php?q="+str+"&c="+categorySub,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str);
}

function loadAjaxMarcaModelo(str, modelo){
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
            document.getElementById("product_modelo").innerHTML=xmlhttp.responseText;
        }else{
            //console.log("error", xmlhttp.readyState + ", " + xmlhttp.status);
        }
    }
    //console.log("error ", str + " " +  marketCat);
    xmlhttp.open("GET","http://localhost/multimarket/app/views/inc/findMarcaModelo.php?q="+str+"&c="+modelo,true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("q="+str);
}