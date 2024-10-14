<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rangking</title>
    <style>
        /* Styling to match previous examples */
        body {
            font-family: Arial, sans-serif;
            background-image: url(img/KKP.jpg);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #4535C1; /* Background color matching the theme */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            max-height: 90vh; /* Limit container height */
            overflow-y: auto; /* Scrollable if content exceeds height */
        }

        h1 {
            text-align: center;
            color: #ffffff; /* White text for contrast */
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            font-weight: 600; /* Bold labels */
            color: #ffffff; /* White label text */
        }

        input[type="text"], input[type="number"] {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #ffffff; /* White input fields */
            font-size: 16px;
            color: #333; /* Dark text */
            width: 100%;
        }

        button.submit-button {
            background-color: #4535C1; /* Match button color with the theme */
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.submit-button:hover {
            background-color: #2f2a8a; /* Darker shade on hover */
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Tambah Rangking</h1>
        </header>

        <main>
            <form action="process.php" method="POST">
                <label for="name">Nama Organisasi</label>
                <input type="text" id="name" name="name" required>

                <label for="unit">Unit Eselon 1</label>
                <input type="text" id="unit" name="unit" required>

                <label for="score">Skor</label>
                <input type="number" id="score" name="score" required>

                <button type="submit" class="submit-button">Tambah</button>
            </form>
        </main>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messageModalLabel">Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if (isset($modal_message)) {
                        echo $modal_message;
                    } else {
                        echo "No message to display.";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
