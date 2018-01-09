<?php
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 09.01.18
 * Time: 17:51
 */
?>

<h4>Оформлен новый заказ</h4>

<table>
    <tr>
        <th>Название товара</th>
        <th>Цена</th>
        <th>Количество</th>
    </tr>
<?php foreach($products as $id => $product):?>
    <tr>
        <td><?= $product[0] ?></td>
        <td><?= $product[1] ?></td>
        <td><?= $product[2] ?></td>
    </tr>
<?php endforeach; ?>
</table>