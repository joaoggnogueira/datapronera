function Table(obj) {

    this.deletedRows = Array();
    this.controls = obj.controls || null;

    var $this = this;

    this.oTable = obj.table.dataTable({
        "bProcessing": true,
        "bDestroy": true,
        "sPaginationType": "bootstrap",
        "sAjaxSource": obj.url
    });

    /* Add a click handler to select the rows */
    obj.table.find('tbody').click(function (event) {

        $($this.oTable.fnSettings().aoData).each(function () {

            if ($(this.nTr).hasClass('active')) {
                $(this.nTr).removeClass('active');
            }
        });

        if (!$(event.target).hasClass('dataTables_empty')) {

            $(event.target.parentNode).addClass('active');
            $this.enableControls();
        }
    });

    /* Add a click handler for the delete row */
    $('.delete-row').click(function () {

        var anSelected = $this.fnGetSelected();

        if (anSelected.length !== 0) {

            var row = $this.oTable.fnGetData(anSelected[0]);

            if (row[0] != 'N') {
                $this.deletedRows.push(row);
            }

            $this.oTable.fnDeleteRow(anSelected[0]);
        }

        $this.disableControls();
    });
}

Table.prototype.enableControls = function () {

    if (this.controls) {
        this.controls.children('li').each(function () {
            if ($(this).children('button.btn-disabled').hasClass('disabled')) {
                $(this).children('button.btn-disabled').removeClass('disabled');
            }
        });
    }
}

Table.prototype.disableControls = function () {

    if (this.controls) {
        this.controls.children('li').each(function () {
            if (!$(this).children('button.btn-disabled').hasClass('disabled')) {
                $(this).children('button.btn-disabled').addClass('disabled');
            }
        });
    }
}

Table.prototype.hideColumns = function (_values) {

    for (var i = 0; i < _values.length; i++) {
        this.oTable.fnSetColumnVis(_values[i], false);
    }
}

Table.prototype.addData = function (_node) {

    this.oTable.fnAddData(_node);
}

Table.prototype.clear = function () {
    var aReturn = new Array();
    var aTrs = this.oTable.fnGetNodes();

    for (var i = 0; i < aTrs.length; i++) {
        var data = this.oTable.fnGetData(aTrs[i]);
        this.oTable.fnDeleteRow(data);
    }

    return aReturn;
}

Table.prototype.deleteSelectedRow = function () {

    var anSelected = this.fnGetSelected();
    this.oTable.fnDeleteRow(anSelected[0]);

    return true;
}

Table.prototype.getAllByIndex = function (_index) {

    var aReturn = new Array();
    var aTrs = this.oTable.fnGetNodes();

    for (var i = 0; i < aTrs.length; i++) {
        var data = this.oTable.fnGetData(aTrs[i]);
        aReturn.push(data[_index]);
    }

    return aReturn;
}

Table.prototype.getAll = function () {

    var aReturn = new Array();
    var aTrs = this.oTable.fnGetNodes();

    for (var i = 0; i < aTrs.length; i++) {
        var data = this.oTable.fnGetData(aTrs[i]);
        aReturn.push(data);
    }

    return aReturn;
}

Table.prototype.getSelectedData = function () {

    var anSelected = this.fnGetSelected();
    return this.oTable.fnGetData(anSelected[0]);
}

Table.prototype.getSelectedByIndex = function (_index) {

    var anSelected = this.fnGetSelected();
    var data = this.oTable.fnGetData(anSelected[0]);

    return data[_index];
}

Table.prototype.getDeletedRows = function (_index) {

    _index = _index || 0;

    var aReturn = new Array();

    for (var i = 0; i < this.deletedRows.length; i++) {
        aReturn.push(this.deletedRows[i][_index]);
    }

    return aReturn;
}

Table.prototype.nodeExists = function (_node) {

    var nodes = this.oTable.fnGetNodes();

    for (var i = 0; i < nodes.length; i++) {
        var data = this.oTable.fnGetData(nodes[i]);

        if (_node.compare(data)) {
            return true;
        }
    }

    return false;
}

Table.prototype.nodeExistsById = function (_node,row_id) {

    var nodes = this.oTable.fnGetNodes();

    for (var i = 0; i < nodes.length; i++) {
        var data = this.oTable.fnGetData(nodes[i]);
        if (_node[row_id]==data[row_id]) {
            return true;
        }
    }

    return false;
}

Table.prototype.fnGetSelected = function () {

    var aReturn = new Array();
    var aTrs = this.oTable.fnGetNodes();

    for (var i = 0; i < aTrs.length; i++) {
        if ($(aTrs[i]).hasClass('active')) {
            aReturn.push(aTrs[i]);
            i = aTrs.length + 1;
        }
    }

    return aReturn;
}