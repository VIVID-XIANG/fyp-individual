<?php
require "db.php";
session_start();

$user_id = $_SESSION['userid'];

// 获取用户默认名字
$user_result = mysqli_query($connect, "SELECT first_name, last_name FROM user WHERE user_id = '$user_id'");
$user = mysqli_fetch_assoc($user_result);
$default_first_name = $user['first_name'] ?? '';
$default_last_name = $user['last_name'] ?? '';

// 表单回传值
$selected_state = $_POST['state_code'] ?? '';
$selected_postcode = $_POST['postcode'] ?? '';
$selected_city = $_POST['city'] ?? '';

// 检查 state 是否变更，如果是则清除 postcode 和 city
if (isset($_POST['state_cide']) && isset($_SESSION['last_state']) && $_POST['state_name'] !== $_SESSION['last_state']) {
    $selected_postcode = '';
    $selected_city = '';
}
$_SESSION['last_state'] = $selected_state;

// 提交处理
if (isset($_POST['save_button'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $building_name = $_POST['building_name'];
    $address_line = $_POST['address_line'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $state = $_POST['state_code'];
    $is_default = isset($_POST['is_default']) ? 1 : 0;
    $phone = $_POST['phone'];

    if ($is_default == 1) {
        mysqli_query($connect, "UPDATE address SET is_default = 0 WHERE user_id = '$user_id'");
    }

    $state_result = mysqli_query($connect, "SELECT state_name FROM state WHERE state_code = '$state'");
    $state_row = mysqli_fetch_assoc($state_result);
    $state_name = $state_row['state_name'] ;

    // 插入使用 state_name
    $insert_query = "
        INSERT INTO address (user_id, first_name, last_name, building_name, address, postcode, city, state_territory, phone, is_default)
        VALUES ('$user_id', '$first_name', '$last_name', '$building_name', '$address_line', '$postcode', '$city', '$state_name', '$phone', '$is_default')
    ";

    $insert_query = "
        INSERT INTO address (user_id, first_name, last_name, building_name, address, postcode, city, state_territory, phone, is_default)
        VALUES ('$user_id', '$first_name', '$last_name', '$building_name', '$address_line', '$postcode', '$city', '$state_name', '$phone', '$is_default')
    ";

    if (mysqli_query($connect, $insert_query)) {
        echo "<script>alert('Address added successfully!'); window.location.href='address_page.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>


<form method="POST" action="">
    <div class="modal-body">
        <input type="text" name="first_name" class="form-control mb-3" placeholder="First Name"
               value="<?= htmlspecialchars($_POST['first_name'] ?? $default_first_name) ?>">

        <input type="text" name="last_name" class="form-control mb-3" placeholder="Last Name"
               value="<?= htmlspecialchars($_POST['last_name'] ?? $default_last_name) ?>">

        <input type="text" name="building_name" class="form-control mb-3" placeholder="Building Name"
               value="<?= htmlspecialchars($_POST['building_name'] ?? '') ?>">

        <input type="text" name="address_line" class="form-control mb-3" placeholder="Address *" required
               value="<?= htmlspecialchars($_POST['address_line'] ?? '') ?>">

        <input type="text" name="phone" class="form-control mb-3" placeholder="Phone Number*"
               value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">

       <!--  State  -->
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

<!-- ✅ Postcode：始终显示，但在未选 state 时禁用 -->
<select name="postcode" class="form-select mb-3" onchange="this.form.submit()" <?= empty($selected_state) ? 'disabled' : '' ?> required>
    <option value="">-- Select Postcode --</option>
    <?php
    if (!empty($selected_state)) {
        $postcode_query = mysqli_query($connect, "SELECT DISTINCT postcode FROM postcode WHERE state_code = '$selected_state' ORDER BY postcode");
        while ($row = mysqli_fetch_assoc($postcode_query)) {
            $selected = ($selected_postcode == $row['postcode']) ? 'selected' : '';
            echo "<option value=\"{$row['postcode']}\" $selected>{$row['postcode']}</option>";
        }
    }
    ?>
</select>

<!-- ✅ City：始终显示，但在未选 postcode 时禁用 -->
<select name="city" class="form-select mb-3" <?= (empty($selected_state) || empty($selected_postcode)) ? 'disabled' : '' ?> required>
    <option value="">-- Select City --</option>
    <?php
    if (!empty($selected_state) && !empty($selected_postcode)) {
        $city_query = mysqli_query($connect, "SELECT DISTINCT area_name FROM postcode WHERE state_code = '$selected_state' AND postcode = '$selected_postcode' ORDER BY area_name");
        while ($row = mysqli_fetch_assoc($city_query)) {
            $selected = ($selected_city == $row['area_name']) ? 'selected' : '';
            echo "<option value=\"{$row['area_name']}\" $selected>{$row['area_name']}</option>";
        }
    }
    ?>
</select>


        <!-- Default checkbox -->
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_default" value="1" id="defaultCheck"
                   <?= isset($_POST['is_default']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="defaultCheck">Set as Default Address</label>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" name="save_button" class="btn btn-primary">Save Address</button>
    </div>
</form>
