<?php 
    $raw_value = $_GET['value'];
    $result = calculateResult($raw_value);

    session_start();
    if (!$_SESSION['results']){
        $_SESSION['results'] = array();
    }
    array_push($_SESSION["results"], $result);

    function calculate($value1, $value2, $operator){
        switch ($operator){
            case '+':
                return $value1+$value2;
            case '-':
                return $value1-$value2;
            case 'X':
                return round($value1*$value2,3);
            case '/':
                return round($value1/$value2,3);

        }
    }

    function calculateResult($operation){
        $operation = explode(' ', $operation);

        while (in_array('/', $operation) or in_array('X', $operation)){
            foreach ($operation as $index=>$digit){
                if (in_array($digit,['X','/'])){
                    $result = calculate($operation[$index-1], $operation[$index+1], $digit);
                    unset($operation[$index-1]);
                    unset($operation[$index]);
                    $operation[$index+1] = $result;
                }
            }
        } 

        $operation = explode('!',implode('!',$operation));

        while (in_array('+', $operation) or in_array('-', $operation)){
            foreach ($operation as $index=>$digit){
                if (in_array($digit,['+','-'])){
                    $result = calculate($operation[$index-1], $operation[$index+1], $digit);
                    unset($operation[$index-1]);
                    unset($operation[$index]);
                    $operation[$index+1] = $result;
                }
            }
        }
        return implode('',$operation);  
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
    <title>Calculadora - Resultado</title>
</head>
<body>
    <div class='all-results'>
        <div>
            <h1>Resultado: 
                <?php 
                    $actualResul = $_SESSION['results'][sizeof($_SESSION['results'])-1];      
                    echo $actualResul;
                ?>
            </h1>
        </div>
        <div class='return-button' onclick='window.location.href = "index.php"'>
            <h2>Voltar</h2>
        </div>
        <div class='return-button' onclick='window.location.href = "index.php?reset=true"'>
            <h2>Limpar memória</h2>
        </div>
        <h4>Resultados anteriores</h4>
        <?php 
        foreach (array_reverse($_SESSION["results"]) as $old_result){
            echo '<div><p>'.$old_result.'</p></div>';
        }      
        ?>
    </div>
</body>
</html>