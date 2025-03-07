function appendType(event) {
    event.preventDefault();
    const selectedValue = document.querySelector('.type-select').value;
    const dbref = document.querySelector('.type-select').querySelector('option').getAttribute("dbref");
    if (dbref == "rx") {
        window.location.href = window.location.origin + '/recieved.php?event_code=' + selectedValue;
    } else if (dbref == "tx"){
        window.location.href = window.location.origin + '/sent.php?event_code=' + selectedValue;
    } else {
        alert("Invalid ref")
    }
}

function appendCat(event) {
    event.preventDefault();
    const selectedValue = document.querySelector('.cat-select').value;
    const dbref = document.querySelector('.cat-select').querySelector('option').getAttribute("dbref");
    if (dbref == "rx") {
        window.location.href = window.location.origin + '/recieved.php?category=' + selectedValue;
    } else if (dbref == "tx"){
        window.location.href = window.location.origin + '/sent.php?category=' + selectedValue;
    } else {
        alert("Invalid ref")
    }
}

function appendTime(event) {
    console.log(event);
    event.preventDefault();
    const yearValue = document.querySelector('.year-select').value;
    const monthValue = document.querySelector('.month-select').value;
    const dayValue = document.querySelector('.day-select').value;
    const dbref = document.querySelector('.year-select').querySelector('option').getAttribute("dbref");
    if (dbref == "rx") {
        window.location.href = window.location.origin + '/recieved.php?year=' + yearValue + '&month=' + monthValue + '&day=' + dayValue;
    } else if (dbref == "tx"){
        window.location.href = window.location.origin + '/sent.php?year=' + yearValue + '&month=' + monthValue + '&day=' + dayValue;
    } else {
        alert("Invalid ref")
    }
}

function appendMon(event) {
    event.preventDefault();
    let selectedValue = document.querySelector('.mon-select').value;
    // Strip # from mon string to make browser happy
    selectedValue = selectedValue.replace(/^#/, '');

    const dbref = document.querySelector('.mon-select').querySelector('option').getAttribute("dbref");
    if (dbref == "rx") {
        window.location.href = window.location.origin + '/recieved.php?mon=' + selectedValue;
    } else {
        alert("Invalid ref")
    }
}