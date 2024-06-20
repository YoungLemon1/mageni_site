
<?php
function sendEmail($formData) {
    $apiKey = "";
    $apiSecret = "";
    $BASE_URL = "https://api.mailjet.com/v3.1";
    $fromMail = "faigitay@gmail.com";
    $fromName = "Itay Faig";
    $toEmail = 'itay@mageni.co.il';
    $toName = 'itay Mageni';
    
      // Extract data from formData
      $name = $formData['name'];
      $email = $formData['email'];
      $phone = $formData['phone'];
      $freeText = isset($formData['freeText']) ? $formData['freeText'] : '';
  
      // Set email subject as the name field from the form
      $subject = "New contact from $name";
      $textContent = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $freeText";
      $htmlContent = "<h1>New Contact Form Submission</h1><p><strong>Name:</strong> $name</p><p><strong>Email:</strong> $email</p><p><strong>Phone:</strong> $phone</p><p><strong>Message:</strong> $freeText</p>";
  
      $body = [
          'Messages' => [
              [
                  'From' => [
                      'Email' => $fromMail,
                      'Name' => $fromName,
                  ],
                  'To' => [
                      [
                          'Email' => $toEmail,
                          'Name' => $toName
                      ]
                  ],
                  'Subject' => $subject,
                  'TextPart' => $textContent,
                  'HTMLPart' => $htmlContent
              ]
          ]
      ];
  
      $ch = curl_init("$BASE_URL/send");
  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
          'Content-Type: application/json',
          'Authorization: Basic ' . base64_encode("$apiKey:$apiSecret")
      ]);
  
      $server_output = curl_exec($ch);
      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
  
      if ($server_output === false) {
          die('Error sending email: ' . curl_error($ch));
      } else {
          $responseData = json_decode($server_output, true);
          if ($httpcode == 200 && $responseData['Messages'][0]['Status'] == 'success') {
              echo 'Email has been sent successfully.';
              echo $responseData;
          } else {
              echo 'Failed to send email. Response: ' . print_r($responseData, true);
          }
      }
  }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use the $_POST superglobal to get form data
    sendEmail($_POST);
}
else
{
    echo "Could not process request";
}
?>
