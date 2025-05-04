<?php
session_start();
require 'db.php';

$user_id = $_SESSION['userid'];
$address_id = intval($_GET['address_id'] ?? 0);

// 获取现有地址信息
$query = "SELECT * FROM address WHERE address_id = '$address_id' AND user_id = '$user_id'";
$result = mysqli_query($connect, $query);
$address = mysqli_fetch_assoc($result);

if (!$address) {
    die("Address not found.");
}

$selected_state = $_POST['state_code'] ?? '';
$selected_postcode = $_POST['postcode'] ?? $address['postcode'];
$selected_city = $_POST['city'] ?? $address['city'];

if (!isset($_POST['state_code'])) {
    $state_name = $address['state_territory'];
    $state_result = mysqli_query($connect, "SELECT state_code FROM state WHERE state_name = '$state_name'");
    $state_row = mysqli_fetch_assoc($state_result);
    $selected_state = $state_row['state_code'] ?? '';
}

// 表单提交处理
if (isset($_POST['update_button'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $building_name = $_POST['building_name'];
    $address_line = $_POST['address_line'];
    $postcode = $_POST['postcode'];
    $city = $_POST['city'];
    $state_code = $_POST['state_code'];
    $phone = $_POST['phone'];

    // 获取 state_name
    $state_result = mysqli_query($connect, "SELECT state_name FROM state WHERE state_code = '$state_code'");
    $state_row = mysqli_fetch_assoc($state_result);
    $state_name = $state_row['state_name'] ?? '';



    
    $update_query = "
        UPDATE address SET
            first_name = '$first_name',
            last_name = '$last_name',
            building_name = '$building_name',
            address = '$address_line',
            postcode = '$postcode',
            city = '$city',
            state_territory = '$state_name',
            phone = '$phone'
        WHERE address_id = '$address_id' AND user_id = '$user_id'
    ";

    if (mysqli_query($connect, $update_query)) {
        echo "<script>alert('Address updated successfully!'); window.location.href='address_page.php';</script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}
?>

<form method="POST">
    <input type="text" name="first_name" class="form-control mb-3" placeholder="First Name" required
           value="<?= htmlspecialchars($_POST['first_name'] ?? $address['first_name']) ?>">

    <input type="text" name="last_name" class="form-control mb-3" placeholder="Last Name" required
           value="<?= htmlspecialchars($_POST['last_name'] ?? $address['last_name']) ?>">

    <input type="text" name="building_name" class="form-control mb-3" placeholder="Building Name"
           value="<?= htmlspecialchars($_POST['building_name'] ?? $address['building_name']) ?>">

    <input type="text" name="address_line" class="form-control mb-3" placeholder="Address *" required
           value="<?= htmlspecialchars($_POST['address_line'] ?? $address['address']) ?>">

    <input type="text" name="phone" class="form-control mb-3" placeholder="Phone Number"
           value="<?= htmlspecialchars($_POST['phone'] ?? $address['phone']) ?>">

    <!-- State dropdown -->
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

    <!-- Postcode dropdown -->
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

    <!-- City dropdown -->
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

    <button type="submit" name="update_button" class="btn btn-primary">Update Address</button>
</form>
