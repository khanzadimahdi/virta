<?php

require_once('./vendor/autoload.php');

use App\Controllers\SearchController;

function get($name) {
    return !empty($_GET[$name]) ? $_GET[$name] : null;
}

$error = null;
$validationErrors = [];
$items = [];

if (get('action') == 'search') {

    $latitude = get('latitude'); 
    $longitude = get('longitude');
    $distance = get('distance');

    if (is_null($latitude) || !is_numeric($latitude) || $latitude < -90 || $latitude > 90) {
        array_push($validationErrors, 'latitude must be a valid number between -90 and 90');
    }

    if (is_null($longitude) || !is_numeric($longitude) || $longitude < -180 || $longitude > 180) {
        array_push($validationErrors, 'longitude must be a valid number between -180 and 180');
    }

    if (!is_null($distance) && $distance <= 0) {
        array_push($validationErrors, 'distance must be a valid number and greater than 0');
    }

    if (empty($validationErrors)) {
        $searchController = new SearchController;
        try {
            $result = $searchController->search($latitude, $longitude, $distance);
            $items = empty($result['data']) ? [] : $result['data'];
        } catch (Exception $exception) {
            $error = $exception->getMessage();
        }    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Search stations</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <?php if(!empty($error)): ?>
                <p class="alert alert-danger"><?= htmlentities($error) ?></p>
            <?php endif; ?>

            <?php foreach($validationErrors as $validationError): ?>
                <p class="alert alert-warning"><?= htmlentities($validationError) ?></p>
            <?php endforeach; ?>

            <form method="GET" action="./">
                <div class="mb-3">
                    <label for="latitude" class="form-label">Latitude (*)</label>
                    <input step=any value="<?= isset($latitude) ? htmlentities($latitude) : '' ?>" type="number" class="form-control" name="latitude" id="latitude" aria-describedby="latitude">
                </div>

                <div class="mb-3">
                    <label for="longitude" class="form-label">Longitude (*)</label>
                    <input step=any value="<?= isset($longitude) ? htmlentities($longitude) : '' ?>" type="number" class="form-control" name="longitude" id="longitude" aria-describedby="longitude">
                </div>

                <div class="mb-3">
                    <label for="distance" class="form-label">Distance</label>
                    <input step=any value="<?= isset($distance) ? htmlentities($distance) : '' ?>" type="number" class="form-control" name="distance" id="distance" aria-describedby="distance">
                </div>

                <button name="action" value="search" type="submit" class="btn btn-primary">Search</button>
            </form>

            <div>
                <table class="table">
                    <tr>
                        <td>name</td>
                        <td>latitude</td>
                        <td>longitude</td>
                        <td>address</td>
                    </tr>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan=4>
                                <p class="alert alert-info">no related results</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($items as $item): ?>
                            <tr>
                                <td><?= htmlentities($item['name']) ?></td>
                                <td><?= htmlentities($item['latitude']) ?></td>
                                <td><?= htmlentities($item['longitude']) ?></td>
                                <td><?= htmlentities($item['address']) ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </table>
            </div>

        </div>
    </body>
</html>