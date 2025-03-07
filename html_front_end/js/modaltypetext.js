$(document).ready(function() {
    // Store the title value when a dropdown item is clicked
    let sortType = '';

        // Listen for show event on the modal
        $('#sortByTypeModal').on('show.bs.modal', function (e) {
            // Get the element that triggered the modal
            const triggerElement = $(e.relatedTarget);
            
            // Extract the title from the data attribute
            modalTitle = triggerElement.data('origin');
            // Update the modal title
            if (modalTitle == "rx") {
                $('#sortTypeModalTitle').text("Sort Recieved Alerts by Type");
            } else if (modalTitle == "tx") {
                $('#sortTypeModalTitle').text("Sort Sent Alerts by Type");
            } else {
                $('#sortTypeModalTitle').text("Sort Alerts by Type");
            }
        });
        $('#sortByCatModal').on('show.bs.modal', function (e) {
            // Get the element that triggered the modal
            const triggerElement = $(e.relatedTarget);
            
            // Extract the title from the data attribute
            modalTitle = triggerElement.data('origin');
            // Update the modal title
            if (modalTitle == "rx") {
                $('#sortCatModalTitle').text("Sort Recieved Alerts by Category");
            } else if (modalTitle == "tx") {
                $('#sortCatModalTitle').text("Sort Sent Alerts by Category");
            } else {
                $('#sortCatModalTitle').text("Sort Alerts by Category");
            }
        });
        $('#sortByTimeModal').on('show.bs.modal', function (e) {
            // Get the element that triggered the modal
            const triggerElement = $(e.relatedTarget);
            
            // Extract the title from the data attribute
            modalTitle = triggerElement.data('origin');
            // Update the modal title
            if (modalTitle == "rx") {
                $('#sortTimeModalTitle').text("Sort Recieved Alerts by Time");
            } else if (modalTitle == "tx") {
                $('#sortTimeModalTitle').text("Sort Sent Alerts by Time");
            } else {
                $('#sortTimeModalTitle').text("Sort Alerts by Time");
            }
        });
    });