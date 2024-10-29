<!-- confirmationModal.php -->
<div id="confirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Confirmation Required</h2>
        <p id="confirmationMessage"></p>
        <div class="modal-buttons">
            <button id="confirmButton" class="btn confirm">Confirm</button>
            <button onclick="closeModal()" class="btn cancel">Cancel</button>
        </div>
    </div>
</div>

<style>
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.5s;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        width: 400px;
        text-align: center;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    h2 {
        margin: 0 0 10px;
    }

    .modal-buttons {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin: 0 5px;
    }

    .confirm {
        background-color: #4CAF50;
        color: white;
    }

    .confirm:hover {
        background-color: #45a049;
    }

    .cancel {
        background-color: #f44336;
        /* Red */
        color: white;
    }

    .cancel:hover {
        background-color: #e53935;
    }
</style>

<script>
    function openModal(message, actionUrl) {
        document.getElementById("confirmationMessage").innerText = message;
        document.getElementById("confirmButton").onclick = function() {
            window.location.href = actionUrl;
        };
        document.getElementById("confirmationModal").style.display = "block";
    }

    function closeModal() {
        document.getElementById("confirmationModal").style.display = "none";
    }
</script>