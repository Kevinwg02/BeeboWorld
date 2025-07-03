<?php
function afficherNavbar()
{
    ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="library.php">📚 Ma Bibliothèque</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="public/public_stats.php">📈 Statistiques</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light px-3 py-1" data-bs-toggle="modal" data-bs-target="#pagesModal" href="#">📖 Pages lues</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="logout.php">🚪 Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}
?>


   <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container-fluid">
            <a class="navbar-brand" href="library.php">📚 Ma Bibliothèque</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link"href="library.php" >📚 Library</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                   <li class="nav-item">
                        <a class="nav-link"href="admin_book.php" >📚  Admin</a>
                    </li>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light px-3 py-1" data-bs-toggle="modal" data-bs-target="#pagesModal" href="#">📖 Pages lues</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    
       