<?php
    include "partials/header.php";
    include "partials/notifications.php";
    include "config/Database.php";
    include "classes/Movie.php";
    session_start();    // using Sessions to display messages

$database = new Database();
$db = $database->connect();

$movie = new Movie($db);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["add_movie"])) {
        $movie->title = $_POST["movie"];
        $a = $movie->create();
        $_SESSION["message"] = "Movie added successfully!";
        $_SESSION["message_class"] = "success";
    }
    elseif (isset($_POST["watched_movie"])) {
        $movie->set_watched($_POST['id']);
        $_SESSION["message"] = "Movie marked as watched!";
        $_SESSION["message_class"] = "success";
    }
    elseif (isset($_POST["unset_watched_movie"])) {
        $movie->unset_watched($_POST['id']);
        $_SESSION["message"] = "Movie reset to not watched!";
        $_SESSION["message_class"] = "success";
    }
    elseif (isset($_POST["delete_movie"])) {
        $movie->delete($_POST['id']);
        $_SESSION["message"] = "Movie deleted successfully!";
        $_SESSION["message_class"] = "success";
    }
}

// Fetching movie details
$movies = $movie->read();
?>
<!-- Notification Container -->
<?php if(isset ($_SESSION['message'])): ?>
    <div class="notification-container">
        <div class="notification <?php echo $_SESSION['message_class']; ?> ">
            <?php echo $_SESSION["message"];?>
            <?php unset($_SESSION["message"]); //unsetting the message so that it won't reappear?>
            <?php unset($_SESSION["message_class"]); ?>
        </div>
    </div>
<?php endif; ?>


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
                <form onsubmit="return confirmDelete()" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $movie['id'] ?>">
                    <button class="delete" type="submit" name="delete_movie">Delete</button>
                </form>
            </div>
        </li>
        <?php endwhile; ?>
    </ul>
</div>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete?")
        }
    </script>

<?php
include "partials/footer.php";
?>