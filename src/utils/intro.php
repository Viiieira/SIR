<?php

function returnIntroData ($conn) {
  $sql = "SELECT * FROM tblHeader";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>