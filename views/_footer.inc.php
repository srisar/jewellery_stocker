<?php


use Jman\Core\App; ?>

<footer class="my-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col text-center">
                <?= date('Y') ?> | Developed by <a href="https://gravitide.io">gravitide.io</a>
            </div>
        </div>
    </div>
</footer>

<div id="toast_container"></div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="<?= App::getSiteURL() ?>/assets/plugins/jquery-3.4.1.min.js"></script>
<script src="<?= App::getSiteURL() ?>/assets/plugins/popper.min.js"></script>
<script src="<?= App::getSiteURL() ?>/assets/plugins/bootstrap-4.4.1-dist/js/bootstrap.bundle.min.js"></script>

<script src="<?= App::getSiteURL() ?>/assets/plugins/daterangepicker/moment.min.js"></script>
<script src="<?= App::getSiteURL() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?= App::getSiteURL() ?>/assets/plugins/DataTables/datatables.min.js"></script>
<script src="<?= App::getSiteURL() ?>/assets/js/app-min.js"></script>
</body>
</html>
