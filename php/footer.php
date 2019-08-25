<?php
    function get_version() {
        include("./conf/version.php");
        $command = escapeshellcmd("python ./py/get_version.py");
        $newest_version = shell_exec($command);
        if ($newest_version == $current_version || $newest_version == "NC") {
            return 'v'.$current_version;
        } else {
            return '<a class="update_info">UPDATE VERFÜGBAR: v'.$newest_version.'</a>';
        }
    } 
?>

<div id="footer">
                <div class="footer_left">
                    <p>&copy; Raffael Baldinger 2019</p>
                </div>
                <div class="footer_right">
                    <p>LERNKARTEN <?php echo get_version(); ?></p>
                </div>
            </div>
        </div>
    </body>
</html>