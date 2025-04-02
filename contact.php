<?php
// Initialize variables to store the submitted form data
$name = $email = $message = "";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data from the POST request and sanitize it
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Send email (you can configure your email and subject here)
    $to = "your-email@example.com"; // Replace with your email address
    $subjectEmail = "New Contact Form Submission from $name";
    $body = "You have received a new message from $name.\n\n".
            "Email: $email\n\n".
            "Message: $message";
    $headers = "From: $email";

    // Send the email and show a success or error message
    if (mail($to, $subjectEmail, $body, $headers)) {
        $successMessage = "Your message has been sent successfully!";
    } else {
        $errorMessage = "Oops! Something went wrong and we couldn't send your message.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            max-width: 600px;
            margin-top: 50px;
            margin-left: 250px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="photos.php">Photos</a></li>
            <li><a href="bio.php">Bio</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="contact.php" class="active">Contact</a></li>
        </ul>
        <div class="social-icons">
            <a href="https://facebook.com" target="_blank" class="text-light mr-2"><i class="fab fa-facebook fa-2x"></i></a>
            <a href="https://instagram.com" target="_blank" class="text-light mr-2"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="https://twitter.com" target="_blank" class="text-light"><i class="fab fa-twitter fa-2x"></i></a>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="container">
        <h2 class="text-center">Contact</h2>

        <?php
        // Display success or error message
        if (isset($successMessage)) {
            echo "<p class='text-success text-center'>$successMessage</p>";
        } elseif (isset($errorMessage)) {
            echo "<p class='text-danger text-center'>$errorMessage</p>";
        }
        ?>

        <form action="contact.php" method="POST">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" value="<?php echo $name; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo $email; ?>" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" placeholder="Your message" required><?php echo $message; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>

