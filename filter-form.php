<!-- filter-form.php -->
<form id="filter-form" class="filter-form">
    <div class="filter-group">
        <label for="mileage" class="filter-label">Kilométrage :</label>
        <div class="filter-range">
            <input type="range" name="min_mileage" id="min_mileage" min="0" max="100000" step="1000" class="filter-input">
            <input type="range" name="max_mileage" id="max_mileage" min="0" max="100000" step="1000" class="filter-input">
            <span id="min_mileage_value" class="filter-value"></span>
            <span id="max_mileage_value" class="filter-value"></span>
        </div>
    </div>

    <div class="filter-group">
        <label for="price" class="filter-label">Prix :</label>
        <div class="filter-range">
            <input type="range" name="min_price" id="min_price" min="0" max="100000" step="1000" class="filter-input">
            <input type="range" name="max_price" id="max_price" min="0" max="100000" step="1000" class="filter-input">
            <span id="min_price_value" class="filter-value"></span>
            <span id="max_price_value" class="filter-value"></span>
        </div>
    </div>

    <div class="filter-group">
        <label for="year" class="filter-label">Années :</label>
        <div class="filter-range">
            <input type="range" name="min_year" id="min_year" min="1900" max="2023" step="1" class="filter-input">
            <input type="range" name="max_year" id="max_year" min="1900" max="2023" step="1" class="filter-input">
            <span id="min_year_value" class="filter-value"></span>
            <span id="max_year_value" class="filter-value"></span>
        </div>
    </div>
</form>
