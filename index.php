<?php
    include "partials/header.php";
    include "partials/notifications.php";
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
        <li class="completed">
            <span class="completed">Sample Movie</span>
            <div>
                <!-- Watched Movie -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="1">
                    <button class="complete" type="submit" name="watched_movie">Watched</button>
                </form>

                <!-- Undo Watched Movie -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="1">
                    <button class="undo" type="submit" name="undo_watched_movie">Undo</button>
                </form>

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
    </ul>
</div>

<?php
include "partials/footer.php";
?>