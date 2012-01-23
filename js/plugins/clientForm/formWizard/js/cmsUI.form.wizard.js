$.widget('cmsUI.formwizard', $.ui.formwizard, {

    lockFlag:false,
    id:'',
    exit:false,
    needSaveOnServer:false,
    saveOnServerInterval:{},
    saveInStorageInterval:{},
    serializeForms:new Object,
    options:{
        preloader:'#preloader',
        back:".prev",
        next:".next",
        disableInputFields:false, //no set to true, serialize wont working
        disableUIStyles:true,
        saveUrl:'',
        loadUrl:'',
        cookieSettings:{},
        saveOnServerInterval:20000,
        saveInStorageInterval:3000,
        userId:null,
        validationUrl:''
    },
    _parent:function()
    {
        return $.ui.formwizard.prototype;
    },

    _init:function()
    {
        this._preloaderShow();
        this._parent()._init.call(this); //base constructor
        var id = this.id = $(this.element).attr('id'), wizard = this, step = $.bbq.getState('_' + id);

        //после инита мы находимся на 0-ом шаге

        //try recover widget
        if (this._storageCheck(this.steps) && this._recoverWidget(this._storageGet(id)))
        {
            this._goToStep(step);
        }
        else
        {
            /*
             это мы делаем только если известен user_id

             тогда мы можем сохранять состояние человека в отдельной таблице и
             вернуть ему все его состояние, если куки похерились
             */
            if (this.options.userId !== null)
            {
                wizard.lock();
                this._recoverFromServer(step, function()
                {
                    wizard._preloaderHide();
                    wizard.unlock();
                });
            }
        }

        //set no saved
        this.steps.children('form').change(function()
        {
            $(this).parent().data('saved', false);
            wizard.needSaveOnServer = true;
        });

        this._preloaderHide();

        //autosave
        //        this.saveOnServerInterval = setInterval(function()
        //        {
        //            wizard.ifUnlock(wizard._saveOnServer);
        //        }, wizard.options.saveOnServerInterval);

        //autosave
        //        this.saveInStorageInterval = setInterval(function()
        //        {
        //            wizard.ifUnlock(wizard._saveInStorage);
        //        }, wizard.options.saveInStorageInterval);
    },
    //parent
    _validateSuccess:function(data, callback)
    {
        var $form = $('#' + this.currentStep).children('form');
        var wizard = this;
        var settings = $form.data('settings');

        if ($.isEmptyObject(data))
        {
            if (this.isLastStep)
            {
                callback.call(this);
                this.exit = true;
                this._preloaderHide();
                $('#'+this.currentStep).find(this.options.next).click();

                //
                //                this._saveOnServer(this._preloaderShow, function(data)
                //                    {
                //
                //                        $(wizard.element).slideUp().after(success);
                //                    },
                //                    function(data)
                //                    {
                //
                //                    });


            }
            else
            {
                var curTab = $('#cost_tab').find('.' + this.currentStep);
                curTab.removeClass('active').addClass('no_active')
                    .next().removeClass('d_l').addClass('l_d')
                    .next().removeClass('no_active').addClass('active')
                    .next().removeClass('l').addClass('d');

                $.ajax({
                    url:this.options.saveUrl,
                    type:'POST',
                    data:$form.serialize(),
                    success:function()
                    {
                        wizard._preloaderHide();

                    },
                    errofr:function()
                    {
                        wizard._preloaderHide();

                    }
                });

                this._parent()._continueToNextStep.call(this);
            }
        }
        else
        {
            $.each(settings.attributes, function(i, attribute)
            {
                $.fn.yiiactiveform.updateInput(attribute, data, $form);
            });
            $.fn.yiiactiveform.updateSummary($form, data);
        }

        this._preloaderHide();
        callback.call(this);
        return false;
    },
    _validateError:function(callback)
    {
        callback.call(this);
    },
    _continueToNextStep:function()
    {
        if (this.exit)
        {
            return true;
        }
        if (this.isLock())
        {
            return false;
        }
        this.lock();
        this._preloaderShow();

        var $form = $('#' + this.currentStep).children('form');
        var wizard = this;
        var settings = this.options;
        var messages = {};
        $.ajax({
            url:settings.validationUrl,
            type:$form.attr('method'),
            data:$form.serialize() + '&' + settings.ajaxVar + '=' + $form.attr('id'),
            dataType:'json',
            success:function(data)
            {
                if (data != null && typeof data == 'object')
                {
                    messages = $.extend({}, messages, data);
                }
                wizard._validateSuccess(messages, wizard.unlock);
            },
            error:function()
            {
                wizard._validateError(wizard.unlock);
            }
        });

        return false;
    },
    _afterSubmit:function()
    {
        alert('_afterSubmit');
        //clean garbage
        this._storageClear();

        //stop autosave
        clearInterval(this.saveInStorageInterval);
        clearInterval(this.saveOnServerInterval);

        //сказать что все хорошо
    },
    _setSaved:function(notSavedSteps)
    {
        notSavedSteps.each(function()
        {
            $(this).data('saved', true);
        });
    },
    _notSavedSteps:function()
    {
        return this.steps.filter(function()
        {
            return $(this).data('saved') !== true;
        });
    },
    _saveInStorage:function()
    {
        var wizard = this, notSavedSteps = wizard._notSavedSteps();

        if (notSavedSteps.length > 0)
        {
            this._serializeAll(notSavedSteps);
        }
    },
    _saveOnServer:function(before, success, error)
    {
        var wizard = this;
        if ($.isFunction(before))
        {
            before.call(wizard);
        }
        wizard._serializeAll(wizard.steps);

        $.post(
            wizard.options.saveUrl,
            wizard.serializeForms,
            function(data)
            {
                if (data.status == 'ok')
                {
                    if ($.isFunction(success))
                    {
                        success.call(wizard, data);
                    }
                    wizard.needSaveOnServer = false;
                }
                else
                {
                    if ($.isFunction(error))
                    {
                        error.call(wizard, data);
                    }
                }

            },
            'json'
        );

        /*
         по сути этой функции будет достаточно и для финального сохранения, только колбэк будет другой


         решить вопрос с валидацией yii
         }
         */
    },
    _state:function()
    {
        //добавить в состояние: хранилище, номера успешных форм
        return this._parent()._state.call(this);
    },
    //хэши и шаги - это id'шники
    _goToStep:function(step)
    {
        if (this.steps.find('#' + step) !== undefined)
        {
            this._show(step);
        }
    },
    _show:function(step, info)
    {
        this._parent()._show.call(this, step, info);
    },


    //widget chrash recovering
    _recoverFromServer:function(step, callback)
    {
        var wizard = this;
        $.post(
            this.options.loadUrl,
            {},
            function(data)
            {
                if (data.status = 'ok')
                {
                    wizard._serializeAll(data.steps);
                    wizard._recoverWidget(state);

                    //заполняем хранилище
                    wizard._goToStep(step);
                }
                else
                {
                    //че?
                }

                callback.call(this);
            },
            'json'
        );
    },
    _recoverWidget:function(state)
    {
        this._deserializeAll(this.steps);

        var data = this._storageGet(this.id);
        if (data == null)
        {
            return false;
        }
        this.options = data.settings;
        this.activatedSteps = data.activatedSteps;
        this.isLastStep = data.isLastStep;
        this.isFirstStep = data.isFirstStep;
        this.previousStep = data.previousStep;
        this.currentStep = data.currentStep;
        this.backButton = data.backButton;
        this.nextButton = data.nextButton;
        this.steps = data.steps;
        this.firstStep = data.firstStep;
        return true;
    },

    //server encapsulation


    //preloader encapsulation
    _preloaderShow:function()
    {
        $(this.options.preloader).fadeIn();
    },
    _preloaderHide:function()
    {
        $(this.options.preloader).fadeOut(1000);
    },

    //form mass encapsulation
    _serializeAll:function(steps)
    {
        var wizard = this;
        steps.each(function()
        {
            wizard._serialize($(this).attr('id'));
        });
    },
    _deserializeAll:function(steps)
    {
        var wizard = this;
        steps.each(function()
        {
            wizard._deserialize($(this).attr('id'));
        });
    },

    //form encapsulation
    _serialize:function(step)
    {
        var item = $("#" + step);

        //        this._storageSet(step, item.children('form').serialize());
        var arr = item.children('form').serializeArray();
        for (var i in arr)
        {
            this.serializeForms[arr[i].name] = arr[i].value;
        }

        item.data('saved', true);
    },
    _deserialize:function(step)
    {
        //        $("#" + step).children('form').deserialize(this._storageGet(step));
    },

    //storage mass functions
    _storageCheck:function(steps)
    {
        if (steps == undefined || steps.length == 0)
        {
            return true;
        }

        var res = false, wizard = this;
        steps.each(function()
        {
            var id = $(this).attr('id');
            res = res || (wizard._storageGet(id) !== null);
        });
        return res;
    },
    _storageGetAll:function(steps)
    {
        var wizard = this, res = new Object;
        if (steps == undefined)
        {
            steps = this.steps;
        }

        steps.each(function()
        {
            var step = $(this).attr('id');
            res[step] = wizard._storageGet(step);
        });
        return res;
    },

    //storage encapsulation
    _storageGet:function(id)
    {
        if ($.jStorage.storageAvailable())
        {
            return $.jStorage.get(id);
        }
        else
        {
            return $.cookie(id);
        }
    },
    _storageSet:function(id, val)
    {
        if ($.jStorage.storageAvailable())
        {
            $.jStorage.set(id, val);
        }
        else
        {
            $.cookie(id, val, this.options.cookieSettings);
        }
    },
    _storageDelete:function(id)
    {
        if ($.jStorage.storageAvailable())
        {
            $.jStorage.deleteKey(key)
        }
        else
        {
            $.cookie(id, null);
        }
    },
    _storageClear:function()
    {
        var wizard = this;
        wizard.steps.each(function()
        {
            wizard._storageDelete($(this).attr('id'));
        });

        wizard._storageDelete(wizard.id);
    },
    _storageGetKeys:function()
    {
        if ($.jStorage.storageAvailable())
        {
            return $.jStorage.index();
        }
        else
        {
            //cookie не написан
        }
    },
    _storageSize:function()
    {
        if ($.jStorage.storageAvailable())
        {
            return $.jStorage.storageSize();
        }
        else
        {
            //cookie не написан
        }
    },

    //api
    lock:function()
    {
        this.lockFlag = true;
    },
    unlock:function()
    {
        this.lockFlag = false;
    },
    isUnlock:function()
    {
        return this.lockFlag !== true;
    },
    isLock:function()
    {
        return !this.isUnlock();
    },
    ifUnlock:function(func)
    {
        if (this.isUnlock())
        {
            this.lock();
            func.call(this);
            this.unlock();
        }
    },
    ifLock:function(func)
    {
        if (this.isLock())
        {
            this.lock();
            func.call(this);
            this.unlock();
        }
    }
});