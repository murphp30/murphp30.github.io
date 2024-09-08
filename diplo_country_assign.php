<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php
            
            $countries = array(
                'britain',
                'france',
                'germany',
                'austria',
                'italy',
                'russia',
                'turkey'
            );

            shuffle($countries);

            $player_names = array();
            $played_countries = array();
            $assigned_countries = array();

            for ($i=0; $i<$_POST['form-TOTAL_FORMS']; $i++) {
                $form = 'form-'.strval($i);
                $country = $form.'-countries';
                $player = $form.'-player_name';
                $player_names[$i] = htmlspecialchars($_POST[$player]);
                if (isset($_POST[$country])) {
                    $played_countries[$player_names[$i]] = $_POST[$country];
                } else {
                    $played_countries[$player_names[$i]] = array();
                }
                $assigned_countries[$player_names[$i]] = $countries[$i];
            }

            function check_assigned($assigned_countries, $played_countries) {
                foreach ($assigned_countries as $player => $country) {
                    if (in_array($country,$played_countries[$player])) {
                        $repeated_country =  True;
                        break;
                    } else {
                        $repeated_country = False;
                    }
                }
                return $repeated_country;
            }
            $count = 0;
            
            $repeated_country = check_assigned($assigned_countries, $played_countries);
            while (($repeated_country) && ($count < 100)) {
                shuffle($countries);
                for ($i=0; $i<$_POST['form-TOTAL_FORMS']; $i++) {
                    $assigned_countries[$player_names[$i]] = $countries[$i];
                }
                $repeated_country = check_assigned($assigned_countries, $played_countries);
                $count++;
            }

        ?>
        <ul>
        <?php
            foreach($assigned_countries as $player => $country) {
                echo '<li>', $player, ' will play as ', $country, '</li>';
            }
        ?>
        </ul>
        <p> Have fun! </p>
        <form action="" method="post">
            <?php
                echo '<input id="id_from-TOTAL_FORMS" type="hidden" name="form-TOTAL_FORMS" value=',$_POST['form-TOTAL_FORMS'],'>';
                for ($i=0;$i<$_POST['form-TOTAL_FORMS'];$i++) {
                    $form = 'form-'.strval($i);
                    $country = $form.'-countries';
                    $player = $form.'-player_name';
                    echo '<input type="hidden" name="',$player,'" value="',$_POST[$player],'">';
                    foreach($_POST[$country] as $played_country) {
                        echo '<input type="hidden" name="',$country,'[]" value="',$played_country,'">';
                    }
                }
            ?>
            <input type="submit" value="Reassign same players">
        <button type="button" onclick="location.href='diplo_country_assign.html'">Assign new players</button>
    </body>
</html>