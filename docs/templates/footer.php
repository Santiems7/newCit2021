            </main>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.1/showdown.min.js"></script>
        <script src="script/tablas.js"></script>
        <script src="script/copiar.js"></script>
        <script src="script/recargaCorreo.js"></script>
        <script src="script/myScript.js"></script>
        <script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>