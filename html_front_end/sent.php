<?php
// Include connection script, but also initiate a connection to rx db for default display
require "dbconnection.php";

function parse_and_validate_parameters() {
    global $dbc;

    // Initialize parameters
    $params = array(
        'year' => $_GET['year'] ?? null,
        'month' => $_GET['month'] ?? null,
        'day' => $_GET['day'] ?? null,
        'category' => $_GET['category'] ?? null,
        'mon' => $_GET['mon'] ?? null, // MON column in the database
        'event_code' => $_GET['event_code'] ?? null // EVENT_CODE column in the database
    );

    // Validate each parameter if present
    foreach ($params as $key => $value) {
        if ($value !== null) {
            if (!validate_parameter($key, $value)) {
                die("Invalid value for parameter: $key");
            }
        }
    }

    return $params;
}

function validate_parameter($key, $value) {
    global $dbc;

    // Validate based on the parameter and column type
    switch ($key) {
        case 'year':
            if (!ctype_digit((string)$value) || strlen((string)$value) !== 4) {
                return false;
            }
            break;
        case 'month':
            if (!ctype_digit((string)$value) || !(1 <= $value && $value <= 12)) {
                return false;
            }
            break;
        case 'day':
            if ((1 <= $value && $value <= 31) || $value == "all") {
                break;
            } else {
                return false;
            }
        case 'mon':
            // Up to 6 monitor channels on endec
            if (!ctype_digit((string)$value) || !(1 <= $value && $value <= 6)) {
                return false;
            }
            break;

        case 'event_code':
            if (!ctype_upper((string)$value) || !(strlen(ctype_upper((string)$value))) == 3) {
                return false;
            }
            break;

        case 'category':
            if ($value == "warning" || $value == "watch" || $value == "advisory" || $value == "test") {
                break;
            } else {
                return false; 
            } 

        }

    return true;
}

function get_available_values($column) {
    global $dbc;

    // Get unique values for a given column
    $stmt = $dbc->prepare("SELECT DISTINCT $column FROM alerts");
    $stmt->execute();
    $result = $stmt->get_result();

    $values = array();
    while ($row = $result->fetch_assoc()) {
        if (!empty($row[$column])) {
            $values[] = $row[$column];
        }
    }

    return $values;
}

function build_query_conditions($params) {

    $conditions = array();

    // Check for and add conditions for each parameter
    if ($params['year'] !== null) {
        $conditions[] = "YEAR(TIMESTP) = '" . (int)$params['year'] . "'";
    }
    if ($params['month'] !== null) {
        $conditions[] = "MONTH(TIMESTP) = '" . (int)$params['month'] . "'";
    }
    if ($params['day'] !== null) {
        if ($params['day'] !== "all") {
            $conditions[] = "DAY(TIMESTP) = '" . (int)$params['day'] . "'";
        }
    }
    if ($params['mon'] !== null) {
        $conditions[] = "MON = '" . "#" . (int)$params['mon'] . "'";
        }
    if ($params['event_code'] !== null) {
        $conditions[] = "EVENT_CODE = '" . $params['event_code'] . "'";
    }
    if ($params['category'] !== null) {
        $conditions[] = "TYPE = '" . $params['category'] . "'";
    }
    // Take all applicable parameters and combine them to append to the query
    return implode(" AND ", $conditions);
}

function getCardColor($type) {
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

}

// Main execution

global $dbc;
$dbc = connect_to_db('digidec_tx_log');

$params = parse_and_validate_parameters();

$query_conditions = build_query_conditions($params);

$sql = "SELECT * FROM alerts";
if (!empty($query_conditions)) {
    $sql .= " WHERE " . $query_conditions . " ORDER BY TIMESTP DESC";
} else {
    $sql .= " ORDER BY TIMESTP DESC";
}

$stmt = $dbc->prepare($sql);
$stmt->execute();

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
        <h1 class="text-center my-4" id="titletext">Filtered Sent Alerts</h1>

        <!-- Displaying Data in Cards -->
        <div class="row" id="alertcards">
            <?php foreach ($stmt as $item): ?>
                <div class="col-md-12" id="alertdiv">
                    <div class="card alertcard border-0 rounded-3">
                        <div class="card-body rounded-3" style="background-color: <?php echo getCardColor($item['TYPE']); ?>">
                            <h4 class="card-title"><strong><?php echo $item['EVENT_TXT']; ?></strong></h4>
                            <p class="card-text"><?php echo $item['DESCR']; ?></p>
                            <p class="text-black-50 small">Alert recieved at: <?php echo $item['TIMESTP']; ?></p>
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

        <!-- End Main Content -->

        <script>
            if (document.getElementById('alertdiv') == null) {
                document.getElementById('noalerts').setAttribute('style', "display: block;")
            } else {
                let alertCount = document.getElementById('alertcards').childElementCount
                document.getElementById('titletext').innerHTML += ` <span class="badge bg-dark">${alertCount}</span>`
            }
        </script>

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