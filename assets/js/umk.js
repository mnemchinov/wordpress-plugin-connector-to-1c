
function getHttpRequest() {
    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}
function getAddressString(typeConnection,server,publicName) {
    return typeConnection + "://" + server + "/" + publicName + "/hs/api/";
}
function getVersionOfUMK(resElementId,typeConnection,server,publicName,User,Pass) {
    var httpRequest = getHttpRequest(typeConnection,server,publicName);
    var addressString = getAddressString(typeConnection,server,publicName) + 'getversion';
    httpRequest.open('GET', addressString, true);
    httpRequest.send();
    httpRequest.onreadystatechange = function () {
        if (httpRequest.readyState == 4) {
            if (httpRequest.status = 200) {
                document.getElementById(resElementId).innerHTML = httpRequest.responseText;
                return false;
            } 
        }
    };
}

