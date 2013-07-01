
var Dashboard = {

    settings: {
        columns: '.column',
        widgetSelector: '.widget',
        handleSelector: '.widget-head',
        contentSelector: '.widget-content',
        widgetDefault: {
            movable: true,
            removable: true,
            collapsible: true
        },
        widgetIndividual: {
            divID: {
                movable: false,
                removable: false,
                collapsible: false
            }
        }
    },

    init: function () {
        this.addWidgetControls();
        this.makeSortable();
    },

    getWidgetSettings: function (id) {
        var settings = this.settings;
        return (id && settings.widgetIndividual[id]) ? $.extend({}, settings.widgetDefault, settings.widgetIndividual[id]) : settings.widgetDefault;
    },

    addWidgetControls: function () {
        var Dashboard = this, settings = this.settings;

        $(settings.widgetSelector, $(settings.columns)).each(function () {
            var thisWidgetSettings = Dashboard.getWidgetSettings(this.id);
            var thisWidgetID = this.id;
            if ($('#' + this.id + ' div a').is('.remove') == false) {
                if (thisWidgetSettings.removable) {
                    $('<a href="#" class="remove">CLOSE</a>').mousedown(function (e) {
                        e.stopPropagation();
                    }).click(function () {
                        $('<div title="Remove Widget">Are you sure you want to remove the <span style="font-weight:bold;text-transform:uppercase;">' + $('#' + thisWidgetID).find('span').text() + '</span> widget?</div>').dialog({
                            resizable: false,
                            modal: true,
                            buttons: {
                                "Remove Widget": function () {
                                    $('#' + thisWidgetID).animate({
                                        opacity: 0
                                    }, function () {
                                        $(this).wrap('<div/>').parent().slideUp(function () {
                                            $(this).remove();
                                            
                                            //delete widget
                                        });
                                    });
                                    $(this).dialog("close");
                                },
                                Cancel: function () {
                                    $(this).dialog("close");
                                }
                            }
                        });
                        return false;
                    }).appendTo($(settings.handleSelector, this));
                }

                $('<a href="#" class="edit">EDIT</a>').mousedown(function (e) {
                    e.stopPropagation();
                }).click(function () {
                    Dashboard.configureWidget(thisWidgetID.replace('dw', ''));
                    return false;
                }).appendTo($(settings.handleSelector, this));

                if (thisWidgetSettings.collapsible) {
                    $('<a href="#" class="collapse">COLLAPSE</a>').mousedown(function (e) {
                        e.stopPropagation();
                    }).click(function () {
                        $(this).parents(settings.widgetSelector).toggleClass('collapsed');
                        var iframeID = 'iframe' + $(this).parent().parent().attr('id');
                        if (!$(this).parents(settings.widgetSelector).hasClass('collapsed'))
                            $('#' + iframeID).attr('src', $('#' + iframeID).attr('src'));
                        else
                            $('#' + iframeID).contents().find("div.container-fluid").html('');
                        Dashboard.savePreferences();
                        return false;
                    }).prependTo($(settings.handleSelector, this));
                }
            }
        });
    },

    attachStylesheet: function (href) {
        return $('<link href="' + href + '" rel="stylesheet" type="text/css" />').appendTo('head');
    },

    makeSortable: function () {
        var Dashboard = this,
            settings = this.settings,
            $sortableItems = (function () {
                var notSortable = '';
                $(settings.widgetSelector, $(settings.columns)).each(function (i) {
                    if (!Dashboard.getWidgetSettings(this.id).movable) {
                        if (!this.id) {
                            this.id = 'widget-no-id-' + i;
                        }
                        notSortable += '#' + this.id + ',';
                    }
                });
                if (notSortable.length == 0)
                    return $('> li', settings.columns);
                else
                    return $('> li:not(' + notSortable + ')', settings.columns);
            })();

        $sortableItems.find(settings.handleSelector).css({
            cursor: 'move'
        }).mousedown(function (e) {
            $sortableItems.css({ width: '' });
            $(this).parent().css({
                width: $(this).parent().width() + 'px'
            });
        }).mouseup(function () {
            if (!$(this).parent().hasClass('dragging')) {
                $(this).parent().css({ width: '' });
            } else {
                $(settings.columns).sortable('disable');
            }
        });

        $(settings.columns).sortable({
            items: $sortableItems,
            connectWith: $(settings.columns),
            handle: settings.handleSelector,
            placeholder: 'widget-placeholder',
            forcePlaceholderSize: true,
            revert: 300,
            delay: 100,
            opacity: 0.8,
            containment: 'document',
            start: function (e, ui) {
                $(ui.helper).addClass('dragging');
            },
            stop: function (e, ui) {
                $(ui.item).css({ width: '' }).removeClass('dragging');
                $(settings.columns).sortable('enable');
                Dashboard.savePreferences();
            }
        });
    },

    savePreferences: function () {
        var Dashboard = this,
				settings = this.settings,
				paramString = '';

        var columnPos = 0;

        $(settings.columns).each(function (i) {

            var sortOrder = 0;

            $(settings.widgetSelector, this).each(function (i) {
                var kpiName = $(this).attr('id');
                var kpiTitle = $(this).find('span').text();
                var kpiUrl = $(this).find('iframe').attr('src');
                var kpiColumnPos = columnPos;
                var kpiSortOrder = sortOrder++;
                var kpiExpanded = $(settings.contentSelector, this).css('display') === 'none' ? '0' : '1';

                paramString += kpiName + ':';
                paramString += kpiTitle + '|' + kpiUrl + '|' + kpiColumnPos + '|' + kpiSortOrder + '|' + kpiExpanded;
                paramString += ';';
            });

            columnPos++;

        });

        //save widget settings 
        //alert(paramString);
    },

    addWidget: function () {

        $('<div title="Add Widget" id="dialog_add_widget" style="overflow:hidden"><iframe src="widgets/addwidget.html" style="border:0px;width:100%;height:98%;" frameborder="0"></iframe></div>').dialog({
            resizable: false,
            width: 412,
            height: 375,
            modal: true,
            close: function (ev, ui) { $(this).remove(); }
        });

        $('#dialog_add_widget iframe').load(function () {
            $("#dialog_add_widget").dialog("option", "height", this.contentWindow.document.body.offsetHeight + 100);
        });

        return false;
    },

    addWidgetToDashboard: function (kpiTitle, kpiName) {
        //TODO: add widget

        //for demo purposes
        var rand = Math.floor(Math.random() * 10 + 1); ;

        var data = '<li id="' + kpiName + rand + '" class="widget"><div class="widget-head"><span>' + kpiTitle + '</span></div><div class="widget-content"><iframe id="iframe' + kpiName + rand + '" class="widget-iframe" style="overflow:hidden;" src="widgets/' + kpiName.toLowerCase() +'.html"></iframe></div></li>';

        if (window.parent.$('.container-fluid #columns').length > 0) {
            window.parent.$('.container-fluid #columns ul:first').append(data);
        }
        else {
            window.parent.$('.container-fluid').html('<div id="columns"><ul class="column">' + data + '</ul><ul class="column"></ul><ul class="column"></ul>');
        }

        window.parent.Dashboard.savePreferences();
        window.parent.Dashboard.addWidgetControls();
        window.parent.Dashboard.makeSortable();

        window.parent.$('#dialog_add_widget').remove();

        return false;
    },

    configureWidget: function (dwid) {

        $('<div title="Configure Widget" id="dialog_configure_widget" style="overflow:hidden"><iframe src="widgets/config.html" style="border:0px;width:100%;height:98%;" frameborder="0"></iframe></div>').dialog({
            resizable: false,
            width: 550,
            modal: true,
            buttons: {
                "Save Widget": function () {
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });

        $('#dialog_configure_widget iframe').load(function () {
            $("#dialog_configure_widget").dialog("option", "height", this.contentWindow.document.body.offsetHeight + 150);
        });

        return false;
    }

};