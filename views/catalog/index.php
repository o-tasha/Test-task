<?php
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: nataly
 * Date: 08.01.18
 * Time: 22:25
 */
$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">Корзина</h3>
    </div>
    <div class="panel-body">
        <div class="alert alert-warning fade in" id="cart-message">
            <strong>Holy guacamole!</strong> Best check yo self, you're not looking too good.
        </div>
        <ul class="list-group" id="cart">
        </ul>
        <button type="button" class="btn btn-primary btn_chekout">Оформить заказ</button>
        <button type="button" class="btn btn-default btn_clear_cart">Очистить</button>
    </div>
</div>

<div class="row">
    <?php for ($i = 1; $i <= 6; $i++):
        $price = 100 * $i;
        ?>
        <div class="col-sm-6 col-md-4">
            <div class="thumbnail">
                <img src="/img/item<?=$i?>.jpg">
                <div class="caption">
                    <h3 id="prod-name-<?=$i?>">Товар <?=$i?></h3>
                    <p>Описание товара <?=$i?></p>
                    <p><?= Html::button('В корзину', ['class' => 'btn btn-primary btn_add_2_shop_cart', 'data-prod' => $i]) ?></p><span id="prod-price-<?=$i?>"><?=$price?></span> руб.
                </div>
            </div>
        </div>
    <?php endfor; ?>
</div>




<?php
$this->registerJs("
    showCart('');

    // чтение данных из LS
    function getCartData() {
      return JSON.parse(localStorage.getItem('cart'));
    }
    
    // запись данных в LS
    function setCartData(o) {
      localStorage.setItem('cart', JSON.stringify(o));
      return false;
    }
    
    function addToCart(prodId, prodName, prodPrice) {
        var cartData = getCartData() || {};
        if(cartData.hasOwnProperty(prodId)) {
            cartData[prodId][2] += 1;
        } else {
            cartData[prodId] = [prodName, prodPrice, 1];
        }
      
        setCartData(cartData);
      
        return false;
    }
    
    // отображение содержимого корзины
    function showCart(message = '') {
        $('#cart li').remove();
   
        var cartData = getCartData(),
            itemRows = '';
       
       if(cartData !== null) {
        for(var items in cartData){
              itemRows += '<li class=\"list-group-item\">';
              //for(var i = 0; i < cartData[items].length; i++) {
              //  itemRows += cartData[items][i];
              //  if (i < cartData[items].length - 1) itemRows += ', ';
              //}
              itemRows += cartData[items][0] + ', цена: ' + cartData[items][1] + ', количество: ' + cartData[items][2];
              itemRows += '</li>';
            }
        $('#cart').html(itemRows);
        } else {
            $('#cart').html('<li class=\"list-group-item\">В корзине пусто</li>');
        }
        
        if(message == '') {
            $('#cart-message').hide();
        } else {
            $('#cart-message').show();
        }
        $('#cart-message').html(message);
        
        return false;
    }

    // Добавить в корзину
    $('.btn_add_2_shop_cart').on('click', function() {
        var prodId = $(this).attr('data-prod'),
            prodName = $('#prod-name-'+prodId).text(),
            prodPrice = $('#prod-price-'+prodId).text();
        
        addToCart(prodId, prodName, prodPrice);
        
        showCart();
    });
    
    // Очистить корзину
    $('.btn_clear_cart').on('click', function() {
        localStorage.removeItem('cart');
        
        showCart('');
    });
    
    // Оформить заказ
    $('.btn_chekout').on('click', function() {
        var cartData = getCartData();
        
        if(cartData !== null) {
            $.ajax({
                url: '" . \yii\helpers\Url::toRoute(['/catalog/checkout']) . "',
                type: 'POST',
                data: cartData,
                success: function(data) {
                    if (data.status == 'ok') {
                            localStorage.removeItem('cart');
                            showCart('Заказ успешно оформлен');
                        }
                    else
                        {
                            showCart('При оформлении заказа возникла проблема, попробуйте еще раз');
                        }
                },
                error: function() {
                    showCart('При оформлении заказа возникла проблема, попробуйте еще раз');
                }
            });
        }
                
        return false;
    });
");
?>

