<?php
$search = $_GET['search'] ?? '';
?>

<form method="GET" class="search-form">
    <div class="search-container">
        <input 
            type="text" 
            name="search" 
            placeholder="<?php echo $placeholder ?? 'Search...'; ?>"
            value="<?php echo htmlspecialchars($search); ?>"
        >

        <button type="submit" class="search-icon">
            Search
        </button>

        <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>" class="reset-btn">
            Reset
        </a>
    </div>
</form>