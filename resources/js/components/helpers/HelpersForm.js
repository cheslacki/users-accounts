import axios from 'axios';

import HelpersController from './HelpersController';

import {HelpersElement} from './';

/**
 *
 */
class HelpersForm extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        this.state = {
            $FormData: (new FormData()),
            formID: null,
            form: null,
            target: {
                method: null,
                action: null
            }
        };
        this.$config = {};

        this.isRegex = /^post|put|patch$/;
    };

    /**
     *
     * @param formID
     */
    create = (formID) => {
        this.state = {
            ...this.state,
            $FormData: (new FormData()),
            formID: (!this.isEmpty(formID) ? formID : null),
            form: (!this.isEmpty(formID) ? document.getElementById(formID) : null)
        };
    };

    /**
     *
     * @param target
     * @param callback
     */
    setTarget = (target, callback) => {
        const
            method = this.verifyField(target, 'method', false, false),
            action = this.verifyField(target, 'action', false, false);

        if (!!method && !!action) {
            this.setStates({
                target: {
                    method: method.toLowerCase(),
                    action: action.toLowerCase()
                }
            }, () => {
                (typeof(callback) === 'function') && callback(true);
            });
        } else {
            const {form} = this.state;

            HelpersElement(form).getTarget((method, action) => {
                this.setStates({
                    target: {
                        method: method,
                        action: action
                    }
                }, () => {
                    (typeof(callback) === 'function') && callback(true);
                });
            });
        }
    };

    /**
     *
     * @param data
     * @param callback
     */
    setData = (data, callback) => {
        const {form} = this.state;

        HelpersElement(form).mapInputs((name, value) => {
            if (this.checkArrayInput(name) && this.isArrayIf(value)) {
                value.map((_value) => {
                    this.state.$FormData.append(name, _value);
                });
            } else {
                this.checkArrayInput(name) && (name = this.removeArrayInput(name));
                this.state.$FormData.append(name, value);
            }
        });

        if (this.isArrayIf(data)) {
            data.map((item) => {
                (item.hasOwnProperty('name') && item.hasOwnProperty('value')) && this.state.$FormData.append(item.name, item.value);
            });
        }

        (typeof(callback) === 'function') && callback(true);
    };

    /**
     *
     * @param object
     */
    submit = (object) => {
        /** @namespace axios.create */
        const
            {method, action} = this.state.target,
            instance = axios.create();

        if (Boolean(method) && Boolean(action)) {

            if (object.hasOwnProperty('upload')) {
                this.$config.onUploadProgress = object.upload;
            }
            if (object.hasOwnProperty('download')) {
                this.$config.onDownloadProgress = object.download;
            }

            instance.interceptors.request.use((config) => {
                object.before();
                return config;
            }, function (error) {
                return Promise.reject(error);
            });

            instance.interceptors.response.use((response) => {
                object.always();
                return response;
            }, function (error) {
                return Promise.reject(error);
            });

            instance[method](action, ...(this.isRegex.test(method) ? [this.state.$FormData, this.$config] : [this.$config])).then((response) => {
                object.done(response);
            }).catch((response) => {
                object.always();
                object.fail(response);
            });
        }
    };
}

export default (new HelpersForm());