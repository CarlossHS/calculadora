<?php
    session_start();
    if (array_key_exists('reset', $_GET)){
        $_SESSION['results'] = array();
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' href='styles.css'> 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <title>Calculadora</title>
</head>
<body>
    <table class='calculator'>
        <tr>
            <td class='disabled' colspan='4'>
                <p class='result'>
                <?php 
                    if (!$_SESSION['results']){
                        $_SESSION['results'] = array();
                        echo '';
                    } else{
                        $actualResul = $_SESSION['results'][sizeof($_SESSION['results'])-1];
                        echo $actualResul;
                    }
                ?>
                </p>
            </td>
        </tr>
        <tr>
            <td class='key'>1</td>
            <td class='key'>2</td>
            <td class='key'>3</td>
            <td class='key'>X</td>
        </tr>
        <tr>
            <td class='key'>4</td>
            <td class='key'>5</td>
            <td class='key'>6</td>
            <td class='key'>/</td>
        </tr>
        <tr>
            <td class='key'>7</td>
            <td class='key'>8</td>
            <td class='key'>9</td>
            <td class='key'>+</td>
        </tr>
        <tr>
            <td class='key'>0</td>
            <td class='clear' colspan='2'>C</td>
            <td class='key'>-</td>
        </tr>
        <tr>
            <td colspan='4'>
                <form method='GET' action='calculate.php' onsubmit="return validateForm()">
                    <input type='text' name='value' id='hidden-text' 
                    value='<?php 
                        if (!$_SESSION['results']){
                            $_SESSION['results'] = array();
                            echo '';
                        } else{
                            $actualResul = $_SESSION['results'][sizeof($_SESSION['results'])-1];
                            echo $actualResul;
                        }
                    ?>'/>
                    <button type='submit'>=</button>
                </form>
            </td>
        </tr>
    
    </table>

    <script>
        const operationDisplay = document.querySelector('.result')
        const clearButton = document.querySelector('.clear')
        const formInput = document.querySelector('input')

        const eachKey = document.querySelectorAll('.key')
        eachKey.forEach(key => {
            key.addEventListener('click', ()=>{
                const actualDigit = key.innerText
                let oldText = operationDisplay.innerText
                let lastDigit = oldText.substring(oldText.length-1)
                if (lastDigit == '*') lastDigit = oldText.substring(oldText.length-2,oldText.length-1)

                if (['+','-','/','X'].includes(oldText.substring(0,1))){
                    operationDisplay.innerHTML = ''
                    oldText = ''
                }

                if (['+','-','/','X'].includes(actualDigit) && ['+','-','/','X'].includes(lastDigit)){
                    operationDisplay.innerText = oldText.replace(lastDigit, actualDigit)
                } else if(['+','-','/','X'].includes(actualDigit)){
                    operationDisplay.innerText = `${oldText} ${actualDigit}`
                } else if(['+','-','/','X'].includes(lastDigit)){
                    operationDisplay.innerText = oldText+' '+actualDigit
                } else{
                    operationDisplay.innerText = oldText+actualDigit
                }
                formInput.value = operationDisplay.innerText
            })
        })

        clearButton.addEventListener('click',()=>{
            operationDisplay.innerText = ''
            formInput.value = operationDisplay.innerText
        })

        function validateForm(){
            const lastChar = formInput.value.substring(formInput.value.length-1,formInput.value.length)
            if (['+','-','/','X'].includes(lastChar)){
                operationDisplay.innerText = formInput.value.substring(0, formInput.value.length-1)
                formInput.value = formInput.value.substring(0, formInput.value.length-1)
            }
            return true
        }
    </script>
</body>
</html>