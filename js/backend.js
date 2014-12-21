var config = {
	homeUrl: ""
};

function LoadBackend(homeUrl)
{
	config.homeUrl = homeUrl;
}

function ShowMessage(message)
{
	var dlg = $("#dialog");
	dlg.html('<div class="alert alert-success">' + message + '</div>');
	dlg.dialog("open");
	dlg.animate({opacity: 1.0}, 1000).fadeOut("slow", function() {
		dlg.dialog("close");
	});
}

function BeginLoadingMessage(message)
{
	var dlg = $("#dialog-loading");
	dlg.html('<div class="alert alert-info">' + message + '</div>');
	dlg.dialog("open");
}

function EndLoadingMessage()
{
	$("#dialog-loading").dialog("close");
}

/**
 *
 */
function OnBeforeCreateCharClick()
{
	$("#btn-create-char").attr('disabled', 'disabled');
	$("#create-char-wait").css("visibility", "visible");
	$("#create-char-sql").empty();
	$("#create-char-errors").empty();
	$("#create-char-warnings").empty();
	$("#run-queries-table").empty();
	$('#create-char-tabs span').text("0");

	BeginLoadingMessage('Создание персонажа...');
}

/**
 * @param array messages
 * @param string type
 *   "errors"
 *   "warnings"
 * @return boolean
 */
function ShowMessages(messages, type)
{
	var messageContainer = $("#create-char-" + type);

	messageContainer.empty();
	var ol = messageContainer.append("<ol>").find("ol");
	for (var i = 0; i < messages.length; ++i)
	{
		ol.append("<li>" + messages[i] + "</li>");
	}
	var a = $('#create-char-tabs a[href="#tab-' + type + '"]');
	a.tab("show");
	a.find("span").text(messages.length);

	return true;
}

/**
 *
 */
function OnCreateCharClick(data)
{
	EndLoadingMessage();

	$("#btn-create-char").removeAttr("disabled");
	$("#create-char-wait").css("visibility", "hidden");
	/*console.log(data);//*/
	result = $.parseJSON(data);
	/*console.log(result);//*/
	if (result == null)
		result = {"errors": ["Не удалось разобрать JSON"]};

	// 1
	$("#create-char-sql").text(result.sql);
	$('#create-char-tabs a[href="#tab-sql"] span').text(Math.floor(result.sql.length / 1024) + " kb");

	// 2
	var queries = result.queries;
	var queryCount = queries.length;
	var runQueriesContainer = $("#run-queries-table");
	runQueriesContainer.empty();
	for (var i = 0; i < queryCount; ++i)
	{
		query = queries[i];
		runQueriesContainer.append('<a class="query-res query-res-success" ' +
			'href="#query_' + i + '" title="' + query.query + '">' + query.status + '</a>');
	}
	runQueriesContainer.append("<hr>");
	for (var i = 0; i < queryCount; ++i)
	{
		query = queries[i];
		runQueriesContainer.append('<div id="query_' + i + '">'	+
			'<a href="#create-char-tabs" title="up"><span class="glyphicon glyphicon-chevron-up"></span></a> ' +
			'<span class="label label-info">' + i + '</span>' + ' Status: <code>' +
			query.status + "</code><pre>" + query.query + "</pre></div>");
	}
	$('#create-char-tabs a[href="#tab-queries"] span').text(queryCount);

	// 3
	ShowMessages(result.warnings, "warnings");

	if (result.errors != undefined && result.errors.length > 0)
	{
		ShowMessages(result.errors, "errors");
		return false;
	}

	$("#btn-create-char").hide();
	$("#btn-create-char-cancel").hide();
	$("#btn-create-char-success").show();

	$('#create-char-tabs a[href="#tab-queries"]').tab("show");

	return true;
}

/**
 *
 */
function OnClearCharacterDataByTransferIdClick(transferId, characterGuid)
{
	alert("TODO: AJAX...");
}

/**
 *
 */
function OnClearCharacterDataByGuidClick(characterGuid)
{
	alert("TODO: AJAX...");
}

/**
 *
 */
function OnShowCharacterDataClick(charactedGuid)
{
	alert("TODO:\n Character's information...\n AJAX...");
}

/**
 *
 */
function OnViewLuaDumpClick(transferId)
{
	var dialog = $("#lua-dump-dialog");
	var content = $("#lua-dump-dialog-content");

	$.ajax(config.homeUrl + "/transfers/luadump/" + transferId, {
		method: "GET",
		success: function (data, textStatus, jqXHR) {
			content.text(data);
		}
	});

	dialog.modal({keyboard: true});
}

/**
 *
 */
function OnViewUncryptedLuaDumpClick(transferId)
{
	alert("TODO:\n view uncrypted lua dump.\nAJAX...");
}

function UpdateComment(id) {
	var comment = $("#view_" + id + " textarea").val();

	$.ajax(config.homeUrl + "/transfers/update/" + id, {
		type: "post",
		data: {
			comment: comment
		},
		success: function(data) {
			ShowMessage("Комментарий изменен");
		}
	});
}

function OnUpdateStatus(tagA) {
	var a = $(tagA);
	var status = a.data("name");
	var id = a.closest("div.view").data("id");
	var eStatus = $("#status_" + id);

	if (eStatus.attr("data-name") === status) {
		return;
	}

	$.ajax(config.homeUrl + "/transfers/update/" + id, {
		type: "post",
		data: {
			status: status
		},
		success: function(data) {
			var checkedStatuses = GetCheckedStatuses();
			if (checkedStatuses.indexOf(status) < 0) {
				$("#view_" + id).hide();
			}
			eStatus.attr("data-name", status);
			eStatus.removeClass();
			eStatus.addClass("tstatus tstatus-" + status);
			eStatus.text(window.statuses[status]);
		},
		error: function (error) {
			alert("Error: " + error);
		}
	});
}

function OnDeleteChar(button, id) {
	if (!confirm("Подтвердите удаление персонажа")) {
		return false;
	}

	BeginLoadingMessage("Удаление персонажа...");

	var url = config.homeUrl + '/transfers/deletechar/' + id;
	console.log(url);
	$.ajax(url, {
		type: "post",
		success: function (data) {
			EndLoadingMessage();
			if (data.error !== undefined)
				ShowMessage(data.error);
			else
				ShowMessage("Персонаж удален");
			$(button).hide();
			$("#btn-create-char-" + id).show();
		},
		error: function () {
			EndLoadingMessage();
		}
	});

	return true;
}