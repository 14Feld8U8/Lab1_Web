<?php

$x = isset($_POST['x']) ? intval($_POST['x']) : null;
$y = isset($_POST['y']) ? floatval($_POST['y']) : null;
$r = isset($_POST['r']) ? floatval($_POST['r']) : null;

session_start();

date_default_timezone_set('Europe/Moscow');
$currentTime = date("H:i:s:ms");
if (!check_values($x, $y, $r)) {
    http_response_code(400);
    return;
}
$res = check_area($x, $y, $r) ? "<span style='color: #439400'>Попала</span>" : "<span style='color: #94002D'>Не попала</span>";
$time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];



$_SESSION['results'][] = [$x, $y, $r, $currentTime, $time, $res];

function check_values($x, $y, $r)
{
    return in_array($x, [-4, -3, -2, -1, 0, 1, 2, 3, 4])
        and is_numeric($y) and $y > -5 and $y < 5
        and in_array($r, [1.0, 1.5, 2.0, 2.5, 3.0]);
}

function check_area($x, $y, $r)
{
    if ($x <= 0) {
        return ($y <= 0 and ($x * $x + $y * $y <= $r * $r / 4)); //часть окружности
    } else {
        return $y >= 0 and $y <= -$x + $r // треугольник
            or ($y <= 0 and $x <= $r / 2 and $y >= -$r); //прямоугольник;
    }
}

?>

<table>
    <tr>
        <th>X</th>
        <th>Y</th>
        <th>R</th>
        <th>Время запуска</th>
        <th>Время работы</th>
        <th>Результат</th>
    </tr>
    <?php foreach ($_SESSION["results"] as $i) { ?>
        <tr>
            <td><?php echo $i[0] ?></td>
            <td><?php echo $i[1] ?></td>
            <td><?php echo $i[2] ?></td>
            <td><?php echo $i[3] ?></td>
            <td><?php echo $i[4] ?></td>
            <td><?php echo $i[5] ?></td>
        </tr>
    <?php } ?>
</table>
