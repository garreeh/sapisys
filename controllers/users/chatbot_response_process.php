<?php

include '../../connections/connections.php';

function fetch_response()
{
  global $conn; // Use the global $conn for the database connection

  $kw = $_POST['kw']; // Get the keyword from POST data
  $sql = "SELECT * FROM `response_list` WHERE id IN (SELECT response_id FROM `keyword_list` WHERE `keyword` = '{$kw}')";
  $resp['sql'] = $sql;
  $qry = $conn->query($sql);

  if ($qry) {
    if ($qry->num_rows > 0) {
      $result = $qry->fetch_array();
      $resp['status'] = 'success';
      $resp['response'] = $result['response'];

      // Fetch suggestions for the response ID
      $sg_qry = $conn->query("SELECT DISTINCT response_id, suggestion FROM `suggestion_list`");
      if ($sg_qry->num_rows > 0) {
        $suggestions = array_column($sg_qry->fetch_all(MYSQLI_ASSOC), 'suggestion');
      } else {
        $suggestions = isset($_settings['suggestion']) && $_settings['suggestion'] != "" ? json_decode($_settings['suggestion']) : [];
      }
      $resp['suggestions'] = $suggestions;

      // Get client IP address
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $client = $_SERVER['HTTP_CLIENT_IP'];
      } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $client = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
        $client = $_SERVER['REMOTE_ADDR'];
      }

      // Log the fetched keyword with client IP
      $conn->query("INSERT INTO `keyword_fetched` SET `response_id` = '{$result['id']}', `client` = '{$client}'");
    } else {
      $resp['status'] = 'success';
      $resp['response'] = isset($_settings['no_answer']) ? $_settings['no_answer'] : "No answer found.";
    }
  } else {
    $resp['status'] = "failed";
    $resp['msg'] = $conn->error;
  }

  return json_encode($resp);
}

// Execute the function if called
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  echo fetch_response();
}
