window.addEventListener('DOMContentLoaded', (event) => {
    
    var modal = document.getElementById("identityModal");
    var identityClick = document.getElementById("identityAdd"); 
    var span = document.getElementsByClassName("close")[0];

    var contactClick = document.getElementById("contactAdd"); 
    var contactModal = document.getElementById("contactModal");
    var cspan = document.getElementsByClassName("contactClose")[0];

    var guardianContactClick = document.getElementById("contactAddGuardian");
    var guardianContactModal = document.getElementById("guardianContactModal");
    var gspan = document.getElementsByClassName("guardianContactClose")[0];

    var qualificationClick = document.getElementById("qualificationAdd"); 
    var qualificationModal = document.getElementById("qualificationModal");
    var qspan = document.getElementsByClassName("qualificationClose")[0];

    if (identityClick && modal) {
    identityClick.onclick = function() {
        modal.style.display = "block";
    };
}
    identityClick.onclick = function() {
        modal.style.display = "block";
    }

    contactClick.onclick = function() {
        contactModal.style.display = "block";
    }

    if (guardianContactClick && guardianContactModal) {
    guardianContactClick.onclick = function() {
        guardianContactModal.style.display = "block";
    }
}

  if (qualificationClick && qualificationModal) {
    qualificationClick.onclick = function () {
        qualificationModal.style.display = "block";
    }
}

    span.onclick = function() {
        modal.style.display = "none";
    }

    cspan.onclick = function() {
        contactModal.style.display = "none";
    }

     if (gspan && guardianContactModal) {
    gspan.onclick = function() {
        guardianContactModal.style.display = "none";
    }
}
    qspan.onclick = function() {
        qualificationModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }else if (event.target == contactModal) {
            contactModal.style.display = "none";
        }else if (event.target == guardianContactModal) {
            guardianContactModal.style.display = "none";
        }else if (event.target == qualificationModal) {
            contactModal.style.display = "none";
        }
    }
});
