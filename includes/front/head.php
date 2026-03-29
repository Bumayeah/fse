<?php

function fse_head() {
    ?>
    <link rel="icon" href="<?php echo esc_url( get_theme_file_uri( '/assets/img/favicon.svg' ) ); ?>" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script>
      (function(){var s=localStorage.getItem('fse_theme');if(s==='dark'||(s===null&&window.matchMedia('(prefers-color-scheme:dark)').matches)){document.documentElement.classList.add('dark');}})();
    </script>
    <?php
}