<?php

try {
    $db = new PDO('mysql:dbname=sakila;host=127.0.0.1', 'root', 'password');
} 

catch(PDOException $e) {
    die($e->getMessage());
}
