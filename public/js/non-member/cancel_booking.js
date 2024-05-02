
    function showConfirmDialog() {
        document.getElementById('confirmPopup').style.display = 'flex';
    }

    function hideConfirmDialog() {
        document.getElementById('confirmPopup').style.display = 'none';
    }

    function cancelBooking() {
        alert('Booking Cancelled!');
        // You can add further logic here to handle booking cancellation
        // For example, sending an AJAX request to the server
        // to update the booking status in the database.
    }

    document.getElementById('bookingForm').addEventListener('submit', function(event) {
        event.preventDefault();
        document.querySelector('.right').style.display = 'block';
    });