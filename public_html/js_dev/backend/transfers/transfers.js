define([
    'jquery',
    'backend/app'
], function($, app) {

    var transfers = {};

    $(function () {

        $("#transfers-listview-block").on("click", ".transfer-save-comment", function () {
            var $view = $(this).closest(".view"),
                id = $view.data("id"),
                comment = $view.find(".transfer-comment").val();
            var requestData = {
                comment: comment
            };
            $.post(app.getBaseUrl() + "transfers/update/" + id, requestData, function (data) {
                app.showMessage($("#t-success-changed").text());
            });
        });

        $("#transfers-listview-block").on("click", ".transfer-statuses a", function () {
            var $a = $(this),
                status = $a.data("name"),
                id = $a.closest(".view").data("id"),
                $status = $("#status_" + id);

            if ($status.attr("data-name") === status) {
                return;
            }

            var requestData = {
                status: status
            };
            $.post(app.getBaseUrl() + "transfers/update/" + id, requestData, function (data) {
                var checkedStatuses = getFilterCheckedStatuses();
                if (checkedStatuses.indexOf(status) < 0) {
                    $("#view_" + id).hide();
                }
                $status.attr("data-name", status);
                $status.removeClass();
                $status.addClass("tstatus tstatus-" + status);
                $status.text(window.statuses[status]);
            });
        });

        $("#transfers-listview-block").on("click", "a.delete-char", function () {
            var $btn = $(this);
            app.dialogs.confirm($("#t-confirm-delete-character").text(), function () {
                app.characters.deleteCharacter($btn);
            });
            return false;
        });

        $("#frm-filter").submit(function () {
            var $form = $(this),
                dtRange = $form.find('input[name="dt_range"]:checked').val(),
                checkedStatuses = getFilterCheckedStatuses($form);

            if (!checkedStatuses.length) {
                return false;
            }

            var requestData = {
                statuses: checkedStatuses,
                dt_range: dtRange
            };
            $.post("", requestData, function (data) {
                $("#transfers-listview").replaceWith(data);
            });

            return false;
        });
        $("#frm-filter").on("change", "input", function () {
            $("#frm-filter").submit();
        });

        $(".switch-password").click(function () {
            var $btn = $(this);
            var id = $("#transfer").data("id");
            var $pass = $("#password_" + id);
            var pass = $pass.data("password");
            if (pass) {
                if ($pass.text().indexOf("*******") !== -1) {
                    $pass.text(pass);
                    $btn.text("-");
                }
                else {
                    $pass.text("*******");
                    $btn.text("+");
                }
            }
            else {
                $.post(app.getBaseUrl() + "transfers/remotepassword/" + id, {}, function (data) {
                    $pass.text(data);
                    $pass.data("password", data);
                    $btn.text("-");
                });
            }
            return false;
        });

    });

    function getFilterCheckedStatuses($form) {
        if ($form === undefined) {
            $form = $("#frm-filter");
        }

        var chbStatuses = $form.find('input[name="statuses[]"]:checked');
        var arrStatuses = [];

        chbStatuses.each(function () {
            arrStatuses.push($(this).val());
        });

        return arrStatuses;
    }

    return transfers;
});
