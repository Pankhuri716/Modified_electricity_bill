<?php
// header.php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Electricity Billing System</title>
<link rel="stylesheet" href="/electricity_bill/css/style.css">
<style>
body { font-family: Arial,sans-serif; margin:0; background:#f5f5f5; }
.container { width:90%; margin:20px auto; }
.card-container { display:flex; flex-wrap:wrap; gap:15px; }
.card { flex:1; min-width:180px; padding:15px; background:#fff; text-align:center; box-shadow:0 2px 5px rgba(0,0,0,0.1); border-radius:6px; text-decoration:none; color:black;}
.card.logout { background:#f44336; color:white; }
.table-box { overflow-x:auto; background:#fff; padding:15px; border-radius:6px; box-shadow:0 2px 5px rgba(0,0,0,0.1);}
</style>
</head>
<body>
<div class="container">
