<!DOCTYPE html>
<html lang="en">
<head>
    <title>Grant List - GPRA Portal</title>
    <?php $this->includeStyles(); ?>
</head>
<body>
    <?php $this->includeHeader(); ?>

    <div class="pageTitle">Select a grant to continue:</div>
    <table class="table table-striped">
        <tr>
            <th>GFA</th>
            <th>Grantee</th>
            <th>Grant #</th>
        </tr>
        <tr v-for="grant in grants">
            <td><a :href="'/home/index?id='+grant.id">{{grant.name}}</a></td>
            <td>{{grant.grantee}}</td>
            <td>{{grant.grantno}}</td>
        </tr>
    </table>

    <?php $this->includeFooter(); ?>
    <?php $this->includeScripts(); ?>

<script type="application/javascript">
    vue = new Vue({
        el: '#main',
        data: {
            grants: <?php echo json_encode($this->grants); ?>
        }
    })
</script>
</body>
</html>