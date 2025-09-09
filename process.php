<?php

// Replace with your Telegram bot token and chat ID
// $telegram_token = 'YOUR_TELEGRAM_BOT_TOKEN';
// $telegram_chat_id = 'YOUR_TELEGRAM_CHAT_ID';

// Email settings
$to_email = 'your_email@example.com';
$subject = 'Appointment booked';

// Get form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = sanitize_input($_POST["first_name"]);
    $last_name = sanitize_input($_POST["last_name"]);
    $phone_number = sanitize_input($_POST["phone_number"]);
    $purpose = sanitize_input($_POST["purpose"]);
    $address = sanitize_input($_POST["address"]);

    // Construct message for email
    $email_message = "Appointment details:\n\n";
    $email_message .= "First Name: $first_name\n";
    $email_message .= "Last Name: $last_name\n";
    $email_message .= "Phone Number: $phone_number\n";
    $email_message .= "Purpose: $purpose\n";
    $email_message .= "Address: $address\n";

    // Send email
    $headers = "From: your_email@example.com\r\n";
    $headers .= "Reply-To: your_email@example.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    mail($to_email, $subject . " " . $first_name, $email_message, $headers);

    // Send message to Telegram
    $telegram_message = "Appointment booked:\n";
    $telegram_message .= "First Name: $first_name\n";
    $telegram_message .= "Last Name: $last_name\n";
    $telegram_message .= "Phone Number: $phone_number\n";
    $telegram_message .= "Purpose: $purpose\n";
    $telegram_message .= "Address: $address\n";

    $telegram_url = "https://api.telegram.org/bot$telegram_token/sendMessage?chat_id=$telegram_chat_id&text=" . urlencode($telegram_message);
    file_get_contents($telegram_url); // Send message to Telegram bot

    // Redirect to another page after submission
    header("Location: thank_you.html"); // Replace with your actual thank you page URL
    exit(); // Ensure no further code is executed
}

// Function to sanitize form inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
