<?php
// Include connection script, but also initiate a connection to rx db for default display
require "dbconnection.php";
$conn = connect_to_db("digidec_rx_log");
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DigiDEC Alerts</title>

    <!-- Bootstrap CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        <?php include 'css/digidec.css'; ?>
    </style>
</head>

<body>
    <div class="container">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded-3">
            <a class="navbar-brand px-3" href="/">DigiDEC</a>
            <button class="navbar-toggler mx-2 sticky-top" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown mx-1 px-3">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">Recieved Alerts</a>
                        <ul class="dropdown-menu" data-bs-theme="dark">
                            <li><a class="dropdown-item" href="/recieved.php">All Recieved Alerts</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTypeModal" data-origin="rx">Filter By Type</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByCatModal" data-origin="rx">Filter By Category</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTimeModal" data-origin="rx">Filter By Time</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByMonModal" data-origin="rx">Filter By Monitor</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-1 px-3">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Sent Alerts</a>
                        <ul class="dropdown-menu" data-bs-theme="dark">
                            <li><a class="dropdown-item" href="/sent.php">All Sent Alerts</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTypeModal" data-origin="tx">Filter By Type</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByCatModal" data-origin="tx">Filter By Category</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTimeModal" data-origin="tx">Filter By Time</a></li>
                        </ul>
                    </li>
                    <li class="nav-item mx-1 px-3">
                        <a class="nav-link" href="/stats.php">Alert Stats</a>
                    </li>
                    <li class="nav-item mx-1 px-3">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">About</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Mobile Menu Button -->
        <div class="hamburger-menu">
            <button class="btn btn-primary" id="mobileMenuToggle" data-bs-toggle="modal" data-bs-target="#mobileMenu"> 
                ☰
            </button>
        </div>
        <!-- End Mobile Menu Button -->

        <!-- Mobile Modal -->
        <div class="modal fade border-0" id="mobileMenu" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <!-- Vertical Navbar -->
                    <nav class="navbar navbar-expand navbar-dark bg-dark rounded-3">
                        <div class="container">
                            <ul class="navbar-nav flex-column">
                                <li class="nav-item dropdown mx-1 px-3">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">Recieved Alerts</a>
                                        <ul class="dropdown-menu" data-bs-theme="dark">
                                            <li><a class="dropdown-item" href="/recieved.php">All Recieved Alerts</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTypeModal" data-origin="rx">Filter By Type</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByCatModal" data-origin="rx">Filter By Category</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTimeModal" data-origin="rx">Filter By Time</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByMonModal" data-origin="rx">Filter By Monitor</a></li>
                                        </ul>
                                </li>
                                <li class="nav-item dropdown mx-1 px-3">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">Sent Alerts</a>
                                        <ul class="dropdown-menu" data-bs-theme="dark">
                                            <li><a class="dropdown-item" href="/sent.php">All Sent Alerts</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTypeModal" data-origin="tx">Filter By Type</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByCatModal" data-origin="tx">Filter By Category</a></li>
                                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#sortByTimeModal" data-origin="tx">Filter By Time</a></li>
                                        </ul>
                                </li>
                                <li class="nav-item mx-1 px-3">
                                    <a class="nav-link" href="/stats.php">Alert Stats</a>
                                </li>
                                <li class="nav-item mx-1 px-3">
                                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">About</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- End Vertical Navbar -->
                </div>
            </div>
        </div>
        <!-- End Mobile Modal -->

        <!-- Sort Type Modal -->
        <div class="modal fade" id="sortByTypeModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sortTypeModalTitle">Sort Alerts By Type</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form onsubmit="appendType(event)">
                        <div class="modal-body">
                            <div class="dropdown">
                                <select class="type-select form-select" id="#alertTypesDropdown">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Sort Type Modal -->

        <!-- Sort Cat Modal -->
        <div class="modal fade" id="sortByCatModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="sortCatModalTitle">Sort Alerts By Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form onsubmit="appendCat(event)">
                        <div class="modal-body">
                            <div class="dropdown">
                                <select class="cat-select form-select" id="#alertCatDropdown">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Sort Cat Modal -->

        <!-- Sort Time Modal -->
        <div class="modal fade" id="sortByTimeModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sortTimeModalTitle">Sort Alerts By Time</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form onsubmit="appendTime(event)">
                        <div class="modal-body row" id="timeModal">
                            <div class="year-dropdown dropdown col">
                                <select class="year-select form-select" id="#alertYearDropdown">
                                </select>
                            </div>
                            <div class="month-dropdown dropdown col">
                                <select class="month-select form-select" id="#alertMonthDropdown">
                                </select>
                            </div>
                            <div class="day-dropdown dropdown col">
                                <select class="day-select form-select" id="#alertDayDropdown">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Sort Time Modal -->

        <!-- Sort Mon Modal -->
        <div class="modal fade" id="sortByMonModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="sortMonModalTitle">Sort Recieved Alerts By Monitor</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form onsubmit="appendMon(event)">
                        <div class="modal-body">
                            <div class="dropdown">
                                <select class="mon-select form-select" id="#alertMonDropdown">
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
                </div>
            </div>
        </div>
        <!-- End Sort Mon Modal -->


        <!-- About Modal -->
        <div class="modal fade" id="aboutModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="card" id="aboutcard">
                        <div class="card-body text-light border-0 rounded-3">
                            <h2 class="card-title text-light my-1"><a href="https://github.com/trevor229/DigiDEC" target="_blank">DigiDEC</a> v2</h2>
                            <h5 class="card-subtitle text-light my-1">by trevor229</h5>
                            <P class="card-text text-light my-3">DigiDEC is software written in Python to enable SAGE EAS ENDEC users with a Lantronix or similar serial server device to log their sent and recieved emergency alerts to a web front end and SQL database</P>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <!-- End About Modal -->

        <!-- Main Content -->
        <h1 class="text-center my-4">Latest Recieved Alerts</h1>

        <?php
        try {
            // Fetch data from database in reverse order, newest alert at top
            $stmt = $conn->query("SELECT * FROM alerts ORDER BY TIMESTP DESC LIMIT 3");
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching data: " . $e->getMessage();
        }
        ?>
        <?php function getCardColor($type) {
            switch ($type) {
                case 'test':
                    return '#6cd46c'; // Green
                case 'warning':
                    return '#db4f4f'; // Red
                case 'watch':
                    return '#e09231'; // Orange
                case 'advisory':
                    return '#fcea4c'; // Yellow
                default:
                    return '#c9c9c9'; // Default background if TYPE is not recognized
            }
        } ?>
        <!-- Displaying Data in Cards -->
        <div class="row" id="alertcards">
            <?php foreach ($data as $item): ?>
                <div class="col-md-12" id="alertdiv">
                    <div class="card alertcard border-0 rounded-3">
                        <div class="card-body rounded-3" style="background-color: <?php echo getCardColor($item['TYPE']); ?>">
                            <h4 class="card-title"><strong><?php echo $item['EVENT_TXT']; ?></strong></h4>
                            <p class="card-text"><?php echo $item['DESCR']; ?></p>
                            <p class="text-black-50 small">Filter: <?php echo $item['FILTER']; ?></p>
                            <p class="text-black-50 small">Alert recieved at: <?php echo $item['TIMESTP']; ?> on MON <?php echo $item['MON']; ?></p>
                            <p class="text-black-50 small"><?php echo $item['ZCZC_STR']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- End Displaying Data in Cards -->
        </div>

        <!-- No Alerts Card -->
        <div class="row" id="noalerts" style="display: none;">
            <div class="col-md-12">
                <div class="card border-0 rounded-3">
                    <div class="card-body rounded-3" style="background-color: var(--bs-gray-400)">
                        <h4 class="card-title">No Alerts Found</strong></h4>
                        <p class="card-text">The database does not have any entries matching the query</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End No Alerts Card -->

        <script>
            if (document.getElementById('alertdiv') == null) {
                document.getElementById('noalerts').setAttribute('style', "display: block;")
            }
        </script>

        <!-- End Main Content -->

        <script src="/js/popper.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/jquery-3.7.1.min.js"></script>
        <script src="/js/modaltypetext.js"></script>
        <script src="/js/appendsortingparams.js"></script>
        <script src="/js/loaddropdowndata.js"></script>
    </div>
</body>
</html>

<?php
// Close database connection
$conn = null;
?>