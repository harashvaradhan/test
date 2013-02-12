<?php
session_start();
if (!isset($_SESSION['username'])) {
     header('Location: login');
 }
    include_once('header.php');
    include_once('menu.php');
    include_once('includes/website-processing.php');
?>
<body>
<div id="dialog-form" title="Create new Website">
    <p class="validateTips">All form fields are required.</p>
    <form id="newwebsite">
    <fieldset>
        <label for="name">Website Name</label>
        <input type="text" name="name" id="name" title='Enter name of website here.'class="text ui-widget-content ui-corner-all" />
    </fieldset>
    </form>
</div>
<div id="websites-contain" class="ui-widget">
    <h1>Existing Websites:</h1>
    <table id="websites" class="ui-widget ui-widget-content">
        <thead>
            <tr class="ui-widget-header ">
                <th colspan='3'>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
                getuserwebsites();
            ?>
        </tbody>
    </table>
</div>
<button id="create-website">Create new website</button>
</body>
<?php
include_once ('footer.php');

?>