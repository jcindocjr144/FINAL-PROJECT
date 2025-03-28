document.querySelectorAll('.exploreCarsLink').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        var availableCars = document.getElementById('availableCars');
        var dashboard = document.getElementById('dashboard');
        var profile = document.getElementById('profile');
        var driversTable = document.getElementById('driversTable');
        if (availableCars.style.display === "none" || availableCars.style.display === "") {
            availableCars.style.display = "block"; 
            dashboard.style.display = "none";
            profile.style.display = "none";
            driversTable.style.display = "none";
        } else {
            availableCars.style.display = "block"; 
        }
    });
});

document.querySelectorAll('.exploreProfileLink').forEach(function(button) {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        var profile = document.getElementById('availableCars');
        var dashboard = document.getElementById('dashboard');
        var profile = document.getElementById('profile');
        var driversTable = document.getElementById('driversTable');
        if (profile.style.display === "none" || profile.style.display === "") {
            profile.style.display = "block"; 
            dashboard.style.display = "none";
            available.style.display = "none";
            driversTable.style.display = "none";
        } else {
            profile.style.display = "block"; 
        }
    });
});

document.getElementById('rentCarLink').addEventListener('click', function(event) {
    event.preventDefault();
    var availableCars = document.getElementById('availableCars');
    var driversTable = document.getElementById('driversTable');
    if (availableCars.style.display === "none" || availableCars.style.display === "") {
        availableCars.style.display = "block"; 
        dashboard.style.display = "none";
        profile.style.display = "none";
        driversTable.style.display = "none";
    } else {
        availableCars.style.display = "block"; 
    }
});

document.getElementById('profileLink').addEventListener('click', function(event) {
    event.preventDefault();
    var profileSection = document.getElementById('profile');
    var availableCars = document.getElementById('availableCars');
    if (profileSection.style.display === "none" || profileSection.style.display === "") {
        profileSection.style.display = "block";
        availableCars.style.display = "none"; 
        driversTable.style.display = "none";
        dashboard.style.display = "none";
    } else {
        profileSection.style.display = "block";
    }
});

document.getElementById('dashboardLink').addEventListener('click', function(event) {
    event.preventDefault();
    var dashboardSection = document.getElementById('dashboard');
    var profileSection = document.getElementById('profile');
    var availableCars = document.getElementById('availableCars');
    if (dashboardSection.style.display === "none" || dashboardSection.style.display === "") {
        dashboardSection.style.display = "block";
        profileSection.style.display = "none";
        availableCars.style.display = "none"; 
        driversTable.style.display = "none";
    } else {
        dashboardSection.style.display = "block";
    }
});

document.getElementById('viewDriversLink').addEventListener('click', function(event) {
    event.preventDefault();
    var driversTable = document.getElementById('driversTable');
    var dashboardSection = document.getElementById('dashboard');
    if (driversTable.style.display === "none" || driversTable.style.display === "") {
        driversTable.style.display = "block";
        dashboardSection.style.display = "none";
        profileSection.style.display = "none";
        availableCars.style.display = "none"; 
        fetchDrivers();
    } else {
        driversTable.style.display = "block";
    }
});

function fetchDrivers() {
    fetch('getDrivers.php')
        .then(response => response.json())
        .then(data => {
            var driversList = document.getElementById('driversList');
            driversList.innerHTML = '';
            
            if (data.length === 0) {
                driversList.innerHTML = '<tr><td colspan="3">No drivers found</td></tr>';
                return;
            }

            data.forEach(driver => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${driver.first_name}</td>
                    <td>${driver.middle_name}</td>
                    <td>${driver.last_name}</td>
                `;
                driversList.appendChild(row);
            });
        })
        .catch(error => {
            console.error('Error fetching drivers:', error);
            var driversList = document.getElementById('driversList');
            driversList.innerHTML = '<tr><td colspan="3">Error fetching drivers</td></tr>';
        });
}

