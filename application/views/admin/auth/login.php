<!-- admin -->
<div style="width: 100%;">
    <form action="<?php echo base_url('admin/auth/login'); ?>" method="post">
        <div>
            <table style="margin-left: 40%; margin-right: 40%; margin-top: 200px;">
                <tr>
                    <td colspan="2" style="color: red;"><?php echo validation_errors(); ?></td>
                </tr>
                <tr>
                    <td><label for="user_name">მომხმარებელი</label></td>
                    <td><input type="text" name="user_name" /></td>
                </tr>
                <tr>
                    <td><label for="password">პაროლი</label></td>
                    <td><input type="password" name="password" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" value="შესვლა" /></td>
                </tr>
            </table>
        </div>
    </form>
</div>