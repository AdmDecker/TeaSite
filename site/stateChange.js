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
