
<?php
require __DIR__ . '/vendor/autoload.php';
$api = new \Yandex\Geo\Api();

if (!empty($_POST['address'])) {

    $api->setQuery($_POST['address']);
    $api->load();

    $response = $api->getResponse();
    
    $collection = $response->getList();
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Composer: Yandex-Geo</title>
    <script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
    ymaps.ready(init);
    var myMap;

    function init(){
        myMap = new ymaps.Map("map", {
            center: [<?=  $_GET['latitude']?>, <?= $_GET['longitude']?>],
            zoom: 15
        });

        myPlacemark = new ymaps.Placemark([<?=  $_GET['latitude']?>, <?= $_GET['longitude']?>]);

        myMap.geoObjects.add(myPlacemark);
    }
</script>
</head>
<body>
<style type="text/css">
* {
    box-sizing: border-box;
}
table {
    border-collapse: collapse;
    margin: 20px 0 0;
    padding: 0;
    background-color: #D1FBF2;
    font-family: sans-serif;
}
table tr td,
table tr th {
    border: 1px solid black;
    padding: 5px;
}
a {
    color: black;
}
a:hover {
    color: red;
}
</style>

<form method="POST" action="index.php">
    <input name="address" placeholder="Адрес">
    <input type="submit" value="Найти">
</form>

<p>Список адресов:</p>

<table>
    <tr>
        <th>Адрес</th>
        <th>Широта</th>
        <th>Долгота</th>
    </tr>

    <?php if (!empty($_POST['address'])) {
         foreach ($collection as $item) { ?>
    <tr>
        <td><a href="index.php?latitude=<?= $item->getLatitude()?>&longitude=<?= $item->getLongitude()?>"><?php echo $item->getAddress() ?></a></td>
        <td><?php echo $item->getLatitude(); ?></td>
        <td><?php echo $item->getLongitude(); ?></td>
    </tr>
    <?php }
    } ?>

</table>

<div id="map" style="width: 600px; height: 400px"></div>

</body>
</html>