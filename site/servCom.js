function stateChange(successCallback, failCallback, debug = false) {
    return function () {
        let response = '';
        try {
            response = json.decode(xmlhttp.responseText);
        }
        catch {
            console.log('Server error (NOT JSON): ' + xmlhttp.responseText);
            return;
        }
        
        if (debug) {
            console.log('RX: ' + response);
        }
        
        //Form variable is REQUIRED
        const form = response.form;
        const action = response.action;
    
        //Handle each action
        if (response.action === 'redirect')
            window.location = response.location;
        else if(response.action === 'error') {
            successCallback(response.message);
        }
        else if(response.action === 'success') {
            failCallback(response.message);
        }
    }
}

function asyncSend(action, form, dataObject, successCallback, failCallback, debug = false) {
    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = stateChange(
        successCallback,
        failCallback,
        debug);
    //Open our http request as POST with our action variable
    xmlhttp.open("POST", action, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    let jsonData = {};
    
    try {
        xmlhttp.send(json.encode(jsonData));
    }
    catch {
        console.log('Send failure (DATA NOT JSON ENCODABLE): ' + dataObject);
        return;
    }
    
}
