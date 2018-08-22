<?php
    require_once('Session.php');
    PupSession::LoadSession();
    PupSession::Validate();
    $teas = PupSession::getTeas();
    $canOrder = PupSession::canOrder();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width" />
        <link href="w3.css" rel="stylesheet" type="text/css">
        <link href="style.css" rel="stylesheet" type="text/css">
        <script src='jquery.js'></script>
        <script src='common.js'></script>
        <script>
            function toggleOrdering(enable) {
                if (enable) {
                    $('#requestTea').removeClass('w3-disabled');
                    $('#minutesMessage').addClass('hidden');
                }
                else {
                    $('#requestTea').addClass('w3-disabled');
                    $('#minutesMessage').removeClass('hidden');
                }
            }

            function updateTeasCounter() {
                displayError('teasCounter', 'You have ' + teas + ' teas');
                if (teas <= 0)
                    toggleOrdering(false);
            }
            
            function requestTea() {
                
                let dataObject = {
                    'requestMessage': getInputValue('orderMessage'),
                }
                
                let action = '/requestTea.php';
                let form = 'requestTea';

                const callBack = function (message) {
                    displayError(form, message);
                }

                const successCallBack = function(message) {
                    callBack(message);
                    teas = teas - 1;
                    updateTeasCounter();
                }
                
                asyncSend(
                    action,
                    form,
                    dataObject,
                    successCallBack,
                    callBack
                );

                toggleOrdering(false);
            }
            
            function giftTeas() {
                const form = 'gift';
                const giftAmount = getInputValue('giftAmount');
                
                let dataObject = {
                    giftRecipient: getInputValue('giftRecipient'),
                    giftAmount: giftAmount,
                };
                
                const callBack = function (message) { displayError( form, message); };
                const successCallBack = function (giftAmount) {
                    return function (message) {
                        callBack(message);
                        teas = teas - giftAmount;
                        updateTeasCounter();
                    }
                }
                
                asyncSend(
                    '/gift.php',
                    form,
                    dataObject,
                    successCallBack(giftAmount),
                    callBack,
                    debug
                );
            }
        </script>
    </head>
    <body>
        <header class="main-header">
            <ul class="nav-list">
                <li class="rides-r-us"><a href="index.php"><b>Tea</b></a></li>
                <li><a href="account.php"><b>Account</b></a></li>
            </ul>
            <hr width="100%">
        </header>
        <div class='center' style="text-align: center">
            <h2 class='center'>Welcome <?php echo PupSession::getUsername(); ?></h2>
            <p class='center' id='teasCounterError'></p>
            <input type='text' id='orderMessage' class='w3-input center login-input' placeholder='Order Message' /><br/><br/>
            <button id='requestTea' onclick='requestTea()' class='w3-button w3-blue w3-disabled login-input'>Order Tea</button>
            <label id='requestTeaError'></label>
            <label class='error' id='requestTeaError'></label>
            <br /><br />
            <h3 class='center'>Gift Teas</h3>
            <span class='login-input center'>
                <input type='text' id='giftRecipient' class='w3-input' style='width: 75%; display: inline-block' placeholder='Gift Recipient' />
                <input type='number' id='giftAmount' class='w3-input' value='0' min='0' style='width: 20%; display: inline-block'/>
            </span><br />
            <button class='w3-button login-input center w3-blue' onclick='giftTeas()'>Gift Teas</button><br />
            <label class='error' id='giftError'></label>
            
            <div><button class="w3-button login-input center w3-red" style="margin-top: 50px;" onclick="window.location='/logout.php'">Logout</button></div>
        </div>
    </body>
    <script>
        teas = <?php echo $teas ?>;
        toggleOrdering(teas > 0);
    </script>
</html>
