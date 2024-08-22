<?php

// Функция для генерации случайного числа в заданном диапазоне
function getRandomInt($min, $max) {
    return rand($min, $max);
}

// Массив категорий с соответствующими URL изображений
$categories = [
    'Футболки' => 'https://media.gq.com/photos/5e6944f74d6be70008ac16c2/master/w_2000,h_1333,c_limit/Uniqlo-U-crew-neck-short-sleeve-T-shirt.jpg',
    'Джинсы' => 'https://detvorashop.ru/image/cache/catalog/mayoral_leto_2018/00000-02999/mayoral-00046-025-1-800x800.JPG',
    'Куртки' => 'https://www.logoprime.ru/upload/iblock/883/7539.40_1_1000x1000.jpg',
    'Обувь' => 'https://img.joomcdn.net/b38af8b3aceac25eb71e0ba2628382964948e944_original.jpeg'
];

// Функция для генерации случайного названия товара с учетом рода существительных
function generateRandomName() {
    $adjectives = ['Красив', 'Модн', 'Стильн', 'Удобн', 'Прочн'];
    $nouns = [
        'футболка' => 'ая',
        'джинсы' => 'ые',
        'куртка' => 'ая',
        'ботинки' => 'ые',
        'кроссовки' => 'ые'
    ];
    $randomNoun = array_keys($nouns)[getRandomInt(0, count(array_keys($nouns)) - 1)];
    $adjectiveEnding = $nouns[$randomNoun];
    $randomAdjective = $adjectives[getRandomInt(0, count($adjectives) - 1)] . $adjectiveEnding;
    return $randomAdjective . ' ' . $randomNoun;
}

// Функция для генерации случайного товара
function generateRandomProduct($categories) {
    $categoryKeys = array_keys($categories);
    $randomCategory = $categoryKeys[getRandomInt(0, count($categoryKeys) - 1)];
    return [
        'name' => generateRandomName(),
        'category' => $randomCategory,
        'price' => getRandomInt(500, 10000),
        'quantity' => getRandomInt(1, 50),
        'imageUrl' => $categories[$randomCategory]
    ];
}

// Генерация списка товаров
$numberOfProducts = getRandomInt(100, 200);
$products = [];

for ($i = 0; $i < $numberOfProducts; $i++) {
    $products[] = generateRandomProduct($categories);
}

// Формирование YML-документа
$ymlContent = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$ymlContent .= '<yml_catalog date="' . date('c') . '">' . "\n";
$ymlContent .= '  <shop>' . "\n";
$ymlContent .= '    <name>Мой Интернет-магазин</name>' . "\n";
$ymlContent .= '    <company>Моя Компания</company>' . "\n";
$ymlContent .= '    <url>https://example.com</url>' . "\n";
$ymlContent .= '    <currencies>' . "\n";
$ymlContent .= '      <currency id="RUB" rate="1"/>' . "\n";
$ymlContent .= '    </currencies>' . "\n";
$ymlContent .= '    <categories>' . "\n";
$categoryIndex = 1;
foreach ($categories as $categoryName => $imageUrl) {
    $ymlContent .= '      <category id="' . $categoryIndex . '">' . $categoryName . '</category>' . "\n";
    $categoryIndex++;
}
$ymlContent .= '    </categories>' . "\n";
$ymlContent .= '    <offers>' . "\n";

foreach ($products as $index => $product) {
    $ymlContent .= '      <offer id="' . ($index + 1) . '" available="true">' . "\n";
    $ymlContent .= '        <name>' . $product['name'] . '</name>' . "\n";
    $ymlContent .= '        <categoryId>' . (array_search($product['category'], array_keys($categories)) + 1) . '</categoryId>' . "\n";
    $ymlContent .= '        <price>' . $product['price'] . '</price>' . "\n";
    $ymlContent .= '        <currencyId>RUB</currencyId>' . "\n";
    $ymlContent .= '        <picture>' . $product['imageUrl'] . '</picture>' . "\n";
    $ymlContent .= '        <stock_quantity>' . $product['quantity'] . '</stock_quantity>' . "\n";
    $ymlContent .= '      </offer>' . "\n";
}

$ymlContent .= '    </offers>' . "\n";
$ymlContent .= '  </shop>' . "\n";
$ymlContent .= '</yml_catalog>' . "\n";

// Запись YML-документа в файл
file_put_contents('value.yml', $ymlContent);