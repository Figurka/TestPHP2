<?php
/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

# Можно использовать список:

$list = array (
	'09:00-11:00',
	'11:00-13:00',
	'15:00-16:00',
	'17:00-20:00',
	'20:30-21:30',
	'21:30-22:30',
);


// function check_one_int(){
// 	if((($intBeg>=$itemB)&&($intBeg<$itemE))||(($intEnd>$itemB)&&($intEnd<=$itemE))){
// 		return false;							// Наложение
// 	}
// }


function convertToTime(string $interval){ 
	list($b,$e) = explode('-',$interval);
	$intBeg = strtotime($b,0);
	$intEnd =strtotime($e,0);
	return array($intBeg,$intEnd);
}
function validateInterval(string $interval){
	list($iB,$iE) = convertToTime($interval);
	if (($iB!==false)&&($iE!==false)&&($iB!==$iE)){ // Если конвертация прошла успешна и начало интервала не равно его концу, то интервал валиден. 
		return true;							   // Можно ввести доп. условия по длительности, но таковых не задано по ТЗ.
	}
	return false;
}

function checkInterval(string $interval){
	global $list;
	if (validateInterval($interval)){
		list($intBeg,$intEnd)=convertToTime($interval);
		foreach($list as $item){
			list($itemB,$itemE)=convertToTime($item);
			if ((($itemB<$itemE && $intBeg <$intEnd) && !($itemE <=$intBeg || $intEnd <= $itemB))
					||
					(((($itemB<$itemE) && ($intBeg > $intEnd)) || (($itemB>$itemE) && ($intBeg<$intEnd))) && !($itemE<=$intBeg && $intEnd<=$itemB))
					||
					($intEnd<$intBeg && $itemE<$itemB)){
				return false;
			}

		}
		return true;
	}
	return false;
}



$listForCheck= array(
	'22:00-00:00',
	'23:00-01:00',
	'00:30-03:00',
	'14:30-15:00',
	'02:30-04:00',
	'01:00-02:40'
);

foreach($listForCheck as $item){
	if (checkInterval($item)){
		echo "{$item} => Наложения нет<br/>";
		$list[]=$item;
	}else{
		echo "{$item} => Наложение<br/>";
	}
	
}

