<?php

/**
 * @charset UTF-8
 *
 * Задание 3
 * В данный момент компания X работает с двумя перевозчиками
 * 1. Почта России
 * 2. DHL
 * У каждого перевозчика своя формула расчета стоимости доставки посылки
 * Почта России до 10 кг берет 100 руб, все что cвыше 10 кг берет 1000 руб
 * DHL за каждый 1 кг берет 100 руб
 * Задача:
 * Необходимо описать архитектуру на php из методов или классов для работы с
 * перевозчиками на предмет получения стоимости доставки по каждому из указанных
 * перевозчиков, согласно данным формулам.
 * При разработке нужно учесть, что количество перевозчиков со временем может
 * возрасти. И делать расчет для новых перевозчиков будут уже другие программисты.
 * Поэтому необходимо построить архитектуру так, чтобы максимально минимизировать
 * ошибки программиста, который будет в дальнейшем делать расчет для нового
 * перевозчика, а также того, кто будет пользоваться данным архитектурным решением.
 *
 */

# Использовать данные:
# любые
 interface Transporter{
    public function transitCost();
 }

 class DHL implements Transporter{
    public function transitCost(int $weight =-1,...$args)
    {
        if ($weight == -1){
            return 'Не возможно расчитать стоимость, проверьте параметры доставки';
        }
        return $weight*100;
    }
 }
 class RussianPost implements Transporter{
    public function transitCost(int $weight = -1,...$args)
    {
        if ($weight == -1){
            return 'Не возможно расчитать стоимость, проверьте параметры доставки';
        }
        return $weight>10?1000:100;  
    }
 }

 class RandomTranporter implements Transporter{
    public function transitCost(int $distance = -1,...$args)
    {   
        if ($distance == -1){
            return 'Не возможно расчитать стоимость, проверьте параметры доставки';
        }
        return $distance * 10;
    }
 }


$trList = [ new DHL(), new RussianPost(), new RandomTranporter()];
foreach ($trList as $transporter ){
    echo 'Стоимость доставки у '. get_class($transporter) .': '.
         $transporter->transitCost(weight :20, distance : 3, randomString:'Хрупкое') .'<br/>';
}