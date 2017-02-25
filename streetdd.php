<?php
require_once 'core/init.php';

if (isset($_GET['townId'])) {
    $townId = escape($_GET['townId']);
    ?>
    <select id="streetdd" name="street">
    <?php
        $get = db::getInstance()->query("select street_id, street_name from streets where town_id = {$townId} order by 2");

        if (!$get->count()) {
            echo 'Empty List';
        } else {

            foreach ($get->results() as $s): ?>
                <option value="<?php echo escape($s->street_id); ?>">
                    <?php echo escape($s->street_name); ?>
                </option>
            <?php endforeach;

        }
    ?>
    </select>
    <?php
} else {
    redirect::to('main.php');
}