<?php
$conn = new mysqli('localhost', 'root', '', 'sigh'); // Ganti dengan kredensial database Anda

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fetch categories for dropdown
$categorySql = "SELECT * FROM Kategori";
$categoryResult = $conn->query($categorySql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuesioner</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Styling tambahan (opsional) */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        label, select {
            display: block;
            margin-bottom: 10px;
        }
        input[type="radio"], input[type="text"], input[type="file"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <!-- Dropdown for selecting category -->
    <label for="kategori">Pilih Kategori:</label>
    <select id="kategori" name="kategori">
        <option value="">Pilih Kategori</option>
        <?php
        if ($categoryResult->num_rows > 0) {
            while ($categoryRow = $categoryResult->fetch_assoc()) {
                echo "<option value='{$categoryRow['id_kategori']}'>{$categoryRow['kategori']}</option>";
            }
        }
        ?>
    </select>

    <div id="questionnaireContainer">
        <!-- AJAX akan memuat konten di sini -->
    </div>

<script>
$(document).ready(function(){
    // Fungsi untuk menyimpan jawaban ke localStorage
    function saveAnswers() {
        // Ambil kategori yang dipilih
        var id_kategori = $('#kategori').val();
        if (!id_kategori) return;

        // Ambil semua input dalam container
        $('#questionnaireContainer').find('input, textarea, select').each(function(){
            var id = $(this).attr('name') || $(this).attr('id');
            if (id) {
                if ($(this).attr('type') === 'radio') {
                    if ($(this).is(':checked')) {
                        localStorage.setItem(id, $(this).val());
                    }
                } else if ($(this).attr('type') === 'file') {
                    // File tidak dapat disimpan di localStorage
                    // Anda bisa mengabaikan atau mengatur ulang jika diperlukan
                } else {
                    localStorage.setItem(id, $(this).val());
                }
            }
        });
    }

    // Fungsi untuk memuat jawaban dari localStorage
    function loadAnswers() {
        $('#questionnaireContainer').find('input, textarea, select').each(function(){
            var id = $(this).attr('name') || $(this).attr('id');
            if (id) {
                var savedValue = localStorage.getItem(id);
                if (savedValue !== null) {
                    if ($(this).attr('type') === 'radio') {
                        if ($(this).val() === savedValue) {
                            $(this).prop('checked', true);
                        }
                    } else {
                        $(this).val(savedValue);
                    }
                }
            }
        });
    }

    // Ketika kategori dipilih
    $('#kategori').on('change', function() {
        // Simpan jawaban sebelum berpindah kategori
        saveAnswers();

        var id_kategori = $(this).val();
        
        if (id_kategori === "") {
            $('#questionnaireContainer').empty();
            return;
        }

        $.ajax({
            url: 'kuesioner.php', // File yang akan menangani permintaan
            type: 'POST',
            data: {id_kategori: id_kategori},
            success: function(data) {
                $('#questionnaireContainer').html(data); // Muat respons ke dalam container
                loadAnswers(); // Muat jawaban yang disimpan untuk kategori ini
            }
        });
    });

    // Delegasi event untuk menyimpan jawaban saat input berubah
    $('#questionnaireContainer').on('change', 'input, textarea, select', function(){
        saveAnswers();
    });

});
</script>

</body>
</html>

<?php
$conn->close();
?>
