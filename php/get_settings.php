    <?php 
    function get_post_value() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            return $_POST["submit_value"];
        } else {
            return "start";
        }
    }

    function read_ini() {
        $command = escapeshellcmd('python ./py/conf.py "get_content"');
        $output = shell_exec($command);
        $output = htmlentities($output);  
        $output = preg_split("/\?/", $output);

        return $output;
    }

    function reset_stats() {        
        $command = escapeshellcmd('python "./py/reset_stats.py" "reset"');
        $output = shell_exec($command);
        return $output;
    }

    function create_help_content() {
        $option = get_post_value();
        $ini_values = read_ini();

        $command = escapeshellcmd('python -c "import os; print(1) if (os.path.exists(\''.$ini_values[0].'\') and os.path.exists(\''.$ini_values[1].'\')) else print(0)"');
        $setup_switch = shell_exec($command);

        if ($option == "start" && $setup_switch == 1) {
            if ($setup_switch == 1) {
                $output =   '<div class="help_box">
                                <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                    <button class="help_content_button setup_config_button" method="post" name="submit_value" value="configuration">Konfiguration</button>
                                    <button class="help_content_button setup_template_button" method="post" name="submit_value" value="template">Vorlagen</button>
                                    <button class="help_content_button setup_stats_button" method="post" name="submit_value" value="reset_stats">Statistiken Zurücksetzen</button>
                                    <button class="help_content_button setup_py_button" method="post" name="submit_value" value="check_py">Pythonmodule Prüfen</button>
                                </form>
                            </div>';
            } 
        } elseif ($option == "start" && $setup_switch == 0) {
            // Falls Angaben in cards.ini falsch sind
            $output =   '<div class="help_box">
                            <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                <table class="edit_box">
                                    <tr class="hidden_border">
                                        <td colspan="2">
                                            <p class="setup_title">Verzeichnisse</p>
                                        </td>
                                    <tr class="hidden_border">
                                        <td>
                                            <a class="info_link" data="Pfad zu index.php. Beispiel: C:/Apache/htdocs/Lernkarten">
                                                <img src="./img/info_small.png" class="info_icon">
                                            </a>Installationspfad:
                                        </td>
                                        <td>
                                            <input class="conf_input_dir" type="text" name="ROOT_DIR">
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td>
                                            <a class="info_link" data="Dieser Pfad wird nach Dokumenten durchsucht um Lernkarten zu erstellen. Beispiel: C:/Benutzer/MaxMuster/Dokumente">
                                                <img src="./img/info_small.png" class="info_icon">
                                            </a>Dokumentenpfad:
                                        </td>
                                        <td>
                                            <input type="text" class="conf_input_dir" name="DOCUMENT_DIR">
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td colspan="2">
                                            </br><p class="setup_title">Fragenkennzeichnung:</p>
                                            Standard: //qa&#60;fach/thema&#60;frage&#60;antwort&#60;</br> </br>
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td>
                                        <a class="info_link" data="Mit der Einleitung wird in Word-Dateien die Karteikarte hinterlegt. Beispiel: //qa">
                                            <img src="./img/info_small.png" class="info_icon">
                                        </a>Einleitung:
                                        </td>
                                        <td>
                                            <input type="text" class="conf_input_dir" name="QA_INTRO" value="//qa"> 
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td>
                                        <a class="info_link" data="Mit dem Trennzeichen werden die unterschiedlichen Sektionen gekennzeichnet. Beispiel: &#60;">
                                            <img src="./img/info_small.png" class="info_icon">
                                        </a>Trennzeichen:
                                        </td>
                                        <td>
                                            <input type="text" class="conf_input_dir" name="SEPERATOR" value="<">
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td colspan="2">
                                        <div class="setup_menu">
                                            <button class="help_content_button" method="post" name="submit_value" value="save_new_conf">Speichern</button>
                                            <button class="help_content_button" method="post" name="submit_value" value="start">Abbrechen</button>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>';
        } elseif ($option == "save_new_conf") {
            $ROOT_DIR=$_POST["ROOT_DIR"];
            $DOCUMENT_DIR = $_POST["DOCUMENT_DIR"];
            $QA_INTRO = $_POST["QA_INTRO"];
            $SEPERATOR = $_POST["SEPERATOR"];

            $command = escapeshellcmd('python ./py/conf.py "setup" "'.$ROOT_DIR.'" "'.$DOCUMENT_DIR.'" "'.$QA_INTRO.'" "'.$SEPERATOR.'"');
            $output = shell_exec($command);  

            $_POST["submit_value"] = "start";
            return $output.create_help_content();

        } elseif ($option == "configuration") {
            $setup_array = read_ini();
            $ROOT_DIR = $setup_array[0];
            $DOCUMENT_DIR = $setup_array[1];
            $QA_INTRO = htmlentities($setup_array[2]);
            $SEPERATOR = $setup_array[3];

            $output =   '<div class="help_box">
                            <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                <table class="edit_box">
                                    <tr class="hidden_border">
                                        <td colspan="2">
                                            <p class="setup_title">Verzeichnisse</p>
                                        </td>
                                    <tr class="hidden_border">
                                        <td>
                                            <a class="info_link" data="Pfad zu index.php. Beispiel: C:/Apache/htdocs/Lernkarten">
                                                <img src="./img/info_small.png" class="info_icon">
                                            </a>Installationspfad:
                                        </td>
                                        <td>
                                            <input class="conf_input_dir" type="text" name="ROOT_DIR" value="'.$ROOT_DIR.'">
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td>
                                            <a class="info_link" data="Dieser Pfad wird nach Dokumenten durchsucht um Lernkarten zu erstellen. Beispiel: C:/Benutzer/MaxMuster/Dokumente">
                                                <img src="./img/info_small.png" class="info_icon">
                                            </a>Dokumentenpfad:
                                        </td>
                                        <td>
                                            <input type="text" class="conf_input_dir" name="DOCUMENT_DIR" value="'.$DOCUMENT_DIR.'">
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td colspan="2">
                                            <p class="setup_title">Fragenkennzeichnung:</p>
                                            Standard: //qa&#60;fach/thema&#60;frage&#60;antwort&#60;
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td>
                                            <a class="info_link" data="Mit der Einleitung wird in Word-Dateien die Karteikarte hinterlegt. Beispiel: //qa"> 
                                                <img src="./img/info_small.png" class="info_icon">
                                            </a>Einleitung: 
                                        </td>
                                        <td>
                                            <input class="conf_input_dir" type="text" name="QA_INTRO" value="'.$QA_INTRO.'"> 
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td>
                                            <a class="info_link" data="Mit dem Trennzeichen werden die unterschiedlichen Sektionen gekennzeichnet. Beispiel: &#60;">
                                                <img src="./img/info_small.png" class="info_icon">
                                            </a>Trennzeichen:
                                        </td>
                                        <td>
                                            <input class="conf_input_dir" type="text" name="SEPERATOR" value="'.$SEPERATOR.'">
                                        </td>
                                    </tr>
                                    <tr class="hidden_border">
                                        <td colspan="2">
                                        <div class="setup_menu">
                                            <button class="help_content_button" method="post" name="submit_value" value="save_new_conf">Speichern</button>
                                            <button class="help_content_button" method="post" name="submit_value" value="start">Abbrechen</button>
                                        </div>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>';
        } elseif ($option == "template") {
            $setup_array = read_ini();
            $ROOT_DIR = $setup_array[0];
            $DOCUMENT_DIR = $setup_array[1];
            $QA_INTRO = $setup_array[2];
            $SEPERATOR = $setup_array[3];
            $SEPERATOR = str_replace(" ", "", $SEPERATOR);

            $output =   '<div class="template_box">
                            <div class="templates_rules">
                                <p class="template_rule_title">Regeln:</p>
                                <p class="template_rule">1. Eine Frage muss immer auf einer Linie (ohne manuellem Zeilenumbruch) geschrieben werden</p>
                                <p class="template_rule">2. Eine Frage muss immer mit "'.$QA_INTRO.'" beginnen</p>
                                <p class="template_rule">3. Die einzelnen Parameter müssen mit "'.$SEPERATOR.'" voneinander getrennt sein</p>
                                <p class="example_rule">Beispiel: </br>'.$QA_INTRO.$SEPERATOR.'Mathematik/Addition'.$SEPERATOR.'Was ergibt 1+1?'.$SEPERATOR.'2'.$SEPERATOR.'</p>
                            </div>
                            <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                <button class="exit_template" method="post" name="submit_value" value="start">Zurück</button>
                            </form>
                        </div>';
        } elseif ($option == "reset_stats") {
            $output = '<form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
            <div class="warning"><p>Statistik zurücksetzen?</p>
            <div class="warning_menu">
            <button method="post" name="submit_value" value="reset_stats_ok">OK</button>
            <button method="post" name="submit_value" value="start">Abbrechen</button>
            </div>
            </div></form>';

            $_POST["submit_value"] = "start";
            return $output.create_help_content();
        } elseif ($option == "reset_stats_ok") {
            $_POST["submit_value"] = "start";
            $message = reset_stats();
            return create_help_content().$message;
        } elseif ($option == "check_py") {
            $check_array=array("Kommandozeile" => NULL, "Pythoninstallation" => NULL, "Python-docx-Modul" => NULL, "Requests-Modul" => NULL, "Hashlib-Modul" => NULL, "Os-Modul" => NULL, "Systemmodul" => NULL, "Regexmodul" => NULL);
            $info_array=array("Kommandozeile" => "Kann cmd.exe geöffnet werden?", "Pythoninstallation" => "Python installiert oder in der PATH Variabel vorhanden? Falls nicht können nachfolgende Tests nicht ausgeführt werden.", "Python-docx-Modul" => "'pip3 install python-docx' Ausgeführt?", "Requests-Modul" => "'pip3 install requests' Ausgeführt?", "Hashlib-Modul" => "'pip3 install hashlib' Ausgeführt?", "Os-Modul" => "'pip3 install os' Ausgeführt?", "Systemmodul" => "'pip3 install sys' Ausgeführt?", "Regexmodul" => "'pip3 install re' Ausgeführt?");
            $check_keys = array_keys($check_array);
            $command = escapeshellcmd("echo 1");
            $check_array["Kommandozeile"] = shell_exec($command)[0];
            $command = escapeshellcmd('python -c "print(1, end=\"\");"');
            $check_array["Pythoninstallation"] = shell_exec($command);

            $i = 0;
            if ($check_array["Pythoninstallation"] != NULL) {
                $all_good = TRUE;
                $command = escapeshellcmd('python "./py/check_modules.py"');
                $cmd_out = shell_exec($command);
                $python_modules = preg_split("/\?/", $cmd_out);
                foreach ($python_modules as $value) {
                    if ($value == 1) {
                        $check_array[$check_keys[$i+2]] = $value; 
                    } 
                    $i++;
                }
                // var_dump($check_array);
            }

            $table_content = "";
            foreach ($check_array as $key => $value) {
                if ($value == 0 || $value == NULL) {
                    $all_good = FALSE;
                    $out_value = "<td class='py_false'>✘</td>";
                } else {
                    $out_value = "<td class='py_true'>✔</td>";
                }
                $table_content .= '<tr><td class="py_info">'.$key.'</td>'.$out_value.'<td><img src="./img/info.png" title="'.$info_array[$key].'"></tr>';
            }

            if ($all_good) {
                $message = '<p class="py_eval">Alle Tests waren erfolgreich</p>';
            } else {
                $message = '<p class="py_eval">Einige Tests sind fehlgeschlagen. Prüfe die Infosymbole für Hinweise</p>';
            }

            $output =   '<div class="help_box">
                            <p class="py_title">Prüfung der Pythonimplementation</p>
                            <table class="py_info_table">
                                '.$table_content.'
                            </table>
                            '.$message.'
                            <form method="post" action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'">
                                <button class="help_content_button" method="post" name="submit_value" value="start">Zurück</button>
                            </form>
                        </div>';
        }

        return $output;
    }
?>