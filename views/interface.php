<?php
	/*Generating of Interface*/
    if(ShareUser::is_user_administrator()){
        $user_id = $_GET['user_id'];
    } else {
        $user_id = get_current_user_id();
    }
    $share_user = new ShareUser();
    $user_data = $share_user->get_user_meta_data($user_id);
    
 ?>
<h3><?php _e("Share User Information", "blank"); ?></h3>

<table class="form-table">
<tr>
    <th><label for="address"><?php _e("Address"); ?></label></th>
    <td>
        <input type="text" name="address" id="address" value="<?= $user_data['address'] ?>" class="regular-text" /><br />
        <span class="description"><?php _e("Please enter your address."); ?></span>
    </td>
</tr>
<tr>
    <th><label for="phone"><?php _e("Phone"); ?></label></th>
    <td>
        <input type="number" name="phone" id="phone" class="regular-text" value="<?= $user_data['phone'] ?>"/><br />
        <span class="description"><?php _e("Please enter your phone number."); ?></span>
    </td>
</tr>
<tr>
<th><label for="gender"><?php _e("Choose Your Gender"); ?></label></th>
    <td>
        <select name="gender" id="gender" class="regular-text">
        	<option <?=($user_data['gender'] == "Male") ? 'selected' : ''; ?>>Male</option>
        	<option <?= ($user_data['gender'] == "Female") ? 'selected' : ''; ?>>Female</option>
            <option <?= ($user_data['gender'] == "Another") ? 'selected' : ''; ?>>Another</option>
        </select>
        	<br />
        <span class="description"><?php _e("Please choose your gender."); ?></span>
    </td>
</tr>
<tr>
<th><label for="gender"><?php _e("Choose Your Gender"); ?></label></th>
    <td>
        <select name="maristat" id="maristat" class="regular-text">
        	<option <?= ($user_data['maristat'] == "Not married") ? 'selected' : ''; ?>>Not married</option>
            <option <?= ($user_data['maristat'] == "Divorced") ? 'selected' : ''; ?>>Divorced</option>
            <option <?= ($user_data['maristat'] == "Married") ? 'selected' : ''; ?>>Married</option>
            <option <?= ($user_data['maristat'] == "Civil Marriage") ? 'selected' : ''; ?>>Civil marriage</option>
        </select>
        	<br />
        <span class="description"><?php _e("Please choose your marriage status."); ?></span>
    </td>
</tr>
</table>