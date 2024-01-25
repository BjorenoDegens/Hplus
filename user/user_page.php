<?php
// Start a session
session_start();

// Replace 'YOUR_API_KEY' with your actual API key from FoodData Central
$apiKey = 'IGnU34ooBnlhDlfS85FoxO3CYh8JIymizB8eWwge';

// Function to make API request and retrieve data based on parameters
function getFoodData($searchTerm, $kcal, $carbohydrates, $fats, $proteins) {
    global $apiKey;

    // API endpoint
    $apiEndpoint = 'https://api.nal.usda.gov/fdc/v1/foods/search';

    // Build query parameters
    $queryParams = [
        'api_key' => $apiKey,
        'query' => $searchTerm,
        'min' => [
            'nutrients' => [
                ['nutrientId' => 1003, 'min' => $kcal],  // kcal
                ['nutrientId' => 1005, 'min' => $carbohydrates],  // carbohydrates
                ['nutrientId' => 1004, 'min' => $fats],  // fats
                ['nutrientId' => 1008, 'min' => $proteins],  // proteins
            ],
        ],
    ];

    // Make the API request
    $url = $apiEndpoint . '?' . http_build_query($queryParams);
    $response = file_get_contents($url);

    // Decode the JSON response
    $data = json_decode($response, true);

    return $data;
}

// Example usage
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$kcal = 200;  // Replace with desired kcal value
$carbohydrates = 30;  // Replace with desired carbohydrates value
$fats = 10;  // Replace with desired fats value
$proteins = 15;  // Replace with desired proteins value

// Get food data based on input parameters
$result = getFoodData($searchTerm, $kcal, $carbohydrates, $fats, $proteins);

// Store the result in the session
$_SESSION['foodSearchResult'] = $result;

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected items' indexes from the hidden input
    $selectedItems = isset($_POST['selectedItems']) ? explode(',', $_POST['selectedItems']) : [];

    // Display selected items' information
    if (!empty($selectedItems)) {
        echo '<div class="container mt-5">';
        echo '<h2 class="mb-4">Comparison Results</h2>';

        foreach ($selectedItems as $index) {
            $foodData = getFoodData($searchTerm, $kcal, $carbohydrates, $fats, $proteins);

            if ($foodData && isset($foodData['foods'][$index])) {
                $food = $foodData['foods'][$index];
                echo '<h3>' . htmlspecialchars($food['description'] ?? '') . '</h3>';
                echo '<p>Brand: ' . htmlspecialchars($food['brandOwner'] ?? '') . '</p>';
                echo '<p>Nutrition Information:</p>';
                echo '<ul>';
                foreach ($food['foodNutrients'] as $nutrient) {
                    echo '<li><strong>' . htmlspecialchars($nutrient['nutrientName'] ?? '') . ':</strong> ' . htmlspecialchars($nutrient['value'] ?? '') . ' ' . htmlspecialchars($nutrient['unitName'] ?? '') . '</li>';
                }
                echo '</ul>';
                echo '<hr>';
            } else {
                echo '<p>Error fetching data for item with index ' . htmlspecialchars($index) . '</p>';
            }
        }

        echo '</div>';
    } else {
        echo '<p>No items selected for comparison.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Food Data Search</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Food Data Search</h2>

    <!-- Search Form -->
    <form method="get">
        <div class="form-row">
            <div class="col-md-8 mb-3">
                <label for="searchTerm">Search Term</label>
                <input type="text" class="form-control" id="searchTerm" name="search" value="<?= htmlspecialchars($searchTerm) ?>" placeholder="Enter food name">
            </div>
            <div class="col-md-4 mb-3">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
    </form>

    <!-- Display Results -->
    <?php if ($result && isset($result['foods']) && is_array($result['foods'])): ?>
        <h3 class="mt-4 mb-3">Results</h3>
        <form method="post">
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Nutrition Information</th>
                    <th>Select</th>
                    <th>Compare</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($result['foods'] as $index => $food): ?>
                    <?php
                    // Only display the item if all nutrient values are present
                    if (isset($food['foodNutrients'])): ?>
                        <tr>
                            <td><?= htmlspecialchars($food['description'] ?? '') ?></td>
                            <td><?= htmlspecialchars($food['brandOwner'] ?? '') ?></td>
                            <td>
                                <button type="button" class="btn btn-primary toggle-nutrition" data-toggle="collapse" data-target="#nutritionDetails<?= $index ?>">Nutrition Details</button>
                                <div id="nutritionDetails<?= $index ?>" class="collapse scrollable-nutrition">
                                    <?php foreach ($food['foodNutrients'] as $nutrient): ?>
                                        <div><strong><?= isset($nutrient['nutrientName']) ? htmlspecialchars($nutrient['nutrientName']) . ': ' : '' ?></strong>
                                            <?= isset($nutrient['value']) ? htmlspecialchars($nutrient['value']) . ' ' . htmlspecialchars($nutrient['unitName']) : '' ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </td>
                            <td>
                                <button type="submit" name="selectedFood" value="<?= $index ?>" class="btn btn-primary">Select</button>
                            </td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="compare[]" value="<?= $index ?>" id="compareCheckbox<?= $index ?>">
                                    <label class="form-check-label" for="compareCheckbox<?= $index ?>">Compare</label>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Hidden input to store selected items for comparison -->
            <input type="hidden" name="selectedItems" id="selectedItems" value="">

            <!-- Compare Button -->
            <button type="button" class="btn btn-success" onclick="compareSelected()">Compare Selected</button>
        </form>
    <?php else: ?>
        <p>No results found.</p>
    <?php endif; ?>

    <style>
        .scrollable-nutrition {
            max-height: 100px; /* Set the max height for the scrollable box */
            overflow-y: auto; /* Enable vertical scrolling if content exceeds max height */
        }
    </style>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        // Manually toggle the collapse state when clicking the button
        $('.toggle-nutrition').on('click', function () {
            var targetId = $(this).data('target');
            $(targetId).collapse('toggle');
        });

        // JavaScript function to set the selected items in the hidden input
        function compareSelected() {
            var selectedItems = [];
            $('input[name="compare[]"]:checked').each(function () {
                selectedItems.push($(this).val());
            });
            $('#selectedItems').val(selectedItems.join(','));
            // Submit the form
            $('form').submit();
        }
    </script>
</div>

</body>
</html>
