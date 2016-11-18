<!DOCTYPE html>
<html lang="en">

<head>
    <?php echo $head; ?>
</head>

<body>
<div class="wrapper">

    <div id="wrapper">

        <div id="sidebar-wrapper">
            <?php echo $nav; ?>
        </div>

        <div id="page-content-wrapper">
        <?php $this->load->view('blocks/top_bar'); ?>
            <section class="container-fluid">
                <?php echo $content; ?>
            </section>
        </div>

    </div>

    <?php $this->load->view('layouts/logged/global'); ?>

    <div class="push"></div>
</div>

</body>

</html>