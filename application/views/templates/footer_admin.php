</div>
</div>
</div>

<script>
    const checkbox = document.getElementById('checkbox-menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menu-toggle');

    function checkboxClick() {
        if (checkbox.checked == true) {
            sidebar.style.width = "200px";
            // sidebar.style.position = "absolute";
        } else {
            sidebar.style.width = "0px";
        }
    }
</script>
</body>

</html>