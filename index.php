<?php
    include "partials/header.php";
    include "partials/notifications.php";
    include "config/Database.php";
    include "classes/Movie.php";

$database = new Database();
$db = $database->connect();
$movie = new Movie($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["add_movie"])) {
        $movie->title = $_POST["movie"];
        $movie->create();
    }
}

// Fetching movie details
$movies = $movie->read();
?>

<!-- Main Content Container -->
<div class="container">
    <h1>Movie Watchlist</h1>

    <!-- Add Movie Form -->
    <form method="POST">
        <input type="text" name="movie" placeholder="Enter a new movie" required>
        <button type="submit" name="add_movie">Add Movie</button>
    </form>

    <!-- Display Movies -->
    <ul>
        <?php while($movie = $movies->fetch_assoc()): ?>
        <li class="completed">
            <span class="<?php echo $movie['is_watched'] ? 'completed' : '' ?>">
                <?php echo $movie['title'] ?>
            </span>
            <div>
                <?php if(!$movie['is_watched']): ?>
                    <!-- Watched Movie -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="1">
                        <button class="complete" type="submit" name="watched_movie">Watched</button>
                    </form>
                <?php else: ?>
                    <!-- Undo Watched Movie -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="1">
                        <button class="undo" type="submit" name="undo_watched_movie">Undo</button>
                    </form>
                <?php endif; ?>

                <!-- Delete Movie -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="1">
                    <button class="delete" type="submit" name="delete_movie">Delete</button>
                </form>
            </div>
        </li>

        <li>
            <span>Another Movie</span>
            <div>
                <!-- Watched Movie -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="2">
                    <button class="complete" type="submit" name="watched_movie">Watched</button>
                </form>

                <!-- Delete Movie -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="2">
                    <button class="delete" type="submit" name="delete_movie">Delete</button>
                </form>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php
include "partials/footer.php";
?>