<?php


# import databázy
require_once __DIR__ . '/DB.php';

#nastavenie ciest (využívajú sa pri nastavovaní aktívnej stránky v nabare)
$rootPrefix = '';
$indexPage = $rootPrefix . 'index.php';
$MestoPage = $rootPrefix . 'Mesto.php';


#funkcia pre kontorlu a nastavenie aktívnej stránky
function isLocationActive(string $location): string
{
  $currentLocation = $_SERVER['SCRIPT_FILENAME'];
  return strpos($currentLocation, $location) ? ' active' : '';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Leave Feedback</title>
      <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f7f6; margin: 0px; }
        .form-container { max-width: 450px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; }
        h2 { margin-top: 0; color: #333; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; background-color: #007bff; color: white; padding: 12px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.2s; }
        button:hover { background-color: #0056b3; }
        .error-box { background-color: #f8d7da; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb; font-weight: bold; }
        table { max-width: 1000px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin: 0 auto; margin-top: 30px; width: 80%; font-weight: bold; }
        .delete { background-color: #dc3545; }
        button.delete:hover { background-color: #ae1f2d; }
        header { text-align: center; margin-bottom: 30px; margin-top: 0px; width: 100%; background-color: #a6a6a6; padding: 10px 0; }
        .btn-header { background-color: #7f7f7f; color: white; width: 25%; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.2s; margin: 20px; }
        .btn-header-on { background-color: #4a4a4a; color: white; width: 25%; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background 0.2s; margin: 20px; }
    </style>
</head>

<body>

    <header>
        <button class="btn-header<?php echo isLocationActive($MestoPage) ? '-on' : '' ?>" 
                onclick="window.location.href='<?= $MestoPage ?>'">Správa Pobočiek</button>
        <button class="btn-header<?php echo isLocationActive($indexPage) ? '-on' : '' ?>" 
                onclick="window.location.href='<?= $indexPage ?>'">Správa Mobilov</button>
    </header>

  <main>
    <div class="container-fluid">