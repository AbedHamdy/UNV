<script>
    // Sidebar open/close
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('menuBtn');
    if (menuBtn) {
        menuBtn.onclick = function(e) {
            sidebar.classList.toggle('open');
            menuBtn.classList.toggle('open');
            e.stopPropagation();
        }
    }
    // Close sidebar when clicking outside (on mobile)
    document.addEventListener('click', function(e) {
        if (sidebar.classList.contains('open') && !sidebar.contains(e.target) && e.target !== menuBtn) {
            sidebar.classList.remove('open');
            menuBtn.classList.remove('open');
        }
    });
    // Set year in footer
    const year = document.getElementById('year');
    if (year) {
        year.textContent = new Date().getFullYear();
    }

    // Dropdowns logic (support multiple dropdowns)
    document.querySelectorAll('.dropdown .sidebar-btn').forEach(function(btn) {
        btn.onclick = function(e) {
            // Close all other dropdowns
            document.querySelectorAll('.dropdown').forEach(function(drop) {
                if (drop !== btn.parentElement) {
                    drop.classList.remove('open');
                }
            });
            // Toggle this dropdown
            btn.parentElement.classList.toggle('open');
            e.stopPropagation();
        }
    });
    // Close all dropdowns on click outside
    document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown').forEach(function(drop) {
            drop.classList.remove('open');
        });
    });
</script>