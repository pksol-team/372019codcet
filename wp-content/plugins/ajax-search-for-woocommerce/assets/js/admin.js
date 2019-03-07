(function ($) {

    var RADIO_SETTINGS_TOGGLE = {
        inputSel: 'dgwt-wcas-options-toggle input[type=radio]',
        groupSel: 'dgwt_wcas_settings-group',
        reloadChoices: function (name) {
            var _this = this,
                $group = $('[name="' + name + '"]').closest('.' + _this.groupSel),
                value = $('[name="' + name + '"]:checked').val(),
                currentClass = '';

            _this.hideAll($group);

            value = value.replace('_', '-');

            if (value.length > 0) {
                currentClass = 'wcas-opt-' + value;
            }

            if ($('.' + currentClass).length > 0) {
                $('.' + currentClass).fadeIn();
            }


        },
        hideAll: function ($group) {
            $group.find('tr[class*="wcas-opt-"]').hide();
        },
        registerListeners: function () {
            var _this = this;

            $('.' + _this.inputSel).on('change', function () {
                _this.reloadChoices($(this).attr('name'));
            });

        },
        init: function () {
            var _this = this,
                $sel = $('.' + _this.inputSel + ':checked');

            if ($sel.length > 0) {
                _this.registerListeners();

                $sel.each(function () {
                    _this.reloadChoices($(this).attr('name'));
                });

            }


        }

    };


    var CHECKBOX_SETTINGS_TOGGLE = {
        inputSel: 'dgwt-wcas-options-cb-toggle input[type=checkbox]',
        groupSel: 'dgwt_wcas_settings-group',
        reloadChoices: function ($el) {
            var _this = this,
                $group = $el.closest('.' + _this.groupSel),
                checked = $el.is(':checked'),
                currentClass = '';

            _this.hideAll($group);

            var classSuffix = $el.attr('name');
            classSuffix = classSuffix.replace('dgwt_wcas_settings[', '');
            classSuffix = classSuffix.replace(']', '');
            classSuffix = classSuffix.replace(new RegExp('_', 'g'), '-');

            if (checked) {
                currentClass = 'wcas-opt-' + classSuffix;
            }

            if (currentClass.length > 0 && $('.' + currentClass).length > 0) {
                $('.' + currentClass).fadeIn();
            }
            ;

        },
        hideAll: function ($group) {
            $group.find('tr[class*="wcas-opt-"]').hide();
        },
        registerListeners: function () {
            var _this = this;

            $('.' + _this.inputSel).on('change', function () {
                _this.reloadChoices($(this));
            });

        },
        init: function () {
            var _this = this,
                $sel = $('.' + _this.inputSel);

            if ($sel.length > 0) {
                _this.registerListeners();

                $sel.each(function () {
                    _this.reloadChoices($(this));
                });

            }


        }

    };

    var AJAX_BUILD_INDEX = {
        actionTriggerClass: 'js-ajax-build-index',
        actionStopTriggerClass: 'js-ajax-stop-build-index',
        indexingWrappoerClass: 'js-dgwt-wcas-indexing-wrapper',
        getWrapper: function () {
            var _this = this;

            return $('.' + _this.indexingWrappoerClass).closest('.dgwt-wcas-settings-info');
        },
        registerListeners: function () {
            var _this = this;

            $(document).on('click', '.' + _this.actionTriggerClass, function (e) {
                e.preventDefault();

                var $btn = $(this);

                $btn.attr('disabled', 'disabled');

                var emergency = $btn.hasClass('js-ajax-build-index-emergency') ? true : false;

                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'dgwt_wcas_build_index',
                        emergency: emergency
                    },
                    success: function (response) {
                        if (typeof response != 'undefined' && response.success) {
                            _this.getWrapper().html(response.data.html);
                            _this.heartbeat();
                        }
                    },
                    complete: function () {
                        $btn.removeAttr('disabled');
                    }
                });
            })

            $(document).on('click', '.' + _this.actionStopTriggerClass, function (e) {
                e.preventDefault();

                var $btn = $(this);

                $btn.attr('disabled', 'disabled');

                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'dgwt_wcas_stop_build_index',
                    },
                    success: function (response) {
                        if (typeof response != 'undefined' && response.success) {
                            _this.getWrapper().html(response.data.html);
                            _this.heartbeat();
                        }
                    },
                    complete: function () {
                        $btn.removeAttr('disabled');
                    }
                });
            })
        },
        heartbeat: function () {
            var _this = this;

            setTimeout(function () {

                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'dgwt_wcas_build_index_heartbeat',
                    },
                    success: function (response) {
                        if (typeof response != 'undefined' && response.success) {
                            _this.getWrapper().html(response.data.html);

                            if (response.data.loop) {
                                _this.heartbeat();
                            }

                        }
                    }
                });

            }, 1000);
        },
        detailsToggle: function () {
            var _this = this,
                display;


            $(document).on('click', '.js-dgwt-wcas-indexing-details-trigger', function (e) {
                e.preventDefault();

                var $details = $('.js-dgwt-wcas-indexer-details');

                if ($details.hasClass('show')) {
                    $details.removeClass('show');
                    $details.addClass('hide');
                    $('.js-dgwt-wcas-indexing__showd').addClass('show').removeClass('hide');
                    $('.js-dgwt-wcas-indexing__hided').addClass('hide').removeClass('show');
                    display = false;
                } else {
                    $details.addClass('show');
                    $details.removeClass('hide');
                    $('.js-dgwt-wcas-indexing__showd').addClass('hide').removeClass('show');
                    $('.js-dgwt-wcas-indexing__hided').addClass('show').removeClass('hide');
                    display = true;
                }

                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'dgwt_wcas_index_details_toggle',
                        display: display
                    }
                });
            });


        },
        init: function () {
            var _this = this;
            _this.registerListeners();

            if ($('.' + _this.indexingWrappoerClass).length > 0) {
                _this.heartbeat();
            }
            _this.detailsToggle();
        }
    };

    var AJAX_CLOSE_BACKWARD_COMPATIBILITY = {
        actionTriggerClass: 'js-dgwt-wcas-bc-wipe-all',
        switchLeftLabelClass: 'js-dgwt-wcas-switch-left',
        switchRightLabelClass: 'js-dgwt-wcas-switch-right',
        switcherClass: 'js-dgwt-wcas-switcher',
        remindMeLaterClass: 'js-dgwt-wcas-bc-remind-me',
        applyChanges: function () {
            var _this = this;


            jQuery(document).on('click', '.' + _this.actionTriggerClass, function (e) {
                e.preventDefault();

                var $btn = $(this);

                $btn.attr('disabled', 'disabled');
                jQuery.ajax({
                    url: ajaxurl,
                    type: 'post',
                    data: {
                        action: 'dgwt_wcas_bc_keep_latest',
                    },
                    success: function (response) {

                        if (typeof response.success != 'undefined' && response.success) {

                            $('.dgwt_wcas_basic-tab').click();

                            $('.js-dgwt-wcas-bc-notice').fadeOut(400, function () {
                                $(this).remove();
                            });
                        }
                    },
                    complete: function () {
                        $btn.removeAttr('disabled');
                    }
                });
            })

        },
        switchAjaxRequest: function (state, visualChange) {
            var _this = this,
                $switcher = $('.dgwt-wcas-bc-switcher'),
                $errorNotice = $('.dgwt-wcas-bc-error'),
                $successNotice = $('.dgwt-wcas-bc-success'),
                $spinner = $('.js-dgwt-wcas-bc-spinner');

            $switcher.addClass('dgwt-wcas-non-events');
            $spinner.removeClass('dgwt-wcas-hidden');
            $errorNotice.addClass('dgwt-wcas-hidden');
            $successNotice.addClass('dgwt-wcas-hidden');

            state = state === 'enable' ? 'enable' : 'disable';

            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'dgwt_wcas_bc_toggle',
                    state: state
                },
                success: function (response) {

                    if (typeof response.success != 'undefined' && response.success) {
                        visualChange();
                        if (state === 'disable') {
                            _this.flashStepsContainer();
                        }
                        setTimeout(function () {
                            $successNotice.removeClass('dgwt-wcas-hidden');
                        }, 500);
                        setTimeout(function () {
                            $successNotice.addClass('dgwt-wcas-hidden');
                        }, 2000);


                    } else {
                        $switcher.removeClass('dgwt-wcas-non-events');
                        $spinner.addClass('dgwt-wcas-hidden');
                        $errorNotice.removeClass('dgwt-wcas-hidden');
                    }

                },
                error: function () {
                    $errorNotice.removeClass('dgwt-wcas-hidden');
                },
                complete: function () {
                    $switcher.removeClass('dgwt-wcas-non-events');
                    $spinner.addClass('dgwt-wcas-hidden');
                }
            });

        },
        enableBC: function () {
            var _this = this;

            _this.switchAjaxRequest('enable', function () {
                $('.' + _this.switcherClass).attr('checked', true);
                $('.' + _this.switchLeftLabelClass).addClass('dgwt-wcas-toggler--is-active');
                $('.' + _this.switchRightLabelClass).removeClass("dgwt-wcas-toggler--is-active");
                $('.dgwt-wcas-toggle').addClass('dgwt-wcas-toggle--mute');

                $('.js-dgwt-wcas-todo-old').removeClass('dgwt-wcas-hidden');
                $('.js-dgwt-wcas-todo-latest').addClass('dgwt-wcas-hidden');
            });


        },
        disableBC: function () {
            var _this = this;

            _this.switchAjaxRequest('disable', function () {
                $('.' + _this.switcherClass).attr('checked', false);
                $('.' + _this.switchRightLabelClass).addClass('dgwt-wcas-toggler--is-active');
                $('.' + _this.switchLeftLabelClass).removeClass("dgwt-wcas-toggler--is-active");
                $('.dgwt-wcas-toggle').removeClass('dgwt-wcas-toggle--mute');

                $('.js-dgwt-wcas-todo-old').addClass('dgwt-wcas-hidden');
                $('.js-dgwt-wcas-todo-latest').removeClass('dgwt-wcas-hidden');
            });

        },
        remindMeLater: function () {
            jQuery.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'dgwt_wcas_bc_remind_me_later',
                },
                success: function (response) {

                    if (typeof response.success != 'undefined' && response.success) {
                        $('.js-dgwt-wcas-bc-notice').fadeOut(400, function () {
                            $(this).remove();
                        });
                    }

                }
            });
        },
        flashStepsContainer: function () {
            var _this = this,
                $container = $('.dgwt-wcas-bc-todo-wrapp');
            $container.addClass('dgwt-wcas-anim-shake');
            setTimeout(function () {
                $container.removeClass('dgwt-wcas-anim-shake');
            }, 2000)
        },
        switchListeners: function () {
            var _this = this;

            $('.' + _this.switchLeftLabelClass).on('click', function () {
                _this.enableBC();
            });

            $('.' + _this.switchRightLabelClass).on('click', function () {
                _this.disableBC();
            });

            $('.' + _this.switcherClass).on('click', function (e) {
                e.preventDefault();

                if ($('.' + _this.switcherClass).is(':checked')) {
                    _this.enableBC();
                } else {
                    _this.disableBC();
                }

            });

            $('.' + _this.remindMeLaterClass).on('click', function (e) {
                e.preventDefault();

                _this.remindMeLater();
            });

        },
        init: function () {
            var _this = this;
            _this.applyChanges();
            _this.switchListeners();
        }
    };

    function automateSettingsColspan() {
        var $el = $('.js-dgwt-wcas-sgs-autocolspan');
        if ($el.length > 0) {
            $el.find('td').attr('colspan', 2);
        }
    }


    $(document).ready(function () {
        RADIO_SETTINGS_TOGGLE.init();
        CHECKBOX_SETTINGS_TOGGLE.init();

        automateSettingsColspan();

        AJAX_CLOSE_BACKWARD_COMPATIBILITY.init();

        AJAX_BUILD_INDEX.init();
    });


})(jQuery);

