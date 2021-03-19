        <script src="<?= $one->assets_folder; ?>/js/plugins/idle-timer/dist/idle-timer.min.js"></script>
        <script>
            $(document).ready(function() {
                "use strict";
                $(document).idleTimer(<?= $this->idletimer ?>e3), $(document).on("idle.idleTimer", function(e, n, i) {
                    $("#idle-modal").modal("show"), $(document).idleTimer(500);
                    var t = setTimeout(function() {
                            window.location.href = "<?= base_url('logout') ?>"
                        }, 1e4),
                        o = 10,
                        d = setInterval(function() {
                            $("#sessionSecondsRemaining").text(--o), 0 == o && ($("#hideMsg").fadeOut("fast"), clearInterval(d))
                        }, 1e3);
                    document.querySelector("#extendSession").onclick = function() {
                        clearTimeout(t), clearInterval(d), setTimeout(function() {
                            $("#sessionSecondsRemaining").text(10)
                        }, 5e3)
                    }
                })
            });
        </script>
        <script type="text/javascript" src="<?= base_url('assets/backend/js/plugins/bootstrap-notify/bootstrap-notify.min.js') ?>"></script>
        <?php
        if (!empty($this->session->flashdata('notify-success'))) {
            echo $this->session->flashdata('notify-success');
        }
        if (!empty($this->session->flashdata('notify-error'))) {
            echo $this->session->flashdata('notify-error');
        }
        if (!empty($this->session->flashdata('notify-warning'))) {
            echo $this->session->flashdata('notify-warning');
        }
        if (!empty($this->session->flashdata('notify-info'))) {
            echo $this->session->flashdata('notify-info');
        }
        if (!empty($this->session->flashdata('notif'))) {
            echo $this->session->flashdata('notif');
        }
        ?>
        </body>

        </html>