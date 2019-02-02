String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};
/**
 *	Carrega HTML por AJAX.
 *
 *	@param	_controller		Controller URL
 *	@param	_file			File name
 *	@param	_elem			Elemento a ser carregado o HTML
 *	@param	_subfolder		Subpasta em views (default null)
 */
function loadHTML(_controller, _file, _elem, _subfolder) {

    _subfolder = _subfolder || null;

    var $elem = $('#' + _elem);

    // Gerando URL
    var url = Array(_controller, _file, _elem, _subfolder).join('/');

    $.ajax({
        url: url,
        success: function (data) {
            $elem.html(data);
        }
    });
}

/**
 *	Carrega as funcionalidades do menu
 *
 *	@param	_option		Opção de carregamento do menu (default: 'all')
 *						Opções: all, dropdown, selectable, scrollable
 */
function loadMenuFeatures(_option) {

    _option = _option || 'all';

    // Aguarda o carregamento dos objetos
    setTimeout(function () {

        switch (_option) {

            // Menus dropdown
            case 'dropdown' :
                $('.dropdown-toggle').dropdown();
                break;

                // Itens do menu selecionáveis
            case 'selectable' :
                $('.overflow-menu').selectable();
                break;

                // Menu deslizante
                //case 'scrollable' : $('.overflow-menu').scrollable(); break;

                // Todas as opções
            default :
                $('.dropdown-toggle').dropdown();
                $('.overflow-menu').selectable();
                //$('.overflow-menu').scrollable();
                break;
        }

    }, 100);
}

/**
 *	Habilita "seleção" dos itens do menu
 */
$.fn.selectable = function () {

    // Menus sem 'dropdown'
    $('.selectable > li').mousedown(function (e) {
        var $this = $(this);

        if (!$this.hasClass('dropdown') && !$this.hasClass('none')) {
            var children = $this.parent().children();

            for (var i = 0; i < children.length; i++) {
                var $child = $(children[i]);

                if ($child.hasClass('active')) {
                    $child.removeClass('active');
                }
            }

            $this.addClass('active');
            e.preventDefault();
        }
    });

    // Menus com 'dropdown'
    $('ul.drop > li').mouseup(function (e) {
        var children = $('.selectable').children();

        for (var i = 0; i < children.length; i++) {
            var $child = $(children[i]);

            if ($child.hasClass('active')) {
                $child.removeClass('active');
            }
        }

        var $this = $(this);
        var $parent = $this.parent().parent();

        $parent.addClass('active');
        e.preventDefault();
    });
}

/**
 *	Torna o menu deslizante
 */
$.fn.scrollable = function () {
    var $this = $(this);
    var $menu = $('.scrollable');

    /**
     *	Evita que parte do menu continue escondido
     *	mesmo quando seu deslocamento é realizado
     */
    //var padding = 30;
    var padding = 0;

    // Último elemento do menu
    var $child = $menu.children().last();

    // Tamanho da área deslizante
    var width = $this.width();

    // Quantidade de pixels escondidos da área não-visível do menu
    limit = $child.offset().left - $this.offset().left - padding;

    /* Aguarda o carregamento do objeto
     setTimeout(function () {
     
     // Habilita o deslizamento do menu
     if (limit < 0) {
     
     // Define posição inicial do menu
     $menu.attr('style','margin-right: '+ limit +'px !important');
     }
     
     },50);*/

    // Evento do mouse
    $this.mouseover(function (e) {

        // Habilita o deslizamento do menu
        if (limit < 0) {

            /**
             *	Calcula quantos pixels devem ser deslocados
             *	utilizando a equação fundamental da reta 
             */
            margin = ((e.pageX - $this.offset().left) / (width / -limit)) + limit;

            // Desliza o menu
            $menu.attr('style', 'margin-right: ' + margin + 'px !important');
        }
    });
}

function request(_url, _data, _fn, _callback) {

    _fn = _fn || 'show';

    // Exibe mensagem de processamento
    processMessage('status');

    // Faz requisição de login ao servidor (retorna um objeto JSON)
    $.ajax({
        url: _url,
        type: 'POST',
        dataType: 'json',
        data: _data,
        timeout: 20000,
        success: function (data) {

            console.log(data.debug);
            // Login autorizado
            if (data.success) {

                _fn == 'show' ? showMessage('status', data) : hideMessage('status');

                $("#desc-course").fadeOut(400);
                // Carrega conteúdo da nova view
                $('#content').fadeOut().queue(function (next) {
                    $(this)
                            .html(data.html.content)
                            .delay(500)
                            .fadeIn("slow");
                    next();
                });

                if (data.html.top_menu !== undefined) {

                    // Carrega conteúdo do menu
                    $('#top_menu').fadeOut().queue(function (next) {
                        $(this)
                                .html(data.html.top_menu)
                                .delay(500)
                                .fadeIn("slow");
                        next();
                    });
                }

                if (data.html.course_info !== undefined) {

                    // Carrega informção sobre o curso seleconado
                    $('#course_info').fadeOut().queue(function (next) {
                        $(this)
                                .html(data.html.course_info)
                                .delay(500)
                                .fadeIn("slow");
                        next();
                    });
                }

                if (_callback && _callback.success) {
                    _callback.success();
                }

                // Login não autorizado
            } else {
                showMessage('status', data); // Exibe mensagem de erro
            }
        },
        error: function (data) {

            console.log(data);

            // Falha na requisição
            var error = {
                'success': false,
                'message': 'Falha na requisição. Tente novamente em instantes.'
            };

            showMessage('status', error); // Exibe mensagem de erro
        }

    });
}

function requestMultipart(_url, _idform, _fn, _append) {

    _fn = _fn || 'show';

    var _data = new FormData($("#" + _idform)[0]);

    // Exibe mensagem de processamento
    processMessage('status');
    if (_append) {
        for (var key in _append) {
            var value = _append[key];
            console.log(key);
            console.log(value);
            _data.append(key, value);
        }
    }
    console.log(_data);

    // Faz requisição de login ao servidor (retorna um objeto JSON)
    $.ajax({
        url: _url,
        type: 'POST',
        dataType: 'json',
        data: _data,
        timeout: 20000,
        processData: false,
        contentType: false,
        success: function (data) {

            // Login autorizado
            if (data.success) {

                _fn == 'show' ? showMessage('status', data) : hideMessage('status');

                // Carrega conteúdo da nova view
                $('#content').fadeOut().queue(function (next) {
                    $(this)
                            .html(data.html.content)
                            .delay(500)
                            .fadeIn("slow");
                    next();
                });

                if (data.html.top_menu !== undefined) {

                    // Carrega conteúdo do menu
                    $('#top_menu').fadeOut().queue(function (next) {
                        $(this)
                                .html(data.html.top_menu)
                                .delay(500)
                                .fadeIn("slow");
                        next();
                    });
                }

                if (data.html.course_info !== undefined) {

                    // Carrega informção sobre o curso seleconado
                    $('#course_info').fadeOut().queue(function (next) {
                        $(this)
                                .html(data.html.course_info)
                                .delay(500)
                                .fadeIn("slow");
                        next();
                    });
                }

                // Login não autorizado
            } else {
                showMessage('status', data); // Exibe mensagem de erro
            }
        },
        error: function (data) {

            console.log(data);

            // Falha na requisição
            var error = {
                'success': false,
                'message': 'Falha na requisição. Tente novamente em instantes.'
            };

            showMessage('status', error); // Exibe mensagem de erro
        }

    });
}

function requestWithoutRedirect(_url, _data, _fn) {

    _fn = _fn || 'show';
    // Exibe mensagem de processamento
    processMessage('status');

    // Faz requisição de login ao servidor (retorna um objeto JSON)
    $.ajax({
        url: _url,
        type: 'POST',
        dataType: 'json',
        data: _data,
        timeout: 20000,
        success: function (data) {

            // Login autorizado
            if (data.success) {
                showMessage('status', data); // Exibe mensagem de erro
                if (_fn.callback) {
                    _fn.callback();
                }
                // Login não autorizado
            } else {
                showMessage('status', data); // Exibe mensagem de erro
            }
        },
        error: function (data) {

            console.log(data);

            // Falha na requisiçãoz\
            var error = {
                'success': false,
                'message': 'Falha na requisição. Tente novamente em instantes.'
            };

            showMessage('status', error); // Exibe mensagem de erro
        }

    });
}

function validateFile(_fileid, maxsize, allowedTypes) {
    if ($("#" + _fileid).get(0).files.length != 0) {
        $elem = $("#" + _fileid);
        var file = $elem.get(0).files[0];
        var key = false;
        for (var i = 0; i < allowedTypes.length; i++) {
            if (allowedTypes[i] == file.type) {
                key = true;
                break;
            }
        }
        if (key) {
            if (parseInt(file.size) < maxsize) {
                $elem.hideErrorMessage();
                $elem.get(0).validate = true;
                return true;
            } else {
                $elem.showErrorMessage("Arquivo excedeu o tamanho limite de " + ((maxsize / 1024) / 1024) + " MB");
            }
        } else {
            $elem.showErrorMessage("Formato inválido");
        }
    } else {
        $elem.showErrorMessage("Selecione o arquivo");
    }
    $elem.get(0).validate = false;
    return false;
}


/**
 *	Exibe uma mensagem de erro refente ao campo do formulário.
 *
 *	@param	_msg	Mensagem de erro
 */
$.fn.showErrorMessage = function (_msg) {
    var $this = $(this);

    switch ($this.getInputType()) {

        case 'text' :
        case 'password' :
        case 'email' :
        case 'textarea' :

            var $label = $('label[for="' + $this.attr('id') + '"]');
            var $parent = $this.parent().parent();

            if (!$parent.hasClass('has-error')) {
                $parent.addClass('has-error');
            }

            $label.html(_msg);
            $label.show();

            break;

        case 'select' :

            var $label = $('label[for="' + $this.attr('id') + '"]');
            var $parent = $this.parent().parent();

            if (!$parent.hasClass('has-error')) {
                $parent.addClass('has-error');
            }

            $label.html(_msg);
            $label.parent().show();

            break;

        default :

            var $label = $('label[for="' + $this.attr('name') + '"]');
            var $parent = $this.parent().parent().parent().parent();

            if (!$parent.hasClass('has-error')) {
                $parent.addClass('has-error');
            }

            $label.html(_msg);
            $label.parent().show();

            break;
    }
}

/**
 *	Esconde a mensagem de erro do campo do formulário.
 */
$.fn.hideErrorMessage = function () {
    var $this = $(this);

    switch ($this.getInputType()) {

        case 'text' :
        case 'password' :
        case 'email' :
        case 'textarea' :

            var $label = $('label[for="' + $this.attr('id') + '"]');
            var $parent = $this.parent().parent();

            if ($parent.hasClass('has-error')) {
                $parent.removeClass('has-error');
            }

            $label.html('');
            $label.hide();

            break;

        case 'select' :

            var $label = $('label[for="' + $this.attr('id') + '"]');
            var $parent = $this.parent().parent();

            if ($parent.hasClass('has-error')) {
                $parent.removeClass('has-error');
            }

            $label.html('');
            $label.parent().hide();

            break;

        default :

            var $label = $('label[for="' + $this.attr('name') + '"]');
            var $parent = $this.parent().parent().parent().parent();

            if ($parent.hasClass('has-error')) {
                $parent.removeClass('has-error');
            }

            $label.html('');
            $label.parent().hide();

            break;
    }
}

/**
 *	Verifica se o conteúdo de uma input é vazio.
 *
 *	@return	boolean		TRUE, se vazio, FALSE, caso contrário
 */
$.fn.isEmpty = function () {
    var $this = $(this);

    switch ($this.getInputType()) {

        case 'text' :
        case 'password' :
        case 'email' :
        case 'textarea' :
            return ($this.val().length == 0) ? true : false;

        case 'radio' :
            var $radio = $('input:radio[name=' + $this.attr('name') + ']:checked');
            return ($radio.val() === undefined) ? true : false;

        case 'checkbox' :
            //return (! $this.prop('checked'));
            var $checkbox = $('input:checkbox[name=' + $this.attr('name') + ']:checked');
            return ($checkbox.val() === undefined) ? true : false;

        case 'select' :
            return ($this.val() === null) ? true : false;
    }
}

/**
 *	Retorna o tipo de uma input
 *
 *	@return 	Tipo da input
 */
$.fn.getInputType = function () {
    return this[0].tagName.toString().toLowerCase() === "input" ?
            $(this[0]).prop("type").toLowerCase() :
            this[0].tagName.toLowerCase();
}

/**
 *	Verifica se os campos do formulário foram preenchidos e são válidos.
 *
 *	@param	_form		Objeto com IDs das inputs e mensages de erro
 *
 *	@return	boolean		TRUE, se completo, FALSE, caso contrário
 */
function isFormComplete(_form) {
    var flag = true;
    var top = false;

    for (var i = 0; i < _form.length; i++) {

        $elem = (_form[i].id !== undefined) ?
                $('#' + _form[i].id) : $('[name=' + _form[i].name + ']');

        var ni = (_form[i].ni !== undefined) ? !_form[i].ni : true;

        // Verifica se o campo está vazio
        if ($elem.isEmpty() && ni) {
            $elem.showErrorMessage(_form[i].message);
            flag = false;

            // Rola página até onde está o primeiro erro
            if (!top) {
                scrollPage($elem);
                top = true;
            }

            // Ignora próxima verificação e esconde a mensagem de erro
            if (_form[i].next === false) {
                $next = (_form[++i].id !== undefined) ?
                        $('#' + _form[i].id) : $('[name=' + _form[i].name + ']');

                $next.hideErrorMessage();
            }

            // Ignora as próximas verificações e esconde as mensagens de erro
            if (_form[i].ignore !== undefined) {
                for (var j = 0; j < _form[i].ignore; j++) {
                    $next = (_form[++i].id !== undefined) ?
                            $('#' + _form[i].id) : $('[name=' + _form[i].name + ']');

                    $next.hideErrorMessage();
                }
            }

            // Verifica se o campo possui alguma validação extra
        } else if (_form[i].extra != null) {

            // Busca e realiza operação de validação
            switch (_form[i].extra.operation) {
                // Valida CPF
                case 'cpf' :

                    if (!cpfValidate($elem.val())) {
                        $elem.showErrorMessage(_form[i].extra.message);
                        flag = false;

                        // Rola página até onde está o primeiro erro
                        if (!top) {
                            scrollPage($elem);
                            top = true;
                        }

                    } else {
                        $elem.hideErrorMessage();
                    }

                    break;

                    // Valida email
                case 'email' :

                    if (!emailValidate($elem.val())) {
                        $elem.showErrorMessage(_form[i].extra.message);
                        flag = false;

                        // Rola página até onde está o primeiro erro
                        if (!top) {
                            scrollPage($elem);
                            top = true;
                        }

                    } else {
                        $elem.hideErrorMessage();
                    }

                    break;

                    // Valida data
                case 'date' :

                    if (!dateValidate($elem.val()) && ni) {
                        $elem.showErrorMessage(_form[i].extra.message);
                        flag = false;

                        // Rola página até onde está o primeiro erro
                        if (!top) {
                            scrollPage($elem);
                            top = true;
                        }

                    } else {
                        $elem.hideErrorMessage();
                    }

                    break;

                    // Verifica se senhas são iguais
                case 'match' :

                    if (!matchValues($elem.val(), _form[i].extra.value)) {
                        $elem.showErrorMessage(_form[i].extra.message);
                        flag = false;

                        // Rola página até onde está o primeiro erro
                        if (!top) {
                            scrollPage($elem);
                            top = true;
                        }

                    } else {
                        $elem.hideErrorMessage();
                    }

                    break;
                case 'password':
                    if ($elem[0].value.length <= 4) {
                        $elem.showErrorMessage(_form[i].extra.message);
                        flag = false;

                        // Rola página até onde está o primeiro erro
                        if (!top) {
                            scrollPage($elem);
                            top = true;
                        }

                    } else {
                        $elem.hideErrorMessage();
                    }
                    break;
                case 'pattern':
                    if ($elem[0].validity.patternMismatch) {
                        $elem.showErrorMessage(_form[i].extra.message);
                        flag = false;

                        // Rola página até onde está o primeiro erro
                        if (!top) {
                            scrollPage($elem);
                            top = true;
                        }

                    } else {
                        $elem.hideErrorMessage();
                    }
                    break;
            }

            // Campo validado
        } else {
            $elem.hideErrorMessage();
        }
    }

    return flag;
}

function scrollPage(_elem, _offset) {

    _offset = _offset || -160;

    $('html,body').animate({scrollTop: (_elem.offset().top + _offset)}, 500);
}

$.fn.niCheck = function (_obj) {
    var $checkbox = $(this);

    $checkbox.change(function () {
        if ($checkbox.is(':checked')) {
            if (_obj.beforeoncheck) {
                _obj.beforeoncheck();
            }
        } else {
            if (_obj.beforeonuncheck) {
                _obj.beforeonuncheck();
            }
        }
        $.each(_obj, function (key, value) {

            for (var i = 0; i < value.length; i++) {

                var $elem;

                switch (key) {
                    case 'id':
                        $elem = $('#' + value[i]);
                        break;

                    case 'name':
                        $elem = $('[name=' + value[i] + ']');
                        break;

                    case 'class':
                        $elem = $('.' + value[i]);
                        break;
                }
                if ($elem) {
                    $elem.each(function (index) {
                        if ($checkbox.is(':checked')) {

                            switch ($(this).getInputType()) {
                                case 'select':
                                    if (_obj.niValue) {
                                        $(this).val(_obj.niValue[index]);
                                    } else {
                                        $(this).val(0);
                                    }
                                    $(this).attr('disabled', true);
                                    break;
                                case 'text' :
                                case 'textarea' :
                                    $(this).val('');
                                    $(this).attr('disabled', true);
                                    break;

                                case 'radio' :
                                    $(this).attr('checked', false);
                                    $(this).attr('disabled', true);
                                    break;

                                case 'checkbox' :
                                    if ($(this).prop('checked')) {
                                        $(this).click();
                                    }

                                    $(this).attr('disabled', true);
                                    break;

                                default:
                                    $(this).attr('disabled', true);
                                    break;
                            }

                        } else {
                            $(this).removeAttr('disabled');
                        }
                    });
                }
            }
        });
        if ($checkbox.is(':checked')) {
            if (_obj.oncheck) {
                _obj.oncheck();
            }
        } else {
            if (_obj.onuncheck) {
                _obj.onuncheck();
            }
        }

    }).change();
}

/**
 *
 *
 *	@param	_obj
 *	@param	_val
 */
$.fn.optionCheck = function (_obj, _val) {

    $.fn.showInput = function () {
        $(this).show();
        $(this).focus();
    }

    $.fn.hideInput = function () {
        switch ($(this).getInputType()) {
            case 'text' :
            case 'textarea' :
                $(this).val('');
                $(this).hide();
                break;
        }
    }

    var $element = $(this);

    _val = _val || null;

    $element.change(function () {

        $.each(_obj, function (key, value) {

            for (var i = 0; i < value.length; i++) {

                var $elem;

                switch (key) {
                    case 'id':
                        $elem = $('#' + value[i]);
                        break;

                    case 'name':
                        $elem = $('[name=' + value[i] + ']');
                        break;

                    case 'class':
                        $elem = $('.' + value[i]);
                        break;
                }

                $elem.each(function () {
                    if ($element.is(':checked')) {
                        if ($element.getInputType() == 'radio') {

                            if ($(getCheckedRadio($element)).val() == _val) {
                                $(this).showInput();

                            } else {
                                $(this).hideInput();
                            }

                        } else {
                            $(this).showInput();
                        }

                    } else {
                        $(this).hideInput();
                    }
                });
            }
        });

    }).change();
}

/**
 *
 *
 *	@param	_url
 */
$.fn.tableInit = function (_url) {

    var oTable = $(this).dataTable({
        "bProcessing": true,
        "sPaginationType": "bootstrap",
        "sAjaxSource": _url
    });
    ;

    /* Add a click handler to select the rows */
    $(this).find('tbody').click(function (event) {
        $(oTable.fnSettings().aoData).each(function () {
            $(this.nTr).removeClass('active');
        });

        $(event.target.parentNode).addClass('active');
    });

    /* Add a click handler for the delete row */
    $('.delete-row').click(function () {
        var anSelected = fnGetSelected();
        if (anSelected.length !== 0) {
            oTable.fnDeleteRow(anSelected[0]);
        }
    });

    $.fn.hideColumns = function (_values) {
        for (var i = 0; i < _values.length; i++) {
            oTable.fnSetColumnVis(_values[i], false);
        }
    }

    $.fn.getAllByIndex = function (_index) {
        var aReturn = new Array();
        var aTrs = oTable.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            var data = oTable.fnGetData(aTrs[i]);
            aReturn.push(data[_index]);
        }

        return aReturn;
    }

    $.fn.getAll = function () {
        var aReturn = new Array();
        var aTrs = oTable.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            var data = oTable.fnGetData(aTrs[i]);
            aReturn.push(data);
        }

        return aReturn;
    }

    $.fn.getSelectedByIndex = function (_index) {
        var anSelected = fnGetSelected();
        var data = oTable.fnGetData(anSelected[_index]);
        return data[_index];
    }

    $.fn.nodeExists = function (_node) {
        var nodes = oTable.fnGetNodes();

        for (var i = 0; i < nodes.length; i++) {
            var data = oTable.fnGetData(nodes[i]);

            if (_node.compare(data)) {
                return true;
            }
        }

        return false;
    }

    function fnGetSelected() {
        var aReturn = new Array();
        var aTrs = oTable.fnGetNodes();

        for (var i = 0; i < aTrs.length; i++) {
            if ($(aTrs[i]).hasClass('active')) {
                aReturn.push(aTrs[i]);
                i = aTrs.length + 1;
            }
        }

        return aReturn;
    }
}

$.fn.dialogInit = function (_function, _size) {

    _size = _size || [450, 200];

    $(this).dialog({
        autoOpen: true,
        width: _size[0],
        height: _size[1],
        modal: true,
        buttons: {
            'Sim': function () {

                if (_function()) {
                    $(this).dialog('close');
                }
            },
            'Não': function () {
                $(this).dialog('close');
            }
        }
    });
}

$.fn.listCities = function (_url, _elem_city_id) {
    var $this = $(this);
    var $elemCity = $('#' + _elem_city_id);
    
    $this.change(function () {
        var state_id = $this.val();
        $elemCity.html("<option>Aguarde...</option>");

        $.get(_url + '/' + state_id, function (cities) {
            $elemCity.html(cities);
        });

    }).change();

};

$.fn.listFallbackJson = function (_url, _elem_city_id) {
    var $this = $(this);
    var $elemCity = $('#' + _elem_city_id);
    var atual_request = false;

    $this.change(function () {
        var state_id = $this.val();
        $elemCity.html("<option>Aguarde...</option>");
        if (atual_request !== false) {
            atual_request.abort();
        }
        atual_request = $.get(_url + '/' + state_id, function (cities) {
            atual_request = false;
            $elemCity.html(cities);
        });

    }).change();

};


$.fn.listCourses = function (_url, _elem_course_id) {
    var $this = $(this);
    var $elemCourse = $('#' + _elem_course_id);

    $this.change(function () {
        var super_id = $this.val();

        $elemCourse.html("<option>Aguarde...</option>");

        $.get(_url + '/' + super_id, function (courses) {
            $elemCourse.html(courses);
        });

    }).change();
}

$.fn.listModality = function (_url, _elem_modality_id) {
    var $this = $(this);
    var $elemModality = $('#' + _elem_modality_id);

    $this.change(function () {
        var super_id = $this.val();

        $elemModality.html("<option>Aguarde...</option>");

        $.get(_url + '/' + super_id, function (modalitys) {
            $elemModality.html(modalitys);
        });

    }).change();
}

/**
 *	Exibe mensagem de processamento na tela
 *
 *	@param	_elem	Elemento para exibir a mensagem
 */
function processMessage(_elem) {
    $('#' + _elem).removeClass();
    $('#' + _elem).addClass('alert alert-warning');
    $('#' + _elem).html('Processando...');
    $('#' + _elem).show(100);
}

/**
 *	Exibe mensagem de resposta na tela
 *
 *	@param	_elem	Elemento para exibir a mensagem
 *	@param	_resp	Dados da mensagem
 */
function showMessage(_elem, _resp) {

    // Estilos da mensagem
    var arrayStyle = Array('alert alert-danger', 'alert alert-success');

    // Botão para fechar a caixa de diálogo
    var btnClose =
            '<span class="status glyphicon glyphicon-remove"' +
            'onclick="$(this).parent().slideToggle(100);">' +
            '</span>';

    var style = _resp.success ? arrayStyle[1] : arrayStyle[0];
    var msg = _resp.message + btnClose;

    $('#' + _elem).removeClass();
    $('#' + _elem).addClass(style);
    $('#' + _elem).html(msg);
}

/**
 *	Esconde mensagem de resposta na tela
 *
 *	@param	_elem	Elemento para esconder a mensagem
 */
function hideMessage(_elem) {
    $('#' + _elem).hide(100);
}

function getCheckedRadio(radio_group) {
    for (var i = 0; i < radio_group.length; i++) {
        var button = radio_group[i];
        if (button.checked) {
            return button;
        }
    }
    return undefined;
}

/**
 *	Captura o URL base da aplicação
 *
 *	@param 	_url	'<?=base_url()?>'
 *
 *	@return	String	URL base da aplicação
 *
 function baseURL (_url) {
 if (_url.indexOf("index.php") < 0) {
 _url += 'index.php';
 }
 
 _url += '/';
 
 return _url;
 }
 
 /**
 *	Inibe a inserção de caracteres específicos
 *
 *	@param	_type	['9'] (numéricos) / ['A' || null] (demais)
 *	@param	_evt	Evento
 *
 *	@return	Char 	Caracter válido
 */
function preventChar(event) {
    if ((event.key >= "0" && event.key <= "9")
            || event.key === "Backspace"
            || (event.keyCode >= 37 && event.keyCode <= 40)
            || event.ctrlKey) {
    } else {
        event.preventDefault();
    }

}

/**
 *	Valida um número de cpf
 *
 *	@param 	_cpf 	Número de CPF a ser validado
 *
 *	@return		TRUE, se o CPF é válido, FALSE, caso contrário
 */
function cpfValidate(_cpf) {
    _cpf = _cpf.replace(/[^\d]+/g, '');

    if ((_cpf == '') || (_cpf.length != 11)) {
        return false;

    } else {

        // Valida 1º dígito
        add = 0;
        for (i = 0; i < 9; i++) {
            add += parseInt(_cpf.charAt(i)) * (10 - i);
        }

        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11) {
            rev = 0;
        }

        if (rev != parseInt(_cpf.charAt(9))) {
            return false;
        }

        // Valida 2º dígito
        add = 0;
        for (i = 0; i < 10; i++) {
            add += parseInt(_cpf.charAt(i)) * (11 - i);
        }

        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11) {
            rev = 0;
        }

        if (rev != parseInt(_cpf.charAt(10))) {
            return false;
        }
    }

    return true;
}

function emailValidate(_email) {

    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    return re.test(_email);
}

function dateValidate(_date) {

    var bissexto = 0;
    var data = _date;
    var tam = data.length;

    if (tam == 7) {
        data = '01/' + data;
    }

    tam = data.length;

    if (tam == 10) {

        var dia = data.substr(0, 2)
        var mes = data.substr(3, 2)
        var ano = data.substr(6, 4)

        if ((ano > 1900) && (ano < 2100)) {

            switch (mes) {

                case '01':
                case '03':
                case '05':
                case '07':
                case '08':
                case '10':
                case '12':

                    if (dia <= 31) {
                        return true;
                    }

                    break;

                case '04':
                case '06':
                case '09':
                case '11':

                    if (dia <= 30) {
                        return true;
                    }

                    break;

                case '02':

                    /* Validando ano Bissexto / fevereiro / dia */
                    if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) {
                        bissexto = 1;
                    }

                    if ((bissexto == 1) && (dia <= 29)) {
                        return true;
                    }

                    if ((bissexto != 1) && (dia <= 28)) {
                        return true;
                    }

                    break;
            }
        }
    }

    return false;
}

function matchValues(_passwd1, _passwd2) {

    return (_passwd1 == _passwd2) ? true : false;
}

// attach the .compare method to Array's prototype to call it on any array
Array.prototype.compare = function (_array) {
    // if the other array is a falsy value, return
    if (!_array)
        return false;

    // compare lengths - can save a lot of time
    if (this.length != _array.length)
        return false;

    for (var i = 0; i < this.length; i++) {
        // Check if we have nested arrays
        if (this[i] instanceof Array && _array[i] instanceof Array) {
            // recurse into the nested arrays
            if (!this[i].compare(_array[i]))
                return false;
        } else if (this[i] != _array[i]) {
            // Warning - two different object instances will never be equal: {x:20} != {x:20}
            return false;
        }
    }
    return true;
}

function subtrDate(_date_1, _date_2) {

    if ((_date_1.length > 0) && (_date_2.length > 0)) {

        var date1 = _date_1.split("/");
        var date2 = _date_2.split("/");

        var year1 = date1[date1.length - 1];
        var year2 = date2[date2.length - 1];

        var dif = year2 - year1 + 1;

        return (dif > 0) ? dif : false;

    } else {

        return false;
    }
}