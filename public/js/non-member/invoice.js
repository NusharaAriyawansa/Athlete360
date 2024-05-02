// Function to display confirmation after 6 seconds
function displayConfirmation() {
    setTimeout(function() {
        var result = confirm("Do you want to Print the invoice?");
        if (result) {
            // Redirect to another page
            window.print();
        } else {
            // Do something else or stay on the same page
            alert("You Don't want to print!!");
        }
    }, 4000); // 6 seconds delay
}

displayConfirmation();
