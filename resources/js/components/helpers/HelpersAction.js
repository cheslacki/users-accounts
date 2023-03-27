import HelpersController from './HelpersController';

import Swal from 'sweetalert2/dist/sweetalert2';

import {
    HelpersSpinner,
    HelpersForm,
    HelpersElement
} from './';

import {HelpersError} from "./index";

/**
 *
 */
class HelpersAction extends HelpersController {

    /**
     *
     * @param props
     */
    constructor(props) {
        super(props);
        jQuery(document).ready(() => {
            Boolean(props.lineView) && this.lineView();
            Boolean(props.lineDelete) && this.lineDelete();
            Boolean(props.formLogin) && this.formLogin();
            Boolean(props.formUser) && this.formUser();
        });
    };

    formLogin = () => {
        const formID = 'form_login', $elements = jQuery(`#${formID}`);

        const execute = () => {
            HelpersElement(HelpersForm.getState('form')).getTarget((method, action) => {
                HelpersForm.setTarget({
                    method: method,
                    action: action
                }, () => {
                    HelpersForm.submit(({
                        before: () => {
                            HelpersSpinner.setAttributes({button_submit: true});
                            HelpersSpinner.start();
                        },
                        done: (response) => {
                            if (this.verifyField(response, 'data.status', false, false)) {
                                let route = HelpersForm.verifyField(response, 'data.route', false, false);
                                route && (window.location.href = route);
                            } else {
                                HelpersError.setErrors(this.verifyField(response, 'data.errors', false, false));
                            }
                        },
                        fail: (response) => {
                            console.log(response);
                        },
                        always: () => {
                            HelpersSpinner.stop();
                        }
                    }));
                });
            });
        };

        /**
         *
         * @param event
         */
        const executeSubmit = (event) => {
            this.stopPropagation(event);
            HelpersForm.create(formID);
            HelpersForm.setData([], () => {
                execute();
            });
        };

        if (!!$elements && Boolean($elements.length)) {
            $elements.off('click.form-login-button-submit', '.button-submit');
            $elements.on('click.form-login-button-submit', '.button-submit', executeSubmit);
        }
    };

    formUser = () => {
        const formID = 'form_user', $elements = jQuery(`#${formID}`);

        const execute = () => {
            HelpersElement(HelpersForm.getState('form')).getTarget((method, action) => {
                HelpersForm.setTarget({
                    method: method,
                    action: action
                }, () => {
                    HelpersForm.submit(({
                        before: () => {
                            HelpersSpinner.setAttributes({button_submit: true});
                            HelpersSpinner.start();
                        },
                        done: (response) => {
                            if (this.verifyField(response, 'data.status', false, false)) {

                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Press ok to continue',
                                    icon: 'success',
                                    showConfirmButton: true,
                                    confirmButtonText: 'OK',
                                    buttonsStyling: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    customClass: {
                                        container: 'swal2-container',
                                        confirmButton: 'btn btn-primary mx-1'
                                    },
                                    willOpen: (element) => {
                                        /* Element swal, for modify or others */
                                    },
                                    preConfirm: () => {
                                        return new Promise((resolve) => {
                                            resolve();
                                        });
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        let route = HelpersForm.verifyField(response, 'data.data.route', false, false);
                                        route && (window.location.href = route);
                                    }
                                });
                            } else {
                                HelpersError.setErrors(this.verifyField(response, 'data.errors', false, false));
                            }
                        },
                        fail: (response) => {
                            console.log(response);
                        },
                        always: () => {
                            HelpersSpinner.stop();
                        }
                    }));
                });
            });
        };

        /**
         *
         * @param event
         */
        const executeSubmit = (event) => {
            this.stopPropagation(event);
            HelpersForm.create(formID);
            HelpersForm.setData([], () => {
                execute();
            });
        };

        if (!!$elements && Boolean($elements.length)) {
            $elements.off('click.form-user-button-submit', '.button-submit');
            $elements.on('click.form-user-button-submit', '.button-submit', executeSubmit);
        }
    };

    lineView = () => {
        const $elements = jQuery('.sheet-content .list-table');

        const execute = (event) => {
            this.stopPropagation(event);
            let
                $this = jQuery(event.target),
                _id = $this.closest('tr.view').data('id');

            if (Boolean(_id)) {

                let uri = `${window.location.protocol}//${window.location.host}`;

                let path = window.location.pathname.replace(/^\/+|\/+$/g, '').split('/');

                window.location.href = `${uri}/${path[0]}/${path[1].slice(0, -1)}/${_id}`;
            }
        };

        if (!!$elements && Boolean($elements.length)) {
            $elements.off('click.list-table-view', '.view');
            $elements.on('click.list-table-view', '.view', execute);
        }
    };

    lineDelete = () => {
        const $elements = jQuery('.sheet-content .list-table');

        const execute = (event) => {
            this.stopPropagation(event);
            let
                $this = jQuery(event.target),
                _id = $this.closest('tr.view').data('id');

            if (Boolean(_id)) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Do you want to continue?',
                    icon: 'warning',
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    buttonsStyling: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    customClass: {
                        container: 'swal2-container',
                        confirmButton: 'btn btn-primary mx-1 button-submit',
                        cancelButton: 'btn btn-default mx-1 button-default'
                    },
                    willOpen: (element) => {
                        /* Element swal, for modify or others */
                    },
                    preConfirm: () => {
                        return new Promise((resolve, reject) => {
                            HelpersForm.setTarget({
                                method: 'DELETE',
                                action: `user/${_id}`
                            }, () => {
                                HelpersForm.submit(({
                                    before: () => {
                                        HelpersSpinner.setAttributes({button_submit: true});
                                        HelpersSpinner.start();
                                    },
                                    done: (response) => {
                                        if (this.verifyField(response, 'data.status', false, false)) {
                                            resolve();
                                        } else {
                                            reject(this.verifyField(response, 'data.message.text', false, 'Something went wrong.'));
                                        }
                                    },
                                    fail: (response) => {
                                        console.log(response);
                                    },
                                    always: () => {
                                        HelpersSpinner.stop();
                                    }
                                }));
                            });
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Press ok to close',
                            icon: 'success',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            buttonsStyling: false,
                            customClass: {
                                container: 'swal2-container',
                                confirmButton: 'btn btn-primary mx-1',
                            },
                            preConfirm: () => {
                                window.location.reload();
                            }
                        });
                    }
                }).catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: error,
                        icon: 'error',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        buttonsStyling: false,
                        customClass: {
                            container: 'swal2-container',
                            confirmButton: 'btn btn-primary mx-1',
                        }
                    });
                })
            }
        };

        if (!!$elements && Boolean($elements.length)) {
            $elements.off('click.list-table-actions-delete', '.actions .delete');
            $elements.on('click.list-table-actions-delete', '.actions .delete', execute);
        }
    };
}

const config = {
    default: {
        lineView: false,
        lineDelete: false,
        formUser: false,
        formLogin: false
    }
};

export default (props) => (new HelpersAction({...config.default, ...props}));
