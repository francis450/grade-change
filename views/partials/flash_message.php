<style>
    .flash-message {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .flash-message.show {
        opacity: 1;
    }

    .flash-message.error {
        background-color: #dc3545;
    }

    .flash-message.success {
        background-color: #28a745;
    }

    /* Close button */
    .flash-message .close-btn {
        position: absolute;
        top: 5px;
        right: 10px;
        cursor: pointer;
        color: #fff;
        font-weight: bold;
    }
</style>

<div class="flash-message <?php echo $flash['type']; ?> show">
    <span class="close-btn" onclick="this.parentElement.style.display='none'">&times;</span>
    <?php echo $flash['message']; ?>
</div>
