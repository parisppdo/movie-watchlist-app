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
        $a = $movie->create();
    }
    elseif (isset($_POST["watched_movie"])) {
        $movie->set_watched($_POST['id']);
    }
    elseif (isset($_POST["unset_watched_movie"])) {
        $movie->unset_watched($_POST['id']);
    }
    elseif (isset($_POST["delete_movie"])) {
        $movie->delete($_POST['id']);
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
                <?php echo ucfirst(strtolower($movie['title'])); ?>
            </span>
            <div>
                <?php if(!$movie['is_watched']): ?>
                    <!-- Set Movie as Watched -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id'] ?>">
                        <button class="complete" type="submit" name="watched_movie">Watched</button>
                    </form>
                <?php else: ?>
                    <!-- Reset Set Movie as Watched -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?php echo $movie['id'] ?>">
                        <button class="undo" type="submit" name="unset_watched_movie">Not Watched</button>
                    </form>
                <?php endif; ?>

                <!-- Delete Movie -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $movie['id'] ?>">
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