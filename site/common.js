function stateChange(form, successCallback, failCallback) {
    return function () {
        //We don't care about these states, so ignore them
        if (!(xmlhttp[form].readyState==4 && xmlhttp[form].status==200))
            return;
        
        let response = '';
        let responseText = xmlhttp[form].responseText;
        try {
            response = JSON.parse(responseText);
        }
        catch {
            console.log('Server error (NOT JSON): ' + responseText);
            return;
        }
        
        if (debug) {
            console.log('RX: ' + responseText);
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

function asyncSend(action, form, dataObject, successCallback, failCallback) {
    xmlhttp[form] = new XMLHttpRequest();
    xmlhttp[form].onreadystatechange = stateChange(
        form,
        successCallback,
        failCallback
    );
    //Open our http request as POST with our action variable
    xmlhttp[form].open("POST", action, true);
    xmlhttp[form].setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    dataObject.form = form;
    let jsonData = JSON.stringify(dataObject);
    
    try {
        xmlhttp[form].send(jsonData);
    }
    catch {
        console.log('Send failure (DATA NOT JSON ENCODABLE)');
        console.log(dataObject);
        return;
    }

    if (debug)
        console.log('TX: ' + jsonData);
}

function getInputValue(id) {
    return document.getElementById(id).value;
}

function setInputValue(id, value) {
    document.getElementById(id).value = value;
}

function getCheckboxValue(id) {
    return document.getElementById(id).checked;
}

function displayError(formId, errorMessage) {
    document.getElementById(formId + 'Error').innerHTML = errorMessage;
}

xmlhttp = [];
debug = true;
