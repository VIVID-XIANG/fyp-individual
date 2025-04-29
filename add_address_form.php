<?php
require "db.php";

$selected_state = $_POST['state_code'] ?? '';
$selected_postcode = $_POST['postcode'] ?? '';
?>

<!-- 注意：action 指向自己，处理下拉 -->
<form method="POST" action="">
    <div class="modal-body">
        <input type="text" name="building_name" class="form-control mb-3" placeholder="Building Name" value="<?= $_POST['building_name'] ?? '' ?>">
        <input type="text" name="address_line" class="form-control mb-3" placeholder="Address Line" value="<?= $_POST['address_line'] ?? '' ?>" required>

        <!-- State Dropdown -->
        <select name="state_code" class="form-select mb-3" onchange="this.form.submit()" required>
            <option value="">-- Select State --</option>
            <?php
            $state_query = mysqli_query($connect, "SELECT * FROM state ORDER BY state_name ASC");
            while ($state = mysqli_fetch_assoc($state_query)) {
                $selected = ($selected_state == $state['state_code']) ? 'selected' : '';
                echo "<option value=\"{$state['state_code']}\" $selected>{$state['state_name']}</option>";
            }
            ?>
        </select>

        <!-- Postcode -->
        <?php if ($selected_state): ?>
            <select name="postcode" class="form-select mb-3" onchange="this.form.submit()" required>
                <option value="">-- Select Postcode --</option>
                <?php
                $postcode_query = mysqli_query($connect, "SELECT DISTINCT postcode FROM postcode WHERE state_code = '$selected_state' ORDER BY postcode");
                while ($row = mysqli_fetch_assoc($postcode_query)) {
                    $selected = ($selected_postcode == $row['postcode']) ? 'selected' : '';
                    echo "<option value=\"{$row['postcode']}\" $selected>{$row['postcode']}</option>";
                }
                ?>
            </select>
        <?php endif; ?>

        <!-- City -->
        <?php if ($selected_state && $selected_postcode): ?>
            <select name="city" class="form-select mb-3" required>
                <option value="">-- Select City --</option>
                <?php
                $city_query = mysqli_query($connect, "SELECT DISTINCT area_name FROM postcode WHERE state_code = '$selected_state' AND postcode = '$selected_postcode' ORDER BY area_name");
                while ($row = mysqli_fetch_assoc($city_query)) {
                    echo "<option value=\"{$row['area_name']}\">{$row['area_name']}</option>";
                }
                ?>
            </select>
        <?php endif; ?>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="defaultCheck">
            <label class="form-check-label" for="defaultCheck">Set as Default Address</label>
        </div>
    </div>

    <!-- 真正保存用另一个按钮跳转 -->
    <?php if ($selected_state && $selected_postcode): ?>
        <div class="modal-footer">
            <form method="POST" action="add_address_form.php">
                <input type="hidden" name="building_name" value="<?= $_POST['building_name'] ?? '' ?>">
                <input type="hidden" name="address_line" value="<?= $_POST['address_line'] ?? '' ?>">
                <input type="hidden" name="state_code" value="<?= $selected_state ?>">
                <input type="hidden" name="postcode" value="<?= $selected_postcode ?>">
                <input type="hidden" name="city" value="<?= $_POST['city'] ?? '' ?>">
                <input type="hidden" name="is_default" value="<?= $_POST['is_default'] ?? 0 ?>">
                <button type="submit" class="btn btn-primary">Save Address</button>
            </form>
        </div>
    <?php endif; ?>
</form>
