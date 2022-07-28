<?php foreach($data as $subject): ?>
    <option value="<?= esc($subject->id) ?>" <?= ($active == $subject->id) ? "selected" : ""  ?>>
        <?= esc($subject->name)  ?>
    </option>
<?php endforeach; ?>