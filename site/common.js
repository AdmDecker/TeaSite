function stateChange(successCallback, failCallback, debug = false) {
    return function () {
        //We don't care about these states, so ignore them
        if (!(xmlhttp.readyState==4) && !(xmlhttp.status==200))
            return;
        
        let response = '';
        try {
            response = JSON.parse(xmlhttp.responseText);
        }
        catch {
            console.log('Server error (NOT JSON): ' + xmlhttp.responseText);
            return;
        }
        
        if (debug) {
            console.log('RX: ' + response);
        }
        
        const action = response.action;
    
        //Handle each action
        if (response.action === 'redirect')
            window.location = response.location;
        else if(response.action === 'error') {
            failCallback(response.message);
        }
        else if(response.action === 'success') {
            successCallback(response.message);
        }
    }
}

function asyncSend(action, form, dataObject, successCallback, failCallback, debug = false) {
    xmlhttp[form] = new XMLHttpRequest();
    xmlhttp[form].onreadystatechange = stateChange(
        successCallback,
        failCallback,
        debug);
    //Open our http request as POST with our action variable
    xmlhttp[form].open("POST", action, true);
    xmlhttp[form].setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    dataObject.form = form;
    
    try {
        xmlhttp[form].send(JSON.stringify(dataObject));
    }
    catch {
        console.log('Send failure (DATA NOT JSON ENCODABLE)');
        console.log(dataObject);
        return;
    }   
}

function getInputValue(id) {
    return document.getElementById(id).value;
}

function displayError(formId, errorMessage) {
    document.getElementById(formId + Error).innerHTML = errorMessage;
}

xmlhttp = [];
