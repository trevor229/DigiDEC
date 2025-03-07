<?php
// Include connection script
require "dbconnection.php";
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
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
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
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
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
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
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
        <h1 class="text-center my-4">Alert Statistics</h1>
        
        <?php
            try {
                // Fetch data from database in reverse order, newest alert at top
                $conn = connect_to_db("digidec_rx_log");
                $monitornums = $conn->query("SELECT DISTINCT mon as monitor FROM alerts");
                $mnum = $monitornums->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error fetching data: " . $e->getMessage();
            }
            $conn = connect_to_db("digidec_rx_log");
            $rxKitchenSink = "SELECT 
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'warning') AS warning_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'watch') AS watch_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'advisory') AS advisory_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'test') AS test_count,
                    (SELECT COUNT(*) FROM alerts) AS total_count,
                    (SELECT DATE(TIMESTP) FROM alerts GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1) AS most_active_date,
    				(SELECT COUNT(*) FROM alerts WHERE DATE(TIMESTP) = (SELECT DATE(TIMESTP) FROM alerts WHERE mon = '#1' GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1)) AS most_active_count,
                    (SELECT MON FROM alerts GROUP BY MON ORDER BY COUNT(*) DESC LIMIT 1) AS most_active_channel";

            $rxResult = $conn->query($rxKitchenSink);
            $rxFetched = $rxResult->fetch(PDO::FETCH_ASSOC);

            $conn = connect_to_db("digidec_tx_log");
            $txKitchenSink = "SELECT 
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'warning') AS warning_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'watch') AS watch_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'advisory') AS advisory_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'test') AS test_count,
                    (SELECT COUNT(*) FROM alerts) AS total_count,
                    (SELECT DATE(TIMESTP) FROM alerts GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1) AS most_active_date,
    				(SELECT COUNT(*) FROM alerts WHERE DATE(TIMESTP) = (SELECT DATE(TIMESTP) FROM alerts GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1)) AS most_active_count";

            $txResult = $conn->query($txKitchenSink);
            $txFetched = $txResult->fetch(PDO::FETCH_ASSOC);

            function monQueryBuilder($monnum){
                $conn = connect_to_db("digidec_rx_log");
                $monQuery = "SELECT 
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'warning' AND mon = '{$monnum}') AS mon_warning_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'watch' AND mon = '{$monnum}') AS mon_watch_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'advisory' AND mon = '{$monnum}') AS mon_advisory_count,
                    (SELECT COUNT(*) FROM alerts WHERE TYPE = 'test' AND mon = '{$monnum}') AS mon_test_count,
                    (SELECT COUNT(*) FROM alerts WHERE mon = '{$monnum}') AS mon_total_count,
                    (SELECT DATE(TIMESTP) FROM alerts WHERE mon = '{$monnum}' GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1) AS mon_most_active_date,
    				(SELECT COUNT(*) FROM alerts WHERE DATE(TIMESTP) = (SELECT DATE(TIMESTP) FROM alerts WHERE mon = '{$monnum}' GROUP BY DATE(TIMESTP) ORDER BY COUNT(*) DESC LIMIT 1)) AS mon_most_active_count";

                $monResult = $conn->query($monQuery);
                $monFetched = $monResult->fetch(PDO::FETCH_ASSOC);
                return $monFetched;
            }
        ?>
        <div class="statsdiv border-0 row g-0" id="statsmain">
            <div class="row g-0" id="rxtxstats">
                <div class="card statcard rounded-3 p-0 col" style="width: 18rem;">
                    <div class="card-body rounded-3">
                        <h5 class="card-title text-reset card-stat-text-white">Recieved Alerts</h5>
                        <p class="card-text text-reset">Total of all recieved alerts in the database</p>
                        <p class="card-text text-reset">Most active day: <?php echo $rxFetched['most_active_date'] ?> (<?php echo $rxFetched['most_active_count'] ?> alerts)</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0" style="background-color: #db4f4f">Warnings:<P class="float-end m-0"><?php echo $rxFetched['warning_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #e09231">Watches:<P class="float-end m-0"><?php echo $rxFetched['watch_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #fcea4c">Advisories:<P class="float-end m-0"><?php echo $rxFetched['advisory_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #6cd46c">Tests:<P class="float-end m-0"><?php echo $rxFetched['test_count'] ?></P></li>
                        <li class="list-group-item border-top" style="background-color:rgb(108, 179, 212)">Total:<P class="float-end m-0"><?php echo $rxFetched['total_count'] ?></P></li>
                    </div>


                <div class="card statcard rounded-3 p-0 col" style="width: 18rem;">
                    <div class="card-body rounded-3">
                        <h5 class="card-title text-reset card-stat-text-white">Sent Alerts</h5>
                        <p class="card-text text-reset">Total of all sent alerts in the database</p>
                        <p class="card-text text-reset">Most active day: <?php echo $txFetched['most_active_date'] ?> (<?php echo $txFetched['most_active_count'] ?> alerts)</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0" style="background-color: #db4f4f">Warnings:<P class="float-end m-0"><?php echo $txFetched['warning_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #e09231">Watches:<P class="float-end m-0"><?php echo $txFetched['watch_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #fcea4c">Advisories:<P class="float-end m-0"><?php echo $txFetched['advisory_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #6cd46c">Tests:<P class="float-end m-0"><?php echo $txFetched['test_count'] ?></P></li>
                        <li class="list-group-item border-top" style="background-color:rgb(108, 179, 212)">Total:<P class="float-end m-0"><?php echo $txFetched['total_count'] ?></P></li>
                    </div>
            </div>

            <div class="monstatdiv border-0 row g-0" id="monstatdiv">
            <?php foreach ($mnum as $item): 
                // Run query once for each monitor
               $mqbResults = monQueryBuilder($item['monitor']);
            ?>
                <div class="card statcard rounded-3 p-0 col" style="width: 18rem;">
                    <div class="card-body rounded-3">
                        <h5 class="card-title text-reset card-stat-text-white">Monitor <?php echo $item['monitor']; ?></h5>
                        <p class="card-text text-reset">All Received alerts from Mon <?php echo $item['monitor']; ?></p>
                        <p class="card-text text-reset">Most active day: <?php echo $mqbResults['mon_most_active_date'] ?> (<?php echo $mqbResults['mon_most_active_count'] ?> alerts)</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item border-0" style="background-color: #db4f4f">Warnings:<P class="float-end m-0"><?php echo $mqbResults['mon_warning_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #e09231">Watches:<P class="float-end m-0"><?php echo $mqbResults['mon_watch_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #fcea4c">Advisories:<P class="float-end m-0"><?php echo $mqbResults['mon_advisory_count'] ?></P></li>
                        <li class="list-group-item border-0" style="background-color: #6cd46c">Tests:<P class="float-end m-0"><?php echo $mqbResults['mon_test_count'] ?></P></li>
                        <li class="list-group-item border-top" style="background-color:rgb(108, 179, 212)">Total:<P class="float-end m-0"><?php echo $mqbResults['mon_total_count'] ?></P></li>
                    </div>
            <?php endforeach; ?>       
            </div>
        </div>

        

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