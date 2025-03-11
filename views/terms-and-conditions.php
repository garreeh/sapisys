<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms and Conditions - Veterinary Appointment System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 800px;
      margin: 50px auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1,
    h2 {
      color: #2c3e50;
    }

    p {
      color: #555;
    }

    .footer {
      margin-top: 20px;
      font-size: 14px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Terms and Conditions</h1>
    <p>Welcome to our Veterinary Appointment System. Please read the following terms and conditions carefully before using our services.</p>

    <h2>1. Appointment Booking</h2>
    <p>All appointments are subject to availability. You must provide accurate information when booking an appointment.</p>

    <h2>2. Cancellations & Rescheduling</h2>
    <p>If you need to cancel or reschedule, please do so at least 24 hours in advance. Failure to notify may result in penalties.</p>

    <h2>3. Pet Health Responsibility</h2>
    <p>We ensure the best care for your pet, but the responsibility for their overall health remains with the owner.</p>

    <h2>4. Payments & Fees</h2>
    <p>All services must be paid in full at the time of the appointment. Additional charges may apply for emergency cases.</p>

    <h2>5. Privacy & Data Protection</h2>
    <p>Your personal data will be handled with strict confidentiality and will not be shared with third parties.</p>

    <div class="footer">
      <p>&copy; <?php echo date("Y"); ?> Veterinary Appointment System. All Rights Reserved.</p>
    </div>
  </div>
</body>

</html>