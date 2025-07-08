<script>
        const sidebar = document.getElementById('sidebar');
        const menuBtn = document.getElementById('menuBtn');
        menuBtn.onclick = function(e) {
            sidebar.classList.toggle('open');
            menuBtn.classList.toggle('open');
            e.stopPropagation();
        }

        document.addEventListener('click', function(e) {
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== menuBtn) {
                sidebar.classList.remove('open');
                menuBtn.classList.remove('open');
            }
        });

        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
