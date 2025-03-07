function loadAlertTypes() {
    // Add event listeners for the filter buttons in the navbar
    document.querySelectorAll('[data-bs-target="#sortByTypeModal"]').forEach(button => {
    if (button.dataset.bsTarget === '#aboutModal') {
        return;  // Exit the loop for this button
    }
    button.addEventListener('click', (e) => {
        //e.preventDefault(); // Prevent the default link behavior
        const origin = button.dataset.origin; // Get the data-origin value

        // Make an AJAX call to get_alert_types.php with the db parameter based on data-origin
        fetch(`get_alert_types.php?db=${origin}`)
        // Take response and read into a string
            .then(response => response.text())
            .then(html => {
                const dropdown = document.querySelector('.type-select');
                dropdown.innerHTML = html;
            });
        });
    });
}

// Load initial alert types when page loads
loadAlertTypes();

function loadTimes() {
// Add event listeners for the filter buttons in the navbar
document.querySelectorAll('[data-bs-target="#sortByTimeModal"]').forEach(button => {
if (button.dataset.bsTarget === '#aboutModal') {
    return;  // Exit the loop for this button
}
    button.addEventListener('click', (e) => {
        //e.preventDefault(); // Prevent the default link behavior
        const origin = button.dataset.origin; // Get the data-origin value

        // Make an AJAX call to get_alert_types.php with the db parameter based on data-origin
        fetch(`get_years.php?db=${origin}`)
        // Take response and read into a string
            .then(response => response.text())
            .then(html => {
                const dropdown = document.querySelector('.year-select');
                dropdown.innerHTML = html;
            });
        fetch(`get_months.php?db=${origin}`)
        // Take response and read into a string
            .then(response => response.text())
            .then(html => {
                const dropdown = document.querySelector('.month-select');
                dropdown.innerHTML = html;
            })

        fetch(`get_days.php?db=${origin}`)
        // Take response and read into a string
            .then(response => response.text())
            .then(html => {
                const dropdown = document.querySelector('.day-select');
                dropdown.innerHTML = html;
            })
    });
});
}
// Load initial alert types when page loads
loadTimes();

function loadMonitors() {
// Add event listeners for the filter buttons in the navbar
document.querySelectorAll('[data-bs-target="#sortByMonModal"]').forEach(button => {
if (button.dataset.bsTarget === '#aboutModal') {
    return;  // Exit the loop for this button
}
button.addEventListener('click', (e) => {
    //e.preventDefault(); // Prevent the default link behavior
    const origin = button.dataset.origin; // Get the data-origin value

    // Make an AJAX call to get_alert_types.php with the db parameter based on data-origin
    fetch(`get_mon.php?db=${origin}`)
    // Take response and read into a string
        .then(response => response.text())
        .then(html => {
            const dropdown = document.querySelector('.mon-select');
            dropdown.innerHTML = html;
        });
    });
});
}

// Load initial alert types when page loads
loadMonitors();


function loadAlertCategory() {
    // Add event listeners for the filter buttons in the navbar
    document.querySelectorAll('[data-bs-target="#sortByCatModal"]').forEach(button => {
    if (button.dataset.bsTarget === '#aboutModal') {
        return;  // Exit the loop for this button
    }
    button.addEventListener('click', (e) => {
        //e.preventDefault(); // Prevent the default link behavior
        const origin = button.dataset.origin; // Get the data-origin value

        // Make an AJAX call to get_alert_types.php with the db parameter based on data-origin
        fetch(`get_alert_category.php?db=${origin}`)
        // Take response and read into a string
            .then(response => response.text())
            .then(html => {
                const dropdown = document.querySelector('.cat-select');
                dropdown.innerHTML = html;
            });
        });
    });
}

// Load initial alert types when page loads
loadAlertCategory();

// Load new alert types when database selection changes
/*document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', (e) => {
        //e.preventDefault();
        const db = e.target.value;
        loadAlertCategory(db);
    });
});*/