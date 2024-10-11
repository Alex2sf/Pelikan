<?php
// Database connection
include '../koneksi.php';

// Fetch data based on AJAX requests
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'fetch_kategori') {
        $sql = "SELECT id_kategori, kategori FROM kategori";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_kategori'] . "'>" . $row['kategori'] . "</option>";
        }
        exit();
    } elseif ($action === 'fetch_subkategori1' && isset($_GET['id_kategori'])) {
        $id_kategori = $_GET['id_kategori'];
        $sql = "SELECT id_subkategori1, subkategori1 FROM SubKategori1 WHERE id_kategori = $id_kategori";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_subkategori1'] . "'>" . $row['subkategori1'] . "</option>";
        }
        exit();
    } elseif ($action === 'fetch_subkategori2' && isset($_GET['id_subkategori1'])) {
        $id_subkategori1 = $_GET['id_subkategori1'];
        $sql = "SELECT id_subkategori2, subkategori2 FROM SubKategori2 WHERE id_subkategori1 = $id_subkategori1";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_subkategori2'] . "'>" . $row['subkategori2'] . "</option>";
        }
        exit();
    } elseif ($action === 'fetch_subkategori3' && isset($_GET['id_subkategori2'])) {
        $id_subkategori2 = $_GET['id_subkategori2'];
        $sql = "SELECT id_subkategori3, subkategori3 FROM SubKategori3 WHERE id_subkategori2 = $id_subkategori2";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id_subkategori3'] . "'>" . $row['subkategori3'] . "</option>";
        }
        exit();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori = $_POST['kategori'];
    $subkategori1 = $_POST['subkategori1'];
    $subkategori2 = $_POST['subkategori2'];
    $subkategori3 = $_POST['subkategori3'];
    $pertanyaan = $_POST['pertanyaan'];
    $bobot = $_POST['bobot'];
    $web = $_POST['web'];
    $sql = "INSERT INTO pertanyaan (pertanyaan, id_kategori, id_subkategori1, id_subkategori2, id_subkategori3,  bobot, web) 
            VALUES ('$pertanyaan', $kategori, $subkategori1, $subkategori2, $subkategori3, '$bobot', '$web')";
    $conn->query($sql);

    echo "Question added successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Question</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <form method="POST">
    <!-- Select Kategori -->
    <label for="kategori">Kategori:</label>
    <select id="kategori" name="kategori" required>
      <option value="">Select Kategori</option>
    </select><br><br>

    <!-- Select SubKategori1 -->
    <label for="subkategori1">SubKategori 1:</label>
    <select id="subkategori1" name="subkategori1" required>
      <option value="">Select SubKategori 1</option>
    </select><br><br>

    <!-- Select SubKategori2 -->
    <label for="subkategori2">SubKategori 2:</label>
    <select id="subkategori2" name="subkategori2" required>
      <option value="">Select SubKategori 2</option>
    </select><br><br>

    <!-- Select SubKategori3 -->
    <label for="subkategori3">SubKategori 3:</label>
    <select id="subkategori3" name="subkategori3" required>
      <option value="">Select SubKategori 3</option>
    </select><br><br>

    <!-- Pertanyaan Field -->
    <label for="pertanyaan">Pertanyaan:</label>
    <textarea id="pertanyaan" name="pertanyaan" required></textarea><br><br>


    <label for="bobot">Bobot</label>
    <textarea id="bobot" name="bobot" required></textarea><br><br>
    <label for="web">Web:</label>
    <textarea id="web" name="web" required></textarea><br><br>

    <!-- Submit Button -->
    <button type="submit">Add Question</button>
  </form>

  <script>
    // jQuery to populate Kategori dropdown on page load
    $(document).ready(function() {
      $.ajax({
        url: '?action=fetch_kategori',
        method: 'GET',
        success: function(data) {
          $('#kategori').append(data);
        }
      });

      // Update SubKategori1 based on Kategori selection
      $('#kategori').change(function() {
        var kategoriId = $(this).val();
        $('#subkategori1').html('<option value="">Select SubKategori 1</option>');
        $('#subkategori2').html('<option value="">Select SubKategori 2</option>');
        $('#subkategori3').html('<option value="">Select SubKategori 3</option>');
        if (kategoriId) {
          $.ajax({
            url: '?action=fetch_subkategori1&id_kategori=' + kategoriId,
            method: 'GET',
            success: function(data) {
              $('#subkategori1').append(data);
            }
          });
        }
      });

      // Update SubKategori2 based on SubKategori1 selection
      $('#subkategori1').change(function() {
        var subkategori1Id = $(this).val();
        $('#subkategori2').html('<option value="">Select SubKategori 2</option>');
        $('#subkategori3').html('<option value="">Select SubKategori 3</option>');
        if (subkategori1Id) {
          $.ajax({
            url: '?action=fetch_subkategori2&id_subkategori1=' + subkategori1Id,
            method: 'GET',
            success: function(data) {
              $('#subkategori2').append(data);
            }
          });
        }
      });

      // Update SubKategori3 based on SubKategori2 selection
      $('#subkategori2').change(function() {
        var subkategori2Id = $(this).val();
        $('#subkategori3').html('<option value="">Select SubKategori 3</option>');
        if (subkategori2Id) {
          $.ajax({
            url: '?action=fetch_subkategori3&id_subkategori2=' + subkategori2Id,
            method: 'GET',
            success: function(data) {
              $('#subkategori3').append(data);
            }
          });
        }
      });
    });
  </script>
</body>
</html>
