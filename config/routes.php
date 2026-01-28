<?php
return [
    'GET' => [
        '/kardex' => 'KardexController@index',
        '/' => 'LoginController@index',
        '/logout' => 'LoginController@logout',
        '/categorias' => 'CategoriasController@index',
        '/productos' => 'ProductosController@index',
        '/ventas' => 'VentasController@index',  
        '/ventas/reportes' => 'VentasController@reportes',
    ],
    'POST' => [
        '/login' => 'LoginController@authenticate',
        '/productos/guardar' => 'ProductosController@store',
        '/productos/actualizar' => 'ProductosController@update',
        '/productos/eliminar/:id' => 'ProductosController@destroy',
        '/categorias/guardar' => 'CategoriasController@store',
        '/categorias/actualizar' => 'CategoriasController@update',
        '/categorias/eliminar/:id' => 'CategoriasController@destroy',
        '/ventas/guardar' => 'VentasController@store',
        '/ventas/guardar_lote' => 'VentasController@store_lote',
    ]
];