<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Confirmation</title>
    <style>
        /* Modal styles */
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        }
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            text-align: center;
        }
        .modal button {
            margin: 5px;
        }
    </style>
</head>
<body>
    <form id="actionForm" action="your_action.php" method="POST">
        <button type="button" onclick="showModal()">Do Something</button>
    </form>

    <!-- Modal -->
    <div id="confirmationModal" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to proceed?</p>
            <button onclick="confirmAction()">Yes</button>
            <button onclick="closeModal()">No</button>
        </div>
    </div>

    <script>
        const modal = document.getElementById("confirmationModal");
        const form = document.getElementById("actionForm");

        function showModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        function confirmAction() {
            modal.style.display = "none";
            form.submit(); // Submit the form
        }
    </script>
</body>
</html>