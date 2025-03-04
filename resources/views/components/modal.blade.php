<div id="modalView" class="modal">
    <div class="modal-content">
        <span onclick="closeModal()" class="modal-button tombol tombol-blank">
            <svg width="20" height="20" viewBox="0 0 20 20"><path d="M10 10l5.09-5.09L10 10l5.09 5.09L10 10zm0 0L4.91 4.91 10 10l-5.09 5.09L10 10z" stroke="currentColor" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </span>
        <img id="modalImage" class="content" src="" alt="Uploaded Image">
    </div>
</div>

<script>
    function openModal(imageUrl) {
        document.getElementById('modalImage').src = imageUrl;
        document.getElementById('modalImage').style.display = 'block';
        document.getElementById('modalView').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('modalView').style.display = 'none';
    }
</script>
